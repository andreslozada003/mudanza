<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class ClientTrackingController extends Controller
{
    public function index(): View
    {
        return view('dashboards.cliente.seguimiento', [
            'tracking' => $this->trackingPayload(),
        ]);
    }

    public function live(): JsonResponse
    {
        return response()->json($this->trackingPayload());
    }

    private function trackingPayload(): array
    {
        $route = [
            ['lat' => 0.5062, 'lng' => -76.5007, 'label' => 'Puerto Asis'],
            ['lat' => 0.6178, 'lng' => -76.5961, 'label' => 'Santa Ana'],
            ['lat' => 0.8243, 'lng' => -76.6135, 'label' => 'Villagarzon'],
            ['lat' => 1.1493, 'lng' => -76.6476, 'label' => 'Mocoa'],
        ];

        $cycleSeconds = 3600;
        $elapsed = now('America/Bogota')->secondsSinceMidnight() % $cycleSeconds;
        $progress = min(1, $elapsed / $cycleSeconds);
        $segment = min(count($route) - 2, (int) floor($progress * (count($route) - 1)));
        $segmentProgress = ($progress * (count($route) - 1)) - $segment;

        $from = $route[$segment];
        $to = $route[$segment + 1];
        $lat = $from['lat'] + (($to['lat'] - $from['lat']) * $segmentProgress);
        $lng = $from['lng'] + (($to['lng'] - $from['lng']) * $segmentProgress);
        $remainingKm = max(0, round(86 * (1 - $progress), 1));
        $remainingMinutes = max(0, (int) round(140 * (1 - $progress)));

        $steps = [
            ['label' => 'Solicitud creada', 'threshold' => 0, 'time' => '08:10 AM'],
            ['label' => 'Conductor acepto', 'threshold' => 0.08, 'time' => '08:24 AM'],
            ['label' => 'Va hacia el origen', 'threshold' => 0.16, 'time' => '08:38 AM'],
            ['label' => 'Carga recogida', 'threshold' => 0.28, 'time' => '09:15 AM'],
            ['label' => 'En transito', 'threshold' => 0.38, 'time' => 'Ahora'],
            ['label' => 'Llego al destino', 'threshold' => 0.92, 'time' => $progress >= 0.92 ? 'Ahora' : 'Pendiente'],
            ['label' => 'Entrega realizada', 'threshold' => 1, 'time' => $progress >= 1 ? 'Ahora' : 'Pendiente'],
        ];

        return [
            'request_number' => '#MD-1024',
            'status' => $progress >= 1 ? 'Entregada' : ($progress >= 0.92 ? 'Llegando al destino' : 'En transito'),
            'lat' => round($lat, 6),
            'lng' => round($lng, 6),
            'remaining_km' => $remainingKm,
            'eta_minutes' => $remainingMinutes,
            'eta_text' => $remainingMinutes > 0 ? $this->formatMinutes($remainingMinutes) : 'Llegando',
            'arrival_time' => now('America/Bogota')->addMinutes($remainingMinutes)->format('h:i A'),
            'updated_at' => now('America/Bogota')->format('h:i:s A'),
            'driver' => [
                'name' => 'Carlos Lopez',
                'phone' => '310 000 0000',
                'vehicle' => 'Camioneta',
                'plate' => 'ABC-1**',
            ],
            'origin' => $route[0],
            'destination' => $route[count($route) - 1],
            'route' => $route,
            'timeline' => array_map(fn (array $step) => [
                'label' => $step['label'],
                'time' => $progress >= $step['threshold'] ? $step['time'] : 'Pendiente',
                'done' => $progress >= $step['threshold'],
                'active' => abs($progress - $step['threshold']) < 0.12,
            ], $steps),
            'history' => [
                ['time' => now('America/Bogota')->subMinutes(18)->format('h:i A'), 'lat' => round($lat - 0.022, 6), 'lng' => round($lng - 0.012, 6), 'event' => 'Ubicacion registrada'],
                ['time' => now('America/Bogota')->subMinutes(9)->format('h:i A'), 'lat' => round($lat - 0.011, 6), 'lng' => round($lng - 0.006, 6), 'event' => 'Avance confirmado'],
                ['time' => now('America/Bogota')->format('h:i A'), 'lat' => round($lat, 6), 'lng' => round($lng, 6), 'event' => 'Ultima ubicacion'],
            ],
        ];
    }

    private function formatMinutes(int $minutes): string
    {
        if ($minutes < 60) {
            return $minutes . ' min';
        }

        $hours = intdiv($minutes, 60);
        $remaining = $minutes % 60;

        return $remaining > 0 ? "{$hours} h {$remaining} min" : "{$hours} h";
    }
}
