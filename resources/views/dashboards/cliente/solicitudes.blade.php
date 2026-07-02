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
    $statuses = ['Pendiente', 'Publicada', 'Con ofertas', 'Conductor seleccionado', 'En camino', 'Recogida', 'En transito', 'Entregada', 'Finalizada', 'Cancelada'];
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitudes de carga</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 text-slate-900">
    <div class="min-h-screen lg:pl-[280px]">
        <aside class="bg-slate-950 px-5 py-6 text-white lg:fixed lg:inset-y-0 lg:left-0 lg:w-[280px] lg:overflow-y-auto">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-300">Mudanza</p>
            <h1 class="mt-2 text-xl font-bold">Cliente</h1>

            <nav class="mt-8 space-y-1">
                @foreach ($menuItems as $item)
                    <a href="{{ $item['url'] }}" class="block rounded-md px-3 py-2 text-sm font-semibold transition {{ $item['label'] === 'Solicitudes de carga' ? 'bg-white text-slate-950' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
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
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-700">solicitudes de carga</p>
                    <h2 class="mt-2 text-3xl font-bold">Gestion de solicitudes</h2>
                    <p class="mt-2 text-slate-600">Crea, consulta, edita, cancela, duplica y revisa todos los detalles de tus envios.</p>
                </div>
                <button type="button" class="rounded-md bg-emerald-600 px-4 py-2.5 font-semibold text-white hover:bg-emerald-700">Nueva solicitud</button>
            </div>

            <section class="mt-8 grid gap-3 md:grid-cols-3 xl:grid-cols-6">
                <button class="rounded-md bg-emerald-600 px-4 py-3 text-sm font-semibold text-white hover:bg-emerald-700">Nueva solicitud</button>
                <button class="rounded-md border border-slate-300 bg-white px-4 py-3 text-sm font-semibold hover:bg-slate-50">Ver solicitudes</button>
                <button class="rounded-md border border-slate-300 bg-white px-4 py-3 text-sm font-semibold hover:bg-slate-50">Editar solicitud</button>
                <button class="rounded-md border border-red-200 bg-white px-4 py-3 text-sm font-semibold text-red-700 hover:bg-red-50">Cancelar solicitud</button>
                <button class="rounded-md border border-slate-300 bg-white px-4 py-3 text-sm font-semibold hover:bg-slate-50">Ver detalles</button>
                <button class="rounded-md border border-slate-300 bg-white px-4 py-3 text-sm font-semibold hover:bg-slate-50">Duplicar solicitud</button>
            </section>

            <section class="mt-6 rounded-lg border border-slate-200 bg-white p-5">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <h3 class="text-xl font-bold">Listado de solicitudes</h3>
                        <p class="mt-1 text-sm text-slate-500">Vista rapida de solicitudes recientes y sus estados.</p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @foreach (['Pendiente', 'En transito', 'Finalizada', 'Cancelada'] as $filter)
                            <button class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700 hover:bg-slate-200">{{ $filter }}</button>
                        @endforeach
                    </div>
                </div>

                <div class="mt-5 overflow-x-auto">
                    <table class="w-full min-w-[920px] text-left text-sm">
                        <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                            <tr>
                                <th class="px-3 py-3">Numero</th>
                                <th class="px-3 py-3">Fecha</th>
                                <th class="px-3 py-3">Tipo de carga</th>
                                <th class="px-3 py-3">Peso</th>
                                <th class="px-3 py-3">Origen</th>
                                <th class="px-3 py-3">Destino</th>
                                <th class="px-3 py-3">Precio</th>
                                <th class="px-3 py-3">Estado</th>
                                <th class="px-3 py-3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <tr>
                                <td class="px-3 py-4 font-semibold">#MD-1024</td>
                                <td class="px-3 py-4">2026-07-01</td>
                                <td class="px-3 py-4">Electrodomesticos</td>
                                <td class="px-3 py-4">850 kg</td>
                                <td class="px-3 py-4">Bogota</td>
                                <td class="px-3 py-4">Medellin</td>
                                <td class="px-3 py-4">$1.250.000</td>
                                <td class="px-3 py-4"><span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-800">En camino</span></td>
                                <td class="px-3 py-4"><button class="font-semibold text-emerald-700">Detalles</button></td>
                            </tr>
                            <tr>
                                <td class="px-3 py-4 font-semibold">#MD-1025</td>
                                <td class="px-3 py-4">2026-07-02</td>
                                <td class="px-3 py-4">Muebles</td>
                                <td class="px-3 py-4">420 kg</td>
                                <td class="px-3 py-4">Cali</td>
                                <td class="px-3 py-4">Pereira</td>
                                <td class="px-3 py-4">$680.000</td>
                                <td class="px-3 py-4"><span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800">Con ofertas</span></td>
                                <td class="px-3 py-4"><button class="font-semibold text-emerald-700">Editar</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <div class="mt-6 grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
                <section class="rounded-lg border border-slate-200 bg-white p-5">
                    <h3 class="text-xl font-bold">Nueva solicitud</h3>
                    <p class="mt-1 text-sm text-slate-500">Informacion completa de la solicitud.</p>

                    <div class="mt-5 grid gap-4 md:grid-cols-2">
                        @foreach ([
                            'Numero de solicitud', 'Estado', 'Fecha', 'Tipo de carga', 'Descripcion', 'Peso', 'Volumen', 'Cantidad',
                            'Valor declarado', 'Tipo de vehiculo requerido', 'Origen', 'Destino', 'Fecha de recogida', 'Hora de recogida',
                            'Precio ofrecido', 'Observaciones',
                        ] as $field)
                            <div>
                                <label class="mb-2 block text-sm font-medium">{{ $field }}</label>
                                <input type="text" class="w-full rounded-md border border-slate-300 px-3 py-2 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4 grid gap-4 md:grid-cols-2">
                        <label class="rounded-md border border-dashed border-slate-300 p-4">
                            <span class="block text-sm font-semibold">Fotografias de la carga</span>
                            <input type="file" multiple class="mt-3 w-full text-sm">
                        </label>
                        <label class="rounded-md border border-dashed border-slate-300 p-4">
                            <span class="block text-sm font-semibold">Documentos adjuntos</span>
                            <input type="file" multiple class="mt-3 w-full text-sm">
                        </label>
                    </div>

                    <div class="mt-5 flex flex-wrap justify-end gap-2">
                        <button class="rounded-md border border-slate-300 px-4 py-2.5 font-semibold hover:bg-slate-50">Guardar borrador</button>
                        <button class="rounded-md bg-emerald-600 px-4 py-2.5 font-semibold text-white hover:bg-emerald-700">Publicar solicitud</button>
                    </div>
                </section>

                <section class="space-y-6">
                    <div class="rounded-lg border border-slate-200 bg-white p-5">
                        <h3 class="text-xl font-bold">Estados posibles</h3>
                        <div class="mt-4 flex flex-wrap gap-2">
                            @foreach ($statuses as $state)
                                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">{{ $state }}</span>
                            @endforeach
                        </div>
                    </div>

                    <div class="rounded-lg border border-slate-200 bg-white p-5">
                        <h3 class="text-xl font-bold">Detalle rapido</h3>
                        <dl class="mt-4 space-y-3 text-sm">
                            <div class="flex justify-between gap-4"><dt class="text-slate-500">Solicitud</dt><dd class="font-semibold">#MD-1024</dd></div>
                            <div class="flex justify-between gap-4"><dt class="text-slate-500">Carga</dt><dd class="font-semibold">Electrodomesticos</dd></div>
                            <div class="flex justify-between gap-4"><dt class="text-slate-500">Vehiculo</dt><dd class="font-semibold">Furgon</dd></div>
                            <div class="flex justify-between gap-4"><dt class="text-slate-500">Ruta</dt><dd class="font-semibold">Bogota a Medellin</dd></div>
                            <div class="flex justify-between gap-4"><dt class="text-slate-500">Precio</dt><dd class="font-semibold">$1.250.000</dd></div>
                        </dl>
                    </div>
                </section>
            </div>
        </main>
    </div>
</body>
</html>
