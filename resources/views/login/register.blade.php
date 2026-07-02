<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear cuenta</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 text-slate-900">
    <main class="flex min-h-screen items-center justify-center px-4 py-10">
        <section class="w-full max-w-2xl rounded-lg bg-white p-8 shadow-xl shadow-slate-200">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold">Crear cuenta</h1>
                    <p class="mt-2 text-sm text-slate-500">Verificaremos tu identidad antes de activar todas las funciones.</p>
                </div>
                <span id="step-counter" class="rounded-full bg-emerald-50 px-3 py-1 text-sm font-semibold text-emerald-700">1 de 5</span>
            </div>

            <div class="mt-6 h-2 overflow-hidden rounded-full bg-slate-200">
                <div id="progress-bar" class="h-full w-1/5 rounded-full bg-emerald-600 transition-all"></div>
            </div>

            @if ($errors->any())
                <div class="mt-5 rounded-md border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                    <ul class="list-inside list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="register-form" class="mt-6" method="POST" action="{{ route('register.store') }}" enctype="multipart/form-data">
                @csrf
                <input id="role" type="hidden" name="role" value="{{ old('role') }}">

                <section class="space-y-5" data-step>
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.16em] text-emerald-700">Tipo de cuenta</p>
                        <h2 class="mt-2 text-xl font-bold">Que cuenta vas a crear?</h2>
                    </div>
                    <div class="grid gap-3 sm:grid-cols-2">
                        <button type="button" data-role-choice="cliente" class="rounded-md border border-slate-300 p-6 text-center font-semibold transition hover:border-emerald-600 hover:bg-emerald-50 focus:border-emerald-600 focus:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                            Cliente
                        </button>
                        <button type="button" data-role-choice="conductor" class="rounded-md border border-slate-300 p-6 text-center font-semibold transition hover:border-emerald-600 hover:bg-emerald-50 focus:border-emerald-600 focus:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                            Conductor
                        </button>
                    </div>
                </section>

                <section class="hidden space-y-5" data-step>
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.16em] text-emerald-700">Cuenta de <span data-role-label></span></p>
                        <h2 class="mt-2 text-xl font-bold">Datos de acceso</h2>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-medium" for="name">Nombre completo</label>
                            <input id="name" name="name" type="text" value="{{ old('name') }}" autocomplete="name" required class="w-full rounded-md border border-slate-300 px-3 py-2 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium" for="phone">Celular</label>
                            <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" autocomplete="tel" required class="w-full rounded-md border border-slate-300 px-3 py-2 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                        </div>
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium" for="email">Correo</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required class="w-full rounded-md border border-slate-300 px-3 py-2 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-medium" for="password">Contrasena</label>
                            <div class="relative">
                                <input id="password" name="password" type="password" autocomplete="new-password" required class="w-full rounded-md border border-slate-300 px-3 py-2 pr-11 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                                <button type="button" data-toggle-password="password" class="absolute inset-y-0 right-0 flex w-11 items-center justify-center text-slate-500 hover:text-slate-900" aria-label="Mostrar contrasena">
                                    <svg data-eye-open xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                                    <svg data-eye-closed xmlns="http://www.w3.org/2000/svg" class="hidden h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18"/><path stroke-linecap="round" stroke-linejoin="round" d="M10.6 10.6A2.9 2.9 0 0 0 12 15a3 3 0 0 0 2.8-4.1"/><path stroke-linecap="round" stroke-linejoin="round" d="M7.1 7.1C4.1 8.9 2.25 12 2.25 12S6 18.75 12 18.75c1.7 0 3.2-.5 4.5-1.2"/><path stroke-linecap="round" stroke-linejoin="round" d="M9.8 5.5c.7-.2 1.4-.25 2.2-.25 6 0 9.75 6.75 9.75 6.75a17 17 0 0 1-2.2 2.9"/></svg>
                                </button>
                            </div>
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium" for="password_confirmation">Confirmar contrasena</label>
                            <div class="relative">
                                <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required class="w-full rounded-md border border-slate-300 px-3 py-2 pr-11 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                                <button type="button" data-toggle-password="password_confirmation" class="absolute inset-y-0 right-0 flex w-11 items-center justify-center text-slate-500 hover:text-slate-900" aria-label="Mostrar contrasena">
                                    <svg data-eye-open xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                                    <svg data-eye-closed xmlns="http://www.w3.org/2000/svg" class="hidden h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18"/><path stroke-linecap="round" stroke-linejoin="round" d="M10.6 10.6A2.9 2.9 0 0 0 12 15a3 3 0 0 0 2.8-4.1"/><path stroke-linecap="round" stroke-linejoin="round" d="M7.1 7.1C4.1 8.9 2.25 12 2.25 12S6 18.75 12 18.75c1.7 0 3.2-.5 4.5-1.2"/><path stroke-linecap="round" stroke-linejoin="round" d="M9.8 5.5c.7-.2 1.4-.25 2.2-.25 6 0 9.75 6.75 9.75 6.75a17 17 0 0 1-2.2 2.9"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="hidden space-y-5" data-step>
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.16em] text-emerald-700">Informacion personal</p>
                        <h2 class="mt-2 text-xl font-bold">Confirma tus datos</h2>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-medium" for="document_type">Tipo de documento</label>
                            <select id="document_type" name="document_type" required class="w-full rounded-md border border-slate-300 px-3 py-2 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                                <option value="">Selecciona</option>
                                <option value="cc" @selected(old('document_type') === 'cc')>Cedula de ciudadania</option>
                                <option value="ce" @selected(old('document_type') === 'ce')>Cedula de extranjeria</option>
                                <option value="passport" @selected(old('document_type') === 'passport')>Pasaporte</option>
                            </select>
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium" for="document_number">Numero de documento</label>
                            <input id="document_number" name="document_number" type="text" value="{{ old('document_number') }}" required class="w-full rounded-md border border-slate-300 px-3 py-2 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium" for="document_issued_at">Fecha de expedicion</label>
                            <input id="document_issued_at" name="document_issued_at" type="date" value="{{ old('document_issued_at') }}" required class="w-full rounded-md border border-slate-300 px-3 py-2 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium" for="birth_date">Fecha de nacimiento</label>
                            <input id="birth_date" name="birth_date" type="date" value="{{ old('birth_date') }}" required class="w-full rounded-md border border-slate-300 px-3 py-2 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium" for="gender">Genero</label>
                            <select id="gender" name="gender" required class="w-full rounded-md border border-slate-300 px-3 py-2 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                                <option value="">Selecciona</option>
                                <option value="femenino" @selected(old('gender') === 'femenino')>Femenino</option>
                                <option value="masculino" @selected(old('gender') === 'masculino')>Masculino</option>
                                <option value="otro" @selected(old('gender') === 'otro')>Otro</option>
                                <option value="prefiero_no_decir" @selected(old('gender') === 'prefiero_no_decir')>Prefiero no decir</option>
                            </select>
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium" for="city">Ciudad</label>
                            <input id="city" name="city" type="text" value="{{ old('city') }}" required class="w-full rounded-md border border-slate-300 px-3 py-2 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                        </div>
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium" for="address">Direccion</label>
                        <input id="address" name="address" type="text" value="{{ old('address') }}" required class="w-full rounded-md border border-slate-300 px-3 py-2 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                    </div>
                </section>

                <section class="hidden space-y-5" data-step>
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.16em] text-emerald-700">Documento y selfie</p>
                        <h2 class="mt-2 text-xl font-bold">Carga fotos claras</h2>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-3">
                        <label class="rounded-md border border-dashed border-slate-300 p-4">
                            <span class="block font-semibold">Frente</span>
                            <span class="mt-1 block text-sm text-slate-500">Documento completo.</span>
                            <input name="document_front" type="file" accept="image/*" required class="mt-4 w-full text-sm">
                        </label>
                        <label class="rounded-md border border-dashed border-slate-300 p-4">
                            <span class="block font-semibold">Reverso</span>
                            <span class="mt-1 block text-sm text-slate-500">Sin reflejos.</span>
                            <input name="document_back" type="file" accept="image/*" required class="mt-4 w-full text-sm">
                        </label>
                        <label class="rounded-md border border-dashed border-slate-300 p-4">
                            <span class="block font-semibold">Selfie</span>
                            <span class="mt-1 block text-sm text-slate-500">Rostro visible.</span>
                            <input name="selfie" type="file" accept="image/*" required class="mt-4 w-full text-sm">
                        </label>
                    </div>
                </section>

                <section class="hidden space-y-5" data-step>
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.16em] text-emerald-700">Revision</p>
                        <h2 class="mt-2 text-xl font-bold">Tu cuenta quedara en verificacion</h2>
                    </div>
                    <div class="space-y-3 rounded-md border border-slate-200 p-4 text-sm">
                        <div class="flex items-center justify-between gap-3"><span>Correo y celular registrados</span><span class="font-semibold text-emerald-700">Listo</span></div>
                        <div class="flex items-center justify-between gap-3"><span>Datos personales completos</span><span class="font-semibold text-emerald-700">Listo</span></div>
                        <div class="flex items-center justify-between gap-3"><span>Documento cargado</span><span class="font-semibold text-emerald-700">Listo</span></div>
                        <div class="flex items-center justify-between gap-3"><span>Selfie cargada</span><span class="font-semibold text-emerald-700">Listo</span></div>
                        <div class="flex items-center justify-between gap-3"><span>Estado inicial</span><span class="font-semibold text-amber-700">En revision</span></div>
                    </div>
                </section>

                <div class="mt-6 flex gap-3">
                    <button id="prev-step" type="button" class="hidden rounded-md border border-slate-300 px-4 py-2.5 font-semibold text-slate-700 hover:bg-slate-50">Atras</button>
                    <button id="next-step" type="button" class="ml-auto rounded-md bg-emerald-600 px-4 py-2.5 font-semibold text-white hover:bg-emerald-700">Continuar</button>
                    <button id="submit-button" type="submit" class="ml-auto hidden rounded-md bg-emerald-600 px-4 py-2.5 font-semibold text-white hover:bg-emerald-700">Crear cuenta</button>
                </div>
            </form>

            <p class="mt-6 text-center text-sm text-slate-600">
                Ya tienes cuenta?
                <a href="{{ route('login') }}" class="font-semibold text-emerald-700 hover:text-emerald-800">Inicia sesion</a>
            </p>
        </section>
    </main>

    <script>
        const steps = [...document.querySelectorAll('[data-step]')];
        const progressBar = document.getElementById('progress-bar');
        const counter = document.getElementById('step-counter');
        const prevButton = document.getElementById('prev-step');
        const nextButton = document.getElementById('next-step');
        const submitButton = document.getElementById('submit-button');
        const roleInput = document.getElementById('role');
        const roleNames = { cliente: 'Cliente', conductor: 'Conductor' };
        let currentStep = roleInput.value && roleNames[roleInput.value] ? 1 : 0;

        function showStep(index) {
            currentStep = index;
            steps.forEach((step, stepIndex) => step.classList.toggle('hidden', stepIndex !== currentStep));
            progressBar.style.width = `${((currentStep + 1) / steps.length) * 100}%`;
            counter.textContent = `${currentStep + 1} de ${steps.length}`;
            prevButton.classList.toggle('hidden', currentStep === 0);
            nextButton.classList.toggle('hidden', currentStep === steps.length - 1);
            submitButton.classList.toggle('hidden', currentStep !== steps.length - 1);
            document.querySelectorAll('[data-role-label]').forEach((label) => {
                label.textContent = roleNames[roleInput.value] || '';
            });
        }

        function currentStepIsValid() {
            const fields = [...steps[currentStep].querySelectorAll('input, select')];
            return fields.every((field) => field.reportValidity());
        }

        document.querySelectorAll('[data-role-choice]').forEach((button) => {
            button.addEventListener('click', () => {
                roleInput.value = button.dataset.roleChoice;
                showStep(1);
            });
        });

        nextButton.addEventListener('click', () => {
            if (! currentStepIsValid()) {
                return;
            }

            showStep(currentStep + 1);
        });

        prevButton.addEventListener('click', () => showStep(currentStep - 1));

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

        showStep(currentStep);
    </script>
</body>
</html>
