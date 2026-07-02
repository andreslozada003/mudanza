<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mudanza</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-950 text-white">
    <main class="mx-auto flex min-h-screen max-w-5xl flex-col justify-center px-6 py-12">
        <p class="mb-3 text-sm font-semibold uppercase tracking-[0.2em] text-emerald-300">Mudanza</p>
        <h1 class="max-w-2xl text-4xl font-bold leading-tight md:text-6xl">Gestion de clientes, conductores y operaciones.</h1>
        <p class="mt-5 max-w-xl text-base text-slate-300">Accede segun tu rol y trabaja desde un panel protegido.</p>
        <div class="mt-8 flex flex-wrap gap-3">
            @auth
                <a href="{{ route('dashboard') }}" class="rounded-md bg-emerald-400 px-5 py-3 font-semibold text-slate-950">Ir al panel</a>
            @else
                <a href="{{ route('login') }}" class="rounded-md bg-emerald-400 px-5 py-3 font-semibold text-slate-950">Iniciar sesion</a>
                <a href="{{ route('register') }}" class="rounded-md border border-white/20 px-5 py-3 font-semibold text-white">Crear cuenta</a>
            @endauth
        </div>
    </main>
</body>
</html>
