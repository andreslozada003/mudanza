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
                <button type="button" data-open-request class="rounded-md bg-emerald-600 px-4 py-2.5 font-semibold text-white hover:bg-emerald-700">Nueva solicitud</button>
            </div>

            <section class="mt-8 grid gap-3 md:grid-cols-3 xl:grid-cols-6">
                <button type="button" data-open-request class="rounded-md bg-emerald-600 px-4 py-3 text-sm font-semibold text-white hover:bg-emerald-700">Nueva solicitud</button>
                <button type="button" data-open-list class="rounded-md border border-slate-300 bg-white px-4 py-3 text-sm font-semibold hover:bg-slate-50">Ver solicitudes</button>
                <button type="button" data-open-edit class="rounded-md border border-slate-300 bg-white px-4 py-3 text-sm font-semibold hover:bg-slate-50">Editar solicitud</button>
                <button type="button" data-open-cancel class="rounded-md border border-red-200 bg-white px-4 py-3 text-sm font-semibold text-red-700 hover:bg-red-50">Cancelar solicitud</button>
                <button type="button" data-view-request class="rounded-md border border-slate-300 bg-white px-4 py-3 text-sm font-semibold hover:bg-slate-50">Ver detalles</button>
                <button type="button" data-open-duplicate class="rounded-md border border-slate-300 bg-white px-4 py-3 text-sm font-semibold hover:bg-slate-50">Duplicar solicitud</button>
            </section>

            <section id="ver-solicitudes" class="mt-6 rounded-lg border border-slate-200 bg-white p-5">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <h3 class="text-xl font-bold">Centro de operaciones</h3>
                        <p class="mt-1 text-sm text-slate-500">Administra tus solicitudes, revisa estados, ofertas, conductor asignado y seguimiento.</p>
                    </div>
                    <button type="button" data-open-request class="rounded-md bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Nueva solicitud</button>
                </div>

                <div class="mt-5 grid gap-3 sm:grid-cols-2 xl:grid-cols-5">
                    @foreach ([['Solicitudes totales', '58'], ['Pendientes', '3'], ['En transito', '2'], ['Finalizadas', '53'], ['Canceladas', '1']] as $stat)
                        <div class="rounded-md border border-slate-200 bg-slate-50 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ $stat[0] }}</p>
                            <p class="mt-2 text-2xl font-bold">{{ $stat[1] }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="mt-5 rounded-lg border border-slate-200 bg-slate-50 p-4">
                    <p class="text-sm font-bold">Filtros</p>
                    <div class="mt-4 grid gap-3 md:grid-cols-2 xl:grid-cols-5">
                        <select class="rounded-md border border-slate-300 bg-white px-3 py-2 text-sm">
                            @foreach (['Todas', 'Pendientes', 'Buscando conductor', 'Con ofertas', 'Conductor asignado', 'En camino', 'En transito', 'Entregadas', 'Finalizadas', 'Canceladas'] as $filter)
                                <option>{{ $filter }}</option>
                            @endforeach
                        </select>
                        <input type="text" placeholder="Numero de solicitud" class="rounded-md border border-slate-300 px-3 py-2 text-sm">
                        <input type="text" placeholder="Origen o destino" class="rounded-md border border-slate-300 px-3 py-2 text-sm">
                        <input type="date" class="rounded-md border border-slate-300 px-3 py-2 text-sm">
                        <select class="rounded-md border border-slate-300 bg-white px-3 py-2 text-sm">
                            @foreach (['Todos los vehiculos', 'Camioneta', 'Furgon', 'Camion', 'Moto', 'Tractomula'] as $vehicle)
                                <option>{{ $vehicle }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mt-3 grid gap-3 md:grid-cols-3">
                        <input type="text" placeholder="Precio minimo" class="rounded-md border border-slate-300 px-3 py-2 text-sm">
                        <input type="text" placeholder="Precio maximo" class="rounded-md border border-slate-300 px-3 py-2 text-sm">
                        <button type="button" class="rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Aplicar filtros</button>
                    </div>
                </div>

                <div class="mt-5 overflow-x-auto">
                    <table class="w-full min-w-[980px] text-left text-sm">
                        <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                            <tr>
                                <th class="px-3 py-3">N</th>
                                <th class="px-3 py-3">Fecha</th>
                                <th class="px-3 py-3">Origen</th>
                                <th class="px-3 py-3">Destino</th>
                                <th class="px-3 py-3">Vehiculo</th>
                                <th class="px-3 py-3">Estado</th>
                                <th class="px-3 py-3">Precio</th>
                                <th class="px-3 py-3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ([
                                ['#000125', '02/07/2026', 'Puerto Asis', 'Mocoa', 'Camioneta', 'Buscando conductor', '$120.000', 'bg-amber-100 text-amber-800', ['Ver', 'Editar', 'Modificar oferta', 'Cancelar']],
                                ['#000124', '01/07/2026', 'Puerto Asis', 'Pasto', 'Camion', 'En transito', '$350.000', 'bg-blue-100 text-blue-800', ['Ver', 'Seguir viaje', 'Chatear', 'Llamar']],
                                ['#000123', '28/06/2026', 'Mocoa', 'Villagarzon', 'Furgon', 'Finalizada', '$180.000', 'bg-emerald-100 text-emerald-800', ['Ver', 'Duplicar', 'Calificar', 'Factura', 'Repetir']],
                            ] as $request)
                                <tr>
                                    <td class="px-3 py-4 font-semibold">{{ $request[0] }}</td>
                                    <td class="px-3 py-4">{{ $request[1] }}</td>
                                    <td class="px-3 py-4">{{ $request[2] }}</td>
                                    <td class="px-3 py-4">{{ $request[3] }}</td>
                                    <td class="px-3 py-4">{{ $request[4] }}</td>
                                    <td class="px-3 py-4"><span class="rounded-full px-3 py-1 text-xs font-semibold {{ $request[7] }}">{{ $request[5] }}</span></td>
                                    <td class="px-3 py-4 font-semibold">{{ $request[6] }}</td>
                                    <td class="px-3 py-4">
                                        <div class="flex flex-wrap gap-2">
                                            @foreach ($request[8] as $action)
                                                <button type="button" @if ($action === 'Editar') data-open-edit @elseif ($action === 'Ver') data-view-request @elseif ($action === 'Cancelar') data-open-cancel @elseif ($action === 'Duplicar' || $action === 'Repetir') data-open-duplicate @endif class="rounded-md border border-slate-300 px-2.5 py-1 text-xs font-semibold hover:bg-slate-50">{{ $action }}</button>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div id="solicitud-detalle" class="mt-6 hidden rounded-lg border border-emerald-200 bg-emerald-50 p-5">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">Detalle de solicitud</p>
                            <h3 class="mt-1 text-2xl font-bold">Solicitud #000125</h3>
                            <p class="mt-2 text-sm font-semibold text-amber-800">Estado: Buscando conductor</p>
                        </div>
                        <div class="text-right text-sm">
                            <p><span class="text-slate-500">Fecha:</span> <strong>02/07/2026</strong></p>
                            <p><span class="text-slate-500">Precio:</span> <strong>$120.000</strong></p>
                        </div>
                    </div>

                    <div class="mt-5 grid gap-4 xl:grid-cols-3">
                        <div class="rounded-md bg-white p-4">
                            <h4 class="font-bold">Informacion de la carga</h4>
                            <dl class="mt-3 space-y-2 text-sm">
                                <div><dt class="text-slate-500">Tipo</dt><dd class="font-semibold">Electrodomestico</dd></div>
                                <div><dt class="text-slate-500">Descripcion</dt><dd>Nevera familiar empacada y lista para traslado.</dd></div>
                                <div><dt class="text-slate-500">Peso</dt><dd class="font-semibold">80 kg</dd></div>
                                <div><dt class="text-slate-500">Cantidad</dt><dd>1 unidad</dd></div>
                                <div><dt class="text-slate-500">Dimensiones</dt><dd>170 x 70 x 65 cm</dd></div>
                                <div><dt class="text-slate-500">Valor declarado</dt><dd>$1.800.000</dd></div>
                                <div><dt class="text-slate-500">Archivos</dt><dd>4 fotografias, factura y remision</dd></div>
                            </dl>
                        </div>

                        <div class="rounded-md bg-white p-4">
                            <h4 class="font-bold">Recogida y entrega</h4>
                            <dl class="mt-3 space-y-2 text-sm">
                                <div><dt class="text-slate-500">Recogida</dt><dd class="font-semibold">Barrio Centro, Puerto Asis, Putumayo</dd></div>
                                <div><dt class="text-slate-500">Entrega</dt><dd class="font-semibold">Mocoa, Putumayo</dd></div>
                                <div><dt class="text-slate-500">Entrega</dt><dd>Cesar Lozada - 310 316 3262</dd></div>
                                <div><dt class="text-slate-500">Recibe</dt><dd>Maria Gomez - 311 000 0000</dd></div>
                                <div><dt class="text-slate-500">Fecha y hora</dt><dd>05/07/2026 - 8:00 a. m.</dd></div>
                                <div><dt class="text-slate-500">Fecha estimada de entrega</dt><dd>05/07/2026</dd></div>
                            </dl>
                        </div>

                        <div class="rounded-md bg-white p-4">
                            <h4 class="font-bold">Vehiculo y conductor</h4>
                            <dl class="mt-3 space-y-2 text-sm">
                                <div><dt class="text-slate-500">Vehiculo solicitado</dt><dd class="font-semibold">Camioneta</dd></div>
                                <div><dt class="text-slate-500">Capacidad requerida</dt><dd>120 kg minimo</dd></div>
                                <div><dt class="text-slate-500">Conductor</dt><dd>Carlos Lopez, 4.9 de calificacion</dd></div>
                                <div><dt class="text-slate-500">Vehiculo</dt><dd>Camioneta blanca - Placa ABC123</dd></div>
                                <div><dt class="text-slate-500">Verificacion</dt><dd class="font-semibold text-emerald-700">Conductor verificado</dd></div>
                            </dl>
                            <div class="mt-4 grid gap-2 sm:grid-cols-3">
                                <button class="rounded-md bg-emerald-600 px-3 py-2 text-xs font-semibold text-white">Mensaje</button>
                                <button class="rounded-md bg-slate-900 px-3 py-2 text-xs font-semibold text-white">Llamar</button>
                                <button class="rounded-md border border-slate-300 px-3 py-2 text-xs font-semibold">Ubicacion</button>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 grid gap-4 xl:grid-cols-[0.9fr_1.1fr]">
                        <div class="rounded-md bg-white p-4">
                            <h4 class="font-bold">Seguimiento</h4>
                            <ol class="mt-4 space-y-3 text-sm">
                                @foreach (['Solicitud creada', 'Publicada', 'Conductor acepto', 'Conductor va hacia el origen', 'Carga recogida', 'En transito', 'Entregada'] as $step)
                                    <li class="flex gap-3"><span class="{{ $loop->iteration <= 3 ? 'bg-emerald-600' : ($loop->iteration === 4 ? 'bg-amber-500' : 'bg-slate-300') }} mt-1 h-3 w-3 shrink-0 rounded-full"></span><span>{{ $step }}</span></li>
                                @endforeach
                            </ol>
                        </div>

                        <div class="rounded-md bg-white p-4">
                            <h4 class="font-bold">Ofertas recibidas</h4>
                            <div class="mt-4 overflow-x-auto">
                                <table class="w-full min-w-[560px] text-left text-sm">
                                    <thead class="bg-slate-50 text-xs uppercase text-slate-500">
                                        <tr><th class="px-3 py-2">Conductor</th><th class="px-3 py-2">Vehiculo</th><th class="px-3 py-2">Precio</th><th class="px-3 py-2">Calificacion</th><th class="px-3 py-2">Accion</th></tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        @foreach ([['Carlos Lopez', 'Camioneta', '$115.000', '4.9'], ['Juan Gomez', 'Camion', '$120.000', '4.8'], ['Luis Perez', 'Furgon', '$110.000', '4.7']] as $offer)
                                            <tr>
                                                <td class="px-3 py-3 font-semibold">{{ $offer[0] }}</td>
                                                <td class="px-3 py-3">{{ $offer[1] }}</td>
                                                <td class="px-3 py-3">{{ $offer[2] }}</td>
                                                <td class="px-3 py-3">{{ $offer[3] }}</td>
                                                <td class="px-3 py-3"><button class="rounded-md bg-emerald-600 px-3 py-1.5 text-xs font-semibold text-white">Seleccionar</button></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="cancelar-solicitud" class="mt-6 hidden rounded-lg border border-red-200 bg-white p-5">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.18em] text-red-700">cancelar solicitud</p>
                        <h3 class="mt-2 text-xl font-bold">Cancelar solicitud #000125</h3>
                        <p class="mt-1 text-sm text-slate-500">Antes de cancelar, revisa el estado y las consecuencias para evitar problemas con conductores u ofertas activas.</p>
                    </div>
                    <span class="rounded-full bg-amber-100 px-3 py-1 text-sm font-semibold text-amber-800">Buscando conductor: cancelable</span>
                </div>

                <div class="mt-5 grid gap-3 md:grid-cols-2 xl:grid-cols-4">
                    @foreach ([['Borrador', 'Se puede cancelar'], ['Publicada', 'Se puede cancelar'], ['Buscando conductor', 'Se puede cancelar'], ['Con ofertas', 'Se puede cancelar y elimina ofertas'], ['Conductor asignado', 'Requiere validacion'], ['En camino', 'Puede generar penalidad'], ['En transito', 'No recomendado'], ['Finalizada', 'No se puede cancelar'], ['Cancelada', 'Ya esta cancelada']] as $rule)
                        <div class="rounded-md border {{ str_contains($rule[1], 'No') || str_contains($rule[1], 'penalidad') ? 'border-red-200 bg-red-50' : 'border-slate-200 bg-slate-50' }} p-3">
                            <p class="text-sm font-bold">{{ $rule[0] }}</p>
                            <p class="mt-1 text-xs text-slate-600">{{ $rule[1] }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 grid gap-6 xl:grid-cols-[1.1fr_0.9fr]">
                    <form class="rounded-md border border-slate-200 p-4">
                        <h4 class="font-bold">Motivo de cancelacion</h4>
                        <div class="mt-4 grid gap-3 md:grid-cols-2">
                            @foreach (['Ya no necesito el servicio', 'Datos incorrectos en la solicitud', 'Cambie origen o destino', 'Precio no adecuado', 'No encontre conductor', 'Quiero crear una nueva solicitud'] as $reason)
                                <label class="rounded-md border border-slate-200 p-3 text-sm font-semibold hover:border-red-300 hover:bg-red-50">
                                    <input type="radio" name="cancel_reason" class="mr-2"> {{ $reason }}
                                </label>
                            @endforeach
                        </div>
                        <div class="mt-4">
                            <label class="mb-2 block text-sm font-medium">Explica el motivo</label>
                            <textarea rows="4" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100" placeholder="Ejemplo: cambie la fecha de recogida y necesito publicar una nueva solicitud."></textarea>
                        </div>

                        <div class="mt-4 rounded-md border border-amber-200 bg-amber-50 p-4 text-sm text-amber-900">
                            <strong>Importante:</strong> al cancelar esta solicitud se cerraran las ofertas activas, se notificara a los conductores interesados y la solicitud quedara en estado Cancelada.
                        </div>

                        <label class="mt-4 flex gap-3 rounded-md border border-slate-200 p-3 text-sm">
                            <input id="confirm-cancel-check" type="checkbox" class="mt-1">
                            <span>Confirmo que deseo cancelar esta solicitud y entiendo que no podre reactivarla desde este estado.</span>
                        </label>

                        <div class="mt-5 flex flex-wrap justify-end gap-2">
                            <button type="button" data-close-cancel class="rounded-md border border-slate-300 px-4 py-2.5 font-semibold hover:bg-slate-50">Volver</button>
                            <button type="button" data-preview-cancel class="rounded-md border border-red-300 px-4 py-2.5 font-semibold text-red-700 hover:bg-red-50">Vista previa</button>
                            <button id="confirm-cancel-button" type="button" class="rounded-md bg-red-600 px-4 py-2.5 font-semibold text-white opacity-60 hover:bg-red-700">Cancelar solicitud</button>
                        </div>
                    </form>

                    <aside class="space-y-5">
                        <div id="cancel-preview" class="hidden rounded-md border border-red-200 bg-red-50 p-4">
                            <h4 class="font-bold text-red-900">Resumen de cancelacion</h4>
                            <dl class="mt-3 space-y-2 text-sm">
                                <div><dt class="text-slate-500">Solicitud</dt><dd class="font-semibold">#000125</dd></div>
                                <div><dt class="text-slate-500">Estado actual</dt><dd class="font-semibold">Buscando conductor</dd></div>
                                <div><dt class="text-slate-500">Ofertas activas</dt><dd class="font-semibold">3 ofertas se cerraran</dd></div>
                                <div><dt class="text-slate-500">Notificaciones</dt><dd class="font-semibold">18 conductores seran avisados</dd></div>
                            </dl>
                        </div>

                        <div id="cancel-success" class="hidden rounded-md border border-emerald-200 bg-emerald-50 p-4">
                            <h4 class="font-bold text-emerald-900">Solicitud cancelada</h4>
                            <p class="mt-2 text-sm text-slate-700">La solicitud #000125 quedo en estado Cancelada. Se notifico a los conductores interesados y las ofertas quedaron cerradas.</p>
                        </div>

                        <div class="rounded-md border border-slate-200 p-4">
                            <h4 class="font-bold">Historial de cancelacion</h4>
                            <div class="mt-4 space-y-3 text-sm">
                                @foreach ([['02/07/2026 09:15', 'Solicitud publicada'], ['02/07/2026 09:20', 'Se notifico a 18 conductores'], ['02/07/2026 09:35', 'Recibio 3 ofertas']] as $change)
                                    <div class="rounded-md bg-slate-50 p-3">
                                        <p class="font-semibold">{{ $change[1] }}</p>
                                        <p class="mt-1 text-xs text-slate-500">{{ $change[0] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </aside>
                </div>
            </section>

            <section id="editar-solicitud" class="mt-6 hidden rounded-lg border border-slate-200 bg-white p-5">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-700">editar solicitud</p>
                        <h3 class="mt-2 text-xl font-bold">Editar solicitud #000125</h3>
                        <p class="mt-1 text-sm text-slate-500">Solo puedes editar mientras ningun conductor haya aceptado la solicitud.</p>
                    </div>
                    <span class="rounded-full bg-amber-100 px-3 py-1 text-sm font-semibold text-amber-800">Buscando conductor: editable</span>
                </div>

                <div class="mt-5 grid gap-3 md:grid-cols-2 xl:grid-cols-4">
                    @foreach ([['Borrador', 'Si'], ['Publicada', 'Si'], ['Buscando conductor', 'Si'], ['Con ofertas', 'Si, invalida ofertas'], ['Conductor asignado', 'No'], ['En camino', 'No'], ['En transito', 'No'], ['Finalizada', 'No'], ['Cancelada', 'No']] as $rule)
                        <div class="rounded-md border {{ str_starts_with($rule[1], 'No') ? 'border-red-200 bg-red-50' : 'border-emerald-200 bg-emerald-50' }} p-3">
                            <p class="text-sm font-bold">{{ $rule[0] }}</p>
                            <p class="mt-1 text-xs {{ str_starts_with($rule[1], 'No') ? 'text-red-700' : 'text-emerald-700' }}">{{ $rule[1] }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="mt-5 rounded-md border border-amber-200 bg-amber-50 p-4 text-sm text-amber-900">
                    <strong>Aviso importante:</strong> si modificas peso, dimensiones, origen, destino, vehiculo o precio, las ofertas recibidas se eliminaran y los conductores seran notificados para enviar nuevas ofertas.
                </div>

                <div class="mt-6 grid gap-6 xl:grid-cols-[1.35fr_0.65fr]">
                    <form class="space-y-5">
                        <section class="rounded-md border border-slate-200 p-4">
                            <h4 class="font-bold">1. Informacion de la carga</h4>
                            <div class="mt-4 grid gap-4 md:grid-cols-2">
                                @foreach (['Nombre de la carga', 'Categoria', 'Cantidad', 'Peso', 'Dimensiones', 'Valor declarado', 'Tipo de empaque', 'Observaciones'] as $field)
                                    <div>
                                        <label class="mb-2 block text-sm font-medium">{{ $field }}</label>
                                        <input type="text" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-4 grid gap-3 md:grid-cols-3">
                                @foreach (['Es fragil?', 'Requiere ayudantes?', 'Requiere cargue y descargue?'] as $field)
                                    <label class="rounded-md border border-slate-200 p-3 text-sm font-semibold">
                                        {{ $field }}
                                        <select class="mt-2 w-full rounded-md border border-slate-300 px-3 py-2 font-normal">
                                            <option>Si</option>
                                            <option>No</option>
                                        </select>
                                    </label>
                                @endforeach
                            </div>
                        </section>

                        <section class="grid gap-5 md:grid-cols-2">
                            <div class="rounded-md border border-slate-200 p-4">
                                <h4 class="font-bold">2. Fotografias</h4>
                                <div class="mt-4 grid gap-3">
                                    <label class="rounded-md border border-dashed border-slate-300 p-3 text-sm font-semibold">Subir nuevas fotos <input type="file" multiple class="mt-2 w-full text-sm"></label>
                                    <div class="grid grid-cols-2 gap-2 text-xs">
                                        @foreach (['Foto actual 1', 'Foto actual 2', 'Foto actual 3', 'Foto actual 4'] as $photo)
                                            <div class="rounded-md bg-slate-100 p-3">
                                                <p class="font-semibold">{{ $photo }}</p>
                                                <div class="mt-2 flex gap-2"><button type="button" class="text-emerald-700">Ver</button><button type="button" class="text-slate-700">Cambiar</button><button type="button" class="text-red-700">Eliminar</button></div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-md border border-slate-200 p-4">
                                <h4 class="font-bold">3. Documentos</h4>
                                <div class="mt-4 space-y-3 text-sm">
                                    @foreach (['Factura', 'Remision', 'Lista de empaque', 'Otros archivos'] as $document)
                                        <div class="flex flex-wrap items-center justify-between gap-2 rounded-md bg-slate-50 p-3">
                                            <span class="font-semibold">{{ $document }}</span>
                                            <div class="flex gap-2 text-xs"><button type="button" class="text-emerald-700">Agregar</button><button type="button" class="text-slate-700">Reemplazar</button><button type="button" class="text-red-700">Eliminar</button></div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </section>

                        <section class="grid gap-5 md:grid-cols-2">
                            <div class="rounded-md border border-slate-200 p-4">
                                <h4 class="font-bold">4. Lugar de recogida</h4>
                                <div class="mt-4 grid gap-3">
                                    @foreach (['Departamento', 'Ciudad', 'Direccion', 'Barrio', 'Punto de referencia', 'Nombre de quien entrega', 'Telefono', 'Fecha', 'Hora'] as $field)
                                        <input type="text" placeholder="{{ $field }}" class="rounded-md border border-slate-300 px-3 py-2 text-sm">
                                    @endforeach
                                </div>
                            </div>

                            <div class="rounded-md border border-slate-200 p-4">
                                <h4 class="font-bold">5. Lugar de entrega</h4>
                                <div class="mt-4 grid gap-3">
                                    @foreach (['Departamento', 'Ciudad', 'Direccion', 'Barrio', 'Punto de referencia', 'Nombre del receptor', 'Telefono', 'Fecha limite', 'Observaciones'] as $field)
                                        <input type="text" placeholder="{{ $field }}" class="rounded-md border border-slate-300 px-3 py-2 text-sm">
                                    @endforeach
                                </div>
                            </div>
                        </section>

                        <section class="grid gap-5 md:grid-cols-3">
                            <div class="rounded-md border border-slate-200 p-4">
                                <h4 class="font-bold">6. Tipo de vehiculo</h4>
                                <select class="mt-4 w-full rounded-md border border-slate-300 px-3 py-2 text-sm">
                                    @foreach (['Moto', 'Automovil', 'Camioneta', 'Furgon', 'Camion', 'Tractomula'] as $vehicle)
                                        <option>{{ $vehicle }}</option>
                                    @endforeach
                                </select>
                                <p class="mt-3 rounded-md bg-emerald-50 p-3 text-xs text-emerald-800">Si cambia el peso o dimensiones, el sistema puede sugerir otro vehiculo.</p>
                            </div>

                            <div class="rounded-md border border-slate-200 p-4">
                                <h4 class="font-bold">7. Precio</h4>
                                <input type="text" value="$120.000" class="mt-4 w-full rounded-md border border-slate-300 px-3 py-2 text-sm">
                                <button type="button" class="mt-3 rounded-md border border-slate-300 px-3 py-2 text-xs font-semibold">Solicitar precio sugerido</button>
                                <label class="mt-3 block text-sm"><input type="checkbox" checked> Recibir ofertas de conductores</label>
                            </div>

                            <div class="rounded-md border border-slate-200 p-4">
                                <h4 class="font-bold">8. Opciones adicionales</h4>
                                <div class="mt-4 space-y-2 text-sm">
                                    @foreach (['Requiere factura', 'Carga asegurada', 'Permitir varios ayudantes'] as $option)
                                        <label class="block"><input type="checkbox"> {{ $option }}</label>
                                    @endforeach
                                    <select class="mt-2 w-full rounded-md border border-slate-300 px-3 py-2">
                                        <option>Prioridad normal</option>
                                        <option>Prioridad urgente</option>
                                    </select>
                                </div>
                            </div>
                        </section>

                        <div class="flex flex-wrap justify-end gap-2">
                            <button type="button" data-cancel-edit class="rounded-md border border-slate-300 px-4 py-2.5 font-semibold hover:bg-slate-50">Cancelar</button>
                            <button type="button" data-preview-edit class="rounded-md border border-emerald-300 px-4 py-2.5 font-semibold text-emerald-700 hover:bg-emerald-50">Vista previa</button>
                            <button type="button" class="rounded-md bg-emerald-600 px-4 py-2.5 font-semibold text-white hover:bg-emerald-700">Guardar cambios</button>
                        </div>
                    </form>

                    <aside class="space-y-5">
                        <div id="edit-preview" class="hidden rounded-md border border-emerald-200 bg-emerald-50 p-4">
                            <h4 class="font-bold">Vista previa de cambios</h4>
                            <dl class="mt-3 space-y-2 text-sm">
                                <div><dt class="text-slate-500">Precio</dt><dd class="font-semibold">$120.000 a $140.000</dd></div>
                                <div><dt class="text-slate-500">Direccion de entrega</dt><dd class="font-semibold">Actualizada</dd></div>
                                <div><dt class="text-slate-500">Fotos</dt><dd class="font-semibold">2 nuevas fotografias</dd></div>
                            </dl>
                        </div>

                        <div class="rounded-md border border-slate-200 p-4">
                            <h4 class="font-bold">Historial de cambios</h4>
                            <div class="mt-4 space-y-3 text-sm">
                                @foreach ([['02/07/2026 10:30', 'Cesar Herrera', 'Cambio el precio de $120.000 a $140.000'], ['02/07/2026 10:35', 'Cesar Herrera', 'Actualizo la direccion de entrega'], ['02/07/2026 10:40', 'Cesar Herrera', 'Agrego dos fotografias']] as $change)
                                    <div class="rounded-md bg-slate-50 p-3">
                                        <p class="font-semibold">{{ $change[2] }}</p>
                                        <p class="mt-1 text-xs text-slate-500">{{ $change[0] }} - {{ $change[1] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </aside>
                </div>
            </section>

            <section id="duplicar-solicitud" class="mt-6 hidden rounded-lg border border-slate-200 bg-white p-5">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-700">duplicar solicitud</p>
                        <h3 class="mt-2 text-xl font-bold">Duplicar solicitud #000123</h3>
                        <p class="mt-1 text-sm text-slate-500">Crea una nueva solicitud usando los datos de una anterior. Revisa fechas, contactos y precio antes de publicarla.</p>
                    </div>
                    <span class="rounded-full bg-slate-100 px-3 py-1 text-sm font-semibold text-slate-700">Nueva copia: borrador</span>
                </div>

                <div class="mt-5 grid gap-5 xl:grid-cols-[0.9fr_1.1fr]">
                    <aside class="space-y-5">
                        <div class="rounded-md border border-slate-200 bg-slate-50 p-4">
                            <h4 class="font-bold">Datos que se copiaran</h4>
                            <div class="mt-4 grid gap-2 text-sm">
                                @foreach (['Tipo de carga', 'Descripcion', 'Cantidad y peso', 'Dimensiones', 'Origen', 'Destino', 'Tipo de vehiculo', 'Observaciones'] as $item)
                                    <div class="flex items-center gap-2 rounded-md bg-white p-2"><span class="h-2 w-2 rounded-full bg-emerald-500"></span><span>{{ $item }}</span></div>
                                @endforeach
                            </div>
                        </div>

                        <div class="rounded-md border border-amber-200 bg-amber-50 p-4 text-sm text-amber-900">
                            <strong>Debes actualizar:</strong> fecha de recogida, hora, disponibilidad de quien entrega, contacto de quien recibe y precio ofrecido si cambiaron las condiciones.
                        </div>

                        <div id="duplicate-success" class="hidden rounded-md border border-emerald-200 bg-emerald-50 p-4">
                            <h4 class="font-bold text-emerald-900">Solicitud duplicada</h4>
                            <p class="mt-2 text-sm text-slate-700">Se creo la solicitud #000126 como borrador. Puedes revisarla y publicarla cuando este lista.</p>
                        </div>
                    </aside>

                    <form class="rounded-md border border-slate-200 p-4">
                        <h4 class="font-bold">Revisar nueva solicitud</h4>
                        <div class="mt-4 grid gap-4 md:grid-cols-2">
                            @foreach ([['Nombre de la carga', 'Nevera familiar'], ['Categoria', 'Electrodomesticos'], ['Peso', '80 kg'], ['Vehiculo', 'Camioneta'], ['Origen', 'Puerto Asis'], ['Destino', 'Mocoa'], ['Precio ofrecido', '$120.000'], ['Estado inicial', 'Borrador']] as $field)
                                <label class="block">
                                    <span class="mb-2 block text-sm font-medium">{{ $field[0] }}</span>
                                    <input type="text" value="{{ $field[1] }}" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                                </label>
                            @endforeach
                        </div>

                        <div class="mt-4 grid gap-4 md:grid-cols-2">
                            <label class="block">
                                <span class="mb-2 block text-sm font-medium">Nueva fecha de recogida</span>
                                <input type="date" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm">
                            </label>
                            <label class="block">
                                <span class="mb-2 block text-sm font-medium">Nueva hora de recogida</span>
                                <input type="time" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm">
                            </label>
                        </div>

                        <div class="mt-4">
                            <label class="mb-2 block text-sm font-medium">Cambios para esta copia</label>
                            <textarea rows="4" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100" placeholder="Ejemplo: esta vez la recogida sera en la tarde y el precio ofrecido sube a $140.000."></textarea>
                        </div>

                        <div class="mt-5 grid gap-3 md:grid-cols-3">
                            <label class="rounded-md border border-slate-200 p-3 text-sm"><input type="checkbox" checked> Copiar fotografias</label>
                            <label class="rounded-md border border-slate-200 p-3 text-sm"><input type="checkbox" checked> Copiar documentos</label>
                            <label class="rounded-md border border-slate-200 p-3 text-sm"><input type="checkbox"> Publicar de inmediato</label>
                        </div>

                        <div class="mt-5 flex flex-wrap justify-end gap-2">
                            <button type="button" data-close-duplicate class="rounded-md border border-slate-300 px-4 py-2.5 font-semibold hover:bg-slate-50">Cancelar</button>
                            <button type="button" data-open-request class="rounded-md border border-emerald-300 px-4 py-2.5 font-semibold text-emerald-700 hover:bg-emerald-50">Abrir formulario completo</button>
                            <button type="button" data-confirm-duplicate class="rounded-md bg-emerald-600 px-4 py-2.5 font-semibold text-white hover:bg-emerald-700">Crear duplicado</button>
                        </div>
                    </form>
                </div>
            </section>

            <div id="nueva-solicitud" class="mt-6 hidden gap-6 xl:grid-cols-[1.2fr_0.8fr]">
                <section class="rounded-lg border border-slate-200 bg-white p-5">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <h3 class="text-xl font-bold">Nueva solicitud</h3>
                            <p class="mt-1 text-sm text-slate-500">Completa la solicitud por pasos para publicarla con seguridad.</p>
                        </div>
                        <span id="step-counter" class="rounded-full bg-emerald-100 px-3 py-1 text-sm font-semibold text-emerald-800">Paso 1 de 6</span>
                    </div>

                    <div class="mt-5 h-2 overflow-hidden rounded-full bg-slate-100">
                        <div id="step-progress" class="h-full w-1/6 rounded-full bg-emerald-600 transition-all"></div>
                    </div>

                    <form class="mt-6">
                        <section data-step class="space-y-5">
                            <div>
                                <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">Paso 1</p>
                                <h4 class="mt-1 text-lg font-bold">Informacion de la carga</h4>
                            </div>
                            <div class="grid gap-4 md:grid-cols-2">
                                @foreach (['Nombre de la carga', 'Categoria', 'Cantidad', 'Peso (kg)', 'Volumen (m3) opcional', 'Valor declarado'] as $field)
                                    <div>
                                        <label class="mb-2 block text-sm font-medium">{{ $field }}</label>
                                        <input type="text" class="w-full rounded-md border border-slate-300 px-3 py-2 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                                    </div>
                                @endforeach
                            </div>
                            <div>
                                <label class="mb-2 block text-sm font-medium">Descripcion</label>
                                <textarea rows="3" class="w-full rounded-md border border-slate-300 px-3 py-2 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"></textarea>
                            </div>
                            <div class="grid gap-3 md:grid-cols-3">
                                @foreach (['Es fragil?', 'Requiere ayudantes?', 'Requiere embalaje?'] as $field)
                                    <div class="rounded-md border border-slate-200 p-3">
                                        <p class="text-sm font-semibold">{{ $field }}</p>
                                        <div class="mt-3 flex gap-4 text-sm"><label><input type="radio" name="{{ $loop->index }}"> Si</label><label><input type="radio" name="{{ $loop->index }}" checked> No</label></div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="grid gap-4 md:grid-cols-3">
                                @foreach (['Largo', 'Ancho', 'Alto'] as $field)
                                    <div><label class="mb-2 block text-sm font-medium">{{ $field }} opcional</label><input type="text" class="w-full rounded-md border border-slate-300 px-3 py-2"></div>
                                @endforeach
                            </div>
                            <div class="grid gap-4 md:grid-cols-2">
                                <label class="rounded-md border border-dashed border-slate-300 p-4"><span class="block text-sm font-semibold">Fotos de la carga</span><input type="file" multiple class="mt-3 w-full text-sm"></label>
                                <label class="rounded-md border border-dashed border-slate-300 p-4"><span class="block text-sm font-semibold">Documentos opcionales</span><input type="file" multiple class="mt-3 w-full text-sm"></label>
                            </div>
                        </section>

                        <section data-step class="hidden space-y-5">
                            <div><p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">Paso 2</p><h4 class="mt-1 text-lg font-bold">Lugar de recogida</h4></div>
                            <div class="grid gap-4 md:grid-cols-2">
                                @foreach (['Departamento', 'Ciudad', 'Direccion', 'Barrio', 'Punto de referencia', 'Nombre de quien entrega', 'Telefono de contacto', 'Fecha de recogida', 'Hora de recogida'] as $field)
                                    <div><label class="mb-2 block text-sm font-medium">{{ $field }}</label><input type="text" class="w-full rounded-md border border-slate-300 px-3 py-2 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"></div>
                                @endforeach
                            </div>
                            <div class="rounded-md border border-dashed border-slate-300 bg-slate-50 p-5 text-sm text-slate-500">Mapa para seleccionar ubicacion exacta</div>
                        </section>

                        <section data-step class="hidden space-y-5">
                            <div><p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">Paso 3</p><h4 class="mt-1 text-lg font-bold">Lugar de entrega</h4></div>
                            <div class="grid gap-4 md:grid-cols-2">
                                @foreach (['Departamento', 'Ciudad', 'Direccion', 'Barrio', 'Punto de referencia', 'Nombre de quien recibe', 'Telefono de contacto', 'Fecha limite de entrega'] as $field)
                                    <div><label class="mb-2 block text-sm font-medium">{{ $field }}</label><input type="text" class="w-full rounded-md border border-slate-300 px-3 py-2 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"></div>
                                @endforeach
                            </div>
                            <div><label class="mb-2 block text-sm font-medium">Observaciones</label><textarea rows="4" class="w-full rounded-md border border-slate-300 px-3 py-2"></textarea></div>
                        </section>

                        <section data-step class="hidden space-y-5">
                            <div><p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">Paso 4</p><h4 class="mt-1 text-lg font-bold">Tipo de vehiculo</h4></div>
                            <div class="grid gap-4 md:grid-cols-4">
                                @foreach (['Camioneta', 'Furgon', 'Camion', 'No estoy seguro'] as $vehicle)
                                    <label class="cursor-pointer rounded-md border border-slate-300 p-4 text-center font-semibold hover:border-emerald-600 hover:bg-emerald-50">
                                        <input type="radio" name="vehicle" class="mb-3 text-emerald-600" @checked($loop->first)> {{ $vehicle }}
                                    </label>
                                @endforeach
                            </div>
                            <div class="rounded-md bg-emerald-50 p-4 text-sm text-emerald-800"><strong>Vehiculo recomendado:</strong> Camioneta, segun peso y dimensiones ingresadas.</div>
                        </section>

                        <section data-step class="hidden space-y-5">
                            <div><p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">Paso 5</p><h4 class="mt-1 text-lg font-bold">Precio</h4></div>
                            <div class="grid gap-4 md:grid-cols-3">
                                <div class="rounded-md border border-emerald-200 bg-emerald-50 p-4"><p class="text-sm font-semibold text-emerald-800">Precio sugerido</p><p class="mt-3 text-3xl font-bold">$120.000</p></div>
                                <div class="rounded-md border border-slate-200 p-4"><label class="text-sm font-semibold">Mi oferta</label><input type="text" value="$110.000" class="mt-3 w-full rounded-md border border-slate-300 px-3 py-2"></div>
                                <label class="rounded-md border border-slate-200 p-4"><input type="checkbox" class="mr-2 text-emerald-600" checked> Quiero recibir ofertas de conductores.</label>
                            </div>
                        </section>

                        <section data-step class="hidden space-y-5">
                            <div><p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">Paso 6</p><h4 class="mt-1 text-lg font-bold">Confirmacion</h4></div>
                            <div class="grid gap-3 rounded-md bg-slate-50 p-4 text-sm md:grid-cols-2">
                                <div><span class="text-slate-500">Carga</span><p class="font-bold">Nevera</p></div>
                                <div><span class="text-slate-500">Peso</span><p class="font-bold">80 kg</p></div>
                                <div><span class="text-slate-500">Origen</span><p class="font-bold">Puerto Asis</p></div>
                                <div><span class="text-slate-500">Destino</span><p class="font-bold">Mocoa</p></div>
                                <div><span class="text-slate-500">Vehiculo</span><p class="font-bold">Camioneta</p></div>
                                <div><span class="text-slate-500">Precio</span><p class="font-bold">$120.000</p></div>
                                <div><span class="text-slate-500">Fecha</span><p class="font-bold">05/07/2026</p></div>
                            </div>
                        </section>

                        <section id="published-state" class="hidden space-y-5 rounded-md border border-emerald-200 bg-emerald-50 p-5">
                            <h4 class="text-xl font-bold">Solicitud #000125 publicada</h4>
                            <p class="text-amber-800 font-semibold">Estado: Buscando conductor</p>
                            <p class="text-sm text-slate-700">Se notifico a 18 conductores cercanos.</p>
                            <div class="grid gap-3 md:grid-cols-4">
                                <button class="rounded-md bg-white px-3 py-2 text-sm font-semibold">Ver ofertas</button>
                                <button class="rounded-md bg-white px-3 py-2 text-sm font-semibold">Chatear</button>
                                <button class="rounded-md bg-white px-3 py-2 text-sm font-semibold">Elegir conductor</button>
                                <button class="rounded-md bg-red-50 px-3 py-2 text-sm font-semibold text-red-700">Cancelar</button>
                            </div>
                        </section>

                        <div class="mt-6 flex flex-wrap justify-between gap-2">
                            <button id="prev-step" type="button" class="hidden rounded-md border border-slate-300 px-4 py-2.5 font-semibold hover:bg-slate-50">Volver</button>
                            <div class="ml-auto flex flex-wrap gap-2">
                                <button type="button" class="rounded-md border border-slate-300 px-4 py-2.5 font-semibold hover:bg-slate-50">Guardar como borrador</button>
                                <button id="next-step" type="button" class="rounded-md bg-emerald-600 px-4 py-2.5 font-semibold text-white hover:bg-emerald-700">Continuar</button>
                                <button id="publish-request" type="button" class="hidden rounded-md bg-emerald-600 px-4 py-2.5 font-semibold text-white hover:bg-emerald-700">Publicar solicitud</button>
                            </div>
                        </div>
                    </form>
                </section>

                <section class="space-y-6">
                    <div class="rounded-lg border border-slate-200 bg-white p-5">
                        <h3 class="text-xl font-bold">Calculos automaticos</h3>
                        <dl class="mt-4 space-y-3 text-sm">
                            <div class="flex justify-between gap-4"><dt class="text-slate-500">Distancia</dt><dd class="font-semibold">86 km</dd></div>
                            <div class="flex justify-between gap-4"><dt class="text-slate-500">Tiempo estimado</dt><dd class="font-semibold">2 h 20 min</dd></div>
                            <div class="flex justify-between gap-4"><dt class="text-slate-500">Precio sugerido</dt><dd class="font-semibold">$120.000</dd></div>
                            <div class="flex justify-between gap-4"><dt class="text-slate-500">Combustible</dt><dd class="font-semibold">$38.000</dd></div>
                            <div class="flex justify-between gap-4"><dt class="text-slate-500">Vehiculo recomendado</dt><dd class="font-semibold">Camioneta</dd></div>
                            <div class="flex justify-between gap-4"><dt class="text-slate-500">Capacidad minima</dt><dd class="font-semibold">120 kg</dd></div>
                            <div class="flex justify-between gap-4"><dt class="text-slate-500">Ruta sugerida</dt><dd class="font-semibold">Puerto Asis a Mocoa</dd></div>
                        </dl>
                    </div>

                    <div class="rounded-lg border border-slate-200 bg-white p-5">
                        <h3 class="text-xl font-bold">Estados posibles</h3>
                        <div class="mt-4 flex flex-wrap gap-2">
                            @foreach ($statuses as $state)
                                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">{{ $state }}</span>
                            @endforeach
                        </div>
                    </div>
                </section>
            </div>

            <script>
                const steps = [...document.querySelectorAll('[data-step]')];
                const counter = document.getElementById('step-counter');
                const progress = document.getElementById('step-progress');
                const previous = document.getElementById('prev-step');
                const next = document.getElementById('next-step');
                const publish = document.getElementById('publish-request');
                const published = document.getElementById('published-state');
                const requestPanel = document.getElementById('nueva-solicitud');
                const openRequestButtons = document.querySelectorAll('[data-open-request]');
                const requestsList = document.getElementById('ver-solicitudes');
                const openListButtons = document.querySelectorAll('[data-open-list]');
                const detailsPanel = document.getElementById('solicitud-detalle');
                const viewRequestButtons = document.querySelectorAll('[data-view-request]');
                const editPanel = document.getElementById('editar-solicitud');
                const openEditButtons = document.querySelectorAll('[data-open-edit]');
                const cancelEditButtons = document.querySelectorAll('[data-cancel-edit]');
                const previewEditButtons = document.querySelectorAll('[data-preview-edit]');
                const editPreview = document.getElementById('edit-preview');
                const cancelPanel = document.getElementById('cancelar-solicitud');
                const openCancelButtons = document.querySelectorAll('[data-open-cancel]');
                const closeCancelButtons = document.querySelectorAll('[data-close-cancel]');
                const previewCancelButtons = document.querySelectorAll('[data-preview-cancel]');
                const cancelPreview = document.getElementById('cancel-preview');
                const cancelSuccess = document.getElementById('cancel-success');
                const confirmCancelCheck = document.getElementById('confirm-cancel-check');
                const confirmCancelButton = document.getElementById('confirm-cancel-button');
                const duplicatePanel = document.getElementById('duplicar-solicitud');
                const openDuplicateButtons = document.querySelectorAll('[data-open-duplicate]');
                const closeDuplicateButtons = document.querySelectorAll('[data-close-duplicate]');
                const confirmDuplicateButtons = document.querySelectorAll('[data-confirm-duplicate]');
                const duplicateSuccess = document.getElementById('duplicate-success');
                let currentStep = 0;

                function showStep(index) {
                    currentStep = index;
                    steps.forEach((step, stepIndex) => step.classList.toggle('hidden', stepIndex !== currentStep));
                    counter.textContent = `Paso ${currentStep + 1} de ${steps.length}`;
                    progress.style.width = `${((currentStep + 1) / steps.length) * 100}%`;
                    previous.classList.toggle('hidden', currentStep === 0);
                    next.classList.toggle('hidden', currentStep === steps.length - 1);
                    publish.classList.toggle('hidden', currentStep !== steps.length - 1);
                }

                previous.addEventListener('click', () => showStep(Math.max(0, currentStep - 1)));
                next.addEventListener('click', () => showStep(Math.min(steps.length - 1, currentStep + 1)));
                openRequestButtons.forEach((button) => {
                    button.addEventListener('click', () => {
                        requestPanel.classList.remove('hidden');
                        requestPanel.classList.add('grid');
                        published.classList.add('hidden');
                        showStep(0);
                        requestPanel.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    });
                });
                openListButtons.forEach((button) => {
                    button.addEventListener('click', () => {
                        requestsList.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    });
                });
                viewRequestButtons.forEach((button) => {
                    button.addEventListener('click', () => {
                        detailsPanel.classList.remove('hidden');
                        detailsPanel.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    });
                });
                openEditButtons.forEach((button) => {
                    button.addEventListener('click', () => {
                        editPanel.classList.remove('hidden');
                        editPanel.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    });
                });
                cancelEditButtons.forEach((button) => {
                    button.addEventListener('click', () => {
                        editPanel.classList.add('hidden');
                        requestsList.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    });
                });
                previewEditButtons.forEach((button) => {
                    button.addEventListener('click', () => {
                        editPreview.classList.toggle('hidden');
                        editPreview.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    });
                });
                openCancelButtons.forEach((button) => {
                    button.addEventListener('click', () => {
                        cancelPanel.classList.remove('hidden');
                        cancelPanel.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    });
                });
                closeCancelButtons.forEach((button) => {
                    button.addEventListener('click', () => {
                        cancelPanel.classList.add('hidden');
                        requestsList.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    });
                });
                previewCancelButtons.forEach((button) => {
                    button.addEventListener('click', () => {
                        cancelPreview.classList.toggle('hidden');
                        cancelPreview.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    });
                });
                confirmCancelCheck.addEventListener('change', () => {
                    confirmCancelButton.classList.toggle('opacity-60', !confirmCancelCheck.checked);
                });
                confirmCancelButton.addEventListener('click', () => {
                    if (!confirmCancelCheck.checked) {
                        cancelPreview.classList.remove('hidden');
                        cancelPreview.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                        return;
                    }

                    cancelSuccess.classList.remove('hidden');
                    cancelSuccess.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                });
                openDuplicateButtons.forEach((button) => {
                    button.addEventListener('click', () => {
                        duplicatePanel.classList.remove('hidden');
                        duplicatePanel.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    });
                });
                closeDuplicateButtons.forEach((button) => {
                    button.addEventListener('click', () => {
                        duplicatePanel.classList.add('hidden');
                        requestsList.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    });
                });
                confirmDuplicateButtons.forEach((button) => {
                    button.addEventListener('click', () => {
                        duplicateSuccess.classList.remove('hidden');
                        duplicateSuccess.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    });
                });
                publish.addEventListener('click', () => {
                    steps.forEach((step) => step.classList.add('hidden'));
                    published.classList.remove('hidden');
                    counter.textContent = 'Solicitud publicada';
                    progress.style.width = '100%';
                    previous.classList.add('hidden');
                    next.classList.add('hidden');
                    publish.classList.add('hidden');
                });

                if (window.location.hash === '#nueva-solicitud') {
                    requestPanel.classList.remove('hidden');
                    requestPanel.classList.add('grid');
                    showStep(0);
                }
            </script>
        </main>
    </div>
</body>
</html>
