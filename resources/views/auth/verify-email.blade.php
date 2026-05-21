<x-guest-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600&family=DM+Sans:wght@300;400;500&display=swap');

        :root {
            --ink: #0f1117;
            --ink-soft: #1e2230;
            --silver: #8a95a8;
            --gold: #c9a84c;
            --surface: #ffffff;
            --surface-soft: #f7f8fa;
            --border: #e2e5eb;
        }

        .auth-wrap * {
            font-family: 'DM Sans', sans-serif;
            box-sizing: border-box;
        }

        .auth-wrap {
            animation: fadeUp 0.5s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .auth-eyebrow {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 28px;
        }

        .auth-eyebrow-line {
            flex: 1;
            height: 1px;
            background: linear-gradient(to right, transparent, var(--border));
        }

        .auth-eyebrow-line.left {
            background: linear-gradient(to left, transparent, var(--border));
        }

        .auth-eyebrow-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--gold);
        }

        .auth-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.75rem;
            font-weight: 500;
            color: var(--ink);
            letter-spacing: -0.01em;
            margin: 0 0 6px 0;
        }

        .auth-subtitle {
            font-size: 0.8rem;
            color: var(--silver);
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-bottom: 16px;
        }

        .auth-divider {
            height: 1px;
            background: var(--border);
            margin-bottom: 24px;
        }

        .auth-description {
            font-size: 0.82rem;
            color: var(--silver);
            line-height: 1.7;
            margin-bottom: 24px;
        }

        .success-notice {
            padding: 10px 14px;
            background: rgba(201, 168, 76, 0.08);
            border: 1px solid rgba(201, 168, 76, 0.25);
            border-radius: 6px;
            font-size: 0.8rem;
            color: #8a6a1e;
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }

        .success-notice svg {
            width: 14px;
            height: 14px;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 22px;
            background: var(--ink);
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 0.78rem;
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            cursor: pointer;
            transition: background 0.2s, transform 0.15s;
            font-family: 'DM Sans', sans-serif;
        }

        .btn-primary:hover {
            background: var(--ink-soft);
            transform: translateY(-1px);
        }

        .link-danger {
            font-size: 0.78rem;
            color: var(--silver);
            text-decoration: none;
            background: none;
            border: none;
            cursor: pointer;
            transition: color 0.2s;
            font-family: 'DM Sans', sans-serif;
            padding: 0;
        }

        .link-danger:hover {
            color: #c0392b;
        }

        .actions-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .email-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            background: rgba(201, 168, 76, 0.08);
            border: 1px solid rgba(201, 168, 76, 0.2);
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .email-icon svg {
            width: 22px;
            height: 22px;
            color: var(--gold);
        }
    </style>

    <div class="auth-wrap">
        <div class="auth-eyebrow">
            <div class="auth-eyebrow-line left"></div>
            <div class="auth-eyebrow-dot"></div>
            <div class="auth-eyebrow-line"></div>
        </div>

        <div class="email-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>

        <h1 class="auth-title">Verify your email</h1>
        <p class="auth-subtitle">One step remaining</p>

        <p class="auth-description">{{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}</p>

        <div class="auth-divider"></div>

        @if (session('status') == 'verification-link-sent')
            <div class="success-notice">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="actions-row">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <x-primary-button class="btn-primary">
                    {{ __('Resend Email') }}
                </x-primary-button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="link-danger">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>