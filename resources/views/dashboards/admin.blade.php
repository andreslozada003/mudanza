<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel administrador</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 text-slate-900">
    <main class="mx-auto max-w-6xl px-6 py-10">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-700">admin</p>
                <h1 class="mt-2 text-3xl font-bold">Verificaciones</h1>
                <p class="mt-2 text-slate-600">Revisa documentos, selfie y estado de cada usuario.</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="rounded-md bg-slate-900 px-4 py-2 font-semibold text-white hover:bg-slate-700">Cerrar sesion</button>
            </form>
        </div>

        @if (session('status'))
            <div class="mt-6 rounded-md border border-emerald-200 bg-emerald-50 p-3 text-sm font-semibold text-emerald-800">
                {{ session('status') }}
            </div>
        @endif

        <section class="mt-8 overflow-hidden rounded-lg border border-slate-200 bg-white">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[780px] text-left text-sm">
                    <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-4 py-3">Usuario</th>
                            <th class="px-4 py-3">Rol</th>
                            <th class="px-4 py-3">Documento</th>
                            <th class="px-4 py-3">Celular</th>
                            <th class="px-4 py-3">Estado</th>
                            <th class="px-4 py-3 text-right">Accion</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($verifications as $verification)
                            <tr>
                                <td class="px-4 py-4">
                                    <div class="font-semibold">{{ $verification->user->name }}</div>
                                    <div class="text-slate-500">{{ $verification->user->email }}</div>
                                </td>
                                <td class="px-4 py-4 capitalize">{{ $verification->user->role }}</td>
                                <td class="px-4 py-4">
                                    <div class="uppercase">{{ $verification->document_type }}</div>
                                    <div class="text-slate-500">{{ $verification->document_number }}</div>
                                </td>
                                <td class="px-4 py-4">{{ $verification->user->phone }}</td>
                                <td class="px-4 py-4">
                                    <span class="rounded-full px-3 py-1 text-xs font-semibold
                                        @class([
                                            'bg-amber-100 text-amber-800' => $verification->status === 'en_revision',
                                            'bg-emerald-100 text-emerald-800' => $verification->status === 'aprobado',
                                            'bg-red-100 text-red-800' => $verification->status === 'rechazado',
                                            'bg-slate-200 text-slate-700' => ! in_array($verification->status, ['en_revision', 'aprobado', 'rechazado']),
                                        ])">
                                        {{ str_replace('_', ' ', $verification->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-right">
                                    <a href="{{ route('admin.verifications.show', $verification) }}" class="rounded-md bg-emerald-600 px-3 py-2 font-semibold text-white hover:bg-emerald-700">Ver</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center text-slate-500">Todavia no hay solicitudes de verificacion.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <div class="mt-5">
            {{ $verifications->links() }}
        </div>
    </main>
</body>
</html>
