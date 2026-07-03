<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Driver;
use App\Models\DriverReport;
use App\Models\DriverServiceRequest;
use App\Models\Message;
use App\Models\User;
use App\Models\UserVerification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminVerificationController extends Controller
{
    public function index(): View
    {
        $verifications = UserVerification::with('user')
            ->latest()
            ->paginate(10);

        return view('dashboards.admin', [
            'verifications' => $verifications,
            'stats' => $this->stats(),
            'users' => User::latest()->limit(8)->get(),
            'drivers' => Driver::latest()->limit(8)->get(),
            'serviceRequests' => DriverServiceRequest::latest()->limit(8)->get(),
            'reports' => DriverReport::latest()->limit(8)->get(),
            'conversations' => Conversation::with(['client', 'driver'])->latest()->limit(8)->get(),
        ]);
    }

    public function live(): JsonResponse
    {
        return response()->json($this->stats());
    }

    public function show(UserVerification $verification): View
    {
        $verification->load('user');

        return view('dashboards.verifications.show', compact('verification'));
    }

    public function approve(UserVerification $verification): RedirectResponse
    {
        $verification->update([
            'status' => 'aprobado',
            'observations' => null,
            'verified_at' => now(),
        ]);

        return redirect()
            ->route('admin.verifications.show', $verification)
            ->with('status', 'Verificacion aprobada correctamente.');
    }

    public function reject(Request $request, UserVerification $verification): RedirectResponse
    {
        $data = $request->validate([
            'observations' => ['required', 'string', 'max:1000'],
        ]);

        $verification->update([
            'status' => 'rechazado',
            'observations' => $data['observations'],
            'verified_at' => null,
        ]);

        return redirect()
            ->route('admin.verifications.show', $verification)
            ->with('status', 'Verificacion rechazada con observacion.');
    }

    public function verifyDriver(Driver $driver): RedirectResponse
    {
        $driver->update([
            'verified_identity' => true,
            'verified_license' => true,
            'verified_vehicle' => true,
            'soat_active' => true,
            'technical_review_active' => true,
        ]);

        return redirect()->route('admin.dashboard')->with('status', "Conductor {$driver->name} verificado correctamente.");
    }

    public function updateReport(Request $request, DriverReport $report): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:pendiente,en_revision,resuelto'],
        ]);

        $report->update($data);

        return redirect()->route('admin.dashboard')->with('status', 'Reporte actualizado correctamente.');
    }

    private function stats(): array
    {
        return [
            'users' => User::count(),
            'clients' => User::where('role', 'cliente')->count(),
            'conductors' => User::where('role', 'conductor')->count(),
            'admins' => User::where('role', 'admin')->count(),
            'pending_verifications' => UserVerification::where('status', 'en_revision')->count(),
            'approved_verifications' => UserVerification::where('status', 'aprobado')->count(),
            'rejected_verifications' => UserVerification::where('status', 'rechazado')->count(),
            'drivers' => Driver::count(),
            'verified_drivers' => Driver::where('verified_identity', true)
                ->where('verified_license', true)
                ->where('verified_vehicle', true)
                ->where('soat_active', true)
                ->where('technical_review_active', true)
                ->count(),
            'service_requests' => DriverServiceRequest::count(),
            'active_conversations' => Conversation::where('status', 'activa')->count(),
            'messages' => Message::count(),
            'pending_reports' => DriverReport::where('status', 'pendiente')->count(),
            'review_reports' => DriverReport::where('status', 'en_revision')->count(),
            'resolved_reports' => DriverReport::where('status', 'resuelto')->count(),
            'updated_at' => now('America/Bogota')->format('h:i:s A'),
        ];
    }
}
