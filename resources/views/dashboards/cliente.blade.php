@php
    $user = auth()->user();
    $verification = $user->verification;
    $status = $verification?->status ?? 'pendiente';

    $statusConfig = [
        'aprobado' => [
            'label' => 'Cuenta verificada',
            'message' => 'Tu cuenta esta aprobada. Ya puedes usar todas las funciones del cliente.',
            'badge' => 'bg-emerald-100 text-emerald-800',
            'panel' => 'border-emerald-200 bg-emerald-50',
        ],
        'en_revision' => [
            'label' => 'Verificacion en revision',
            'message' => 'Estamos revisando tus documentos. Algunas funciones pueden estar limitadas.',
            'badge' => 'bg-amber-100 text-amber-800',
            'panel' => 'border-amber-200 bg-amber-50',
        ],
        'rechazado' => [
            'label' => 'Verificacion rechazada',
            'message' => $verification?->observations ?: 'Debes volver a cargar documentos claros para continuar.',
            'badge' => 'bg-red-100 text-red-800',
            'panel' => 'border-red-200 bg-red-50',
        ],
        'pendiente' => [
            'label' => 'Verificacion pendiente',
            'message' => 'Completa tu verificacion para activar todas las funciones.',
            'badge' => 'bg-slate-200 text-slate-700',
            'panel' => 'border-slate-200 bg-white',
        ],
    ];

    $current = $statusConfig[$status] ?? $statusConfig['pendiente'];
    $firstName = explode(' ', trim($user->name))[0] ?: 'Cliente';

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
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel cliente</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 text-slate-900">
    <div class="min-h-screen lg:pl-[280px]">
        <aside class="bg-slate-950 px-5 py-6 text-white lg:fixed lg:inset-y-0 lg:left-0 lg:w-[280px] lg:overflow-y-auto">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-300">Mudanza</p>
                <h1 class="mt-2 text-xl font-bold">Cliente</h1>
            </div>

            <nav class="mt-8 space-y-1">
                @foreach ($menuItems as $index => $item)
                    <a href="{{ $item['url'] }}" class="block rounded-md px-3 py-2 text-sm font-semibold transition {{ $index === 0 ? 'bg-white text-slate-950' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        {{ $item['label'] }}
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
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-700">dashboard</p>
                    <h2 class="mt-2 text-3xl font-bold">Hola, {{ $firstName }}</h2>
                    <p class="mt-2 text-slate-600">Gestiona todo el proceso de envio de tus cargas desde un solo lugar.</p>
                </div>
                <button type="button" class="rounded-md bg-emerald-600 px-4 py-2.5 font-semibold text-white hover:bg-emerald-700">
                    Nueva solicitud
                </button>
            </div>

            <section class="mt-8 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-lg border border-slate-200 bg-white p-5">
                    <p class="text-sm font-semibold text-slate-500">Solicitudes activas</p>
                    <p class="mt-3 text-3xl font-bold">2</p>
                </div>
                <div class="rounded-lg border border-slate-200 bg-white p-5">
                    <p class="text-sm font-semibold text-slate-500">En transito</p>
                    <p class="mt-3 text-3xl font-bold">1</p>
                </div>
                <div class="rounded-lg border border-slate-200 bg-white p-5">
                    <p class="text-sm font-semibold text-slate-500">Finalizadas</p>
                    <p class="mt-3 text-3xl font-bold">35</p>
                </div>
                <div class="rounded-lg border border-slate-200 bg-white p-5">
                    <p class="text-sm font-semibold text-slate-500">Pendientes de pago</p>
                    <p class="mt-3 text-3xl font-bold">1</p>
                </div>
            </section>

            <section class="mt-6 rounded-lg border p-5 {{ $current['panel'] }}">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <h3 class="text-xl font-bold">Estado de la cuenta</h3>
                        <p class="mt-1 text-sm text-slate-700">{{ $current['message'] }}</p>
                    </div>
                    <span class="rounded-full px-3 py-1 text-sm font-semibold {{ $current['badge'] }}">
                        {{ $current['label'] }}
                    </span>
                </div>
            </section>

            <div class="mt-6 grid gap-6 xl:grid-cols-[1.4fr_0.9fr]">
                <section class="rounded-lg border border-slate-200 bg-white p-5">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <h3 class="text-xl font-bold">Solicitudes de carga</h3>
                            <p class="mt-1 text-sm text-slate-500">Crea, consulta, edita, cancela o duplica solicitudes.</p>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <button class="rounded-md bg-emerald-600 px-3 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Crear</button>
                            <button class="rounded-md border border-slate-300 px-3 py-2 text-sm font-semibold hover:bg-slate-50">Ver todas</button>
                        </div>
                    </div>

                    <div class="mt-5 overflow-x-auto">
                        <table class="w-full min-w-[760px] text-left text-sm">
                            <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                                <tr>
                                    <th class="px-3 py-3">Numero</th>
                                    <th class="px-3 py-3">Carga</th>
                                    <th class="px-3 py-3">Origen</th>
                                    <th class="px-3 py-3">Destino</th>
                                    <th class="px-3 py-3">Precio</th>
                                    <th class="px-3 py-3">Estado</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <tr>
                                    <td class="px-3 py-4 font-semibold">#MD-1024</td>
                                    <td class="px-3 py-4">Electrodomesticos, 850 kg</td>
                                    <td class="px-3 py-4">Bogota</td>
                                    <td class="px-3 py-4">Medellin</td>
                                    <td class="px-3 py-4">$1.250.000</td>
                                    <td class="px-3 py-4"><span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-800">En camino</span></td>
                                </tr>
                                <tr>
                                    <td class="px-3 py-4 font-semibold">#MD-1025</td>
                                    <td class="px-3 py-4">Muebles, 420 kg</td>
                                    <td class="px-3 py-4">Cali</td>
                                    <td class="px-3 py-4">Pereira</td>
                                    <td class="px-3 py-4">$680.000</td>
                                    <td class="px-3 py-4"><span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800">Con ofertas</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <section class="rounded-lg border border-slate-200 bg-white p-5">
                    <h3 class="text-xl font-bold">Centro de control</h3>
                    <div class="mt-5 space-y-4">
                        <div class="flex justify-between gap-3"><span class="text-sm text-slate-600">Servicios activos</span><strong>2</strong></div>
                        <div class="flex justify-between gap-3"><span class="text-sm text-slate-600">Dinero gastado este mes</span><strong>$2.430.000</strong></div>
                        <div class="flex justify-between gap-3"><span class="text-sm text-slate-600">Tiempo promedio de entrega</span><strong>18 h</strong></div>
                        <div class="flex justify-between gap-3"><span class="text-sm text-slate-600">Conductores favoritos</span><strong>4</strong></div>
                        <div class="flex justify-between gap-3"><span class="text-sm text-slate-600">Alertas importantes</span><strong class="text-amber-700">2</strong></div>
                    </div>
                </section>
            </div>

            <section class="mt-6 grid gap-6 xl:grid-cols-3">
                <div class="rounded-lg border border-slate-200 bg-white p-5">
                    <h3 class="text-lg font-bold">Buscar conductor</h3>
                    <p class="mt-2 text-sm text-slate-500">Filtra por vehiculo, capacidad, calificacion, precio y distancia.</p>
                    <div class="mt-4 rounded-md bg-slate-50 p-3 text-sm text-slate-600">Conductores disponibles, favoritos y perfiles.</div>
                </div>
                <div class="rounded-lg border border-slate-200 bg-white p-5">
                    <h3 class="text-lg font-bold">Seguimiento en tiempo real</h3>
                    <p class="mt-2 text-sm text-slate-500">Estado: conductor en camino. ETA: 35 min. Restan 14 km.</p>
                    <div class="mt-4 h-28 rounded-md bg-slate-100 p-3 text-sm text-slate-500">Mapa del servicio activo</div>
                </div>
                <div class="rounded-lg border border-slate-200 bg-white p-5">
                    <h3 class="text-lg font-bold">Mensajes</h3>
                    <div class="mt-4 space-y-3 text-sm">
                        <p class="rounded-md bg-slate-50 p-3"><strong>Conductor:</strong> Estoy a 10 minutos.</p>
                        <p class="rounded-md bg-slate-50 p-3"><strong>Soporte:</strong> Servicio monitoreado.</p>
                    </div>
                </div>
            </section>

            <section class="mt-6 grid gap-6 xl:grid-cols-4">
                <div class="rounded-lg border border-slate-200 bg-white p-5">
                    <h3 class="text-lg font-bold">Pagos</h3>
                    <p class="mt-2 text-sm text-slate-500">Costo, pago, factura, recibo e historial.</p>
                </div>
                <div class="rounded-lg border border-slate-200 bg-white p-5">
                    <h3 class="text-lg font-bold">Historial</h3>
                    <p class="mt-2 text-sm text-slate-500">Viajes, fechas, costos, conductores y estados.</p>
                </div>
                <div class="rounded-lg border border-slate-200 bg-white p-5">
                    <h3 class="text-lg font-bold">Calificaciones</h3>
                    <p class="mt-2 text-sm text-slate-500">Evalua puntualidad, comunicacion y cuidado de la carga.</p>
                </div>
                <div class="rounded-lg border border-slate-200 bg-white p-5">
                    <h3 class="text-lg font-bold">Notificaciones</h3>
                    <p class="mt-2 text-sm text-slate-500">Solicitudes, pagos, mensajes y alertas.</p>
                </div>
            </section>

            <section class="mt-6 grid gap-6 xl:grid-cols-3">
                <div class="rounded-lg border border-slate-200 bg-white p-5">
                    <h3 class="text-lg font-bold">Conductores favoritos</h3>
                    <p class="mt-2 text-sm text-slate-500">Guarda conductores para contratarlos de nuevo.</p>
                </div>
                <div class="rounded-lg border border-slate-200 bg-white p-5">
                    <h3 class="text-lg font-bold">Mi perfil</h3>
                    <p class="mt-2 text-sm text-slate-500">{{ $user->name }} · {{ $user->phone ?? 'Sin celular' }}</p>
                </div>
                <div class="rounded-lg border border-slate-200 bg-white p-5">
                    <h3 class="text-lg font-bold">Seguridad</h3>
                    <p class="mt-2 text-sm text-slate-500">Verificacion, sesiones, contrasena y privacidad.</p>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
