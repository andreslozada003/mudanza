<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesion</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 text-slate-900">
    <main class="flex min-h-screen items-center justify-center px-4 py-10">
        <section class="w-full max-w-md rounded-lg bg-white p-8 shadow-xl shadow-slate-200">
            <h1 class="text-2xl font-bold">Iniciar sesion</h1>
            <p class="mt-2 text-sm text-slate-500">Entra con tu correo y contrasena.</p>

            @if ($errors->any())
                <div class="mt-5 rounded-md border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <form class="mt-6 space-y-5" method="POST" action="{{ route('login.store') }}">
                @csrf
                <div>
                    <label class="mb-2 block text-sm font-medium" for="email">Correo</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required autofocus class="w-full rounded-md border border-slate-300 px-3 py-2 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium" for="password">Contrasena</label>
                    <div class="relative">
                        <input id="password" name="password" type="password" autocomplete="current-password" required class="w-full rounded-md border border-slate-300 px-3 py-2 pr-11 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                        <button type="button" data-toggle-password="password" class="absolute inset-y-0 right-0 flex w-11 items-center justify-center text-slate-500 hover:text-slate-900" aria-label="Mostrar contrasena">
                            <svg data-eye-open xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                            <svg data-eye-closed xmlns="http://www.w3.org/2000/svg" class="hidden h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18"/><path stroke-linecap="round" stroke-linejoin="round" d="M10.6 10.6A2.9 2.9 0 0 0 12 15a3 3 0 0 0 2.8-4.1"/><path stroke-linecap="round" stroke-linejoin="round" d="M7.1 7.1C4.1 8.9 2.25 12 2.25 12S6 18.75 12 18.75c1.7 0 3.2-.5 4.5-1.2"/><path stroke-linecap="round" stroke-linejoin="round" d="M9.8 5.5c.7-.2 1.4-.25 2.2-.25 6 0 9.75 6.75 9.75 6.75a17 17 0 0 1-2.2 2.9"/></svg>
                        </button>
                    </div>
                </div>

                <label class="flex items-center gap-2 text-sm text-slate-600">
                    <input type="checkbox" name="remember" value="1" class="rounded border-slate-300 text-emerald-600">
                    Recordarme
                </label>

                <button type="submit" class="w-full rounded-md bg-emerald-600 px-4 py-2.5 font-semibold text-white hover:bg-emerald-700">Entrar</button>
            </form>

            <p class="mt-6 text-center text-sm text-slate-600">
                No tienes cuenta?
                <a href="{{ route('register') }}" class="font-semibold text-emerald-700 hover:text-emerald-800">Registrate</a>
            </p>
        </section>
    </main>

    <script>
        document.querySelectorAll('[data-toggle-password]').forEach((button) => {
            button.addEventListener('click', () => {
                const input = document.getElementById(button.dataset.togglePassword);
                const show = input.type === 'password';
                input.type = show ? 'text' : 'password';
                button.setAttribute('aria-label', show ? 'Ocultar contrasena' : 'Mostrar contrasena');
                button.querySelector('[data-eye-open]').classList.toggle('hidden', show);
                button.querySelector('[data-eye-closed]').classList.toggle('hidden', !show);
            });
        });
    </script>
</body>
</html>
