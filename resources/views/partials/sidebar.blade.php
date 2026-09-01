@php
    $currentRoute = request()->route()
        ? request()->route()->getName()
        : null;
@endphp

<button
    id="sidebarToggle"
    type="button"
    aria-label="Buka menu sidebar"
    aria-expanded="false"
    class="fixed left-4 top-4 z-50 inline-flex h-11 w-11 items-center justify-center rounded-full bg-gradient-to-br from-[#22365d] to-[#101a2e] text-lg text-[#f8f7f2] shadow-lg shadow-black/40 ring-1 ring-white/10 transition-all duration-200 hover:from-[#2c4272] hover:to-[#17243f] active:scale-95 md:hidden"
>
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
</button>

<div
    id="sidebarOverlay"
    class="fixed inset-0 z-40 hidden bg-slate-900/50 backdrop-blur-[2px] md:hidden"
></div>

<aside
    id="sidebarMenu"
    class="fixed inset-y-0 left-0 z-50 w-72 -translate-x-full transform overflow-x-hidden overflow-y-auto bg-gradient-to-b from-[#1c2c4d] via-[#161f38] to-[#0f1729] p-6 text-[#f8f7f2] shadow-2xl shadow-black/30 transition-transform duration-200 ease-in-out md:static md:w-72 md:translate-x-0 md:shrink-0 md:min-h-screen md:sticky md:top-0 md:border-r md:border-white/5"
>

    {{-- AMBIENT GLOW (murni dekoratif, di belakang konten) --}}
    <div aria-hidden="true" class="pointer-events-none absolute -left-16 -top-24 -z-10 h-64 w-64 rounded-full bg-[#f5b63f]/10 blur-3xl"></div>
    <div aria-hidden="true" class="pointer-events-none absolute -bottom-24 -right-10 -z-10 h-56 w-56 rounded-full bg-[#3a5a9c]/20 blur-3xl"></div>

    {{-- LOGO / BRAND --}}
    <div class="flex items-center gap-3 mb-8 border-b border-white/10 pb-5">

        <div
            class="relative flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-[#ffd479] to-[#e8952a] shadow-lg shadow-amber-900/40 ring-1 ring-inset ring-white/40"
        >
            <span class="text-[#17243f] font-bold text-sm">
                WCK
            </span>
        </div>

        <div>
            <p class="text-xs uppercase tracking-[0.2em] text-[#f5b63f]/80">
                SMK
            </p>

            <h1 class="font-semibold text-lg leading-tight">
                Wira Cipta Karya
            </h1>
        </div>

    </div>


    {{-- NAVIGATION --}}
    <nav class="space-y-3">

        <p class="px-3 pb-2 text-[10px] uppercase tracking-[0.2em] text-white/50">
            Menu utama
        </p>


        {{-- DASHBOARD --}}
        <a
            href="{{ route('dashboard') }}"
            class="
                group relative flex items-center gap-3 overflow-hidden rounded-xl px-3 py-2.5
                text-sm font-medium transition-all duration-200
                {{ $currentRoute === 'dashboard'
                    ? 'bg-gradient-to-r from-[#f5b63f]/25 via-white/10 to-transparent text-white shadow-[inset_0_1px_0_0_rgba(255,255,255,0.12)]'
                    : 'text-white/75 hover:bg-white/[0.07] hover:text-white'
                }}
            "
        >
            @if ($currentRoute === 'dashboard')
                <span class="absolute inset-y-1.5 left-0 w-[3px] rounded-full bg-[#f5b63f]"></span>
            @endif

            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg transition-colors {{ $currentRoute === 'dashboard' ? 'bg-[#f5b63f]/20' : 'bg-white/10 group-hover:bg-white/15' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
            </span>

            <span>
                Dashboard
            </span>

        </a>


        {{-- DATA MASTER --}}
        <div class="relative rounded-2xl border border-white/10 bg-gradient-to-b from-white/[0.07] to-white/[0.02] p-2 shadow-inner shadow-black/20">

            <p class="px-2 pb-2 text-[10px] uppercase tracking-[0.2em] text-white/50">
                Data master
            </p>


            {{-- DATA SISWA --}}
            <a
                href="{{ route('students.index') }}"
                class="
                    group relative flex items-center gap-3 overflow-hidden rounded-lg px-3 py-2.5
                    text-sm font-medium transition-all duration-200
                    {{ $currentRoute && str_starts_with($currentRoute, 'students')
                        ? 'bg-gradient-to-r from-[#f5b63f]/25 via-white/10 to-transparent text-white shadow-[inset_0_1px_0_0_rgba(255,255,255,0.12)]'
                        : 'text-white/75 hover:bg-white/[0.07] hover:text-white'
                    }}
                "
            >
                @if ($currentRoute && str_starts_with($currentRoute, 'students'))
                    <span class="absolute inset-y-1.5 left-0 w-[3px] rounded-full bg-[#f5b63f]"></span>
                @endif

                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg transition-colors {{ $currentRoute && str_starts_with($currentRoute, 'students') ? 'bg-[#f5b63f]/20' : 'bg-white/10 group-hover:bg-white/15' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/></svg>
                </span>

                <span>
                    Data Siswa
                </span>

            </a>


            {{-- DATA GURU --}}
            <a
                href="#"
                class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-white/75 transition-all duration-200 hover:bg-white/[0.07] hover:text-white"
            >
                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white/10 transition-colors group-hover:bg-white/15">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5"/></svg>
                </span>

                <span>
                    Data Guru
                </span>

            </a>


            {{-- DATA KELAS --}}
            <a
                href="{{ route('classes.index') }}"
                class="
                    group relative flex items-center gap-3 overflow-hidden rounded-lg px-3 py-2.5
                    text-sm font-medium transition-all duration-200
                    {{ $currentRoute && str_starts_with($currentRoute, 'classes')
                        ? 'bg-gradient-to-r from-[#f5b63f]/25 via-white/10 to-transparent text-white shadow-[inset_0_1px_0_0_rgba(255,255,255,0.12)]'
                        : 'text-white/75 hover:bg-white/[0.07] hover:text-white'
                    }}
                "
            >
                @if ($currentRoute && str_starts_with($currentRoute, 'classes'))
                    <span class="absolute inset-y-1.5 left-0 w-[3px] rounded-full bg-[#f5b63f]"></span>
                @endif

                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg transition-colors {{ $currentRoute && str_starts_with($currentRoute, 'classes') ? 'bg-[#f5b63f]/20' : 'bg-white/10 group-hover:bg-white/15' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z"/></svg>
                </span>

                <span>
                    Data Kelas
                </span>

            </a>


            {{-- TAHUN AJARAN --}}
            <a
                href="#"
                class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-white/75 transition-all duration-200 hover:bg-white/[0.07] hover:text-white"
            >
                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white/10 transition-colors group-hover:bg-white/15">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/></svg>
                </span>

                <span>
                    Tahun Ajaran
                </span>

            </a>

        </div>


        {{-- INPUT ABSENSI --}}
        <a
            href="#"
            class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-white/75 transition-all duration-200 hover:bg-white/[0.07] hover:text-white"
        >
            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white/10 transition-colors group-hover:bg-white/15">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75"/></svg>
            </span>

            <span>
                Input Absensi
            </span>

        </a>


        {{-- REKAP KEHADIRAN --}}
        <a
            href="#"
            class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-white/75 transition-all duration-200 hover:bg-white/[0.07] hover:text-white"
        >
            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white/10 transition-colors group-hover:bg-white/15">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"/></svg>
            </span>

            <span>
                Rekap Kehadiran
            </span>

        </a>


        {{-- ROLE & PERMISSION --}}
        <a
            href="#"
            class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-white/75 transition-all duration-200 hover:bg-white/[0.07] hover:text-white"
        >
            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white/10 transition-colors group-hover:bg-white/15">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/></svg>
            </span>

            <span>
                Role & Permission
            </span>

        </a>

    </nav>


    {{-- STATUS --}}
    <div class="relative mt-10 overflow-hidden rounded-2xl border border-white/10 bg-gradient-to-br from-white/[0.08] to-white/[0.02] p-4 shadow-inner shadow-black/20">

        <p class="text-[10px] uppercase tracking-[0.2em] text-white/50">
            Status
        </p>

        <div class="mt-3 flex items-center gap-3">

            <div class="relative flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-[#ffd479] to-[#e8952a] text-sm font-bold text-[#17243f] shadow-md shadow-amber-900/30">
                {{ strtoupper(substr(auth()->user()->name ?? 'P', 0, 1)) }}
                <span class="absolute -bottom-0.5 -right-0.5 h-3 w-3 rounded-full bg-emerald-400 ring-2 ring-[#161f38]"></span>
            </div>

            <div class="min-w-0">
                <p class="truncate text-sm font-medium text-white">
                    {{ auth()->user()->name ?? 'Pengguna' }}
                </p>

                <p class="truncate text-xs text-white/60">
                    {{ auth()->user()->email ?? 'user@example.com' }}
                </p>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="ml-auto shrink-0">
                @csrf
                <button
                    type="submit"
                    aria-label="Keluar dari aplikasi"
                    title="Logout"
                    class="flex h-9 w-9 items-center justify-center rounded-lg text-white/60 transition-colors hover:bg-rose-500/15 hover:text-rose-300 focus:outline-none focus:ring-2 focus:ring-[#f5b63f]/70"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6A2.25 2.25 0 0 0 5.25 5.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3-6 3 3m0 0-3 3m3-3H9.75" />
                    </svg>
                </button>
            </form>

        </div>

    </div>

</aside>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebarMenu');
        const toggle = document.getElementById('sidebarToggle');
        const overlay = document.getElementById('sidebarOverlay');

        if (!sidebar || !toggle || !overlay) {
            return;
        }

        const ICON_BARS_3 = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>';
        const ICON_X_MARK = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>';

        const setToggleState = function (isOpen) {
            toggle.setAttribute('aria-expanded', String(isOpen));
            toggle.setAttribute('aria-label', isOpen ? 'Tutup menu sidebar' : 'Buka menu sidebar');
            toggle.innerHTML = isOpen ? ICON_X_MARK : ICON_BARS_3;
        };

        const closeSidebar = function () {
            if (window.innerWidth >= 768) {
                return;
            }

            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
            setToggleState(false);
        };

        const openSidebar = function () {
            if (window.innerWidth >= 768) {
                return;
            }

            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
            setToggleState(true);
        };

        const syncDesktopState = function () {
            if (window.innerWidth >= 768) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.add('hidden');
                setToggleState(false);
            }
        };

        toggle.addEventListener('click', function () {
            if (window.innerWidth >= 768) {
                return;
            }

            if (sidebar.classList.contains('-translate-x-full')) {
                openSidebar();
                return;
            }

            closeSidebar();
        });

        overlay.addEventListener('click', closeSidebar);

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && window.innerWidth < 768 && !sidebar.classList.contains('-translate-x-full')) {
                closeSidebar();
            }
        });

        window.addEventListener('resize', syncDesktopState);
        syncDesktopState();
    });
</script>