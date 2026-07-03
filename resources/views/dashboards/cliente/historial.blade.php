@php
    $user = auth()->user();
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

    $services = [
        ['id' => '#MD-1024', 'date' => '2026-07-01', 'origin' => 'Bogota', 'destination' => 'Medellin', 'price' => '$1.250.000', 'driver' => 'Carlos Ramirez', 'status' => 'En transito'],
        ['id' => '#MD-1019', 'date' => '2026-06-25', 'origin' => 'Cali', 'destination' => 'Pereira', 'price' => '$920.000', 'driver' => 'Laura Martinez', 'status' => 'Finalizada'],
        ['id' => '#MD-1012', 'date' => '2026-06-12', 'origin' => 'Neiva', 'destination' => 'Mocoa', 'price' => '$1.480.000', 'driver' => 'Jorge Silva', 'status' => 'Entregada'],
        ['id' => '#MD-1007', 'date' => '2026-05-30', 'origin' => 'Pasto', 'destination' => 'Puerto Asis', 'price' => '$760.000', 'driver' => 'Andres Rojas', 'status' => 'Cancelada'],
    ];
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media (max-width: 1023px) {
            body { overflow-x: hidden; }
            body::after {
                content: '';
                position: fixed;
                inset: 0;
                background: rgba(15, 23, 42, 0.45);
                opacity: 0;
                pointer-events: none;
                transition: opacity .2s ease;
                z-index: 35;
            }
            body.mobile-menu-open::after { opacity: 1; pointer-events: auto; }
            body > div > aside.bg-slate-950 {
                position: fixed;
                z-index: 50;
                inset: 0 auto 0 0;
                width: min(86vw, 280px);
                max-width: 280px;
                transform: translateX(-105%);
                transition: transform .22s ease;
                overflow-y: auto;
                box-shadow: 18px 0 40px rgba(15, 23, 42, .35);
            }
            body.mobile-menu-open > div > aside.bg-slate-950 { transform: translateX(0); }
            main { padding-top: 5.5rem !important; padding-left: 1rem !important; padding-right: 1rem !important; }
            h1, h2 { font-size: clamp(1.45rem, 7vw, 2rem) !important; line-height: 1.12 !important; overflow-wrap: anywhere; }
            h3 { overflow-wrap: anywhere; }
            button, a, input, select, textarea { max-width: 100%; }
            table { white-space: nowrap; }
            .mobile-safe-grid { grid-template-columns: 1fr !important; }
        }
        @media (min-width: 1024px) { .mobile-shell { display: none !important; } }
    </style>
    <link rel="stylesheet" href="{{ asset('css/client-mobile.css') }}?v=3">
</head>
<body class="min-h-screen bg-slate-100 text-slate-900">
    <div class="mobile-shell fixed inset-x-0 top-0 z-40 border-b border-slate-200 bg-white/95 px-4 py-3 shadow-sm backdrop-blur">
        <div class="flex items-center justify-between gap-3">
            <a href="{{ route('cliente.dashboard') }}" class="inline-flex h-11 w-11 items-center justify-center rounded-md bg-emerald-600 text-white" aria-label="Ir al inicio">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10.5 12 3l9 7.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M5.25 9.75V21h13.5V9.75"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 21v-6h6v6"/></svg>
            </a>
            <div class="min-w-0 flex-1">
                <p class="truncate text-sm font-semibold text-slate-500">Puerto Asis</p>
                <p class="truncate text-base font-bold text-slate-900">Panel cliente</p>
            </div>
            <button type="button" data-mobile-menu onclick="event.stopImmediatePropagation(); document.body.classList.toggle('mobile-menu-open')" class="inline-flex h-11 w-11 items-center justify-center rounded-md border border-slate-300 text-slate-800" aria-label="Abrir menu">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
            </button>
        </div>
    </div>
    <div class="min-h-screen lg:pl-[280px]">
        <aside class="bg-slate-950 px-5 py-6 text-white lg:fixed lg:inset-y-0 lg:left-0 lg:w-[280px] lg:overflow-y-auto">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-300">Mudanza</p>
            <h1 class="mt-2 text-xl font-bold">Cliente</h1>

            <nav class="mt-8 space-y-1">
                @foreach ($menuItems as $item)
                    <a href="{{ $item['url'] }}" class="block rounded-md px-3 py-2 text-sm font-semibold transition {{ $item['label'] === 'Historial' ? 'bg-white text-slate-950' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
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
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-700">historial</p>
                    <h2 class="mt-2 text-3xl font-bold">Historial de servicios</h2>
                    <p class="mt-2 text-slate-600">Consulta todos tus viajes, fechas, costos, conductores, facturas y estados.</p>
                </div>
                <button type="button" class="rounded-md bg-emerald-600 px-4 py-2.5 font-semibold text-white hover:bg-emerald-700">Exportar historial</button>
            </div>

            <section class="mt-8 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-lg border border-slate-200 bg-white p-5"><p class="text-sm font-semibold text-slate-500">Todos los servicios</p><p class="mt-3 text-3xl font-bold">39</p></div>
                <div class="rounded-lg border border-slate-200 bg-white p-5"><p class="text-sm font-semibold text-slate-500">Finalizados</p><p class="mt-3 text-3xl font-bold">35</p></div>
                <div class="rounded-lg border border-slate-200 bg-white p-5"><p class="text-sm font-semibold text-slate-500">En proceso</p><p class="mt-3 text-3xl font-bold">3</p></div>
                <div class="rounded-lg border border-slate-200 bg-white p-5"><p class="text-sm font-semibold text-slate-500">Cancelados</p><p class="mt-3 text-3xl font-bold">1</p></div>
            </section>

            <section class="mt-6 rounded-lg border border-slate-200 bg-white p-5">
                <h3 class="text-xl font-bold">Filtros</h3>
                <div class="mt-5 grid gap-4 md:grid-cols-4">
                    <div>
                        <label class="mb-2 block text-sm font-medium">Fecha</label>
                        <input type="date" class="w-full rounded-md border border-slate-300 px-3 py-2 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium">Ciudad</label>
                        <input type="text" placeholder="Origen o destino" class="w-full rounded-md border border-slate-300 px-3 py-2 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium">Estado</label>
                        <select class="w-full rounded-md border border-slate-300 px-3 py-2 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                            <option>Todos</option>
                            <option>En transito</option>
                            <option>Entregada</option>
                            <option>Finalizada</option>
                            <option>Cancelada</option>
                        </select>
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium">Precio</label>
                        <select class="w-full rounded-md border border-slate-300 px-3 py-2 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                            <option>Cualquier precio</option>
                            <option>Menos de $1.000.000</option>
                            <option>$1.000.000 a $2.000.000</option>
                            <option>Mas de $2.000.000</option>
                        </select>
                    </div>
                </div>
            </section>

            <section class="mt-6 rounded-lg border border-slate-200 bg-white p-5">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <h3 class="text-xl font-bold">Todos los servicios</h3>
                        <p class="mt-1 text-sm text-slate-500">Listado completo con fecha, ruta, precio, conductor y estado.</p>
                    </div>
                    <button class="rounded-md border border-slate-300 px-3 py-2 text-sm font-semibold hover:bg-slate-50">Limpiar filtros</button>
                </div>

                <div class="mt-5 overflow-x-auto">
                    <table class="w-full min-w-[920px] text-left text-sm">
                        <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                            <tr>
                                <th class="px-3 py-3">Servicio</th>
                                <th class="px-3 py-3">Fecha</th>
                                <th class="px-3 py-3">Origen</th>
                                <th class="px-3 py-3">Destino</th>
                                <th class="px-3 py-3">Precio</th>
                                <th class="px-3 py-3">Conductor</th>
                                <th class="px-3 py-3">Estado</th>
                                <th class="px-3 py-3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($services as $service)
                                <tr>
                                    <td class="px-3 py-4 font-semibold">{{ $service['id'] }}</td>
                                    <td class="px-3 py-4">{{ $service['date'] }}</td>
                                    <td class="px-3 py-4">{{ $service['origin'] }}</td>
                                    <td class="px-3 py-4">{{ $service['destination'] }}</td>
                                    <td class="px-3 py-4">{{ $service['price'] }}</td>
                                    <td class="px-3 py-4">{{ $service['driver'] }}</td>
                                    <td class="px-3 py-4">
                                        <span class="rounded-full px-3 py-1 text-xs font-semibold
                                            @class([
                                                'bg-emerald-100 text-emerald-800' => in_array($service['status'], ['Finalizada', 'Entregada']),
                                                'bg-sky-100 text-sky-800' => $service['status'] === 'En transito',
                                                'bg-red-100 text-red-800' => $service['status'] === 'Cancelada',
                                            ])">{{ $service['status'] }}</span>
                                    </td>
                                    <td class="px-3 py-4">
                                        <div class="flex flex-wrap gap-2">
                                            <button class="font-semibold text-emerald-700">Detalles</button>
                                            <button class="font-semibold text-slate-700">Factura</button>
                                            <button class="font-semibold text-slate-700">Comprobante</button>
                                            <button class="font-semibold text-slate-700">Repetir</button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="mt-6 grid gap-4 md:grid-cols-4">
                <button class="rounded-md bg-emerald-600 px-4 py-3 font-semibold text-white hover:bg-emerald-700">Ver detalles</button>
                <button class="rounded-md border border-slate-300 bg-white px-4 py-3 font-semibold hover:bg-slate-50">Descargar factura</button>
                <button class="rounded-md border border-slate-300 bg-white px-4 py-3 font-semibold hover:bg-slate-50">Descargar comprobante</button>
                <button class="rounded-md border border-slate-300 bg-white px-4 py-3 font-semibold hover:bg-slate-50">Repetir solicitud</button>
            </section>
        </main>
    </div>
    <script>
        document.querySelectorAll('[data-mobile-menu]').forEach((button) => {
            button.addEventListener('click', () => document.body.classList.toggle('mobile-menu-open'));
        });
        document.addEventListener('click', (event) => {
            if (!document.body.classList.contains('mobile-menu-open')) return;
            const aside = document.querySelector('aside.bg-slate-950');
            const trigger = event.target.closest('[data-mobile-menu]');
            if (trigger || aside?.contains(event.target)) return;
            document.body.classList.remove('mobile-menu-open');
        });
        document.querySelectorAll('aside.bg-slate-950 a').forEach((link) => {
            link.addEventListener('click', () => document.body.classList.remove('mobile-menu-open'));
        });
    </script>
    <script src="{{ asset('js/client-mobile.js') }}?v=3"></script>
</body>
</html>
