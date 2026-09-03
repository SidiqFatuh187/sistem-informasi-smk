<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kelas — SMK Wira Cipta Karya</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ink: '#17243f',
                        cream: '#f8f7f2',
                        amber: '#f5b63f',
                        slate: '#64748b',
                        navy: '#17243f',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-cream text-ink min-h-screen">
    <div class="flex min-h-screen">
        @include('partials.sidebar')

        <main class="flex-1 min-w-0 bg-cream">
            <header class="bg-[#f3f4f6] border-b border-ink/10">
                <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm text-slate">Manajemen</p>
                        <h1 class="font-bold text-xl text-ink">Data Kelas</h1>
                    </div>

                    <a href="{{ route('classes.create') }}" class="bg-black text-white px-4 py-2 rounded-full text-sm font-semibold hover:bg-slate-800 transition">
                        + Tambah Kelas
                    </a>
                </div>
            </header>

            <div class="max-w-7xl mx-auto px-6 py-10">
                @if (session('success'))
                    <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        {{ session('error') }}
                    </div>
                @endif

                <section class="mb-6 rounded-2xl border border-[#17243f]/10 bg-[#f3f4f6] p-5 shadow-sm">
                    <div class="mb-4">
                        <h2 class="text-lg font-bold text-ink">Kenaikan Kelas</h2>
                        <p class="mt-1 text-sm text-slate">Pindahkan seluruh siswa dari kelas sebelumnya ke kelas berikutnya.</p>
                    </div>

                    <form id="promotionForm" method="POST" action="{{ route('classes.promote-students') }}" class="grid gap-3 md:grid-cols-[1fr_auto_1fr_auto] md:items-end">
                        @csrf
                        <div>
                            <label for="source_class_id" class="mb-2 block text-xs font-semibold uppercase tracking-[0.2em] text-slate">Kelas asal</label>
                            <select id="source_class_id" name="source_class_id" required class="w-full rounded-xl border border-ink/10 bg-white px-4 py-3 text-sm text-ink focus:border-ink/30 focus:outline-none">
                                <option value="">Pilih kelas asal</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->nama_kelas }} ({{ $class->students->count() }} siswa)</option>
                                @endforeach
                            </select>
                        </div>
                        <span class="hidden pb-3 text-center text-xl text-slate md:block">&#8594;</span>
                        <div>
                            <label for="target_class_id" class="mb-2 block text-xs font-semibold uppercase tracking-[0.2em] text-slate">Kelas tujuan</label>
                            <select id="target_class_id" name="target_class_id" required class="w-full rounded-xl border border-ink/10 bg-white px-4 py-3 text-sm text-ink focus:border-ink/30 focus:outline-none">
                                <option value="">Pilih kelas tujuan</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <x-confirm
                            :action="route('classes.promote-students')"
                            title="Konfirmasi Kenaikan Kelas"
                            message="Semua siswa dari kelas asal akan dipindahkan ke kelas tujuan. Data absensi lama tetap aman. Lanjutkan?"
                            confirm-text="Ya, Naikkan"
                            button-text="Naikkan Siswa"
                            form-id="promotionForm"
                        />
                    </form>
                </section>

                <form method="GET" action="{{ route('classes.index') }}" class="mb-6 rounded-2xl border border-ink/10 bg-[#f3f4f6] p-4 shadow-sm">
                    <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
                        <div class="flex-1 min-w-0">
                            <label for="search" class="mb-2 block text-xs font-semibold uppercase tracking-[0.2em] text-slate">Cari kelas</label>
                            <input id="search" name="search" type="search" value="{{ $search ?? '' }}" placeholder="Cari nama kelas atau wali kelas..." class="w-full rounded-xl border border-ink/10 bg-white px-4 py-3 text-sm text-ink placeholder:text-slate-400 focus:border-ink/30 focus:outline-none">
                        </div>

                        <div class="flex shrink-0 items-center gap-2">
                            <button type="submit" class="rounded-xl bg-black px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800 transition">
                                Cari
                            </button>

                            @if ($search)
                                <a href="{{ route('classes.index') }}" class="rounded-xl bg-[#e5e7eb] px-5 py-3 text-sm font-semibold text-ink hover:bg-[#d1d5db] transition">
                                    Reset
                                </a>
                            @endif
                        </div>
                    </div>
                </form>

                @if ($classes->isEmpty())
                    <div class="rounded-2xl border border-dashed border-ink/15 bg-[#f3f4f6] p-8 text-center shadow-sm">
                        <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-navy/5 text-3xl">🏫</div>

                        <h2 class="text-xl font-bold text-ink">
                            @if ($search)
                                Tidak ada kelas yang cocok dengan pencarian
                            @else
                                Belum ada data kelas
                            @endif
                        </h2>

                        <p class="mt-2 text-sm text-slate">
                            @if ($search)
                                Coba cari dengan nama kelas atau wali kelas lain.
                            @else
                                Mulai dengan menambahkan kelas pertama untuk sekolah ini.
                            @endif
                        </p>

                        <div class="mt-6 flex justify-center gap-3">
                            <a href="{{ route('classes.create') }}" class="inline-flex rounded-full bg-black px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-slate-800 transition">
                                + Tambah Kelas
                            </a>

                            @if ($search)
                                <a href="{{ route('classes.index') }}" class="inline-flex rounded-full bg-[#e5e7eb] px-5 py-2.5 text-sm font-semibold text-ink shadow-sm hover:bg-[#d1d5db] transition">
                                    Reset Pencarian
                                </a>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="overflow-hidden rounded-2xl border border-ink/10 bg-[#f3f4f6] shadow-sm">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-ink/10">
                                <thead class="bg-[#e5e7eb]">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate">Nama Kelas</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate">Wali Kelas</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate">Jumlah Siswa</th>
                                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-ink/10">
                                    @foreach ($classes as $class)
                                        <tr class="hover:bg-white/60 transition">
                                            <td class="px-4 py-3 text-sm text-ink font-medium">
                                                <a href="{{ route('classes.show', $class) }}" class="hover:text-slate-600 hover:underline">{{ $class->nama_kelas }}</a>
                                            </td>
                                            <td class="px-4 py-3 text-sm text-ink">{{ $class->teacher?->nama ?? 'Belum ditentukan' }}</td>
                                            <td class="px-4 py-3 text-sm text-ink"><a href="{{ route('classes.show', $class) }}" class="hover:underline">{{ $class->students->count() }} siswa</a></td>
                                            <td class="px-4 py-3 text-right">
                                                <div class="flex justify-end gap-2">
                                                    <a href="{{ route('classes.edit', $class) }}" class="rounded-lg border border-amber/50 bg-amber/10 px-3 py-1.5 text-xs font-semibold text-navy hover:bg-amber/20 transition">
                                                        Edit
                                                    </a>

                                                    <x-delete :action="route('classes.destroy', $class)" :name="$class->nama_kelas" title="Hapus Kelas Ini?" />
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </main>
    </div>

    <div id="deleteModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4">
        <div class="bg-white rounded-[1.5rem] shadow-xl w-full max-w-sm overflow-hidden">
            <form id="deleteForm" action="" method="POST">
                @csrf
                @method('DELETE')

                <div class="p-6 text-center">
                    <div class="w-16 h-16 mx-auto bg-rose-50 text-rose-600 rounded-full flex items-center justify-center mb-5 border-[6px] border-white shadow-sm shadow-rose-100">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>

                    <h3 class="text-lg font-bold text-slate-900 tracking-tight mb-2">Hapus Kelas Ini?</h3>

                    <p class="text-sm text-slate-500 leading-relaxed mb-8">
                        <span id="modal-item-name" class="font-semibold text-slate-700"></span>
                        akan dihapus permanen dan tidak bisa dikembalikan.
                    </p>

                    <div class="flex gap-3">
                        <button type="button" onclick="closeDeleteModal()" class="flex-1 px-4 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl transition-colors">
                            Batal
                        </button>

                        <button type="submit" class="flex-1 px-4 py-3 bg-rose-600 hover:bg-rose-700 text-white text-sm font-semibold rounded-xl transition-all active:scale-95 shadow-lg shadow-rose-200">
                            Ya, Hapus
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openDeleteModal(action, name) {
            document.getElementById('deleteForm').action = action;
            document.getElementById('modal-item-name').textContent = '"' + name + '"';
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        document.getElementById('deleteModal').addEventListener('click', function (event) {
            if (event.target === this) {
                closeDeleteModal();
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeDeleteModal();
            }
        });
    </script>
</body>
</html>
