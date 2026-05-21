<x-guest-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600&family=DM+Sans:wght@300;400;500&display=swap');

        :root {
            --ink: #0f1117;
            --ink-soft: #1e2230;
            --silver: #8a95a8;
            --gold: #c9a84c;
            --surface: #2e929f;
            --surface-soft: #4877d5;
            --border: #385795;
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
            margin-bottom: 24px;
        }

        .auth-divider {
            height: 1px;
            background: var(--border);
            margin-bottom: 24px;
        }

        .info-box {
            display: flex;
            gap: 14px;
            align-items: flex-start;
            background: rgba(201, 168, 76, 0.07);
            border: 1px solid rgba(201, 168, 76, 0.25);
            border-radius: 8px;
            padding: 16px 18px;
            margin-bottom: 24px;
        }

        .info-box-icon {
            font-size: 1.2rem;
            color: var(--gold);
            flex-shrink: 0;
            margin-top: 1px;
        }

        .info-box-text {
            font-size: 0.82rem;
            color: var(--ink-soft);
            line-height: 1.65;
        }

        .info-box-text strong {
            display: block;
            font-weight: 600;
            color: var(--ink);
            margin-bottom: 4px;
            font-size: 0.85rem;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.78rem;
            color: var(--silver);
            text-decoration: none;
            letter-spacing: 0.04em;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: var(--ink);
        }
    </style>

    <div class="auth-wrap">
        <div class="auth-eyebrow">
            <div class="auth-eyebrow-line left"></div>
            <div class="auth-eyebrow-dot"></div>
            <div class="auth-eyebrow-line"></div>
        </div>

        <h1 class="auth-title">Forgot password?</h1>
        <p class="auth-subtitle">Account recovery</p>

        <div class="auth-divider"></div>

        <div class="info-box">
            <span class="info-box-icon">&#9432;</span>
            <div class="info-box-text">
                <strong>Contact your administrator</strong>
                Password resets are managed by your system administrator. Please reach out to them directly and they'll get your account sorted out.
            </div>
        </div>

        <a href="{{ route('login') }}" class="back-link">
            &#8592; Back to login
        </a>
    </div>
</x-guest-layout>