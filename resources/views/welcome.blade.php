<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Puerto Asís Mudanzas & Viajes</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            color: #ffffff;
            font-family: Arial, Helvetica, sans-serif;
            background:
                radial-gradient(circle at 18px 18px, rgba(35, 210, 104, 0.12) 0 3px, transparent 4px) 0 0 / 32px 32px,
                linear-gradient(135deg, #031426 0%, #061b31 45%, #02111f 100%);
            overflow-x: hidden;
        }

        .hero {
            position: relative;
            min-height: 100svh;
            display: grid;
            grid-template-columns: minmax(0, 0.92fr) minmax(330px, 0.84fr);
            align-items: center;
            gap: clamp(18px, 2vw, 34px);
            padding: clamp(18px, 3.4vh, 42px) 0 clamp(18px, 3vh, 34px) clamp(26px, 5vw, 76px);
            isolation: isolate;
        }

        .hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 32% 55%, rgba(9, 70, 116, 0.22), transparent 36%);
            z-index: -2;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 18px;
            margin-bottom: clamp(26px, 6vh, 58px);
        }

        .brand-mark {
            width: clamp(130px, 12vw, 190px);
            height: clamp(82px, 7.6vw, 120px);
            position: relative;
            color: #ffffff;
        }

        .brand-mark svg {
            width: 100%;
            height: 100%;
            display: block;
        }

        .brand-copy strong {
            display: block;
            font-size: clamp(24px, 2.2vw, 31px);
            line-height: 1;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .brand-copy span {
            display: block;
            margin-top: 8px;
            color: #31d66d;
            font-size: clamp(11px, 1vw, 14px);
            letter-spacing: clamp(3px, 0.36vw, 5px);
            text-transform: uppercase;
        }

        h1 {
            max-width: 690px;
            margin: 0;
            font-size: clamp(42px, 5.4vw, 78px);
            line-height: 1.07;
            letter-spacing: -1.5px;
            font-weight: 900;
            text-shadow: 0 5px 0 rgba(0, 0, 0, 0.17);
        }

        h1 .dot {
            color: #2bd466;
        }

        .lead {
            margin: clamp(14px, 2.4vh, 24px) 0 0;
            max-width: 660px;
            color: rgba(255, 255, 255, 0.88);
            font-size: clamp(18px, 1.7vw, 24px);
            line-height: 1.45;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: clamp(14px, 1.8vw, 22px);
            margin-top: clamp(22px, 3.8vh, 38px);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
            min-width: clamp(210px, 18vw, 254px);
            min-height: clamp(58px, 6.5vh, 74px);
            padding: 14px 24px;
            border-radius: 10px;
            color: #ffffff;
            font-size: clamp(20px, 1.8vw, 25px);
            font-weight: 800;
            text-decoration: none;
            transition: transform 160ms ease, box-shadow 160ms ease, background 160ms ease;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-primary {
            color: #031426;
            background: linear-gradient(180deg, #36d96d, #24bd59);
            box-shadow: 0 22px 50px rgba(37, 198, 91, 0.25);
        }

        .btn-secondary {
            background: rgba(3, 20, 38, 0.48);
            border: 1.5px solid #28d466;
        }

        .btn svg {
            width: 34px;
            height: 34px;
            flex: 0 0 auto;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(3, minmax(150px, 1fr));
            gap: clamp(20px, 2.5vw, 34px);
            max-width: 780px;
            margin-top: clamp(34px, 7vh, 70px);
        }

        .feature {
            display: grid;
            grid-template-columns: 64px 1fr;
            gap: 18px;
            align-items: center;
        }

        .feature svg {
            width: clamp(44px, 4vw, 58px);
            height: clamp(44px, 4vw, 58px);
            color: #28d466;
        }

        .feature strong {
            display: block;
            font-size: clamp(17px, 1.4vw, 20px);
            line-height: 1.1;
        }

        .feature span {
            display: block;
            margin-top: 6px;
            color: rgba(255, 255, 255, 0.76);
            font-size: clamp(14px, 1.1vw, 16px);
            line-height: 1.25;
        }

        .location {
            display: flex;
            align-items: center;
            gap: 13px;
            margin-top: clamp(28px, 5.4vh, 52px);
            color: rgba(255, 255, 255, 0.92);
            font-size: clamp(17px, 1.4vw, 20px);
        }

        .location svg {
            width: 26px;
            height: 26px;
            color: #31d66d;
        }

        .visual {
            position: relative;
            min-height: 100svh;
            align-self: stretch;
            overflow: hidden;
        }

        .photo-ring {
            position: absolute;
            top: 50%;
            right: clamp(-86px, -4vw, -38px);
            width: clamp(440px, 46vw, 710px);
            height: clamp(440px, 46vw, 710px);
            max-height: calc(100svh - 70px);
            max-width: calc(100svh - 70px);
            transform: translateY(-50%);
            border-radius: 50%;
            background: linear-gradient(135deg, #1fd45f 0%, #0f5d36 36%, #06351f 100%);
            padding: 18px;
            box-shadow: -38px 0 0 rgba(41, 209, 95, 0.16), -20px 0 60px rgba(0, 0, 0, 0.45);
        }

        .photo {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            overflow: hidden;
            background: #0b1725;
            box-shadow: inset 0 0 0 2px rgba(255, 255, 255, 0.08);
        }

        .photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: 64% 50%;
            display: block;
        }

        .truck-logo {
            position: absolute;
            right: clamp(18px, 4.2vw, 76px);
            top: 50%;
            width: clamp(92px, 10vw, 160px);
            transform: translateY(-50%);
            color: #071a31;
            text-align: center;
            filter: drop-shadow(0 7px 18px rgba(255, 255, 255, 0.32));
        }

        .truck-logo svg {
            width: 100%;
            height: auto;
            display: block;
        }

        .truck-logo strong {
            display: block;
            margin-top: 8px;
            color: #062a57;
            font-size: clamp(18px, 1.9vw, 28px);
            line-height: 0.95;
        }

        .truck-logo span {
            display: block;
            margin-top: 6px;
            color: #087d3a;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 2px;
        }

        @media (max-width: 1180px) {
            .hero {
                grid-template-columns: 1fr;
                padding: 38px 28px 48px;
            }

            .visual {
                min-height: min(54svh, 560px);
                order: -1;
            }

            .photo-ring {
                right: 50%;
                width: min(680px, 92vw);
                height: min(680px, 92vw);
                min-width: 0;
                min-height: 0;
                transform: translate(50%, -50%);
            }

            .truck-logo {
                right: 8%;
                top: 54%;
                width: 150px;
            }

            .brand {
                margin-bottom: 38px;
            }
        }

        @media (min-width: 900px) and (max-height: 840px) {
            body {
                overflow: hidden;
            }

            .hero {
                height: 100svh;
                min-height: 0;
                padding-top: 10px;
                padding-bottom: 10px;
            }

            .brand {
                margin-bottom: 14px;
            }

            .brand-mark {
                width: 96px;
                height: 58px;
            }

            .brand-copy strong {
                font-size: 21px;
            }

            .brand-copy span {
                margin-top: 5px;
                font-size: 9px;
                letter-spacing: 3px;
            }

            h1 {
                max-width: 560px;
                font-size: clamp(36px, 4.15vw, 52px);
                line-height: 1.04;
            }

            .lead {
                margin-top: 10px;
                font-size: 16px;
            }

            .actions {
                margin-top: 16px;
            }

            .btn {
                min-height: 50px;
                min-width: 190px;
                font-size: 18px;
                padding: 10px 18px;
            }

            .btn svg {
                width: 28px;
                height: 28px;
            }

            .features {
                margin-top: 20px;
                gap: 14px;
            }

            .feature {
                grid-template-columns: 40px 1fr;
                gap: 10px;
            }

            .feature svg {
                width: 34px;
                height: 34px;
            }

            .feature strong {
                font-size: 15px;
            }

            .feature span {
                font-size: 12px;
            }

            .location {
                margin-top: 14px;
                font-size: 15px;
            }

            .location svg {
                width: 20px;
                height: 20px;
            }

            .photo-ring {
                width: clamp(390px, 40vw, 540px);
                height: clamp(390px, 40vw, 540px);
                max-height: calc(100svh - 80px);
                max-width: calc(100svh - 80px);
                right: clamp(-58px, -3vw, -28px);
            }

            .truck-logo {
                display: none;
            }
        }

        @media (min-width: 900px) and (max-height: 660px) {
            .hero {
                padding-left: clamp(22px, 4.5vw, 68px);
            }

            .brand {
                margin-bottom: 10px;
            }

            h1 {
                max-width: 520px;
                font-size: clamp(34px, 3.8vw, 48px);
            }

            .features {
                margin-top: 16px;
            }

            .location {
                margin-top: 10px;
            }

            .photo-ring {
                width: clamp(360px, 38vw, 500px);
                height: clamp(360px, 38vw, 500px);
                max-height: calc(100svh - 70px);
                max-width: calc(100svh - 70px);
            }
        }

        @media (max-width: 720px) {
            .hero {
                padding: 24px 18px 34px;
            }

            .visual {
                min-height: 330px;
            }

            .photo-ring {
                width: min(450px, 104vw);
                height: min(450px, 104vw);
                padding: 10px;
            }

            .brand {
                gap: 12px;
            }

            .brand-mark {
                width: 114px;
                height: 74px;
            }

            .brand-copy strong {
                font-size: 22px;
            }

            .brand-copy span {
                font-size: 11px;
                letter-spacing: 3px;
            }

            h1 {
                font-size: 44px;
                letter-spacing: -1px;
            }

            .lead {
                font-size: 18px;
            }

            .btn {
                width: 100%;
                min-width: 0;
                min-height: 62px;
                font-size: 20px;
            }

            .features {
                grid-template-columns: 1fr;
                gap: 22px;
                margin-top: 46px;
            }

            .truck-logo {
                width: 104px;
                right: 4%;
            }
        }
    </style>
</head>
<body>
    <main class="hero">
        <section class="content" aria-label="Inicio Puerto Asis">
            <div class="brand">
                <div class="brand-mark" aria-hidden="true">
                    <svg viewBox="0 0 220 140" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M58 94c24-18 60-28 102-24-18 9-34 20-49 35-21-7-39-10-53-11Z" fill="currentColor"/>
                        <path d="M86 102c29-5 61 0 96 13-34 2-69 1-105-5l9-8Z" fill="currentColor"/>
                        <path d="M21 65h15l10-28h46l22 30h17c8 0 15 7 15 15v7h-21a16 16 0 0 0-31 0H55a16 16 0 0 0-31 0H14V74c0-5 3-9 7-9Z" fill="currentColor"/>
                        <path d="M53 42h29l17 23H45l8-23Z" fill="#061b31"/>
                        <circle cx="39" cy="91" r="10" fill="#061b31"/>
                        <circle cx="109" cy="91" r="10" fill="#061b31"/>
                        <path d="M115 25c39-19 72-1 91 36" stroke="#28d466" stroke-width="8" stroke-linecap="round"/>
                        <path d="M126 35h62v31h-62V35Z" stroke="#28d466" stroke-width="5"/>
                        <path d="M158 20v50M137 35l21-15 31 15" stroke="#28d466" stroke-width="4" stroke-linecap="round"/>
                    </svg>
                </div>
                <div class="brand-copy">
                    <strong>Puerto Asís</strong>
                    <span>Mudanzas & Viajes</span>
                </div>
            </div>

            <h1>Gestión de clientes, conductores y operaciones<span class="dot">.</span></h1>
            <p class="lead">Accede según tu rol y trabaja desde un panel protegido.</p>

            <div class="actions">
                @auth
                    <a class="btn btn-primary" href="{{ route('dashboard') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M4 12h14"/><path d="m13 6 6 6-6 6"/></svg>
                        Ir al panel
                    </a>
                @else
                    <a class="btn btn-primary" href="{{ route('login') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="8" r="4"/><path d="M4 21c1.8-4 4.4-6 8-6s6.2 2 8 6"/></svg>
                        Iniciar sesión
                    </a>
                    <a class="btn btn-secondary" href="{{ route('register') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="9" cy="8" r="4"/><path d="M2 21c1.4-4 3.8-6 7-6"/><path d="M18 8v8"/><path d="M14 12h8"/></svg>
                        Crear cuenta
                    </a>
                @endauth
            </div>

            <div class="features">
                <div class="feature">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"><path d="M2 7h12v9H2z"/><path d="M14 10h4l4 4v2h-8z"/><circle cx="6" cy="18" r="2"/><circle cx="18" cy="18" r="2"/></svg>
                    <div><strong>Trasteos</strong><span>Seguros y confiables</span></div>
                </div>
                <div class="feature">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"><path d="M4 11h16l-2 9H6z"/><path d="M8 11V6h8v5"/><path d="M10 6V3h4v3"/><path d="M3 15c2 0 2 2 4 2s2-2 4-2 2 2 4 2 2-2 6-2"/></svg>
                    <div><strong>Viajes</strong><span>Nacionales e internacionales</span></div>
                </div>
                <div class="feature">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"><path d="M12 3 4 7v6c0 5 3.4 7.8 8 9 4.6-1.2 8-4 8-9V7z"/><path d="m9 12 2 2 4-5"/></svg>
                    <div><strong>Seguridad</strong><span>Tu carga, nuestra prioridad</span></div>
                </div>
            </div>

            <div class="location">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a8 8 0 0 0-8 8c0 5.5 8 12 8 12s8-6.5 8-12a8 8 0 0 0-8-8Zm0 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z"/></svg>
                <span>Puerto Asís, Putumayo, Colombia</span>
            </div>
        </section>

        <section class="visual" aria-hidden="true">
            <div class="photo-ring">
                <div class="photo">
                    <img src="{{ asset('images/hero-logistics.png') }}" alt="">
                </div>
            </div>
            <div class="truck-logo">
                <svg viewBox="0 0 220 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M35 67h15l9-25h44l20 27h15c7 0 13 6 13 13v5h-20a15 15 0 0 0-29 0H65a15 15 0 0 0-29 0H27V76c0-5 3-9 8-9Z" fill="#0a3d7a"/>
                    <path d="M65 47h28l15 20H57l8-20Z" fill="#d9f1ff"/>
                    <circle cx="51" cy="89" r="9" fill="#062a57"/>
                    <circle cx="116" cy="89" r="9" fill="#062a57"/>
                    <path d="M112 27c35-16 65 0 82 32" stroke="#24c45a" stroke-width="7" stroke-linecap="round"/>
                    <path d="M123 36h55v28h-55V36Z" stroke="#24c45a" stroke-width="4"/>
                    <path d="M151 23v45M132 36l19-13 28 13" stroke="#24c45a" stroke-width="3.5" stroke-linecap="round"/>
                    <path d="M56 97c27-12 64-16 111-5-28 7-62 8-111 5Z" fill="#0b6f3a"/>
                </svg>
                <strong>PUERTO ASÍS</strong>
                <span>Mudanzas & Viajes</span>
            </div>
        </section>
    </main>
</body>
</html>
