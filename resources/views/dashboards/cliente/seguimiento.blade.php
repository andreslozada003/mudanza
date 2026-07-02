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
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seguimiento</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
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
                    <h2 class="mt-2 text-3xl font-bold">Solicitud <span data-request-number>{{ $tracking['request_number'] }}</span></h2>
                    <p class="mt-2 text-slate-600">La pantalla se actualiza automaticamente con la ultima ubicacion del servicio.</p>
                </div>
                <div class="flex flex-wrap items-center gap-2">
                    <span data-last-update class="rounded-full bg-slate-200 px-4 py-2 text-sm font-semibold text-slate-700">Actualizado {{ $tracking['updated_at'] }}</span>
                    <span data-status class="rounded-full bg-emerald-100 px-4 py-2 text-sm font-semibold text-emerald-800">{{ $tracking['status'] }}</span>
                </div>
            </div>

            <section class="mt-8 grid gap-4 md:grid-cols-2 xl:grid-cols-5">
                <div class="rounded-lg border border-slate-200 bg-white p-5"><p class="text-sm font-semibold text-slate-500">Estado actual</p><p data-status-text class="mt-3 text-xl font-bold">{{ $tracking['status'] }}</p></div>
                <div class="rounded-lg border border-slate-200 bg-white p-5"><p class="text-sm font-semibold text-slate-500">Ubicacion GPS</p><p data-gps class="mt-3 text-xl font-bold">{{ $tracking['lat'] }}, {{ $tracking['lng'] }}</p></div>
                <div class="rounded-lg border border-slate-200 bg-white p-5"><p class="text-sm font-semibold text-slate-500">Tiempo estimado</p><p data-eta class="mt-3 text-xl font-bold">{{ $tracking['eta_text'] }}</p></div>
                <div class="rounded-lg border border-slate-200 bg-white p-5"><p class="text-sm font-semibold text-slate-500">Kilometros restantes</p><p data-km class="mt-3 text-xl font-bold">{{ $tracking['remaining_km'] }} km</p></div>
                <div class="rounded-lg border border-slate-200 bg-white p-5"><p class="text-sm font-semibold text-slate-500">Hora de llegada</p><p data-arrival class="mt-3 text-xl font-bold">{{ $tracking['arrival_time'] }}</p></div>
            </section>

            <div class="mt-6 grid gap-6 xl:grid-cols-[1.3fr_0.7fr]">
                <section class="rounded-lg border border-slate-200 bg-white p-5">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <h3 class="text-xl font-bold">Mapa del recorrido</h3>
                            <p class="mt-1 text-sm text-slate-500">Ruta aproximada entre Puerto Asis y Mocoa con posicion del conductor.</p>
                        </div>
                        <button type="button" data-refresh class="rounded-md bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Actualizar ahora</button>
                    </div>
                    <div id="map" class="mt-5 h-96 rounded-lg border border-slate-200 bg-slate-50"></div>
                    <p class="mt-3 text-xs text-slate-500">Si el mapa no carga, revisa tu conexion a internet. Las coordenadas siguen actualizandose desde el servidor.</p>
                </section>

                <section class="rounded-lg border border-slate-200 bg-white p-5">
                    <h3 class="text-xl font-bold">Conductor</h3>
                    <dl class="mt-4 space-y-3 text-sm">
                        <div class="flex justify-between gap-4"><dt class="text-slate-500">Nombre</dt><dd data-driver-name class="font-semibold">{{ $tracking['driver']['name'] }}</dd></div>
                        <div class="flex justify-between gap-4"><dt class="text-slate-500">Vehiculo</dt><dd class="font-semibold">{{ $tracking['driver']['vehicle'] }}</dd></div>
                        <div class="flex justify-between gap-4"><dt class="text-slate-500">Placa</dt><dd class="font-semibold">{{ $tracking['driver']['plate'] }}</dd></div>
                        <div class="flex justify-between gap-4"><dt class="text-slate-500">Telefono</dt><dd class="font-semibold">{{ $tracking['driver']['phone'] }}</dd></div>
                    </dl>

                    <h3 class="mt-6 text-xl font-bold">Funciones</h3>
                    <div class="mt-4 grid gap-3">
                        <button type="button" data-share class="rounded-md bg-slate-900 px-4 py-3 text-sm font-semibold text-white hover:bg-slate-700">Compartir seguimiento</button>
                        <button type="button" data-contact class="rounded-md border border-slate-300 bg-white px-4 py-3 text-sm font-semibold hover:bg-slate-50">Contactar conductor</button>
                        <button type="button" data-history class="rounded-md border border-slate-300 bg-white px-4 py-3 text-sm font-semibold hover:bg-slate-50">Ver historial de ubicaciones</button>
                        <button type="button" data-download class="rounded-md border border-slate-300 bg-white px-4 py-3 text-sm font-semibold hover:bg-slate-50">Descargar comprobante</button>
                    </div>
                </section>
            </div>

            <section id="history-panel" class="mt-6 hidden rounded-lg border border-slate-200 bg-white p-5">
                <h3 class="text-xl font-bold">Historial de ubicaciones</h3>
                <div data-history-list class="mt-5 grid gap-3 md:grid-cols-3"></div>
            </section>

            <section class="mt-6 rounded-lg border border-slate-200 bg-white p-5">
                <h3 class="text-xl font-bold">Linea de tiempo</h3>
                <div data-timeline class="mt-6 space-y-4"></div>
            </section>
        </main>
    </div>

    <script>
        const trackingUrl = @json(route('cliente.seguimiento.live'));
        let tracking = @json($tracking);
        let map;
        let driverMarker;
        let routeLine;

        function updateText(payload) {
            document.querySelector('[data-status]').textContent = payload.status;
            document.querySelector('[data-status-text]').textContent = payload.status;
            document.querySelector('[data-gps]').textContent = `${payload.lat}, ${payload.lng}`;
            document.querySelector('[data-eta]').textContent = payload.eta_text;
            document.querySelector('[data-km]').textContent = `${payload.remaining_km} km`;
            document.querySelector('[data-arrival]').textContent = payload.arrival_time;
            document.querySelector('[data-last-update]').textContent = `Actualizado ${payload.updated_at}`;
            renderTimeline(payload.timeline);
            renderHistory(payload.history);
        }

        function renderTimeline(items) {
            const container = document.querySelector('[data-timeline]');
            container.innerHTML = items.map((step, index) => `
                <div class="flex gap-4">
                    <div class="flex flex-col items-center">
                        <span class="flex h-9 w-9 items-center justify-center rounded-full text-sm font-bold ${step.done ? 'bg-emerald-600 text-white' : 'bg-slate-200 text-slate-500'}">
                            ${step.done ? 'OK' : '-'}
                        </span>
                        ${index + 1 < items.length ? '<span class="h-8 w-px bg-slate-200"></span>' : ''}
                    </div>
                    <div class="pb-3">
                        <p class="font-semibold">${step.label}</p>
                        <p class="mt-1 text-sm text-slate-500">${step.time}</p>
                    </div>
                </div>
            `).join('');
        }

        function renderHistory(items) {
            const container = document.querySelector('[data-history-list]');
            container.innerHTML = items.map((item) => `
                <div class="rounded-md bg-slate-50 p-4 text-sm">
                    <p class="font-bold">${item.event}</p>
                    <p class="mt-1 text-slate-500">${item.time}</p>
                    <p class="mt-2 font-semibold">${item.lat}, ${item.lng}</p>
                </div>
            `).join('');
        }

        function initMap(payload) {
            if (!window.L) {
                return;
            }

            map = L.map('map').setView([payload.lat, payload.lng], 10);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap',
            }).addTo(map);

            const routePoints = payload.route.map((point) => [point.lat, point.lng]);
            routeLine = L.polyline(routePoints, { color: '#059669', weight: 5 }).addTo(map);
            L.marker([payload.origin.lat, payload.origin.lng]).addTo(map).bindPopup('Origen: ' + payload.origin.label);
            L.marker([payload.destination.lat, payload.destination.lng]).addTo(map).bindPopup('Destino: ' + payload.destination.label);
            driverMarker = L.marker([payload.lat, payload.lng]).addTo(map).bindPopup('Conductor');
            map.fitBounds(routeLine.getBounds(), { padding: [30, 30] });
        }

        function updateMap(payload) {
            if (!map || !driverMarker) {
                return;
            }

            driverMarker.setLatLng([payload.lat, payload.lng]);
        }

        async function refreshTracking(showAlert = false) {
            try {
                const response = await fetch(trackingUrl, { headers: { Accept: 'application/json' } });
                tracking = await response.json();
                updateText(tracking);
                updateMap(tracking);

                if (showAlert) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Seguimiento actualizado',
                        text: `Ultima ubicacion: ${tracking.lat}, ${tracking.lng}`,
                        confirmButtonColor: '#059669',
                    });
                }
            } catch (error) {
                if (showAlert) {
                    Swal.fire({
                        icon: 'error',
                        title: 'No se pudo actualizar',
                        text: 'Revisa la conexion o intenta nuevamente.',
                        confirmButtonColor: '#dc2626',
                    });
                }
            }
        }

        document.querySelector('[data-refresh]').addEventListener('click', () => refreshTracking(true));
        document.querySelector('[data-history]').addEventListener('click', () => {
            document.getElementById('history-panel').classList.toggle('hidden');
            renderHistory(tracking.history);
        });
        document.querySelector('[data-contact]').addEventListener('click', () => {
            Swal.fire({
                icon: 'info',
                title: 'Contactar conductor',
                text: `Puedes llamar a ${tracking.driver.name}: ${tracking.driver.phone}`,
                confirmButtonColor: '#059669',
            });
        });
        document.querySelector('[data-share]').addEventListener('click', () => {
            navigator.clipboard?.writeText(window.location.href);
            Swal.fire({
                icon: 'success',
                title: 'Enlace copiado',
                text: 'El enlace de seguimiento quedo listo para compartir.',
                confirmButtonColor: '#059669',
            });
        });
        document.querySelector('[data-download]').addEventListener('click', () => {
            Swal.fire({
                icon: 'success',
                title: 'Comprobante generado',
                text: 'Cuando conectemos documentos reales, aqui se descargara el PDF del servicio.',
                confirmButtonColor: '#059669',
            });
        });

        updateText(tracking);
        initMap(tracking);
        setInterval(refreshTracking, 5000);
    </script>
</body>
</html>
