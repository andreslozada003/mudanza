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

    $drivers = [
        ['name' => 'Carlos Ramirez', 'company' => 'Carga Express SAS', 'experience' => '8 anos', 'rating' => '4.9', 'trips' => '318', 'vehicles' => 'Furgon, camioneta', 'city' => 'Bogota', 'status' => 'Disponible', 'verified' => 'Verificado', 'response' => '5 min', 'capacity' => '2.5 ton', 'price' => '$1.180.000', 'distance' => '4.2 km'],
        ['name' => 'Laura Martinez', 'company' => 'Independiente', 'experience' => '5 anos', 'rating' => '4.8', 'trips' => '204', 'vehicles' => 'Camion', 'city' => 'Medellin', 'status' => 'Disponible', 'verified' => 'Verificado', 'response' => '8 min', 'capacity' => '5 ton', 'price' => '$1.450.000', 'distance' => '7.8 km'],
        ['name' => 'Jorge Silva', 'company' => 'Logistica Norte', 'experience' => '11 anos', 'rating' => '4.7', 'trips' => '512', 'vehicles' => 'Tractomula', 'city' => 'Cali', 'status' => 'Ocupado', 'verified' => 'Verificado', 'response' => '15 min', 'capacity' => '18 ton', 'price' => '$3.900.000', 'distance' => '12 km'],
    ];
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar conductor</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 text-slate-900">
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
                    <h2 class="mt-2 text-3xl font-bold">Conductores disponibles</h2>
                    <p class="mt-2 text-slate-600">Busca, filtra, revisa perfiles y elige el conductor ideal para tu carga.</p>
                </div>
                <button type="button" class="rounded-md bg-emerald-600 px-4 py-2.5 font-semibold text-white hover:bg-emerald-700">Asignar automaticamente</button>
            </div>

            <section class="mt-8 rounded-lg border border-slate-200 bg-white p-5">
                <h3 class="text-xl font-bold">Busqueda</h3>
                <div class="mt-5 grid gap-4 md:grid-cols-3">
                    <div>
                        <label class="mb-2 block text-sm font-medium">Buscar por nombre</label>
                        <input type="text" placeholder="Nombre del conductor" class="w-full rounded-md border border-slate-300 px-3 py-2 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium">Buscar por ciudad</label>
                        <input type="text" placeholder="Ciudad" class="w-full rounded-md border border-slate-300 px-3 py-2 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium">Tipo de vehiculo</label>
                        <select class="w-full rounded-md border border-slate-300 px-3 py-2 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                            <option>Todos</option>
                            <option>Camion</option>
                            <option>Furgon</option>
                            <option>Camioneta</option>
                            <option>Moto</option>
                            <option>Tractomula</option>
                        </select>
                    </div>
                </div>
            </section>

            <section class="mt-6 grid gap-6 xl:grid-cols-[280px_1fr]">
                <aside class="rounded-lg border border-slate-200 bg-white p-5">
                    <h3 class="text-xl font-bold">Filtros</h3>
                    <div class="mt-5 space-y-5">
                        <div>
                            <p class="mb-2 text-sm font-semibold">Vehiculo</p>
                            <div class="space-y-2 text-sm">
                                @foreach (['Camion', 'Furgon', 'Camioneta', 'Moto', 'Tractomula'] as $vehicle)
                                    <label class="flex items-center gap-2"><input type="checkbox" class="rounded border-slate-300 text-emerald-600"> {{ $vehicle }}</label>
                                @endforeach
                            </div>
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-semibold">Capacidad</label>
                            <select class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm"><option>Cualquier capacidad</option><option>Hasta 1 tonelada</option><option>1 a 5 toneladas</option><option>Mas de 5 toneladas</option></select>
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-semibold">Precio maximo</label>
                            <input type="text" placeholder="$0" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm">
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-semibold">Calificacion minima</label>
                            <select class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm"><option>4.5+</option><option>4.0+</option><option>3.5+</option></select>
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-semibold">Distancia</label>
                            <select class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm"><option>Menos de 5 km</option><option>Menos de 10 km</option><option>Cualquier distancia</option></select>
                        </div>
                        <label class="flex items-center gap-2 text-sm font-semibold"><input type="checkbox" class="rounded border-slate-300 text-emerald-600"> Disponible ahora</label>
                    </div>
                </aside>

                <section class="space-y-4">
                    @foreach ($drivers as $driver)
                        <article class="rounded-lg border border-slate-200 bg-white p-5">
                            <div class="flex flex-col gap-5 xl:flex-row xl:items-start xl:justify-between">
                                <div class="flex gap-4">
                                    <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-md bg-emerald-100 text-xl font-bold text-emerald-800">
                                        {{ substr($driver['name'], 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="flex flex-wrap items-center gap-2">
                                            <h3 class="text-xl font-bold">{{ $driver['name'] }}</h3>
                                            <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-800">{{ $driver['verified'] }}</span>
                                            <span class="rounded-full {{ $driver['status'] === 'Disponible' ? 'bg-sky-100 text-sky-800' : 'bg-slate-200 text-slate-700' }} px-3 py-1 text-xs font-semibold">{{ $driver['status'] }}</span>
                                        </div>
                                        <p class="mt-1 text-sm text-slate-500">{{ $driver['company'] }}</p>
                                        <div class="mt-4 grid gap-3 text-sm md:grid-cols-3">
                                            <div><span class="text-slate-500">Experiencia</span><p class="font-semibold">{{ $driver['experience'] }}</p></div>
                                            <div><span class="text-slate-500">Calificacion</span><p class="font-semibold">{{ $driver['rating'] }} / 5</p></div>
                                            <div><span class="text-slate-500">Viajes</span><p class="font-semibold">{{ $driver['trips'] }}</p></div>
                                            <div><span class="text-slate-500">Vehiculos</span><p class="font-semibold">{{ $driver['vehicles'] }}</p></div>
                                            <div><span class="text-slate-500">Ciudad</span><p class="font-semibold">{{ $driver['city'] }}</p></div>
                                            <div><span class="text-slate-500">Respuesta</span><p class="font-semibold">{{ $driver['response'] }}</p></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="w-full rounded-md bg-slate-50 p-4 xl:w-56">
                                    <div class="space-y-2 text-sm">
                                        <div class="flex justify-between gap-3"><span class="text-slate-500">Capacidad</span><strong>{{ $driver['capacity'] }}</strong></div>
                                        <div class="flex justify-between gap-3"><span class="text-slate-500">Precio</span><strong>{{ $driver['price'] }}</strong></div>
                                        <div class="flex justify-between gap-3"><span class="text-slate-500">Distancia</span><strong>{{ $driver['distance'] }}</strong></div>
                                    </div>
                                    <div class="mt-4 grid gap-2">
                                        <button class="rounded-md bg-emerald-600 px-3 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Enviar solicitud</button>
                                        <button class="rounded-md border border-slate-300 bg-white px-3 py-2 text-sm font-semibold hover:bg-slate-50">Ver perfil</button>
                                        <button class="rounded-md border border-slate-300 bg-white px-3 py-2 text-sm font-semibold hover:bg-slate-50">Agregar a favoritos</button>
                                        <button class="rounded-md border border-slate-300 bg-white px-3 py-2 text-sm font-semibold hover:bg-slate-50">Chatear</button>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </section>
            </section>
        </main>
    </div>
</body>
</html>
