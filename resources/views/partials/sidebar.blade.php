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
    class="fixed left-4 top-4 z-50 inline-flex h-11 w-11 items-center justify-center rounded-full bg-[#17243f] text-lg text-[#f8f7f2] shadow-lg shadow-slate-900/20 transition hover:bg-[#22365d] md:hidden"
>
    ☰
</button>

<div
    id="sidebarOverlay"
    class="fixed inset-0 z-40 hidden bg-slate-900/40 md:hidden"
></div>

<aside
    id="sidebarMenu"
    class="fixed inset-y-0 left-0 z-50 w-72 -translate-x-full transform transition-transform duration-200 ease-in-out p-6 shadow-xl shadow-slate-900/10 bg-[#17243f] text-[#f8f7f2] md:static md:w-72 md:translate-x-0 md:shrink-0 md:min-h-screen md:sticky md:top-0"
>

    {{-- LOGO / BRAND --}}
    <div class="flex items-center gap-3 mb-8 border-b border-white/10 pb-5">

        <div
            class="w-11 h-11 rounded-full flex items-center justify-center shadow-md shadow-amber-400/40 bg-[#f5b63f]"
        >
            <span class="text-[#17243f] font-bold text-sm">
                WCK
            </span>
        </div>

        <div>
            <p class="text-xs uppercase tracking-[0.2em] text-[#f5b63f]/80">
                SMK
            </p>

            <h1 class="font-semibold text-lg">
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
                flex items-center gap-3 rounded-xl px-3 py-2.5
                text-sm font-medium transition
                {{ $currentRoute === 'dashboard'
                    ? 'bg-white/10 text-white'
                    : 'text-white/80 hover:bg-white/10'
                }}
            "
        >

            <span>🏠</span>

            <span>
                Dashboard
            </span>

        </a>


        {{-- DATA MASTER --}}
        <div class="rounded-xl border border-white/10 bg-white/5 p-2">

            <p class="px-2 pb-2 text-[10px] uppercase tracking-[0.2em] text-white/50">
                Data master
            </p>


            {{-- DATA SISWA --}}
            <a
                href="{{ route('students.index') }}"
                class="
                    flex items-center gap-3 rounded-lg px-3 py-2.5
                    text-sm transition font-medium
                    {{ $currentRoute && str_starts_with($currentRoute, 'students')
                        ? 'bg-white/10 text-white'
                        : 'text-white/80 hover:bg-white/10'
                    }}
                "
            >

                <span>👥</span>

                <span>
                    Data Siswa
                </span>

            </a>


            {{-- DATA GURU --}}
            <a
                href="#"
                class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-white/80 hover:bg-white/10 transition"
            >

                <span>👨‍🏫</span>

                <span>
                    Data Guru
                </span>

            </a>


            {{-- DATA KELAS --}}
            <a
                href="#"
                class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-white/80 hover:bg-white/10 transition"
            >

                <span>🏫</span>

                <span>
                    Data Kelas
                </span>

            </a>


            {{-- TAHUN AJARAN --}}
            <a
                href="#"
                class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-white/80 hover:bg-white/10 transition"
            >

                <span>📅</span>

                <span>
                    Tahun Ajaran
                </span>

            </a>

        </div>


        {{-- INPUT ABSENSI --}}
        <a
            href="#"
            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-white/80 hover:bg-white/10 transition"
        >

            <span>✅</span>

            <span>
                Input Absensi
            </span>

        </a>


        {{-- REKAP KEHADIRAN --}}
        <a
            href="#"
            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-white/80 hover:bg-white/10 transition"
        >

            <span>📊</span>

            <span>
                Rekap Kehadiran
            </span>

        </a>


        {{-- ROLE & PERMISSION --}}
        <a
            href="#"
            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-white/80 hover:bg-white/10 transition"
        >

            <span>🔐</span>

            <span>
                Role & Permission
            </span>

        </a>

    </nav>


    {{-- STATUS --}}
    <div class="mt-10 rounded-2xl bg-white/5 border border-white/10 p-4">

        <p class="text-[10px] uppercase tracking-[0.2em] text-white/50">
            Status
        </p>

        <p class="mt-2 text-sm font-medium text-white">
            {{ auth()->user()->name ?? 'Pengguna' }}
        </p>

        <p class="text-xs text-white/70">
            {{ auth()->user()->email ?? 'user@example.com' }}
        </p>

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

        const setToggleState = function (isOpen) {
            toggle.setAttribute('aria-expanded', String(isOpen));
            toggle.setAttribute('aria-label', isOpen ? 'Tutup menu sidebar' : 'Buka menu sidebar');
            toggle.textContent = isOpen ? '✕' : '☰';
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