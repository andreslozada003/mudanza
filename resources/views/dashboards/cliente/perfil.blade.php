@php
    $user = auth()->user();
    $verification = $user->verification;
    $isVerified = $verification?->status === 'aprobado';
    $menuItems = [
        ['label' => 'Dashboard', 'url' => route('cliente.dashboard')],
        ['label' => 'Solicitudes de carga', 'url' => route('cliente.solicitudes')],
        ['label' => 'Buscar conductor', 'url' => route('cliente.conductores')],
        ['label' => 'Seguimiento', 'url' => route('cliente.seguimiento')],
        ['label' => 'Mensajes', 'url' => route('cliente.mensajes')],
        ['label' => 'Pagos', 'url' => route('cliente.pagos')],
        ['label' => 'Historial', 'url' => route('cliente.historial')],
        ['label' => 'Calificaciones', 'url' => route('cliente.calificaciones')],
        ['label' => 'Notificaciones', 'url' => route('cliente.notificaciones')],
        ['label' => 'Mi perfil', 'url' => route('cliente.perfil')],
        ['label' => 'Seguridad', 'url' => route('cliente.seguridad')],
        ['label' => 'Configuracion', 'url' => route('cliente.configuracion')],
    ];
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi perfil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 text-slate-900">
    <div class="min-h-screen lg:pl-[280px]">
        <aside class="bg-slate-950 px-5 py-6 text-white lg:fixed lg:inset-y-0 lg:left-0 lg:w-[280px] lg:overflow-y-auto">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-300">Mudanza</p>
            <h1 class="mt-2 text-xl font-bold">Cliente</h1>

            <nav class="mt-8 space-y-1">
                @foreach ($menuItems as $item)
                    <a href="{{ $item['url'] }}" class="block rounded-md px-3 py-2 text-sm font-semibold transition {{ $item['label'] === 'Mi perfil' ? 'bg-white text-slate-950' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>

            <div class="mt-8 rounded-md border border-white/10 bg-white/5 p-4">
                <p class="text-sm font-semibold">{{ $user->name }}</p>
                <p class="mt-1 break-all text-xs text-slate-300">{{ $user->email }}</p>
            </div>

            <form class="mt-6" method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full rounded-md bg-white px-4 py-2 font-semibold text-slate-950 hover:bg-slate-200">Cerrar sesion</button>
            </form>
        </aside>

        <main class="px-5 py-8 lg:px-8">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-700">mi perfil</p>
                    <h2 class="mt-2 text-3xl font-bold">Datos personales</h2>
                    <p class="mt-2 text-slate-600">Administra tu informacion, datos de contacto y estado de verificacion.</p>
                </div>
                <span class="rounded-full px-4 py-2 text-sm font-semibold {{ $isVerified ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                    {{ $isVerified ? 'Usuario verificado' : 'Verificacion pendiente' }}
                </span>
            </div>

            <section class="mt-8 grid gap-6 xl:grid-cols-[360px_1fr]">
                <aside class="rounded-lg border border-slate-200 bg-white p-5">
                    <div class="flex flex-col items-center text-center">
                        <div class="flex h-32 w-32 items-center justify-center rounded-full bg-emerald-100 text-5xl font-bold text-emerald-800">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <h3 class="mt-4 text-2xl font-bold">{{ $user->name }}</h3>
                        <p class="mt-1 text-sm text-slate-500">{{ $user->email }}</p>
                        <span class="mt-4 rounded-full px-3 py-1 text-xs font-semibold {{ $isVerified ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                            {{ $isVerified ? 'Usuario verificado' : str_replace('_', ' ', $verification?->status ?? 'pendiente') }}
                        </span>
                    </div>

                    <div class="mt-6 grid gap-3">
                        <button class="rounded-md bg-emerald-600 px-4 py-2.5 font-semibold text-white hover:bg-emerald-700">Cambiar fotografia</button>
                        <button class="rounded-md border border-slate-300 px-4 py-2.5 font-semibold hover:bg-slate-50">Editar datos</button>
                    </div>
                </aside>

                <section class="rounded-lg border border-slate-200 bg-white p-5">
                    <h3 class="text-xl font-bold">Informacion del perfil</h3>
                    <div class="mt-5 grid gap-4 md:grid-cols-2">
                        <div class="rounded-md bg-slate-50 p-4"><p class="text-xs font-semibold uppercase text-slate-500">Nombre</p><p class="mt-2 font-bold">{{ $user->name }}</p></div>
                        <div class="rounded-md bg-slate-50 p-4"><p class="text-xs font-semibold uppercase text-slate-500">Empresa</p><p class="mt-2 font-bold">No registrada</p></div>
                        <div class="rounded-md bg-slate-50 p-4"><p class="text-xs font-semibold uppercase text-slate-500">Documento</p><p class="mt-2 font-bold">{{ $verification?->document_number ?? 'Pendiente' }}</p></div>
                        <div class="rounded-md bg-slate-50 p-4"><p class="text-xs font-semibold uppercase text-slate-500">Correo</p><p class="mt-2 font-bold">{{ $user->email }}</p></div>
                        <div class="rounded-md bg-slate-50 p-4"><p class="text-xs font-semibold uppercase text-slate-500">Celular</p><p class="mt-2 font-bold">{{ $user->phone ?? 'Sin registrar' }}</p></div>
                        <div class="rounded-md bg-slate-50 p-4"><p class="text-xs font-semibold uppercase text-slate-500">Direccion</p><p class="mt-2 font-bold">{{ $verification?->address ?? 'Pendiente' }}</p></div>
                        <div class="rounded-md bg-slate-50 p-4"><p class="text-xs font-semibold uppercase text-slate-500">Ciudad</p><p class="mt-2 font-bold">{{ $verification?->city ?? 'Pendiente' }}</p></div>
                        <div class="rounded-md bg-slate-50 p-4"><p class="text-xs font-semibold uppercase text-slate-500">Fecha de registro</p><p class="mt-2 font-bold">{{ $user->created_at?->format('d/m/Y') }}</p></div>
                        <div class="rounded-md bg-slate-50 p-4"><p class="text-xs font-semibold uppercase text-slate-500">Estado</p><p class="mt-2 font-bold capitalize">{{ $user->role }}</p></div>
                        <div class="rounded-md bg-slate-50 p-4"><p class="text-xs font-semibold uppercase text-slate-500">Informacion adicional</p><p class="mt-2 font-bold">Cliente de transporte de carga</p></div>
                    </div>
                </section>
            </section>

            <section class="mt-6 rounded-lg border border-slate-200 bg-white p-5">
                <h3 class="text-xl font-bold">Acciones</h3>
                <div class="mt-5 grid gap-3 md:grid-cols-5">
                    <button class="rounded-md bg-emerald-600 px-4 py-3 font-semibold text-white hover:bg-emerald-700">Editar datos</button>
                    <button class="rounded-md border border-slate-300 px-4 py-3 font-semibold hover:bg-slate-50">Cambiar contrasena</button>
                    <button class="rounded-md border border-slate-300 px-4 py-3 font-semibold hover:bg-slate-50">Cambiar fotografia</button>
                    <button class="rounded-md border border-slate-300 px-4 py-3 font-semibold hover:bg-slate-50">Cambiar correo</button>
                    <button class="rounded-md border border-slate-300 px-4 py-3 font-semibold hover:bg-slate-50">Cambiar telefono</button>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
