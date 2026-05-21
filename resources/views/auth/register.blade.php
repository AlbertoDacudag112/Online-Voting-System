<x-guest-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600&family=DM+Sans:wght@300;400;500&display=swap');
        :root {
            --ink: #0f1117; --ink-soft: #1e2230; --silver: #8a95a8;
            --gold: #c9a84c; --surface: #ffffff; --surface-soft: #f7f8fa;
            --border: #e2e5eb; --danger: #c0392b;
        }
        .auth-wrap * { font-family: 'DM Sans', sans-serif; box-sizing: border-box; }
        .auth-wrap { animation: fadeUp 0.5s ease both; }
        @keyframes fadeUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
        .auth-eyebrow { display:flex; align-items:center; gap:10px; margin-bottom:28px; }
        .auth-eyebrow-line { flex:1; height:1px; background:linear-gradient(to right, transparent, var(--border)); }
        .auth-eyebrow-line.left { background:linear-gradient(to left, transparent, var(--border)); }
        .auth-eyebrow-dot { width:6px; height:6px; border-radius:50%; background:var(--gold); }
        .auth-title { font-family:'Cormorant Garamond',serif; font-size:1.75rem; font-weight:500; color:var(--ink); margin:0 0 6px; line-height:1.2; }
        .auth-subtitle { font-size:0.8rem; color:var(--silver); letter-spacing:0.08em; text-transform:uppercase; margin-bottom:28px; }
        .auth-divider { height:1px; background:var(--border); margin-bottom:24px; }
        .field-group { margin-bottom:18px; }
        .field-group label { display:block; font-size:0.7rem; font-weight:500; letter-spacing:0.1em; text-transform:uppercase; color:var(--silver); margin-bottom:7px; }
        .field-group input, .field-group select {
            width:100%; padding:10px 14px; border:1px solid var(--border); border-radius:6px;
            font-size:0.875rem; color:var(--ink); background:var(--surface-soft);
            transition:border-color .2s,box-shadow .2s; outline:none;
            font-family:'DM Sans',sans-serif;
        }
        .field-group select {
            appearance:none; -webkit-appearance:none;
            background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%238a95a8' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
            background-repeat:no-repeat; background-position:right 14px center; cursor:pointer;
            transition:border-color .2s,box-shadow .2s;
        }
        .field-group input:focus, .field-group select:focus {
            border-color:var(--gold); background:var(--surface);
            box-shadow:0 0 0 3px rgba(201,168,76,0.1);
        }
        .field-row { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
        .error-msg { font-size:0.75rem; color:var(--danger); margin-top:5px; }
        .btn-primary {
            display:inline-flex; align-items:center; justify-content:center;
            padding:10px 22px; background:var(--ink); color:#fff; border:none;
            border-radius:6px; font-size:0.78rem; font-weight:500; letter-spacing:0.08em;
            text-transform:uppercase; cursor:pointer; transition:background .2s,transform .15s;
            font-family:'DM Sans',sans-serif;
        }
        .btn-primary:hover { background:var(--ink-soft); transform:translateY(-1px); }
        .link-soft { font-size:0.78rem; color:var(--silver); text-decoration:none; transition:color .2s; }
        .link-soft:hover { color:var(--gold); }
        .actions-row { display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap; margin-top:24px; }
    </style>

    <div class="auth-wrap">
        <div class="auth-eyebrow">
            <div class="auth-eyebrow-line left"></div>
            <div class="auth-eyebrow-dot"></div>
            <div class="auth-eyebrow-line"></div>
        </div>

        <h1 class="auth-title">Create account</h1>
        <p class="auth-subtitle">Get started today</p>
        <div class="auth-divider"></div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- Name fields --}}
            <div class="field-row">
                <div class="field-group">
                    <x-input-label for="first_name" :value="__('First Name')" />
                    <x-text-input id="first_name" type="text" name="first_name" :value="old('first_name')" required autofocus autocomplete="given-name" />
                    <x-input-error :messages="$errors->get('first_name')" class="error-msg" />
                </div>

                <div class="field-group">
                    <x-input-label for="last_name" :value="__('Last Name')" />
                    <x-text-input id="last_name" type="text" name="last_name" :value="old('last_name')" required autocomplete="family-name" />
                    <x-input-error :messages="$errors->get('last_name')" class="error-msg" />
                </div>
            </div>

            <div class="field-group">
                <x-input-label for="middle_name" :value="__('Middle Name')" />
                <div style="position:relative;">
                    <x-text-input id="middle_name" type="text" name="middle_name" :value="old('middle_name')" autocomplete="additional-name" style="padding-right:80px;" />
                    <span style="position:absolute;right:12px;top:50%;transform:translateY(-50%);font-size:0.65rem;letter-spacing:0.08em;text-transform:uppercase;color:var(--silver);pointer-events:none;">Optional</span>
                </div>
                <x-input-error :messages="$errors->get('middle_name')" class="error-msg" />
            </div>

            <div class="field-group">
                <x-input-label for="email" :value="__('Email Address')" />
                <x-text-input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="error-msg" />
            </div>

            {{-- Course + Year Level side by side --}}
            <div class="field-row">
                <div class="field-group">
                    <x-input-label for="course" :value="__('Course')" />
                    <select id="course" name="course" required>
                        <option value="" disabled {{ old('course') ? '' : 'selected' }}>— Select course —</option>
                        @foreach ($courses as $key => $label)
                            <option value="{{ $key }}" {{ old('course') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('course')" class="error-msg" />
                </div>

                <div class="field-group">
                    <x-input-label for="year_level" :value="__('Year Level')" />
                    <select id="year_level" name="year_level" required>
                        <option value="" disabled {{ old('year_level') ? '' : 'selected' }}>— Select year —</option>
                        @foreach ($year_levels as $key => $label)
                            <option value="{{ $key }}" {{ old('year_level') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('year_level')" class="error-msg" />
                </div>
            </div>

            <div class="field-group">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="error-msg" />
            </div>

            <div class="field-group">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="error-msg" />
            </div>

            <div class="actions-row">
                <a class="link-soft" href="{{ route('login') }}">{{ __('Already have an account?') }}</a>
                <x-primary-button class="btn-primary">{{ __('Register') }}</x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>