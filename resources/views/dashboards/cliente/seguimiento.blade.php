@php
    $user = auth()->user();
    $menuItems = [
        ['label' => 'Dashboard', 'url' => route('cliente.dashboard')],
        ['label' => 'Solicitudes de carga', 'url' => route('cliente.solicitudes')],
        ['label' => 'Buscar conductor', 'url' => route('cliente.conductores')],
        ['label' => 'Seguimiento', 'url' => route('cliente.seguimiento')],
        ['label' => 'Mensajes', 'url' => '#'],
        ['label' => 'Pagos', 'url' => '#'],
        ['label' => 'Historial', 'url' => '#'],
        ['label' => 'Calificaciones', 'url' => '#'],
        ['label' => 'Notificaciones', 'url' => '#'],
        ['label' => 'Mi perfil', 'url' => '#'],
        ['label' => 'Seguridad', 'url' => '#'],
        ['label' => 'Configuracion', 'url' => '#'],
    ];

    $timeline = [
        ['label' => 'Solicitud creada', 'time' => '08:10 AM', 'done' => true],
        ['label' => 'Conductor acepto', 'time' => '08:24 AM', 'done' => true],
        ['label' => 'Va hacia el origen', 'time' => '08:38 AM', 'done' => true],
        ['label' => 'Carga recogida', 'time' => '09:15 AM', 'done' => true],
        ['label' => 'En transito', 'time' => 'Ahora', 'done' => true],
        ['label' => 'Llego al destino', 'time' => 'Pendiente', 'done' => false],
        ['label' => 'Entrega realizada', 'time' => 'Pendiente', 'done' => false],
    ];
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seguimiento</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 text-slate-900">
    <div class="min-h-screen lg:pl-[280px]">
        <aside class="bg-slate-950 px-5 py-6 text-white lg:fixed lg:inset-y-0 lg:left-0 lg:w-[280px] lg:overflow-y-auto">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-300">Mudanza</p>
            <h1 class="mt-2 text-xl font-bold">Cliente</h1>

            <nav class="mt-8 space-y-1">
                @foreach ($menuItems as $item)
                    <a href="{{ $item['url'] }}" class="block rounded-md px-3 py-2 text-sm font-semibold transition {{ $item['label'] === 'Seguimiento' ? 'bg-white text-slate-950' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
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
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-700">seguimiento en tiempo real</p>
                    <h2 class="mt-2 text-3xl font-bold">Solicitud #MD-1024</h2>
                    <p class="mt-2 text-slate-600">Monitorea la ubicacion, estado del viaje y avance de la entrega.</p>
                </div>
                <span class="rounded-full bg-emerald-100 px-4 py-2 text-sm font-semibold text-emerald-800">En transito</span>
            </div>

            <section class="mt-8 grid gap-4 md:grid-cols-2 xl:grid-cols-5">
                <div class="rounded-lg border border-slate-200 bg-white p-5"><p class="text-sm font-semibold text-slate-500">Estado actual</p><p class="mt-3 text-xl font-bold">En transito</p></div>
                <div class="rounded-lg border border-slate-200 bg-white p-5"><p class="text-sm font-semibold text-slate-500">Ubicacion GPS</p><p class="mt-3 text-xl font-bold">6.2442, -75.5812</p></div>
                <div class="rounded-lg border border-slate-200 bg-white p-5"><p class="text-sm font-semibold text-slate-500">Tiempo estimado</p><p class="mt-3 text-xl font-bold">2 h 15 min</p></div>
                <div class="rounded-lg border border-slate-200 bg-white p-5"><p class="text-sm font-semibold text-slate-500">Kilometros restantes</p><p class="mt-3 text-xl font-bold">146 km</p></div>
                <div class="rounded-lg border border-slate-200 bg-white p-5"><p class="text-sm font-semibold text-slate-500">Hora de llegada</p><p class="mt-3 text-xl font-bold">4:45 PM</p></div>
            </section>

            <div class="mt-6 grid gap-6 xl:grid-cols-[1.3fr_0.7fr]">
                <section class="rounded-lg border border-slate-200 bg-white p-5">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <h3 class="text-xl font-bold">Mapa del recorrido</h3>
                            <p class="mt-1 text-sm text-slate-500">Ubicacion del conductor y ruta hacia el destino.</p>
                        </div>
                        <button class="rounded-md bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Ver mapa</button>
                    </div>
                    <div class="mt-5 flex h-80 items-center justify-center rounded-lg border border-dashed border-slate-300 bg-slate-50 text-sm font-semibold text-slate-500">
                        Mapa GPS del servicio activo
                    </div>
                </section>

                <section class="rounded-lg border border-slate-200 bg-white p-5">
                    <h3 class="text-xl font-bold">Funciones</h3>
                    <div class="mt-5 grid gap-3">
                        <button class="rounded-md bg-slate-900 px-4 py-3 text-sm font-semibold text-white hover:bg-slate-700">Ver mapa</button>
                        <button class="rounded-md border border-slate-300 bg-white px-4 py-3 text-sm font-semibold hover:bg-slate-50">Compartir seguimiento</button>
                        <button class="rounded-md border border-slate-300 bg-white px-4 py-3 text-sm font-semibold hover:bg-slate-50">Contactar conductor</button>
                        <button class="rounded-md border border-slate-300 bg-white px-4 py-3 text-sm font-semibold hover:bg-slate-50">Ver historial de ubicaciones</button>
                        <button class="rounded-md border border-slate-300 bg-white px-4 py-3 text-sm font-semibold hover:bg-slate-50">Descargar comprobante</button>
                    </div>
                </section>
            </div>

            <section class="mt-6 rounded-lg border border-slate-200 bg-white p-5">
                <h3 class="text-xl font-bold">Linea de tiempo</h3>
                <div class="mt-6 space-y-4">
                    @foreach ($timeline as $step)
                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <span class="flex h-9 w-9 items-center justify-center rounded-full text-sm font-bold {{ $step['done'] ? 'bg-emerald-600 text-white' : 'bg-slate-200 text-slate-500' }}">
                                    {{ $step['done'] ? '✓' : '•' }}
                                </span>
                                @if (! $loop->last)
                                    <span class="h-8 w-px bg-slate-200"></span>
                                @endif
                            </div>
                            <div class="pb-3">
                                <p class="font-semibold">{{ $step['label'] }}</p>
                                <p class="mt-1 text-sm text-slate-500">{{ $step['time'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        </main>
    </div>
</body>
</html>
