<x-guest-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600&family=DM+Sans:wght@300;400;500&display=swap');

        :root {
            --ink: #0f1117;
            --ink-soft: #1e2230;
            --silver: #8a95a8;
            --silver-light: #a9b4c6;
            --gold: #c9a84c;
            --gold-light: #e8c87a;
            --surface: #ffffff;
            --surface-soft: #f7f8fa;
            --border: #6895ef;
            --danger: #c0392b;
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
            line-height: 1.2;
        }

        .auth-subtitle {
            font-size: 0.8rem;
            color: var(--silver);
            letter-spacing: 0.08em;
            text-transform: uppercase;
            font-weight: 400;
            margin-bottom: 28px;
        }

        .auth-divider {
            height: 1px;
            background: var(--border);
            margin-bottom: 24px;
        }

        .field-group {
            margin-bottom: 18px;
        }

        .field-group label {
            display: block;
            font-size: 0.7rem;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--silver);
            margin-bottom: 7px;
        }

        .field-group input {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 0.875rem;
            color: var(--ink);
            background: var(--surface-soft);
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            outline: none;
            font-family: 'DM Sans', sans-serif;
        }

        .field-group input:focus {
            border-color: var(--gold);
            background: var(--surface);
            box-shadow: 0 0 0 3px rgba(201, 168, 76, 0.1);
        }

        .field-group .error-msg {
            font-size: 0.75rem;
            color: var(--danger);
            margin-top: 5px;
        }

        .remember-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
        }

        .remember-row input[type="checkbox"] {
            width: 15px;
            height: 15px;
            border: 1px solid var(--border);
            border-radius: 3px;
            accent-color: var(--gold);
            cursor: pointer;
        }

        .remember-row span {
            font-size: 0.8rem;
            color: var(--silver);
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

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 22px;
            background: transparent;
            color: var(--ink);
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 0.78rem;
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            cursor: pointer;
            transition: border-color 0.2s, color 0.2s, transform 0.15s;
            font-family: 'DM Sans', sans-serif;
            text-decoration: none;
        }

        .btn-secondary:hover {
            border-color: var(--ink);
            color: var(--ink);
            transform: translateY(-1px);
        }

        .link-soft {
            font-size: 0.78rem;
            color: var(--silver);
            text-decoration: none;
            transition: color 0.2s;
            letter-spacing: 0.02em;
        }

        .link-soft:hover {
            color: var(--gold);
        }

        .actions-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .actions-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .session-status {
            padding: 10px 14px;
            background: rgba(201, 168, 76, 0.08);
            border: 1px solid rgba(201, 168, 76, 0.25);
            border-radius: 6px;
            font-size: 0.8rem;
            color: #8a6a1e;
            margin-bottom: 20px;
        }
    </style>

    <div class="auth-wrap">
        <!-- Session Status -->
        @if (session('status'))
            <div class="session-status">{{ session('status') }}</div>
        @endif

        <div class="auth-eyebrow">
            <div class="auth-eyebrow-line left"></div>
            <div class="auth-eyebrow-dot"></div>
            <div class="auth-eyebrow-line"></div>
        </div>

        <h1 class="auth-title">Welcome, Voters!</h1>
        <p class="auth-subtitle">Sign in to your account</p>

        <div class="auth-divider"></div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="field-group">
                <x-input-label for="email" :value="__('Email Address')" />
                <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="error-msg" />
            </div>

            <!-- Password -->
            <div class="field-group">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="error-msg" />
            </div>

            <!-- Remember Me -->
            <div class="remember-row">
                <input id="remember_me" type="checkbox" name="remember">
                <span>{{ __('Keep me signed in') }}</span>
            </div>

            <div class="actions-row">
                @if (Route::has('password.request'))
                    <a class="link-soft" href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif

                <div class="actions-right">
                    <a href="{{ route('register') }}" class="btn-secondary">
                        {{ __('Register') }}
                    </a>
                    <x-primary-button class="btn-primary">
                        {{ __('Sign In') }}
                    </x-primary-button>
                </div>
            </div>
        </form>
    </div>
</x-guest-layout>