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

    $criteria = ['Puntualidad', 'Comunicacion', 'Estado del vehiculo', 'Trato recibido', 'Cuidado de la carga'];
    $history = [
        ['service' => '#MD-1019', 'driver' => 'Laura Martinez', 'date' => '2026-06-25', 'rating' => '5.0', 'comment' => 'Excelente servicio.'],
        ['service' => '#MD-1012', 'driver' => 'Jorge Silva', 'date' => '2026-06-12', 'rating' => '4.7', 'comment' => 'Muy buen manejo de la carga.'],
        ['service' => '#MD-1004', 'driver' => 'Carlos Ramirez', 'date' => '2026-05-18', 'rating' => '4.8', 'comment' => 'Puntual y atento.'],
    ];
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calificaciones</title>
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
    <link rel="stylesheet" href="{{ asset('css/client-mobile.css') }}?v=2">
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
            <button type="button" data-mobile-menu class="inline-flex h-11 w-11 items-center justify-center rounded-md border border-slate-300 text-slate-800" aria-label="Abrir menu">
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
                    <a href="{{ $item['url'] }}" class="block rounded-md px-3 py-2 text-sm font-semibold transition {{ $item['label'] === 'Calificaciones' ? 'bg-white text-slate-950' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
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
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-700">calificaciones</p>
                    <h2 class="mt-2 text-3xl font-bold">Calificar servicio</h2>
                    <p class="mt-2 text-slate-600">Evalua el conductor y deja comentarios sobre la experiencia del viaje.</p>
                </div>
                <span class="rounded-full bg-amber-100 px-4 py-2 text-sm font-semibold text-amber-800">Promedio recibido: 4.8 / 5</span>
            </div>

            <section class="mt-8 grid gap-4 md:grid-cols-3">
                <div class="rounded-lg border border-slate-200 bg-white p-5">
                    <p class="text-sm font-semibold text-slate-500">Promedio recibido</p>
                    <p class="mt-3 text-4xl font-bold text-amber-500">4.8</p>
                    <p class="mt-2 text-sm text-slate-500">Basado en 35 servicios</p>
                </div>
                <div class="rounded-lg border border-slate-200 bg-white p-5">
                    <p class="text-sm font-semibold text-slate-500">Servicios calificados</p>
                    <p class="mt-3 text-4xl font-bold">32</p>
                    <p class="mt-2 text-sm text-slate-500">3 pendientes por calificar</p>
                </div>
                <div class="rounded-lg border border-slate-200 bg-white p-5">
                    <p class="text-sm font-semibold text-slate-500">Mejor conductor</p>
                    <p class="mt-3 text-xl font-bold">Laura Martinez</p>
                    <p class="mt-2 text-sm text-slate-500">5.0 estrellas</p>
                </div>
            </section>

            <div class="mt-6 grid gap-6 xl:grid-cols-[1fr_0.9fr]">
                <section class="rounded-lg border border-slate-200 bg-white p-5">
                    <h3 class="text-xl font-bold">Nuevo comentario</h3>
                    <p class="mt-1 text-sm text-slate-500">Servicio #MD-1024 con Carlos Ramirez.</p>

                    <div class="mt-5 rounded-md bg-slate-50 p-4">
                        <p class="text-sm font-semibold text-slate-600">Calificar</p>
                        <div class="mt-3 flex gap-2 text-4xl text-amber-400">
                            <button type="button">★</button>
                            <button type="button">★</button>
                            <button type="button">★</button>
                            <button type="button">★</button>
                            <button type="button">★</button>
                        </div>
                    </div>

                    <div class="mt-5 grid gap-4 md:grid-cols-2">
                        @foreach ($criteria as $item)
                            <div>
                                <label class="mb-2 block text-sm font-medium">{{ $item }}</label>
                                <select class="w-full rounded-md border border-slate-300 px-3 py-2 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                                    <option>5 - Excelente</option>
                                    <option>4 - Bueno</option>
                                    <option>3 - Regular</option>
                                    <option>2 - Malo</option>
                                    <option>1 - Muy malo</option>
                                </select>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-5">
                        <label class="mb-2 block text-sm font-medium">Comentario</label>
                        <textarea rows="5" class="w-full rounded-md border border-slate-300 px-3 py-2 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">Excelente servicio.</textarea>
                    </div>

                    <div class="mt-5 flex justify-end">
                        <button class="rounded-md bg-emerald-600 px-4 py-2.5 font-semibold text-white hover:bg-emerald-700">Enviar calificacion</button>
                    </div>
                </section>

                <section class="rounded-lg border border-slate-200 bg-white p-5">
                    <h3 class="text-xl font-bold">Evaluacion por criterios</h3>
                    <div class="mt-5 space-y-4">
                        @foreach ($criteria as $item)
                            <div>
                                <div class="flex justify-between text-sm">
                                    <span class="font-semibold">{{ $item }}</span>
                                    <span class="text-slate-500">4.8</span>
                                </div>
                                <div class="mt-2 h-2 rounded-full bg-slate-100">
                                    <div class="h-2 rounded-full bg-amber-400" style="width: 96%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>

            <section class="mt-6 rounded-lg border border-slate-200 bg-white p-5">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <h3 class="text-xl font-bold">Historial de calificaciones</h3>
                        <p class="mt-1 text-sm text-slate-500">Comentarios y estrellas de servicios anteriores.</p>
                    </div>
                    <button class="rounded-md border border-slate-300 px-3 py-2 text-sm font-semibold hover:bg-slate-50">Ver todas</button>
                </div>

                <div class="mt-5 overflow-x-auto">
                    <table class="w-full min-w-[720px] text-left text-sm">
                        <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                            <tr>
                                <th class="px-3 py-3">Servicio</th>
                                <th class="px-3 py-3">Conductor</th>
                                <th class="px-3 py-3">Fecha</th>
                                <th class="px-3 py-3">Calificacion</th>
                                <th class="px-3 py-3">Comentario</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($history as $item)
                                <tr>
                                    <td class="px-3 py-4 font-semibold">{{ $item['service'] }}</td>
                                    <td class="px-3 py-4">{{ $item['driver'] }}</td>
                                    <td class="px-3 py-4">{{ $item['date'] }}</td>
                                    <td class="px-3 py-4"><span class="font-semibold text-amber-500">{{ $item['rating'] }} ★</span></td>
                                    <td class="px-3 py-4">{{ $item['comment'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
    <script src="{{ asset('js/client-mobile.js') }}?v=2"></script>
</body>
</html>
