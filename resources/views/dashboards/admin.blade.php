@php
    $menuItems = [
        ['label' => 'Resumen', 'href' => '#resumen'],
        ['label' => 'Verificaciones', 'href' => '#verificaciones'],
        ['label' => 'Usuarios', 'href' => '#usuarios'],
        ['label' => 'Conductores', 'href' => '#conductores'],
        ['label' => 'Solicitudes', 'href' => '#solicitudes'],
        ['label' => 'Reportes', 'href' => '#reportes'],
        ['label' => 'Mensajes', 'href' => '#mensajes'],
    ];

    $statusClass = fn ($status) => match ($status) {
        'aprobado', 'resuelto', 'aceptada' => 'bg-emerald-100 text-emerald-800',
        'rechazado', 'cancelada', 'rechazada' => 'bg-red-100 text-red-800',
        'en_revision', 'enviada', 'pendiente' => 'bg-amber-100 text-amber-800',
        default => 'bg-slate-100 text-slate-700',
    };
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel administrador</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="min-h-screen bg-slate-100 text-slate-900">
    <div class="min-h-screen lg:pl-[290px]">
        <aside id="admin-sidebar" class="fixed inset-y-0 left-0 z-40 hidden w-[290px] overflow-y-auto bg-slate-950 px-5 py-6 text-white lg:block">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-300">Puerto Asis</p>
            <h1 class="mt-2 text-xl font-bold">Admin empresarial</h1>

            <nav class="mt-8 space-y-1">
                @foreach ($menuItems as $item)
                    <a href="{{ $item['href'] }}" class="block rounded-md px-3 py-2 text-sm font-semibold text-slate-300 transition hover:bg-white/10 hover:text-white">{{ $item['label'] }}</a>
                @endforeach
            </nav>

            <div class="mt-8 rounded-md border border-white/10 bg-white/5 p-4">
                <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>
                <p class="mt-1 break-all text-xs text-slate-300">{{ auth()->user()->email }}</p>
            </div>

            <form class="mt-6" method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full rounded-md bg-white px-4 py-2 font-semibold text-slate-950 hover:bg-slate-200">Cerrar sesion</button>
            </form>
        </aside>

        <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/95 px-4 py-3 backdrop-blur lg:hidden">
            <div class="flex items-center justify-between gap-3">
                <a href="{{ route('admin.dashboard') }}" class="flex h-10 w-10 items-center justify-center rounded-md bg-emerald-600 text-white">⌂</a>
                <div class="min-w-0 flex-1">
                    <p class="truncate text-xs font-semibold text-slate-500">Puerto Asis</p>
                    <p class="truncate font-bold">Admin</p>
                </div>
                <button type="button" data-admin-menu class="flex h-10 w-10 items-center justify-center rounded-md border border-slate-300">☰</button>
            </div>
        </header>

        <main class="px-4 py-6 lg:px-8 lg:py-8">
            <section id="resumen" class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-700">centro de control</p>
                    <h2 class="mt-2 text-3xl font-bold">Operaciones en tiempo real</h2>
                    <p class="mt-2 text-slate-600">Usuarios, verificaciones, conductores, chats, solicitudes y reportes desde la base de datos.</p>
                </div>
                <div class="rounded-md border border-slate-200 bg-white px-4 py-3 text-sm">
                    <span class="text-slate-500">Actualizado:</span>
                    <strong data-stat="updated_at">{{ $stats['updated_at'] }}</strong>
                </div>
            </section>

            @if (session('status'))
                <div class="mt-6 rounded-md border border-emerald-200 bg-emerald-50 p-3 text-sm font-semibold text-emerald-800">
                    {{ session('status') }}
                </div>
            @endif

            <section class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                @foreach ([
                    ['Usuarios', 'users', 'Clientes: '.$stats['clients'].' · Conductores: '.$stats['conductors']],
                    ['Verificaciones pendientes', 'pending_verifications', 'Aprobadas: '.$stats['approved_verifications']],
                    ['Conductores verificados', 'verified_drivers', 'Total conductores: '.$stats['drivers']],
                    ['Reportes pendientes', 'pending_reports', 'En revision: '.$stats['review_reports']],
                    ['Solicitudes enviadas', 'service_requests', 'Conductor seleccionado'],
                    ['Conversaciones activas', 'active_conversations', 'Mensajes: '.$stats['messages']],
                    ['Administradores', 'admins', 'Acceso protegido'],
                    ['Reportes resueltos', 'resolved_reports', 'Historial operativo'],
                ] as $card)
                    <article class="rounded-lg border border-slate-200 bg-white p-5">
                        <p class="text-sm font-semibold text-slate-500">{{ $card[0] }}</p>
                        <p data-stat="{{ $card[1] }}" class="mt-3 text-3xl font-bold">{{ $stats[$card[1]] }}</p>
                        <p class="mt-2 text-sm text-slate-500">{{ $card[2] }}</p>
                    </article>
                @endforeach
            </section>

            <section id="verificaciones" class="mt-6 rounded-lg border border-slate-200 bg-white p-5">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <h3 class="text-xl font-bold">Verificaciones KYC</h3>
                        <p class="mt-1 text-sm text-slate-500">Revisa documento, selfie y estado del usuario.</p>
                    </div>
                    <a href="#reportes" class="rounded-md border border-slate-300 px-3 py-2 text-sm font-semibold hover:bg-slate-50">Ver reportes</a>
                </div>
                <div class="mt-5 overflow-x-auto">
                    <table class="w-full min-w-[860px] text-left text-sm">
                        <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                            <tr><th class="px-3 py-3">Usuario</th><th class="px-3 py-3">Rol</th><th class="px-3 py-3">Documento</th><th class="px-3 py-3">Celular</th><th class="px-3 py-3">Estado</th><th class="px-3 py-3 text-right">Accion</th></tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($verifications as $verification)
                                <tr>
                                    <td class="px-3 py-4"><div class="font-semibold">{{ $verification->user->name }}</div><div class="text-slate-500">{{ $verification->user->email }}</div></td>
                                    <td class="px-3 py-4 capitalize">{{ $verification->user->role }}</td>
                                    <td class="px-3 py-4"><div class="uppercase">{{ $verification->document_type }}</div><div class="text-slate-500">{{ $verification->document_number }}</div></td>
                                    <td class="px-3 py-4">{{ $verification->user->phone }}</td>
                                    <td class="px-3 py-4"><span class="rounded-full px-3 py-1 text-xs font-semibold {{ $statusClass($verification->status) }}">{{ str_replace('_', ' ', $verification->status) }}</span></td>
                                    <td class="px-3 py-4 text-right"><a href="{{ route('admin.verifications.show', $verification) }}" class="rounded-md bg-emerald-600 px-3 py-2 font-semibold text-white hover:bg-emerald-700">Revisar</a></td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="px-3 py-10 text-center text-slate-500">No hay verificaciones.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-5">{{ $verifications->links() }}</div>
            </section>

            <div class="mt-6 grid gap-6 xl:grid-cols-2">
                <section id="usuarios" class="rounded-lg border border-slate-200 bg-white p-5">
                    <h3 class="text-xl font-bold">Usuarios recientes</h3>
                    <div class="mt-4 space-y-3">
                        @foreach ($users as $user)
                            <div class="flex flex-wrap items-center justify-between gap-3 rounded-md bg-slate-50 p-3">
                                <div><p class="font-semibold">{{ $user->name }}</p><p class="text-sm text-slate-500">{{ $user->email }}</p></div>
                                <span class="rounded-full bg-white px-3 py-1 text-xs font-semibold capitalize text-slate-700">{{ $user->role }}</span>
                            </div>
                        @endforeach
                    </div>
                </section>

                <section id="conductores" class="rounded-lg border border-slate-200 bg-white p-5">
                    <h3 class="text-xl font-bold">Conductores</h3>
                    <div class="mt-4 space-y-3">
                        @foreach ($drivers as $driver)
                            @php $verified = $driver->verified_identity && $driver->verified_license && $driver->verified_vehicle && $driver->soat_active && $driver->technical_review_active; @endphp
                            <div class="rounded-md bg-slate-50 p-3">
                                <div class="flex flex-wrap items-center justify-between gap-3">
                                    <div><p class="font-semibold">{{ $driver->name }}</p><p class="text-sm text-slate-500">{{ $driver->vehicle_type }} · {{ $driver->city }} · {{ $driver->rating }}</p></div>
                                    <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $verified ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">{{ $verified ? 'Verificado' : 'Pendiente' }}</span>
                                </div>
                                @unless ($verified)
                                    <form class="mt-3" method="POST" action="{{ route('admin.drivers.verify', $driver) }}">
                                        @csrf
                                        <button data-confirm="Verificar conductor {{ $driver->name }}?" class="rounded-md bg-emerald-600 px-3 py-2 text-sm font-semibold text-white">Verificar conductor</button>
                                    </form>
                                @endunless
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>

            <div class="mt-6 grid gap-6 xl:grid-cols-3">
                <section id="solicitudes" class="rounded-lg border border-slate-200 bg-white p-5">
                    <h3 class="text-xl font-bold">Solicitudes a conductores</h3>
                    <div class="mt-4 space-y-3">
                        @forelse ($serviceRequests as $request)
                            <div class="rounded-md bg-slate-50 p-3 text-sm">
                                <p class="font-semibold">{{ $request->request_number }}</p>
                                <p class="mt-1 text-slate-500">{{ $request->origin }} a {{ $request->destination }} · ${{ number_format($request->offered_price, 0, ',', '.') }}</p>
                                <span class="mt-2 inline-block rounded-full px-3 py-1 text-xs font-semibold {{ $statusClass($request->status) }}">{{ $request->status }}</span>
                            </div>
                        @empty
                            <p class="text-sm text-slate-500">No hay solicitudes enviadas.</p>
                        @endforelse
                    </div>
                </section>

                <section id="reportes" class="rounded-lg border border-slate-200 bg-white p-5">
                    <h3 class="text-xl font-bold">Reportes</h3>
                    <div class="mt-4 space-y-3">
                        @forelse ($reports as $report)
                            <form method="POST" action="{{ route('admin.reports.update', $report) }}" class="rounded-md bg-slate-50 p-3 text-sm">
                                @csrf
                                <p class="font-semibold">{{ $report->reason }}</p>
                                <p class="mt-1 text-slate-500">{{ $report->description ?: 'Sin descripcion' }}</p>
                                <select name="status" class="mt-3 w-full rounded-md border border-slate-300 px-3 py-2">
                                    @foreach (['pendiente', 'en_revision', 'resuelto'] as $status)
                                        <option value="{{ $status }}" @selected($report->status === $status)>{{ str_replace('_', ' ', $status) }}</option>
                                    @endforeach
                                </select>
                                <button class="mt-2 rounded-md bg-slate-900 px-3 py-2 text-xs font-semibold text-white">Actualizar</button>
                            </form>
                        @empty
                            <p class="text-sm text-slate-500">No hay reportes.</p>
                        @endforelse
                    </div>
                </section>

                <section id="mensajes" class="rounded-lg border border-slate-200 bg-white p-5">
                    <h3 class="text-xl font-bold">Conversaciones</h3>
                    <div class="mt-4 space-y-3">
                        @forelse ($conversations as $conversation)
                            <div class="rounded-md bg-slate-50 p-3 text-sm">
                                <p class="font-semibold">{{ $conversation->request_number ?: 'Soporte' }}</p>
                                <p class="mt-1 text-slate-500">{{ $conversation->client?->name }} ↔ {{ $conversation->driver?->name ?: 'Soporte' }}</p>
                                <span class="mt-2 inline-block rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-800">{{ $conversation->status }}</span>
                            </div>
                        @empty
                            <p class="text-sm text-slate-500">No hay conversaciones.</p>
                        @endforelse
                    </div>
                </section>
            </div>
        </main>
    </div>

    <script>
        const liveUrl = @json(route('admin.live'));

        async function refreshAdminStats() {
            const response = await fetch(liveUrl, { headers: { Accept: 'application/json' } });
            const data = await response.json();
            Object.entries(data).forEach(([key, value]) => {
                document.querySelectorAll(`[data-stat="${key}"]`).forEach((node) => node.textContent = value);
            });
        }

        document.querySelectorAll('[data-confirm]').forEach((button) => {
            button.addEventListener('click', (event) => {
                event.preventDefault();
                Swal.fire({
                    icon: 'question',
                    title: button.dataset.confirm,
                    showCancelButton: true,
                    confirmButtonText: 'Confirmar',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#059669',
                }).then((result) => {
                    if (result.isConfirmed) button.closest('form').submit();
                });
            });
        });

        document.querySelector('[data-admin-menu]')?.addEventListener('click', () => {
            document.getElementById('admin-sidebar').classList.toggle('hidden');
            document.getElementById('admin-sidebar').classList.toggle('block');
        });

        setInterval(refreshAdminStats, 5000);
    </script>
</body>
</html>
