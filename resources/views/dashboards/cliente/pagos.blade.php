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

    $payments = [
        ['id' => '#FAC-2041', 'service' => '#MD-1024', 'date' => '2026-07-01', 'method' => 'Tarjeta', 'amount' => '$1.250.000', 'status' => 'Pagado'],
        ['id' => '#FAC-2042', 'service' => '#MD-1025', 'date' => '2026-07-02', 'method' => 'Transferencia', 'amount' => '$680.000', 'status' => 'Pendiente'],
        ['id' => '#FAC-2038', 'service' => '#MD-1019', 'date' => '2026-06-25', 'method' => 'Saldo interno', 'amount' => '$920.000', 'status' => 'Pagado'],
    ];
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagos</title>
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
                    <a href="{{ $item['url'] }}" class="block rounded-md px-3 py-2 text-sm font-semibold transition {{ $item['label'] === 'Pagos' ? 'bg-white text-slate-950' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
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
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-700">pagos</p>
                    <h2 class="mt-2 text-3xl font-bold">Centro de pagos</h2>
                    <p class="mt-2 text-slate-600">Consulta costos, facturas, comprobantes, descuentos, comisiones y devoluciones.</p>
                </div>
                <button type="button" data-pay class="rounded-md bg-emerald-600 px-4 py-2.5 font-semibold text-white hover:bg-emerald-700">Pagar servicio</button>
            </div>

            <section class="mt-8 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-lg border border-slate-200 bg-white p-5"><p class="text-sm font-semibold text-slate-500">Total pagado</p><p class="mt-3 text-3xl font-bold">$8.900.000</p></div>
                <div class="rounded-lg border border-slate-200 bg-white p-5"><p class="text-sm font-semibold text-slate-500">Servicios pendientes</p><p class="mt-3 text-3xl font-bold">1</p></div>
                <div class="rounded-lg border border-slate-200 bg-white p-5"><p class="text-sm font-semibold text-slate-500">Facturas</p><p class="mt-3 text-3xl font-bold">12</p></div>
                <div class="rounded-lg border border-slate-200 bg-white p-5"><p class="text-sm font-semibold text-slate-500">Comprobantes</p><p class="mt-3 text-3xl font-bold">9</p></div>
            </section>

            <div class="mt-6 grid gap-6 xl:grid-cols-[0.85fr_1.15fr]">
                <section class="rounded-lg border border-slate-200 bg-white p-5">
                    <h3 class="text-xl font-bold">Metodos de pago</h3>
                    <div class="mt-5 grid gap-3">
                        @foreach (['Tarjeta', 'Transferencia', 'Billetera digital', 'Saldo interno'] as $method)
                            <label class="flex cursor-pointer items-center justify-between rounded-md border border-slate-200 p-4 hover:border-emerald-500 hover:bg-emerald-50">
                                <span class="font-semibold">{{ $method }}</span>
                                <input type="radio" name="payment_method" class="text-emerald-600" @checked($loop->first)>
                            </label>
                        @endforeach
                    </div>

                    <div class="mt-5 rounded-md bg-slate-50 p-4 text-sm">
                        <div class="flex justify-between gap-3"><span class="text-slate-600">Servicio pendiente</span><strong>#MD-1025</strong></div>
                        <div class="mt-3 flex justify-between gap-3"><span class="text-slate-600">Subtotal</span><strong>$650.000</strong></div>
                        <div class="mt-3 flex justify-between gap-3"><span class="text-slate-600">Comision</span><strong>$30.000</strong></div>
                        <div class="mt-3 flex justify-between gap-3"><span class="text-slate-600">Descuento</span><strong class="text-emerald-700">-$0</strong></div>
                        <div class="mt-4 border-t border-slate-200 pt-4 flex justify-between gap-3 text-base"><span class="font-semibold">Total</span><strong>$680.000</strong></div>
                    </div>
                </section>

                <section class="rounded-lg border border-slate-200 bg-white p-5">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <h3 class="text-xl font-bold">Facturas y comprobantes</h3>
                            <p class="mt-1 text-sm text-slate-500">Descarga facturas, recibos y revisa el historial de pagos.</p>
                        </div>
                        <button type="button" data-history class="rounded-md border border-slate-300 px-3 py-2 text-sm font-semibold hover:bg-slate-50">Ver historial</button>
                    </div>

                    <div class="mt-5 overflow-x-auto">
                        <table class="w-full min-w-[720px] text-left text-sm">
                            <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                                <tr>
                                    <th class="px-3 py-3">Factura</th>
                                    <th class="px-3 py-3">Servicio</th>
                                    <th class="px-3 py-3">Fecha</th>
                                    <th class="px-3 py-3">Metodo</th>
                                    <th class="px-3 py-3">Valor</th>
                                    <th class="px-3 py-3">Estado</th>
                                    <th class="px-3 py-3">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ($payments as $payment)
                                    <tr>
                                        <td class="px-3 py-4 font-semibold">{{ $payment['id'] }}</td>
                                        <td class="px-3 py-4">{{ $payment['service'] }}</td>
                                        <td class="px-3 py-4">{{ $payment['date'] }}</td>
                                        <td class="px-3 py-4">{{ $payment['method'] }}</td>
                                        <td class="px-3 py-4">{{ $payment['amount'] }}</td>
                                        <td class="px-3 py-4">
                                            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $payment['status'] === 'Pagado' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">{{ $payment['status'] }}</span>
                                        </td>
                                        <td class="px-3 py-4">
                                            <div class="flex gap-2">
                                                <button type="button" data-invoice class="font-semibold text-emerald-700">Factura</button>
                                                <button type="button" data-receipt class="font-semibold text-slate-700">Recibo</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>

            <section class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-5">
                <button type="button" data-pay class="rounded-md bg-emerald-600 px-4 py-3 font-semibold text-white hover:bg-emerald-700">Pagar</button>
                <button type="button" data-invoice class="rounded-md border border-slate-300 bg-white px-4 py-3 font-semibold hover:bg-slate-50">Descargar factura</button>
                <button type="button" data-receipt class="rounded-md border border-slate-300 bg-white px-4 py-3 font-semibold hover:bg-slate-50">Descargar recibo</button>
                <button type="button" data-history class="rounded-md border border-slate-300 bg-white px-4 py-3 font-semibold hover:bg-slate-50">Ver historial</button>
                <button type="button" data-refund class="rounded-md border border-red-200 bg-white px-4 py-3 font-semibold text-red-700 hover:bg-red-50">Solicitar devolucion</button>
            </section>

            <section id="payment-summary" class="mt-6 hidden rounded-lg border border-emerald-200 bg-white p-5">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">Resumen de pago</p>
                        <h3 class="mt-1 text-2xl font-bold">Solicitud #125</h3>
                    </div>
                    <span id="payment-status" class="rounded-full bg-amber-100 px-3 py-1 text-sm font-semibold text-amber-800">Pendiente</span>
                </div>

                <dl class="mt-5 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                    <div class="rounded-md bg-slate-50 p-4"><dt class="text-sm text-slate-500">Origen</dt><dd class="mt-1 font-bold">Puerto Asis</dd></div>
                    <div class="rounded-md bg-slate-50 p-4"><dt class="text-sm text-slate-500">Destino</dt><dd class="mt-1 font-bold">Mocoa</dd></div>
                    <div class="rounded-md bg-slate-50 p-4"><dt class="text-sm text-slate-500">Conductor</dt><dd class="mt-1 font-bold">Carlos Lopez</dd></div>
                    <div class="rounded-md bg-slate-50 p-4"><dt class="text-sm text-slate-500">Vehiculo</dt><dd class="mt-1 font-bold">Camioneta</dd></div>
                    <div class="rounded-md bg-slate-50 p-4"><dt class="text-sm text-slate-500">Valor del servicio</dt><dd class="mt-1 font-bold">$120.000</dd></div>
                    <div class="rounded-md bg-slate-50 p-4"><dt class="text-sm text-slate-500">Comision plataforma</dt><dd class="mt-1 font-bold">$5.000</dd></div>
                </dl>

                <div class="mt-5 rounded-md bg-emerald-50 p-5">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <span class="text-lg font-semibold">Total</span>
                        <strong class="text-3xl">$125.000</strong>
                    </div>
                </div>

                <div class="mt-5 flex flex-wrap justify-end gap-2">
                    <button type="button" data-close-summary class="rounded-md border border-slate-300 px-4 py-2.5 font-semibold hover:bg-slate-50">Cancelar</button>
                    <button type="button" data-continue-payment class="rounded-md bg-emerald-600 px-4 py-2.5 font-semibold text-white hover:bg-emerald-700">Continuar al pago</button>
                </div>
            </section>

            <section id="payment-history" class="mt-6 hidden rounded-lg border border-slate-200 bg-white p-5">
                <h3 class="text-xl font-bold">Historial de pagos</h3>
                <div class="mt-4 grid gap-3 md:grid-cols-3">
                    <div class="rounded-md bg-slate-50 p-4"><p class="font-bold">#FAC-2041</p><p class="mt-1 text-sm text-slate-500">Pagado - $1.250.000</p></div>
                    <div class="rounded-md bg-slate-50 p-4"><p class="font-bold">#FAC-2042</p><p class="mt-1 text-sm text-slate-500">Pendiente - $680.000</p></div>
                    <div class="rounded-md bg-slate-50 p-4"><p class="font-bold">#FAC-0125</p><p class="mt-1 text-sm text-slate-500">Solicitud #125 - $125.000</p></div>
                </div>
            </section>
        </main>
    </div>

    <script>
        const paymentSummary = document.getElementById('payment-summary');
        const paymentHistory = document.getElementById('payment-history');
        const paymentStatus = document.getElementById('payment-status');

        function downloadTextFile(filename, content) {
            const blob = new Blob([content], { type: 'text/plain;charset=utf-8' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = filename;
            link.click();
            URL.revokeObjectURL(url);
        }

        document.querySelectorAll('[data-pay]').forEach((button) => {
            button.addEventListener('click', () => {
                paymentSummary.classList.remove('hidden');
                paymentSummary.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });

        document.querySelector('[data-close-summary]').addEventListener('click', () => {
            paymentSummary.classList.add('hidden');
        });

        document.querySelector('[data-continue-payment]').addEventListener('click', () => {
            Swal.fire({
                icon: 'question',
                title: 'Confirmar pago',
                html: '<strong>Total a pagar: $125.000</strong><br>Metodo seleccionado: Tarjeta',
                showCancelButton: true,
                confirmButtonText: 'Pagar ahora',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#059669',
            }).then((result) => {
                if (!result.isConfirmed) return;
                paymentStatus.textContent = 'Pagado';
                paymentStatus.className = 'rounded-full bg-emerald-100 px-3 py-1 text-sm font-semibold text-emerald-800';
                Swal.fire({
                    icon: 'success',
                    title: 'Pago realizado',
                    text: 'El pago de la solicitud #125 fue registrado correctamente.',
                    confirmButtonColor: '#059669',
                });
            });
        });

        document.querySelectorAll('[data-invoice]').forEach((button) => {
            button.addEventListener('click', () => {
                downloadTextFile('factura-solicitud-125.txt', 'FACTURA\nSolicitud #125\nOrigen: Puerto Asis\nDestino: Mocoa\nConductor: Carlos Lopez\nValor servicio: $120.000\nComision plataforma: $5.000\nTotal: $125.000');
                Swal.fire({ icon: 'success', title: 'Factura descargada', timer: 1600, showConfirmButton: false });
            });
        });

        document.querySelectorAll('[data-receipt]').forEach((button) => {
            button.addEventListener('click', () => {
                downloadTextFile('recibo-solicitud-125.txt', 'RECIBO DE PAGO\nSolicitud #125\nTotal pagado: $125.000\nEstado: Pagado\nCliente: {{ $user->name }}');
                Swal.fire({ icon: 'success', title: 'Recibo descargado', timer: 1600, showConfirmButton: false });
            });
        });

        document.querySelectorAll('[data-history]').forEach((button) => {
            button.addEventListener('click', () => {
                paymentHistory.classList.toggle('hidden');
                paymentHistory.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });

        document.querySelector('[data-refund]').addEventListener('click', async () => {
            const result = await Swal.fire({
                icon: 'warning',
                title: 'Solicitar devolucion',
                input: 'textarea',
                inputPlaceholder: 'Explica el motivo de la devolucion',
                showCancelButton: true,
                confirmButtonText: 'Enviar solicitud',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#dc2626',
                inputValidator: (value) => !value ? 'Debes escribir el motivo.' : null,
            });

            if (result.isConfirmed) {
                Swal.fire({
                    icon: 'success',
                    title: 'Solicitud enviada',
                    text: 'Tu solicitud de devolucion quedo registrada para revision.',
                    confirmButtonColor: '#059669',
                });
            }
        });
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
</body>
</html>
