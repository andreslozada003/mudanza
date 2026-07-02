<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Conversation;
use App\Models\DriverFavorite;
use App\Models\DriverMessage;
use App\Models\DriverReport;
use App\Models\DriverServiceRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientDriverController extends Controller
{
    public function index(Request $request): View
    {
        $this->ensureDemoDrivers();
        $this->syncRegisteredConductors();

        $drivers = $this->filteredDrivers($request)->get();
        $favoriteIds = DriverFavorite::where('user_id', $request->user()->id)->pluck('driver_id')->all();

        return view('dashboards.cliente.conductores', [
            'drivers' => $drivers,
            'favoriteIds' => $favoriteIds,
            'filters' => $request->only(['search', 'city', 'department', 'vehicle_type', 'capacity', 'min_price', 'max_price', 'rating', 'availability', 'verified']),
            'pendingRequests' => $this->pendingRequests(),
        ]);
    }

    public function best(Request $request): JsonResponse
    {
        $this->ensureDemoDrivers();
        $this->syncRegisteredConductors();

        $driver = $this->filteredDrivers($request)
            ->orderByDesc('rating')
            ->orderBy('distance_km')
            ->orderBy('base_price')
            ->first();

        return response()->json([
            'driver' => $driver,
            'message' => $driver
                ? "{$driver->name} es el mejor candidato por calificacion, cercania, disponibilidad y precio."
                : 'No se encontraron conductores con esos filtros.',
        ]);
    }

    public function favorite(Request $request, Driver $driver): JsonResponse
    {
        $favorite = DriverFavorite::where('user_id', $request->user()->id)->where('driver_id', $driver->id)->first();

        if ($favorite) {
            $favorite->delete();

            return response()->json(['active' => false, 'message' => "{$driver->name} fue eliminado de favoritos."]);
        }

        DriverFavorite::create(['user_id' => $request->user()->id, 'driver_id' => $driver->id]);

        return response()->json(['active' => true, 'message' => "{$driver->name} fue agregado a favoritos."]);
    }

    public function requestService(Request $request, Driver $driver): JsonResponse
    {
        $validated = $request->validate([
            'request_number' => ['required', 'string', 'max:30'],
            'message' => ['nullable', 'string', 'max:500'],
        ]);

        $load = collect($this->pendingRequests())->firstWhere('number', $validated['request_number']);

        if (! $load) {
            return response()->json(['message' => 'La solicitud seleccionada no esta disponible.'], 422);
        }

        $serviceRequest = DriverServiceRequest::create([
            'user_id' => $request->user()->id,
            'driver_id' => $driver->id,
            'request_number' => $load['number'],
            'origin' => $load['origin'],
            'destination' => $load['destination'],
            'weight_kg' => $load['weight_kg'],
            'vehicle_type' => $load['vehicle_type'],
            'offered_price' => $load['offered_price'],
            'message' => $validated['message'] ?? null,
        ]);

        $conversation = Conversation::firstOrCreate(
            [
                'cliente_id' => $request->user()->id,
                'conductor_id' => $driver->id,
                'request_number' => $load['number'],
            ],
            ['status' => 'activa']
        );

        $conversation->messages()->firstOrCreate([
            'sender_role' => 'system',
            'message' => "Chat creado para la solicitud {$load['number']}.",
            'type' => 'system',
        ]);

        $conversation->messages()->create([
            'sender_role' => 'system',
            'message' => "Solicitud enviada a {$driver->name}.",
            'type' => 'system',
        ]);

        return response()->json([
            'message' => "Solicitud {$serviceRequest->request_number} enviada a {$driver->name}.",
            'service_request' => $serviceRequest,
        ]);
    }

    public function message(Request $request, Driver $driver): JsonResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:500'],
        ]);

        DriverMessage::create([
            'user_id' => $request->user()->id,
            'driver_id' => $driver->id,
            'message' => $validated['message'],
        ]);

        return response()->json(['message' => "Mensaje enviado a {$driver->name}."]);
    }

    public function report(Request $request, Driver $driver): JsonResponse
    {
        $validated = $request->validate([
            'reason' => ['required', 'string', 'max:80'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        DriverReport::create([
            'user_id' => $request->user()->id,
            'driver_id' => $driver->id,
            'reason' => $validated['reason'],
            'description' => $validated['description'] ?? null,
        ]);

        return response()->json(['message' => 'Reporte enviado. El administrador lo revisara.']);
    }

    private function filteredDrivers(Request $request)
    {
        return Driver::query()
            ->when($request->filled('search'), fn ($query) => $query->where('name', 'like', '%' . $request->search . '%'))
            ->when($request->filled('city'), fn ($query) => $query->where('city', 'like', '%' . $request->city . '%'))
            ->when($request->filled('department'), fn ($query) => $query->where('department', 'like', '%' . $request->department . '%'))
            ->when($request->filled('vehicle_type'), fn ($query) => $query->where('vehicle_type', $request->vehicle_type))
            ->when($request->filled('capacity'), fn ($query) => $query->where('capacity_kg', '>=', (int) $request->capacity))
            ->when($request->filled('min_price'), fn ($query) => $query->where('base_price', '>=', (int) $request->min_price))
            ->when($request->filled('max_price'), fn ($query) => $query->where('base_price', '<=', (int) $request->max_price))
            ->when($request->filled('rating'), fn ($query) => $query->where('rating', '>=', (float) $request->rating))
            ->when($request->filled('availability'), fn ($query) => $query->where('availability', $request->availability))
            ->when($request->boolean('verified'), fn ($query) => $query
                ->where('verified_identity', true)
                ->where('verified_license', true)
                ->where('verified_vehicle', true))
            ->orderByRaw("availability = 'Disponible ahora' desc")
            ->orderByDesc('rating')
            ->orderBy('distance_km');
    }

    private function pendingRequests(): array
    {
        return [
            ['number' => '#000123', 'origin' => 'Puerto Asis', 'destination' => 'Mocoa', 'weight_kg' => 80, 'vehicle_type' => 'Camioneta', 'offered_price' => 120000],
            ['number' => '#000125', 'origin' => 'Puerto Asis', 'destination' => 'Villagarzon', 'weight_kg' => 180, 'vehicle_type' => 'Furgon', 'offered_price' => 180000],
        ];
    }

    private function ensureDemoDrivers(): void
    {
        if (Driver::query()->exists()) {
            return;
        }

        foreach ($this->demoDrivers() as $driver) {
            Driver::create($driver);
        }
    }

    private function syncRegisteredConductors(): void
    {
        User::query()
            ->with('verification')
            ->where('role', 'conductor')
            ->whereDoesntHave('verification', fn ($query) => $query->where('status', 'rechazado'))
            ->get()
            ->each(function (User $user) {
                if (Driver::where('user_id', $user->id)->exists()) {
                    return;
                }

                Driver::create([
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'company' => 'Independiente',
                    'city' => $user->verification?->city ?: 'Puerto Asis',
                    'department' => 'Putumayo',
                    'vehicle_type' => 'Camioneta',
                    'vehicle_brand' => 'Por registrar',
                    'vehicle_model' => 'Por registrar',
                    'vehicle_year' => now()->format('Y'),
                    'plate_mask' => '***-***',
                    'capacity_kg' => 500,
                    'rating' => 5,
                    'trips' => 0,
                    'cancelled_trips' => 0,
                    'completed_percent' => 100,
                    'response_minutes' => 5,
                    'distance_km' => 5,
                    'base_price' => 120000,
                    'price_per_km' => 2800,
                    'availability' => 'Disponible ahora',
                    'verified_identity' => $user->verification?->status === 'aprobado',
                    'verified_license' => false,
                    'verified_vehicle' => false,
                    'soat_active' => false,
                    'technical_review_active' => false,
                    'lat' => 0.5062,
                    'lng' => -76.5007,
                    'bio' => 'Conductor registrado en la plataforma. Debe completar los datos del vehiculo para mejorar su perfil.',
                ]);
            });
    }

    private function demoDrivers(): array
    {
        return [
            [
                'name' => 'Carlos Lopez',
                'company' => 'Independiente',
                'city' => 'Puerto Asis',
                'vehicle_type' => 'Camioneta',
                'vehicle_brand' => 'Toyota',
                'vehicle_model' => 'Hilux',
                'vehicle_year' => '2022',
                'plate_mask' => 'ABC-1**',
                'capacity_kg' => 500,
                'rating' => 4.9,
                'trips' => 340,
                'cancelled_trips' => 4,
                'completed_percent' => 98,
                'response_minutes' => 3,
                'distance_km' => 3.5,
                'base_price' => 120000,
                'price_per_km' => 2800,
                'availability' => 'Disponible ahora',
                'lat' => 0.5062,
                'lng' => -76.5007,
                'bio' => 'Especialista en mudanzas pequenas y transporte de electrodomesticos.',
            ],
            [
                'name' => 'Juan Gomez',
                'company' => 'Carga Sur SAS',
                'city' => 'Mocoa',
                'vehicle_type' => 'Camion',
                'vehicle_brand' => 'Chevrolet',
                'vehicle_model' => 'NPR',
                'vehicle_year' => '2020',
                'plate_mask' => 'JKL-4**',
                'capacity_kg' => 3000,
                'rating' => 4.8,
                'trips' => 286,
                'cancelled_trips' => 6,
                'completed_percent' => 97,
                'response_minutes' => 6,
                'distance_km' => 6.8,
                'base_price' => 135000,
                'price_per_km' => 3100,
                'availability' => 'Disponible hoy',
                'lat' => 1.1493,
                'lng' => -76.6476,
                'bio' => 'Transporte de carga mediana con experiencia regional.',
            ],
            [
                'name' => 'Luis Perez',
                'company' => 'Transportes LP',
                'city' => 'Villagarzon',
                'vehicle_type' => 'Furgon',
                'vehicle_brand' => 'Renault',
                'vehicle_model' => 'Master',
                'vehicle_year' => '2021',
                'plate_mask' => 'MNO-7**',
                'capacity_kg' => 1000,
                'rating' => 4.7,
                'trips' => 198,
                'cancelled_trips' => 5,
                'completed_percent' => 96,
                'response_minutes' => 9,
                'distance_km' => 9.2,
                'base_price' => 110000,
                'price_per_km' => 2600,
                'availability' => 'Programado',
                'lat' => 0.9177,
                'lng' => -76.6267,
                'bio' => 'Furgon cerrado para cargas delicadas y paquetes empresariales.',
            ],
        ];
    }
}
