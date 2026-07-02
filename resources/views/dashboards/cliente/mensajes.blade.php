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
    <title>Mensajes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="min-h-screen bg-slate-100 text-slate-900">
    <div class="min-h-screen lg:pl-[280px]">
        <aside class="bg-slate-950 px-5 py-6 text-white lg:fixed lg:inset-y-0 lg:left-0 lg:w-[280px] lg:overflow-y-auto">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-300">Mudanza</p>
            <h1 class="mt-2 text-xl font-bold">Cliente</h1>

            <nav class="mt-8 space-y-1">
                @foreach ($menuItems as $item)
                    <a href="{{ $item['url'] }}" class="block rounded-md px-3 py-2 text-sm font-semibold transition {{ $item['label'] === 'Mensajes' ? 'bg-white text-slate-950' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
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
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-700">mensajes</p>
                    <h2 class="mt-2 text-3xl font-bold">Chat de servicios</h2>
                    <p class="mt-2 text-slate-600">Conversaciones ligadas a solicitudes de carga. Se actualiza automaticamente.</p>
                </div>
                <span class="rounded-full bg-emerald-100 px-4 py-2 text-sm font-semibold text-emerald-800">En linea</span>
            </div>

            <section class="mt-8 grid gap-6 xl:grid-cols-[340px_1fr]">
                <aside class="rounded-lg border border-slate-200 bg-white">
                    <div class="border-b border-slate-100 p-4">
                        <label class="mb-2 block text-sm font-semibold">Conversaciones</label>
                        <input type="text" placeholder="Buscar por solicitud o conductor" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                    </div>
                    <div class="divide-y divide-slate-100">
                        @forelse ($conversations as $conversation)
                            @php $last = $conversation->messages->first(); @endphp
                            <button type="button" data-conversation="{{ $conversation->id }}" class="block w-full p-4 text-left transition {{ $activeConversation?->id === $conversation->id ? 'bg-emerald-50' : 'hover:bg-slate-50' }}">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">{{ $conversation->request_number ?: 'Soporte' }}</span>
                                        <p class="mt-2 font-bold">{{ $conversation->driver?->name ?: 'Soporte Mudanza' }}</p>
                                        <p class="mt-1 line-clamp-1 text-sm text-slate-500">{{ $last?->message ?: 'Sin mensajes todavia' }}</p>
                                    </div>
                                    <p class="text-xs text-slate-500">{{ $last?->created_at?->format('h:i A') }}</p>
                                </div>
                            </button>
                        @empty
                            <div class="p-6 text-sm text-slate-500">Cuando selecciones un conductor se creara el chat automaticamente.</div>
                        @endforelse
                    </div>
                </aside>

                <section class="rounded-[18px] border border-zinc-700 bg-zinc-900 text-white shadow-xl">
                    <div class="flex flex-wrap items-center justify-between gap-4 border-b border-zinc-700 p-5">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full border border-blue-500 text-blue-400">◎</div>
                            <div>
                                <h3 data-chat-title class="font-bold">{{ $activeConversation?->driver?->name ?: 'Sin conversacion' }}</h3>
                                <p class="mt-1 text-sm text-emerald-400">En linea · {{ $activeConversation?->request_number }}</p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <button type="button" data-location class="rounded-md border border-zinc-600 px-3 py-2 text-sm font-semibold hover:bg-zinc-800">Ubicacion</button>
                            <button type="button" data-file-trigger class="rounded-md border border-zinc-600 px-3 py-2 text-sm font-semibold hover:bg-zinc-800">Archivo</button>
                        </div>
                    </div>

                    <div id="chat-box" class="h-[430px] space-y-4 overflow-y-auto bg-zinc-950 p-5"></div>

                    <form id="chat-form" class="border-t border-zinc-700 p-4">
                        <div class="flex gap-3">
                            <input id="chat-input" type="text" placeholder="Escribe un mensaje..." class="min-w-0 flex-1 rounded-full border border-zinc-700 bg-zinc-950 px-4 py-3 text-white outline-none focus:border-blue-500">
                            <button class="rounded-full bg-blue-900 px-5 py-3 font-semibold text-white hover:bg-blue-800">Enviar</button>
                        </div>
                        <p class="mt-2 text-center text-xs text-zinc-500">Mensajes leidos con doble confirmacion. Fotos, documentos y ubicacion activos.</p>
                    </form>
                    <form id="file-form" class="hidden">
                        <input id="chat-file" type="file" accept=".jpg,.jpeg,.png,.webp,.pdf,.doc,.docx,.xls,.xlsx">
                    </form>
                </section>
            </section>
        </main>
    </div>

    <script>
        const csrf = @json(csrf_token());
        let activeConversationId = @json($activeConversation?->id);
        const routes = {
            show: @json(route('cliente.mensajes.show', ['conversation' => '__ID__'])),
            send: @json(route('cliente.mensajes.send', ['conversation' => '__ID__'])),
            upload: @json(route('cliente.mensajes.upload', ['conversation' => '__ID__'])),
            location: @json(route('cliente.mensajes.location', ['conversation' => '__ID__'])),
        };
        const chatBox = document.getElementById('chat-box');
        const chatForm = document.getElementById('chat-form');
        const chatInput = document.getElementById('chat-input');
        const chatFile = document.getElementById('chat-file');

        function routeFor(name) {
            return routes[name].replace('__ID__', activeConversationId);
        }

        function renderMessages(messages) {
            chatBox.innerHTML = messages.map((message) => {
                if (message.type === 'system') {
                    return `<div class="text-center text-xs text-zinc-500">${message.message}</div>`;
                }

                const body = message.type === 'image'
                    ? `<a href="${message.file}" target="_blank"><img src="${message.file}" class="max-h-52 rounded-md"></a><p class="mt-2">${message.message}</p>`
                    : message.type === 'file'
                        ? `<a href="${message.file}" target="_blank" class="font-semibold underline">${message.message}</a>`
                        : message.type === 'location'
                            ? `<a href="https://www.google.com/maps?q=${message.message}" target="_blank" class="font-semibold underline">Ver ubicacion: ${message.message}</a>`
                            : `<p>${message.message}</p>`;

                return `
                    <div class="flex ${message.mine ? 'justify-end' : 'justify-start'}">
                        <div class="max-w-[78%] rounded-2xl px-4 py-3 text-sm ${message.mine ? 'bg-blue-950 text-white' : 'border border-zinc-700 bg-zinc-800 text-white'}">
                            ${body}
                            <div class="mt-2 text-right text-xs ${message.mine ? 'text-blue-200' : 'text-zinc-400'}">${message.time} ${message.mine ? (message.read ? '✓✓' : '✓') : ''}</div>
                        </div>
                    </div>
                `;
            }).join('');
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        async function loadConversation(id = activeConversationId) {
            if (!id) return;
            activeConversationId = id;
            const response = await fetch(routeFor('show'), { headers: { Accept: 'application/json' } });
            const data = await response.json();
            document.querySelector('[data-chat-title]').textContent = data.conversation.driver?.name || 'Soporte Mudanza';
            renderMessages(data.messages);
        }

        async function postJson(url, payload) {
            const response = await fetch(url, {
                method: 'POST',
                headers: { 'Accept': 'application/json', 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
                body: JSON.stringify(payload),
            });
            const data = await response.json();
            if (!response.ok) throw new Error(data.message || 'No se pudo enviar.');
            return data;
        }

        document.querySelectorAll('[data-conversation]').forEach((button) => {
            button.addEventListener('click', () => loadConversation(button.dataset.conversation));
        });

        chatForm.addEventListener('submit', async (event) => {
            event.preventDefault();
            if (!activeConversationId || !chatInput.value.trim()) return;
            await postJson(routeFor('send'), { message: chatInput.value.trim() });
            chatInput.value = '';
            await loadConversation();
        });

        document.querySelector('[data-file-trigger]').addEventListener('click', () => chatFile.click());
        chatFile.addEventListener('change', async () => {
            if (!activeConversationId || !chatFile.files.length) return;
            const formData = new FormData();
            formData.append('file', chatFile.files[0]);
            const response = await fetch(routeFor('upload'), {
                method: 'POST',
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf },
                body: formData,
            });
            if (!response.ok) {
                Swal.fire({ icon: 'error', title: 'Archivo no enviado', text: 'Revisa el formato o el tamano.', confirmButtonColor: '#dc2626' });
                return;
            }
            chatFile.value = '';
            await loadConversation();
        });

        document.querySelector('[data-location]').addEventListener('click', () => {
            if (!navigator.geolocation) {
                Swal.fire({ icon: 'info', title: 'Ubicacion no disponible', text: 'Tu navegador no permite geolocalizacion.' });
                return;
            }

            navigator.geolocation.getCurrentPosition(async (position) => {
                await postJson(routeFor('location'), {
                    lat: position.coords.latitude.toFixed(6),
                    lng: position.coords.longitude.toFixed(6),
                });
                await loadConversation();
            });
        });

        loadConversation();
        setInterval(() => loadConversation(), 3000);
    </script>
</body>
</html>
