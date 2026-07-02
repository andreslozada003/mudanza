@php
    $user = auth()->user();
    $verification = $user->verification;
    $status = $verification?->status ?? 'pendiente';

    $statusConfig = [
        'aprobado' => [
            'label' => 'Cuenta verificada',
            'message' => 'Ya puedes usar todas las funciones disponibles para tu rol.',
            'badge' => 'bg-emerald-100 text-emerald-800',
            'panel' => 'border-emerald-200 bg-emerald-50',
            'mark' => '✓',
        ],
        'en_revision' => [
            'label' => 'Verificacion en revision',
            'message' => 'Estamos revisando tus documentos. Algunas funciones pueden estar limitadas.',
            'badge' => 'bg-amber-100 text-amber-800',
            'panel' => 'border-amber-200 bg-amber-50',
            'mark' => '⌛',
        ],
        'rechazado' => [
            'label' => 'Verificacion rechazada',
            'message' => $verification?->observations ?: 'Debes volver a enviar documentos legibles.',
            'badge' => 'bg-red-100 text-red-800',
            'panel' => 'border-red-200 bg-red-50',
            'mark' => '!',
        ],
        'pendiente' => [
            'label' => 'Verificacion pendiente',
            'message' => 'Completa tu verificacion para activar tu cuenta.',
            'badge' => 'bg-slate-200 text-slate-700',
            'panel' => 'border-slate-200 bg-white',
            'mark' => '•',
        ],
    ];

    $current = $statusConfig[$status] ?? $statusConfig['pendiente'];
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 text-slate-900">
    <div class="min-h-screen lg:grid lg:grid-cols-[280px_1fr]">
        <aside class="border-b border-slate-200 bg-slate-950 px-5 py-6 text-white lg:min-h-screen lg:border-b-0 lg:border-r">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-300">Mudanza</p>
                <h1 class="mt-2 text-xl font-bold">{{ ucfirst($user->role) }}</h1>
            </div>

            <nav class="mt-8 space-y-1">
                @foreach ($menuItems as $index => $item)
                    <a href="#" class="block rounded-md px-3 py-2 text-sm font-semibold transition {{ $index === 0 ? 'bg-white text-slate-950' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        {{ $item }}
                    </a>
                @endforeach
            </nav>

            <div class="mt-8 rounded-md border border-white/10 bg-white/5 p-4">
                <p class="text-sm font-semibold">{{ $user->name }}</p>
                <p class="mt-1 break-all text-xs text-slate-300">{{ $user->email }}</p>
                <span class="mt-3 inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $current['badge'] }}">
                    {{ $current['label'] }}
                </span>
            </div>

            <form class="mt-6" method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full rounded-md bg-white px-4 py-2 font-semibold text-slate-950 hover:bg-slate-200">
                    Cerrar sesion
                </button>
            </form>
        </aside>

        <main class="px-5 py-8 lg:px-8">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-700">{{ $user->role }}</p>
                    <h2 class="mt-2 text-3xl font-bold">{{ $title }}</h2>
                    <p class="mt-2 text-slate-600">{{ $subtitle }}</p>
                </div>
                <button type="button" class="rounded-md bg-emerald-600 px-4 py-2.5 font-semibold text-white hover:bg-emerald-700">
                    {{ $primaryAction }}
                </button>
            </div>

            <section class="mt-8 rounded-lg border p-5 {{ $current['panel'] }}">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-3">
                            <span class="flex h-10 w-10 items-center justify-center rounded-full bg-white text-lg font-bold shadow-sm">
                                {{ $current['mark'] }}
                            </span>
                            <div>
                                <h3 class="text-xl font-bold">{{ $current['label'] }}</h3>
                                <p class="mt-1 text-sm text-slate-700">{{ $current['message'] }}</p>
                            </div>
                        </div>
                    </div>
                    <span class="rounded-full px-3 py-1 text-sm font-semibold {{ $current['badge'] }}">
                        {{ str_replace('_', ' ', $status) }}
                    </span>
                </div>

                <div class="mt-6 grid gap-3 md:grid-cols-4">
                    <div class="rounded-md bg-white p-3 text-sm shadow-sm">
                        <p class="font-semibold text-emerald-700">✓ Cuenta creada</p>
                        <p class="mt-1 text-slate-500">Registro activo.</p>
                    </div>
                    <div class="rounded-md bg-white p-3 text-sm shadow-sm">
                        <p class="font-semibold text-emerald-700">✓ Datos enviados</p>
                        <p class="mt-1 text-slate-500">Perfil completo.</p>
                    </div>
                    <div class="rounded-md bg-white p-3 text-sm shadow-sm">
                        <p class="font-semibold text-emerald-700">✓ Documento cargado</p>
                        <p class="mt-1 text-slate-500">Imagenes recibidas.</p>
                    </div>
                    <div class="rounded-md bg-white p-3 text-sm shadow-sm">
                        <p class="font-semibold {{ $status === 'aprobado' ? 'text-emerald-700' : ($status === 'rechazado' ? 'text-red-700' : 'text-amber-700') }}">
                            {{ $status === 'aprobado' ? '✓ Aprobado' : ($status === 'rechazado' ? '! Rechazado' : '⌛ En revision') }}
                        </p>
                        <p class="mt-1 text-slate-500">Revision administrativa.</p>
                    </div>
                </div>
            </section>

            <section class="mt-6 grid gap-4 md:grid-cols-3">
                <div class="rounded-lg border border-slate-200 bg-white p-5">
                    <p class="text-sm font-semibold uppercase tracking-wide text-slate-500">Nivel de acceso</p>
                    <h3 class="mt-2 text-2xl font-bold">{{ $status === 'aprobado' ? 'Completo' : 'Limitado' }}</h3>
                </div>
                <div class="rounded-lg border border-slate-200 bg-white p-5">
                    <p class="text-sm font-semibold uppercase tracking-wide text-slate-500">Celular</p>
                    <h3 class="mt-2 text-xl font-bold">{{ $user->phone ?? 'Sin registrar' }}</h3>
                </div>
                <div class="rounded-lg border border-slate-200 bg-white p-5">
                    <p class="text-sm font-semibold uppercase tracking-wide text-slate-500">Rol</p>
                    <h3 class="mt-2 text-xl font-bold capitalize">{{ $user->role }}</h3>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
