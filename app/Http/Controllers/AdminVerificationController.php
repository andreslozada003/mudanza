<?php

namespace App\Http\Controllers;

use App\Models\UserVerification;
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

        return view('dashboards.admin', compact('verifications'));
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
}
