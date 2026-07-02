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

    $types = ['Nuevo conductor disponible', 'Solicitud aceptada', 'Vehiculo en camino', 'Carga recogida', 'Carga entregada', 'Pago realizado', 'Nuevo mensaje', 'Promociones', 'Alertas de seguridad'];
    $notifications = [
        ['type' => 'Solicitud aceptada', 'title' => 'Tu solicitud #MD-1024 fue aceptada', 'message' => 'Carlos Ramirez tomo el servicio y va hacia el origen.', 'time' => 'Hace 8 min', 'status' => 'Nueva', 'tone' => 'emerald'],
        ['type' => 'Vehiculo en camino', 'title' => 'Vehiculo en camino', 'message' => 'El conductor esta a 14 km del punto de recogida.', 'time' => 'Hace 22 min', 'status' => 'Nueva', 'tone' => 'sky'],
        ['type' => 'Nuevo mensaje', 'title' => 'Nuevo mensaje del conductor', 'message' => 'Estoy a 10 minutos del origen.', 'time' => 'Hace 30 min', 'status' => 'Leida', 'tone' => 'slate'],
        ['type' => 'Pago realizado', 'title' => 'Pago confirmado', 'message' => 'El pago de la factura #FAC-2041 fue procesado.', 'time' => 'Ayer', 'status' => 'Leida', 'tone' => 'emerald'],
        ['type' => 'Alertas de seguridad', 'title' => 'Revisa tu verificacion', 'message' => 'Mantener tus datos actualizados protege tus solicitudes.', 'time' => 'Ayer', 'status' => 'Nueva', 'tone' => 'amber'],
    ];
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificaciones</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 text-slate-900">
    <div class="min-h-screen lg:pl-[280px]">
        <aside class="bg-slate-950 px-5 py-6 text-white lg:fixed lg:inset-y-0 lg:left-0 lg:w-[280px] lg:overflow-y-auto">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-300">Mudanza</p>
            <h1 class="mt-2 text-xl font-bold">Cliente</h1>

            <nav class="mt-8 space-y-1">
                @foreach ($menuItems as $item)
                    <a href="{{ $item['url'] }}" class="block rounded-md px-3 py-2 text-sm font-semibold transition {{ $item['label'] === 'Notificaciones' ? 'bg-white text-slate-950' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
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
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-700">notificaciones</p>
                    <h2 class="mt-2 text-3xl font-bold">Centro de alertas</h2>
                    <p class="mt-2 text-slate-600">Consulta avisos de solicitudes, viajes, pagos, mensajes, promociones y seguridad.</p>
                </div>
                <button type="button" class="rounded-md bg-emerald-600 px-4 py-2.5 font-semibold text-white hover:bg-emerald-700">Marcar todo como leido</button>
            </div>

            <section class="mt-8 grid gap-4 md:grid-cols-4">
                <div class="rounded-lg border border-slate-200 bg-white p-5"><p class="text-sm font-semibold text-slate-500">Todas</p><p class="mt-3 text-3xl font-bold">18</p></div>
                <div class="rounded-lg border border-slate-200 bg-white p-5"><p class="text-sm font-semibold text-slate-500">No leidas</p><p class="mt-3 text-3xl font-bold">4</p></div>
                <div class="rounded-lg border border-slate-200 bg-white p-5"><p class="text-sm font-semibold text-slate-500">Seguridad</p><p class="mt-3 text-3xl font-bold">2</p></div>
                <div class="rounded-lg border border-slate-200 bg-white p-5"><p class="text-sm font-semibold text-slate-500">Promociones</p><p class="mt-3 text-3xl font-bold">3</p></div>
            </section>

            <section class="mt-6 grid gap-6 xl:grid-cols-[300px_1fr]">
                <aside class="rounded-lg border border-slate-200 bg-white p-5">
                    <h3 class="text-xl font-bold">Tipos</h3>
                    <div class="mt-5 space-y-2">
                        @foreach ($types as $type)
                            <button class="w-full rounded-md bg-slate-50 px-3 py-2 text-left text-sm font-semibold text-slate-700 hover:bg-emerald-50 hover:text-emerald-800">{{ $type }}</button>
                        @endforeach
                    </div>
                    <div class="mt-6 border-t border-slate-100 pt-5">
                        <h4 class="font-bold">Filtros</h4>
                        <div class="mt-3 space-y-2 text-sm">
                            <label class="flex items-center gap-2"><input type="checkbox" class="rounded border-slate-300 text-emerald-600"> Solo no leidas</label>
                            <label class="flex items-center gap-2"><input type="checkbox" class="rounded border-slate-300 text-emerald-600"> Seguridad</label>
                            <label class="flex items-center gap-2"><input type="checkbox" class="rounded border-slate-300 text-emerald-600"> Viajes activos</label>
                        </div>
                    </div>
                </aside>

                <section class="rounded-lg border border-slate-200 bg-white p-5">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <h3 class="text-xl font-bold">Ver todas</h3>
                            <p class="mt-1 text-sm text-slate-500">Listado de alertas recientes y acciones rapidas.</p>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <button class="rounded-md border border-slate-300 px-3 py-2 text-sm font-semibold hover:bg-slate-50">Filtrar</button>
                            <button class="rounded-md border border-red-200 px-3 py-2 text-sm font-semibold text-red-700 hover:bg-red-50">Eliminar leidas</button>
                        </div>
                    </div>

                    <div class="mt-5 space-y-3">
                        @foreach ($notifications as $notification)
                            <article class="rounded-lg border border-slate-200 p-4 {{ $notification['status'] === 'Nueva' ? 'bg-emerald-50/50' : 'bg-white' }}">
                                <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                                    <div>
                                        <div class="flex flex-wrap items-center gap-2">
                                            <span class="rounded-full px-3 py-1 text-xs font-semibold
                                                @class([
                                                    'bg-emerald-100 text-emerald-800' => $notification['tone'] === 'emerald',
                                                    'bg-sky-100 text-sky-800' => $notification['tone'] === 'sky',
                                                    'bg-amber-100 text-amber-800' => $notification['tone'] === 'amber',
                                                    'bg-slate-100 text-slate-700' => $notification['tone'] === 'slate',
                                                ])">{{ $notification['type'] }}</span>
                                            <span class="rounded-full {{ $notification['status'] === 'Nueva' ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-600' }} px-3 py-1 text-xs font-semibold">{{ $notification['status'] }}</span>
                                        </div>
                                        <h4 class="mt-3 text-lg font-bold">{{ $notification['title'] }}</h4>
                                        <p class="mt-1 text-sm text-slate-600">{{ $notification['message'] }}</p>
                                        <p class="mt-2 text-xs text-slate-500">{{ $notification['time'] }}</p>
                                    </div>
                                    <div class="flex flex-wrap gap-2">
                                        <button class="rounded-md border border-slate-300 px-3 py-2 text-sm font-semibold hover:bg-slate-50">Marcar como leida</button>
                                        <button class="rounded-md border border-red-200 px-3 py-2 text-sm font-semibold text-red-700 hover:bg-red-50">Eliminar</button>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>
            </section>

            <section class="mt-6 grid gap-4 md:grid-cols-4">
                <button class="rounded-md bg-emerald-600 px-4 py-3 font-semibold text-white hover:bg-emerald-700">Marcar como leida</button>
                <button class="rounded-md border border-red-200 bg-white px-4 py-3 font-semibold text-red-700 hover:bg-red-50">Eliminar</button>
                <button class="rounded-md border border-slate-300 bg-white px-4 py-3 font-semibold hover:bg-slate-50">Filtrar</button>
                <button class="rounded-md border border-slate-300 bg-white px-4 py-3 font-semibold hover:bg-slate-50">Ver todas</button>
            </section>
        </main>
    </div>
</body>
</html>
