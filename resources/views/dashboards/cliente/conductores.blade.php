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

    $money = fn ($value) => '$' . number_format((int) $value, 0, ',', '.');
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar conductor</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    <a href="{{ $item['url'] }}" class="block rounded-md px-3 py-2 text-sm font-semibold transition {{ $item['label'] === 'Buscar conductor' ? 'bg-white text-slate-950' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
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
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-700">buscar conductor</p>
                    <h2 class="mt-2 text-3xl font-bold">Encuentra y contrata conductores</h2>
                    <p class="mt-2 text-slate-600">Filtros reales, favoritos guardados, solicitudes enviadas, mensajes y reportes registrados en la base de datos.</p>
                </div>
                <button type="button" data-best-driver class="rounded-md bg-emerald-600 px-4 py-2.5 font-semibold text-white hover:bg-emerald-700">Encontrar el mejor conductor</button>
            </div>

            <form method="GET" action="{{ route('cliente.conductores') }}" class="mt-8 rounded-lg border border-slate-200 bg-white p-5">
                <div class="grid gap-4 lg:grid-cols-[1fr_180px_180px_190px]">
                    <label>
                        <span class="mb-2 block text-sm font-medium">Buscar por nombre</span>
                        <input name="search" value="{{ $filters['search'] ?? '' }}" type="text" placeholder="Carlos Lopez" class="w-full rounded-md border border-slate-300 px-3 py-2 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                    </label>
                    <label>
                        <span class="mb-2 block text-sm font-medium">Ciudad</span>
                        <input name="city" value="{{ $filters['city'] ?? '' }}" type="text" placeholder="Puerto Asis" class="w-full rounded-md border border-slate-300 px-3 py-2 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                    </label>
                    <label>
                        <span class="mb-2 block text-sm font-medium">Vehiculo</span>
                        <select name="vehicle_type" class="w-full rounded-md border border-slate-300 px-3 py-2 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                            <option value="">Todos</option>
                            @foreach (['Camioneta', 'Furgon', 'Camion', 'Moto', 'Tractomula'] as $vehicle)
                                <option value="{{ $vehicle }}" @selected(($filters['vehicle_type'] ?? '') === $vehicle)>{{ $vehicle }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="flex items-end gap-2 rounded-md border border-emerald-200 bg-emerald-50 px-3 py-2 text-sm font-semibold text-emerald-800">
                        <input name="verified" value="1" type="checkbox" @checked(($filters['verified'] ?? '') == '1') class="mb-1 rounded border-slate-300 text-emerald-600">
                        Solo verificados
                    </label>
                </div>

                <div class="mt-4 grid gap-4 md:grid-cols-2 xl:grid-cols-6">
                    <input name="department" value="{{ $filters['department'] ?? '' }}" type="text" placeholder="Departamento" class="rounded-md border border-slate-300 px-3 py-2 text-sm">
                    <select name="capacity" class="rounded-md border border-slate-300 px-3 py-2 text-sm">
                        <option value="">Cualquier capacidad</option>
                        @foreach ([300 => 'Hasta 300 kg', 500 => '500 kg', 1000 => '1 tonelada', 3000 => '3 toneladas', 5000 => '5 toneladas'] as $value => $label)
                            <option value="{{ $value }}" @selected(($filters['capacity'] ?? '') == $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <input name="min_price" value="{{ $filters['min_price'] ?? '' }}" type="number" placeholder="Precio minimo" class="rounded-md border border-slate-300 px-3 py-2 text-sm">
                    <input name="max_price" value="{{ $filters['max_price'] ?? '' }}" type="number" placeholder="Precio maximo" class="rounded-md border border-slate-300 px-3 py-2 text-sm">
                    <select name="rating" class="rounded-md border border-slate-300 px-3 py-2 text-sm">
                        <option value="">Calificacion</option>
                        @foreach (['5' => '5 estrellas', '4.5' => '4.5+', '4' => '4.0+'] as $value => $label)
                            <option value="{{ $value }}" @selected(($filters['rating'] ?? '') == $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <select name="availability" class="rounded-md border border-slate-300 px-3 py-2 text-sm">
                        <option value="">Disponibilidad</option>
                        @foreach (['Disponible ahora', 'Disponible hoy', 'Disponible manana', 'Programado'] as $availability)
                            <option value="{{ $availability }}" @selected(($filters['availability'] ?? '') === $availability)>{{ $availability }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-4 flex flex-wrap justify-end gap-2">
                    <a href="{{ route('cliente.conductores') }}" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold hover:bg-slate-50">Limpiar</a>
                    <button type="submit" class="rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Aplicar filtros</button>
                </div>
            </form>

            <section id="best-driver-result" class="mt-6 hidden rounded-lg border border-emerald-200 bg-emerald-50 p-5"></section>

            <section class="mt-6 grid gap-4">
                @forelse ($drivers as $driver)
                    @php $isFavorite = in_array($driver->id, $favoriteIds); @endphp
                    <article class="rounded-lg border border-slate-200 bg-white p-5">
                        <div class="flex flex-col gap-5 xl:flex-row xl:items-start xl:justify-between">
                            <div class="flex gap-4">
                                <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-md bg-emerald-100 text-xl font-bold text-emerald-800">
                                    {{ substr($driver->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="flex flex-wrap items-center gap-2">
                                        <h3 class="text-xl font-bold">{{ $driver->name }}</h3>
                                        <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800">{{ $driver->rating }} estrellas</span>
                                        <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-800">Verificado</span>
                                        <span class="rounded-full bg-sky-100 px-3 py-1 text-xs font-semibold text-sky-800">{{ $driver->availability }}</span>
                                    </div>
                                    <p class="mt-1 text-sm text-slate-500">{{ $driver->company ?: 'Independiente' }} - {{ $driver->city }}, {{ $driver->department }}</p>
                                    <div class="mt-4 grid gap-3 text-sm md:grid-cols-4">
                                        <div><span class="text-slate-500">Vehiculo</span><p class="font-semibold">{{ $driver->vehicle_type }}</p></div>
                                        <div><span class="text-slate-500">Distancia</span><p class="font-semibold">{{ $driver->distance_km }} km</p></div>
                                        <div><span class="text-slate-500">Viajes</span><p class="font-semibold">{{ $driver->trips }}</p></div>
                                        <div><span class="text-slate-500">Desde</span><p class="font-semibold">{{ $money($driver->base_price) }}</p></div>
                                    </div>
                                </div>
                            </div>

                            <div class="grid w-full gap-2 xl:w-56">
                                <button type="button" data-profile="{{ $driver->id }}" class="rounded-md border border-slate-300 bg-white px-3 py-2 text-sm font-semibold hover:bg-slate-50">Ver perfil</button>
                                <button type="button" data-service-request="{{ $driver->id }}" data-driver-name="{{ $driver->name }}" class="rounded-md bg-emerald-600 px-3 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Solicitar servicio</button>
                                <button type="button" data-message="{{ $driver->id }}" data-driver-name="{{ $driver->name }}" class="rounded-md border border-slate-300 bg-white px-3 py-2 text-sm font-semibold hover:bg-slate-50">Enviar mensaje</button>
                                <button type="button" data-favorite="{{ $driver->id }}" class="rounded-md border px-3 py-2 text-sm font-semibold hover:bg-slate-50 {{ $isFavorite ? 'border-emerald-300 bg-emerald-50 text-emerald-700' : 'border-slate-300 bg-white' }}">{{ $isFavorite ? 'Quitar de favoritos' : 'Agregar a favoritos' }}</button>
                            </div>
                        </div>
                    </article>

                    <section id="driver-profile-{{ $driver->id }}" class="mt-4 hidden rounded-lg border border-slate-200 bg-white p-5">
                        <div class="flex flex-wrap items-start justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">perfil del conductor</p>
                                <h3 class="mt-1 text-2xl font-bold">{{ $driver->name }}</h3>
                                <p class="mt-1 text-sm text-slate-500">{{ $driver->city }} - Activo y disponible en plataforma</p>
                            </div>
                            <button type="button" data-report="{{ $driver->id }}" data-driver-name="{{ $driver->name }}" class="rounded-md border border-red-200 px-4 py-2 text-sm font-semibold text-red-700 hover:bg-red-50">Reportar</button>
                        </div>

                        <div class="mt-5 grid gap-5 xl:grid-cols-3">
                            <div class="rounded-md border border-slate-200 p-4">
                                <h4 class="font-bold">Verificacion</h4>
                                <div class="mt-4 space-y-2 text-sm">
                                    @foreach ([['Identidad verificada', $driver->verified_identity], ['Licencia verificada', $driver->verified_license], ['Vehiculo verificado', $driver->verified_vehicle], ['SOAT vigente', $driver->soat_active], ['Tecnico-mecanica vigente', $driver->technical_review_active]] as $badge)
                                        <p class="rounded-md {{ $badge[1] ? 'bg-emerald-50 text-emerald-800' : 'bg-red-50 text-red-700' }} p-2 font-semibold">{{ $badge[0] }}</p>
                                    @endforeach
                                </div>
                            </div>

                            <div class="rounded-md border border-slate-200 p-4">
                                <h4 class="font-bold">Vehiculo</h4>
                                <dl class="mt-4 space-y-2 text-sm">
                                    <div><dt class="text-slate-500">Marca y modelo</dt><dd class="font-semibold">{{ $driver->vehicle_brand }} {{ $driver->vehicle_model }} {{ $driver->vehicle_year }}</dd></div>
                                    <div><dt class="text-slate-500">Placa</dt><dd class="font-semibold">{{ $driver->plate_mask }}</dd></div>
                                    <div><dt class="text-slate-500">Tipo</dt><dd class="font-semibold">{{ $driver->vehicle_type }}</dd></div>
                                    <div><dt class="text-slate-500">Capacidad</dt><dd class="font-semibold">{{ $driver->capacity_kg }} kg</dd></div>
                                </dl>
                            </div>

                            <div class="rounded-md border border-slate-200 p-4">
                                <h4 class="font-bold">Tarifas y disponibilidad</h4>
                                <dl class="mt-4 space-y-2 text-sm">
                                    <div><dt class="text-slate-500">Tarifa minima</dt><dd class="font-semibold">{{ $money($driver->base_price) }}</dd></div>
                                    <div><dt class="text-slate-500">Precio por km</dt><dd class="font-semibold">{{ $money($driver->price_per_km) }}</dd></div>
                                    <div><dt class="text-slate-500">Distancia</dt><dd class="font-semibold">{{ $driver->distance_km }} km</dd></div>
                                    <div><dt class="text-slate-500">Disponible</dt><dd class="font-semibold">{{ $driver->availability }}</dd></div>
                                </dl>
                            </div>
                        </div>

                        <div class="mt-5 grid gap-5 xl:grid-cols-[1fr_0.8fr]">
                            <div class="rounded-md border border-slate-200 p-4">
                                <h4 class="font-bold">Estadisticas</h4>
                                <div class="mt-4 grid gap-3 sm:grid-cols-3">
                                    @foreach ([['Servicios realizados', $driver->trips], ['Calificacion', $driver->rating], ['Respuesta', $driver->response_minutes . ' min'], ['Cancelados', $driver->cancelled_trips], ['Completados', $driver->completed_percent . '%'], ['Capacidad', $driver->capacity_kg . ' kg']] as $stat)
                                        <div class="rounded-md bg-slate-50 p-3"><p class="text-xs text-slate-500">{{ $stat[0] }}</p><p class="mt-1 text-xl font-bold">{{ $stat[1] }}</p></div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="rounded-md border border-slate-200 p-4">
                                <h4 class="font-bold">Ubicacion aproximada</h4>
                                <div class="mt-4 flex h-40 items-center justify-center rounded-md bg-slate-100 text-center text-sm font-semibold text-slate-500">
                                    {{ $driver->lat }}, {{ $driver->lng }}<br>A {{ $driver->distance_km }} km
                                </div>
                                <p class="mt-3 text-sm text-slate-600">Tiempo aproximado para llegar: {{ max(3, (int) round($driver->distance_km * 4)) }} minutos.</p>
                            </div>
                        </div>

                        <div class="mt-5 rounded-md border border-slate-200 p-4">
                            <h4 class="font-bold">Comentarios</h4>
                            <div class="mt-4 grid gap-3 md:grid-cols-2">
                                <blockquote class="rounded-md bg-slate-50 p-3 text-sm">5 estrellas. Llego puntual y cuido muy bien la carga.</blockquote>
                                <blockquote class="rounded-md bg-slate-50 p-3 text-sm">5 estrellas. Excelente comunicacion durante el viaje.</blockquote>
                            </div>
                        </div>
                    </section>
                @empty
                    <div class="rounded-lg border border-slate-200 bg-white p-8 text-center">
                        <h3 class="text-xl font-bold">No hay conductores con esos filtros</h3>
                        <p class="mt-2 text-slate-500">Prueba ampliar la busqueda o quitar algun filtro.</p>
                    </div>
                @endforelse
            </section>
        </main>
    </div>

    <script>
        const csrf = @json(csrf_token());
        const pendingRequests = @json($pendingRequests);
        const routes = {
            best: @json(route('cliente.conductores.best')),
            favorite: @json(route('cliente.conductores.favorite', ['driver' => '__ID__'])),
            request: @json(route('cliente.conductores.request', ['driver' => '__ID__'])),
            message: @json(route('cliente.conductores.message', ['driver' => '__ID__'])),
            report: @json(route('cliente.conductores.report', ['driver' => '__ID__'])),
        };

        function routeFor(name, id) {
            return routes[name].replace('__ID__', id);
        }

        async function postJson(url, payload = {}) {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                },
                body: JSON.stringify(payload),
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || 'No se pudo completar la accion.');
            }

            return data;
        }

        document.querySelectorAll('[data-profile]').forEach((button) => {
            button.addEventListener('click', () => {
                const panel = document.getElementById(`driver-profile-${button.dataset.profile}`);
                panel.classList.toggle('hidden');
                panel.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });

        document.querySelector('[data-best-driver]').addEventListener('click', async () => {
            const params = new URLSearchParams(window.location.search);
            const url = `${routes.best}?${params.toString()}`;
            const result = await fetch(url, { headers: { Accept: 'application/json' } }).then((response) => response.json());

            if (!result.driver) {
                Swal.fire({ icon: 'info', title: 'Sin candidatos', text: result.message, confirmButtonColor: '#059669' });
                return;
            }

            const panel = document.getElementById('best-driver-result');
            panel.innerHTML = `
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">recomendacion inteligente</p>
                        <h3 class="mt-1 text-xl font-bold">Mejor candidato: ${result.driver.name}</h3>
                        <p class="mt-2 text-sm text-slate-700">${result.message}</p>
                    </div>
                    <button type="button" data-service-request="${result.driver.id}" data-driver-name="${result.driver.name}" class="rounded-md bg-emerald-600 px-4 py-2 text-sm font-semibold text-white">Solicitar servicio</button>
                </div>
            `;
            panel.classList.remove('hidden');
            panel.scrollIntoView({ behavior: 'smooth', block: 'start' });
            bindServiceButtons();
            Swal.fire({ icon: 'success', title: 'Mejor conductor encontrado', text: result.message, confirmButtonColor: '#059669' });
        });

        document.querySelectorAll('[data-favorite]').forEach((button) => {
            button.addEventListener('click', async () => {
                try {
                    const data = await postJson(routeFor('favorite', button.dataset.favorite));
                    button.textContent = data.active ? 'Quitar de favoritos' : 'Agregar a favoritos';
                    button.classList.toggle('border-emerald-300', data.active);
                    button.classList.toggle('bg-emerald-50', data.active);
                    button.classList.toggle('text-emerald-700', data.active);
                    Swal.fire({ icon: 'success', title: 'Favoritos actualizado', text: data.message, timer: 1800, showConfirmButton: false });
                } catch (error) {
                    Swal.fire({ icon: 'error', title: 'Error', text: error.message, confirmButtonColor: '#dc2626' });
                }
            });
        });

        function bindServiceButtons() {
            document.querySelectorAll('[data-service-request]').forEach((button) => {
                if (button.dataset.bound) return;
                button.dataset.bound = '1';
                button.addEventListener('click', async () => {
                    const options = pendingRequests.map((request) => `<option value="${request.number}">${request.number} - ${request.origin} a ${request.destination} - ${request.weight_kg} kg - $${Number(request.offered_price).toLocaleString('es-CO')}</option>`).join('');
                    const result = await Swal.fire({
                        title: `Enviar solicitud a ${button.dataset.driverName}`,
                        html: `
                            <select id="load-request" class="swal2-input">${options}</select>
                            <textarea id="load-message" class="swal2-textarea" placeholder="Mensaje opcional para el conductor"></textarea>
                        `,
                        showCancelButton: true,
                        confirmButtonText: 'Enviar',
                        cancelButtonText: 'Cancelar',
                        confirmButtonColor: '#059669',
                        preConfirm: () => ({
                            request_number: document.getElementById('load-request').value,
                            message: document.getElementById('load-message').value,
                        }),
                    });

                    if (!result.isConfirmed) return;

                    try {
                        const data = await postJson(routeFor('request', button.dataset.serviceRequest), result.value);
                        Swal.fire({ icon: 'success', title: 'Solicitud enviada', text: data.message, confirmButtonColor: '#059669' });
                    } catch (error) {
                        Swal.fire({ icon: 'error', title: 'Error', text: error.message, confirmButtonColor: '#dc2626' });
                    }
                });
            });
        }

        document.querySelectorAll('[data-message]').forEach((button) => {
            button.addEventListener('click', async () => {
                const result = await Swal.fire({
                    title: `Mensaje para ${button.dataset.driverName}`,
                    input: 'textarea',
                    inputPlaceholder: 'Escribe tu mensaje',
                    showCancelButton: true,
                    confirmButtonText: 'Enviar',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#059669',
                    inputValidator: (value) => !value ? 'Escribe un mensaje.' : null,
                });

                if (!result.isConfirmed) return;

                try {
                    const data = await postJson(routeFor('message', button.dataset.message), { message: result.value });
                    Swal.fire({ icon: 'success', title: 'Mensaje enviado', text: data.message, confirmButtonColor: '#059669' });
                } catch (error) {
                    Swal.fire({ icon: 'error', title: 'Error', text: error.message, confirmButtonColor: '#dc2626' });
                }
            });
        });

        document.querySelectorAll('[data-report]').forEach((button) => {
            button.addEventListener('click', async () => {
                const result = await Swal.fire({
                    title: `Reportar a ${button.dataset.driverName}`,
                    html: `
                        <select id="report-reason" class="swal2-input">
                            <option>Incumplimiento</option>
                            <option>Mala conducta</option>
                            <option>Vehiculo diferente</option>
                            <option>Retraso</option>
                            <option>Otro motivo</option>
                        </select>
                        <textarea id="report-description" class="swal2-textarea" placeholder="Describe lo ocurrido"></textarea>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Enviar reporte',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#dc2626',
                    preConfirm: () => ({
                        reason: document.getElementById('report-reason').value,
                        description: document.getElementById('report-description').value,
                    }),
                });

                if (!result.isConfirmed) return;

                try {
                    const data = await postJson(routeFor('report', button.dataset.report), result.value);
                    Swal.fire({ icon: 'success', title: 'Reporte enviado', text: data.message, confirmButtonColor: '#059669' });
                } catch (error) {
                    Swal.fire({ icon: 'error', title: 'Error', text: error.message, confirmButtonColor: '#dc2626' });
                }
            });
        });

        bindServiceButtons();
    </script>
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
