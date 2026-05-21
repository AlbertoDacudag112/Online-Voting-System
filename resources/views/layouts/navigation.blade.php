<style>
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600&display=swap');

:root {
    --ink:         #a1a1ac;
    --ink-2:       #fdfdfd;
    --gold:        #e8b450;
    --gold-dim:    rgba(232,180,80,0.15);
    --gold-border: rgba(232,180,80,0.25);
    --cream:       #f0ebe3;
    --muted:       rgba(240,235,227,0.45);
    --topbar-h:    60px;
}

.nav-shell {
    position: sticky;
    top: 0;
    z-index: 100;
    background: var(--ink);
    border-bottom: 1px solid rgba(232,180,80,0.12);
    font-family: 'Outfit', sans-serif;
}

.nav-inner {
    max-width: 1200px;
    margin: 0 auto;
    height: var(--topbar-h);
    padding: 0 24px;
    display: flex;
    align-items: center;
    gap: 0;
}

/* Brand */
.nav-brand {
    display: flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    margin-right: 32px;
    flex-shrink: 0;
}

.nav-brand-mark {
    width: 30px; height: 30px;
    border: 1.5px solid var(--gold-border);
    border-radius: 7px;
    display: flex; align-items: center; justify-content: center;
}

.nav-brand-mark svg { width: 15px; height: 15px; color: var(--gold); }

.nav-brand-name {
    font-family: 'Playfair Display', serif;
    font-size: 1rem;
    color: var(--cream);
    letter-spacing: 0.03em;
}

/* Nav links (desktop) */
.nav-links {
    display: flex;
    align-items: center;
    gap: 4px;
    flex: 1;
}

.nav-link-item {
    padding: 6px 14px;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 400;
    color: var(--muted);
    text-decoration: none;
    transition: color 0.2s, background 0.2s;
    white-space: nowrap;
}

.nav-link-item:hover { color: var(--cream); background: rgba(240,235,227,0.06); }
.nav-link-item.active-link { color: var(--gold); background: var(--gold-dim); }

/* Right side */
.nav-right {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-left: auto;
}

.nav-user {
    display: flex;
    align-items: center;
    gap: 10px;
}

.nav-avatar {
    width: 32px; height: 32px;
    border-radius: 50%;
    background: var(--gold-dim);
    border: 1.5px solid var(--gold-border);
    display: flex; align-items: center; justify-content: center;
    font-size: 0.72rem;
    font-weight: 600;
    color: var(--gold);
    text-transform: uppercase;
    flex-shrink: 0;
}

.nav-user-name {
    font-size: 0.82rem;
    font-weight: 500;
    color: var(--cream);
}

.nav-divider { width: 1px; height: 22px; background: rgba(240,235,227,0.1); }

/* Dropdown */
.nav-dropdown { position: relative; }

.nav-dropdown-btn {
    display: flex;
    align-items: center;
    gap: 6px;
    background: none;
    border: 1px solid rgba(240,235,227,0.12);
    border-radius: 6px;
    padding: 6px 12px;
    font-size: 0.78rem;
    color: var(--muted);
    cursor: pointer;
    font-family: 'Outfit', sans-serif;
    transition: border-color 0.2s, color 0.2s;
}

.nav-dropdown-btn:hover { border-color: rgba(240,235,227,0.3); color: var(--cream); }

.nav-dropdown-btn svg { width: 12px; height: 12px; transition: transform 0.2s; }
.nav-dropdown-btn[aria-expanded="true"] svg { transform: rotate(180deg); }

.nav-dropdown-menu {
    position: absolute;
    top: calc(100% + 8px);
    right: 0;
    min-width: 180px;
    background: var(--ink-2);
    border: 1px solid rgba(240,235,227,0.1);
    border-radius: 10px;
    padding: 6px;
    box-shadow: 0 12px 40px rgba(0,0,0,0.35);
    display: none;
    z-index: 200;
    animation: dd-open 0.15s ease both;
}

.nav-dropdown-menu.open { display: block; }

.nav-dropdown-item {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 9px 12px;
    border-radius: 7px;
    font-size: 0.8rem;
    color: var(--muted);
    text-decoration: none;
    transition: color 0.2s, background 0.2s;
    cursor: pointer;
    background: none;
    border: none;
    width: 100%;
    text-align: left;
    font-family: 'Outfit', sans-serif;
}

.nav-dropdown-item:hover { color: var(--cream); background: rgba(240,235,227,0.06); }
.nav-dropdown-item.danger:hover { color: #e8a0a0; background: rgba(224,82,82,0.08); }

.nav-dropdown-sep { height: 1px; background: rgba(240,235,227,0.08); margin: 4px 0; }

/* Mobile hamburger */
.nav-mob-btn {
    display: none;
    background: none;
    border: none;
    color: var(--muted);
    cursor: pointer;
    padding: 6px;
    font-size: 1.2rem;
    align-items: center;
    margin-left: auto;
}

/* Mobile drawer */
.nav-mob-drawer {
    display: none;
    flex-direction: column;
    background: var(--ink);
    border-top: 1px solid rgba(240,235,227,0.06);
    padding: 12px 16px 20px;
}

.nav-mob-drawer.open { display: flex; }

.nav-mob-user {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 0;
    border-bottom: 1px solid rgba(240,235,227,0.08);
    margin-bottom: 8px;
}

.nav-mob-name { font-size: 0.85rem; font-weight: 500; color: var(--cream); }
.nav-mob-email { font-size: 0.72rem; color: var(--muted); }

.nav-mob-link {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 9px 4px;
    font-size: 0.83rem;
    color: var(--muted);
    text-decoration: none;
    transition: color 0.2s;
    background: none;
    border: none;
    cursor: pointer;
    font-family: 'Outfit', sans-serif;
    width: 100%;
    text-align: left;
}

.nav-mob-link:hover { color: var(--cream); }
.nav-mob-link.active-link { color: var(--gold); }

@media (max-width: 768px) {
    .nav-links, .nav-right { display: none; }
    .nav-mob-btn { display: flex; }
}

@keyframes dd-open { from { opacity: 0; transform: translateY(-6px); } to { opacity: 1; transform: translateY(0); } }
</style>

<nav class="nav-shell" x-data="{ open: false }">
    <div class="nav-inner">
        <!-- Brand -->
        <a href="{{ route('dashboard') }}" class="nav-brand">
            <div class="nav-brand-mark">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                </svg>
            </div>
            <span class="nav-brand-name">{{ config('app.name', 'Platform') }}</span>
        </a>

        <!-- Desktop Nav Links -->
        <div class="nav-links">
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="nav-link-item {{ request()->routeIs('dashboard') ? 'active-link' : '' }}">
                {{ __('Dashboard') }}
            </x-nav-link>
        </div>

        <!-- Desktop Right -->
        <div class="nav-right">
            <div class="nav-user">
                <div class="nav-avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                <span class="nav-user-name">{{ Auth::user()->name }}</span>
            </div>

            <div class="nav-divider"></div>

            <!-- Dropdown -->
            <div class="nav-dropdown">
                <button class="nav-dropdown-btn" onclick="toggleNavDropdown(this)" aria-expanded="false">
                    Account
                    <svg viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>

                <div class="nav-dropdown-menu" id="nav-dd-menu">
                    <a href="{{ route('profile.edit') }}" class="nav-dropdown-item">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        {{ __('Profile') }}
                    </a>
                    <div class="nav-dropdown-sep"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-dropdown-item danger">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/></svg>
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Mobile toggle -->
        <button class="nav-mob-btn" @click="open = !open" aria-label="Toggle menu">
            <svg x-show="!open" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
            <svg x-show="open" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    <!-- Mobile drawer -->
    <div class="nav-mob-drawer" :class="{ 'open': open }">
        <div class="nav-mob-user">
            <div class="nav-avatar" style="width:36px;height:36px;">{{ substr(Auth::user()->name, 0, 1) }}</div>
            <div>
                <div class="nav-mob-name">{{ Auth::user()->name }}</div>
                <div class="nav-mob-email">{{ Auth::user()->email }}</div>
            </div>
        </div>

        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="nav-mob-link {{ request()->routeIs('dashboard') ? 'active-link' : '' }}">
            {{ __('Dashboard') }}
        </x-responsive-nav-link>

        <a href="{{ route('profile.edit') }}" class="nav-mob-link">{{ __('Profile') }}</a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="nav-mob-link">
                {{ __('Log Out') }}
            </x-responsive-nav-link>
        </form>
    </div>
</nav>

<script>
function toggleNavDropdown(btn) {
    const menu = document.getElementById('nav-dd-menu');
    const isOpen = menu.classList.toggle('open');
    btn.setAttribute('aria-expanded', isOpen);
    if (isOpen) {
        const close = (e) => {
            if (!btn.closest('.nav-dropdown').contains(e.target)) {
                menu.classList.remove('open');
                btn.setAttribute('aria-expanded', false);
                document.removeEventListener('click', close);
            }
        };
        setTimeout(() => document.addEventListener('click', close), 0);
    }
}
</script>