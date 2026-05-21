<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Outfit:wght@300;400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Outfit', sans-serif;
            background: #f0ebe3;
            min-height: 100vh;
        }

        /* Override any Tailwind/Vite base resets that may affect our layout */
        body > div { all: unset; display: block; }

        .guest-page {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        /* ── Left decorative panel ── */
        .guest-left {
            background: #1a1a2e;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 52px 56px;
            overflow: hidden;
        }

        .guest-left::before {
            content: '';
            position: absolute;
            top: -130px; right: -130px;
            width: 440px; height: 440px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(232,180,80,0.18) 0%, transparent 70%);
            pointer-events: none;
        }

        .guest-left::after {
            content: '';
            position: absolute;
            bottom: -90px; left: -90px;
            width: 340px; height: 340px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(232,100,120,0.12) 0%, transparent 70%);
            pointer-events: none;
        }

        /* Decorative corner brackets */
        .guest-left .c-tl,
        .guest-left .c-br {
            position: absolute;
            width: 40px; height: 40px;
        }
        .guest-left .c-tl { top: 24px; left: 24px; border-top: 1px solid rgba(232,180,80,0.3); border-left: 1px solid rgba(232,180,80,0.3); }
        .guest-left .c-br { bottom: 24px; right: 24px; border-bottom: 1px solid rgba(232,180,80,0.3); border-right: 1px solid rgba(232,180,80,0.3); }

        .guest-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            animation: g-fadein 0.6s ease both;
            text-decoration: none;
        }

        .guest-brand-mark {
            width: 36px; height: 36px;
            border: 1.5px solid rgba(232,180,80,0.6);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .guest-brand-mark svg { width: 18px; height: 18px; color: #e8b450; }

        .guest-brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem;
            color: #f0ebe3;
            letter-spacing: 0.04em;
        }

        .guest-panel-body { animation: g-fadeup 0.7s 0.15s ease both; }

        .guest-panel-tag {
            display: inline-block;
            font-size: 0.65rem;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: #e8b450;
            border: 1px solid rgba(232,180,80,0.3);
            padding: 5px 12px;
            border-radius: 20px;
            margin-bottom: 24px;
        }

        .guest-panel-headline {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 3vw, 2.8rem);
            color: #f0ebe3;
            line-height: 1.2;
            font-weight: 400;
            margin-bottom: 20px;
        }

        .guest-panel-headline em { font-style: italic; color: #e8b450; }

        .guest-panel-body-text {
            font-size: 0.82rem;
            color: rgba(240,235,227,0.5);
            line-height: 1.8;
            max-width: 280px;
        }

        .guest-panel-footer {
            font-size: 0.7rem;
            color: rgba(240,235,227,0.25);
            letter-spacing: 0.06em;
            animation: g-fadein 0.6s 0.3s ease both;
        }

        /* ── Right form panel ── */
        .guest-right {
            background: #f0ebe3;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 52px 48px;
            animation: g-fadein 0.6s 0.2s ease both;
        }

        .guest-slot {
            width: 100%;
            max-width: 400px;
        }

        @media (max-width: 768px) {
            .guest-page { grid-template-columns: 1fr; }
            .guest-left { display: none; }
            .guest-right { padding: 40px 24px; background: #f0ebe3; }
        }

        @keyframes g-fadein { from { opacity: 0; } to { opacity: 1; } }
        @keyframes g-fadeup  { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body>
<div class="guest-page">

    <!-- Left decorative panel -->
    <div class="guest-left">
        <div class="c-tl"></div>
        <div class="c-br"></div>

        <a href="/" class="guest-brand">
            <div class="guest-brand-mark">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                </svg>
            </div>

        </a>

        <div class="guest-panel-body">
            <h2 class="guest-panel-headline">Cast your<br>vote with<br><em>confidence.</em></h2>
            <p class="guest-panel-body-text">A transparent, secure, and modern platform for elections that every voice deserves.</p>
        </div>

    </div>

    <!-- Right slot panel -->
    <div class="guest-right">
        <div class="guest-slot">
            {{ $slot }}
        </div>
    </div>

</div>
</body>
</html>