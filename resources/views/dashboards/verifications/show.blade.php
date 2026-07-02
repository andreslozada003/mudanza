<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de verificacion</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="min-h-screen bg-slate-100 text-slate-900">
    <main class="mx-auto max-w-6xl px-6 py-10">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <a href="{{ route('admin.dashboard') }}" class="text-sm font-semibold text-emerald-700 hover:text-emerald-800">Volver</a>
                <h1 class="mt-2 text-3xl font-bold">{{ $verification->user->name }}</h1>
                <p class="mt-2 text-slate-600">{{ $verification->user->email }} · {{ $verification->user->phone }}</p>
            </div>
            <span class="rounded-full px-4 py-2 text-sm font-semibold
                @class([
                    'bg-amber-100 text-amber-800' => $verification->status === 'en_revision',
                    'bg-emerald-100 text-emerald-800' => $verification->status === 'aprobado',
                    'bg-red-100 text-red-800' => $verification->status === 'rechazado',
                    'bg-slate-200 text-slate-700' => ! in_array($verification->status, ['en_revision', 'aprobado', 'rechazado']),
                ])">
                {{ str_replace('_', ' ', $verification->status) }}
            </span>
        </div>

        @if (session('status'))
            <div class="mt-6 rounded-md border border-emerald-200 bg-emerald-50 p-3 text-sm font-semibold text-emerald-800">
                {{ session('status') }}
            </div>
        @endif

        <div class="mt-8 grid gap-6 lg:grid-cols-[1fr_360px]">
            <section class="rounded-lg border border-slate-200 bg-white p-5">
                <h2 class="text-lg font-bold">Datos personales</h2>
                <dl class="mt-5 grid gap-4 sm:grid-cols-2">
                    <div><dt class="text-xs uppercase text-slate-500">Rol</dt><dd class="mt-1 font-semibold capitalize">{{ $verification->user->role }}</dd></div>
                    <div><dt class="text-xs uppercase text-slate-500">Documento</dt><dd class="mt-1 font-semibold uppercase">{{ $verification->document_type }} {{ $verification->document_number }}</dd></div>
                    <div><dt class="text-xs uppercase text-slate-500">Expedicion</dt><dd class="mt-1 font-semibold">{{ $verification->document_issued_at->format('d/m/Y') }}</dd></div>
                    <div><dt class="text-xs uppercase text-slate-500">Nacimiento</dt><dd class="mt-1 font-semibold">{{ $verification->birth_date->format('d/m/Y') }}</dd></div>
                    <div><dt class="text-xs uppercase text-slate-500">Genero</dt><dd class="mt-1 font-semibold">{{ str_replace('_', ' ', $verification->gender) }}</dd></div>
                    <div><dt class="text-xs uppercase text-slate-500">Ciudad</dt><dd class="mt-1 font-semibold">{{ $verification->city }}</dd></div>
                    <div class="sm:col-span-2"><dt class="text-xs uppercase text-slate-500">Direccion</dt><dd class="mt-1 font-semibold">{{ $verification->address }}</dd></div>
                </dl>
            </section>

            <section class="rounded-lg border border-slate-200 bg-white p-5">
                <h2 class="text-lg font-bold">Decision</h2>
                <div class="mt-5 space-y-3">
                    <form id="approve-form" method="POST" action="{{ route('admin.verifications.approve', $verification) }}">
                        @csrf
                        <button type="submit" class="w-full rounded-md bg-emerald-600 px-4 py-2.5 font-semibold text-white hover:bg-emerald-700">Aprobar</button>
                    </form>
                    <form method="POST" action="{{ route('admin.verifications.reject', $verification) }}" class="space-y-3">
                        @csrf
                        <textarea name="observations" rows="4" required placeholder="Motivo del rechazo" class="w-full rounded-md border border-slate-300 px-3 py-2 outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100">{{ old('observations', $verification->observations) }}</textarea>
                        @error('observations')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <button type="submit" class="w-full rounded-md bg-red-600 px-4 py-2.5 font-semibold text-white hover:bg-red-700">Rechazar</button>
                    </form>
                </div>
            </section>
        </div>

        <section class="mt-6 rounded-lg border border-slate-200 bg-white p-5">
            <h2 class="text-lg font-bold">Imagenes cargadas</h2>
            <div class="mt-5 grid gap-4 md:grid-cols-3">
                <a href="{{ asset('storage/'.$verification->document_front_path) }}" target="_blank" class="block">
                    <span class="mb-2 block text-sm font-semibold">Frente documento</span>
                    <img src="{{ asset('storage/'.$verification->document_front_path) }}" alt="Frente del documento" class="aspect-[4/3] w-full rounded-md border border-slate-200 object-cover">
                </a>
                <a href="{{ asset('storage/'.$verification->document_back_path) }}" target="_blank" class="block">
                    <span class="mb-2 block text-sm font-semibold">Reverso documento</span>
                    <img src="{{ asset('storage/'.$verification->document_back_path) }}" alt="Reverso del documento" class="aspect-[4/3] w-full rounded-md border border-slate-200 object-cover">
                </a>
                <a href="{{ asset('storage/'.$verification->selfie_path) }}" target="_blank" class="block">
                    <span class="mb-2 block text-sm font-semibold">Selfie</span>
                    <img src="{{ asset('storage/'.$verification->selfie_path) }}" alt="Selfie del usuario" class="aspect-[4/3] w-full rounded-md border border-slate-200 object-cover">
                </a>
            </div>
        </section>
    </main>

    <script>
        const approveForm = document.getElementById('approve-form');

        approveForm.addEventListener('submit', (event) => {
            event.preventDefault();

            Swal.fire({
                title: 'Aprobar verificacion?',
                text: 'El usuario quedara marcado como aprobado.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#059669',
                cancelButtonColor: '#475569',
                confirmButtonText: 'Si, aprobar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    approveForm.submit();
                }
            });
        });

        @if (session('status'))
            Swal.fire({
                title: 'Listo',
                text: @json(session('status')),
                icon: 'success',
                confirmButtonColor: '#059669',
                confirmButtonText: 'Aceptar',
            });
        @endif
    </script>
</body>
</html>
