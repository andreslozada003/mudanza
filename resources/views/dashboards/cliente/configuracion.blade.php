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
    <title>Configuracion</title>
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
                    <a href="{{ $item['url'] }}" class="block rounded-md px-3 py-2 text-sm font-semibold transition {{ $item['label'] === 'Configuracion' ? 'bg-white text-slate-950' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
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
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-700">configuracion</p>
                    <h2 class="mt-2 text-3xl font-bold">Preferencias de la cuenta</h2>
                    <p class="mt-2 text-slate-600">Configura idioma, pagos, notificaciones, privacidad y accesibilidad.</p>
                </div>
                <button type="button" class="rounded-md bg-emerald-600 px-4 py-2.5 font-semibold text-white hover:bg-emerald-700">Guardar cambios</button>
            </div>

            <div class="mt-8 grid gap-6 xl:grid-cols-2">
                <section class="rounded-lg border border-slate-200 bg-white p-5">
                    <h3 class="text-xl font-bold">General</h3>
                    <div class="mt-5 grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-medium">Idioma</label>
                            <select class="w-full rounded-md border border-slate-300 px-3 py-2"><option>Español</option><option>Ingles</option></select>
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium">Moneda</label>
                            <select class="w-full rounded-md border border-slate-300 px-3 py-2"><option>COP - Peso colombiano</option><option>USD - Dolar</option></select>
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium">Zona horaria</label>
                            <select class="w-full rounded-md border border-slate-300 px-3 py-2"><option>America/Bogota</option><option>UTC</option></select>
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium">Tema</label>
                            <select class="w-full rounded-md border border-slate-300 px-3 py-2"><option>Claro</option><option>Oscuro</option><option>Automatico</option></select>
                        </div>
                    </div>
                </section>

                <section class="rounded-lg border border-slate-200 bg-white p-5">
                    <h3 class="text-xl font-bold">Notificaciones</h3>
                    <div class="mt-5 grid gap-3">
                        @foreach (['Correo', 'SMS', 'Push', 'WhatsApp'] as $item)
                            <label class="flex items-center justify-between rounded-md bg-slate-50 p-4">
                                <span class="font-semibold">{{ $item }}</span>
                                <input type="checkbox" class="rounded border-slate-300 text-emerald-600" checked>
                            </label>
                        @endforeach
                    </div>
                </section>
            </div>

            <div class="mt-6 grid gap-6 xl:grid-cols-2">
                <section class="rounded-lg border border-slate-200 bg-white p-5">
                    <h3 class="text-xl font-bold">Privacidad</h3>
                    <div class="mt-5 space-y-4">
                        <div>
                            <label class="mb-2 block text-sm font-medium">Quien puede ver el perfil</label>
                            <select class="w-full rounded-md border border-slate-300 px-3 py-2"><option>Solo conductores asignados</option><option>Conductores verificados</option><option>Nadie</option></select>
                        </div>
                        <label class="flex items-center justify-between rounded-md bg-slate-50 p-4">
                            <span class="font-semibold">Compartir datos con conductores</span>
                            <input type="checkbox" class="rounded border-slate-300 text-emerald-600" checked>
                        </label>
                        <label class="flex items-center justify-between rounded-md bg-slate-50 p-4">
                            <span class="font-semibold">Consentimiento para promociones</span>
                            <input type="checkbox" class="rounded border-slate-300 text-emerald-600">
                        </label>
                    </div>
                </section>

                <section class="rounded-lg border border-slate-200 bg-white p-5">
                    <h3 class="text-xl font-bold">Preferencias</h3>
                    <div class="mt-5 grid gap-4">
                        <div>
                            <label class="mb-2 block text-sm font-medium">Vehiculos favoritos</label>
                            <select class="w-full rounded-md border border-slate-300 px-3 py-2"><option>Furgon</option><option>Camioneta</option><option>Camion</option><option>Tractomula</option></select>
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium">Direcciones frecuentes</label>
                            <input type="text" value="Puerto Asis, Putumayo" class="w-full rounded-md border border-slate-300 px-3 py-2">
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium">Metodo de pago predeterminado</label>
                            <select class="w-full rounded-md border border-slate-300 px-3 py-2"><option>Tarjeta</option><option>Transferencia</option><option>Billetera digital</option><option>Saldo interno</option></select>
                        </div>
                    </div>
                </section>
            </div>

            <section class="mt-6 rounded-lg border border-slate-200 bg-white p-5">
                <h3 class="text-xl font-bold">Configuracion de accesibilidad</h3>
                <div class="mt-5 grid gap-3 md:grid-cols-3">
                    <label class="flex items-center justify-between rounded-md bg-slate-50 p-4"><span class="font-semibold">Texto grande</span><input type="checkbox" class="rounded border-slate-300 text-emerald-600"></label>
                    <label class="flex items-center justify-between rounded-md bg-slate-50 p-4"><span class="font-semibold">Alto contraste</span><input type="checkbox" class="rounded border-slate-300 text-emerald-600"></label>
                    <label class="flex items-center justify-between rounded-md bg-slate-50 p-4"><span class="font-semibold">Reducir animaciones</span><input type="checkbox" class="rounded border-slate-300 text-emerald-600"></label>
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
    <script src="{{ asset('js/client-mobile.js') }}?v=3"></script>
</body>
</html>
