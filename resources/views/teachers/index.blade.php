<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Guru — SMK Wira Cipta Karya</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-[#f8f7f2] text-[#17243f]">
    <div class="flex min-h-screen">
        @include('partials.sidebar')

        <main class="min-w-0 flex-1">
            <header class="border-b border-[#17243f]/10 bg-[#f3f4f6]">
                <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-6 py-4">
                    <div>
                        <p class="text-sm text-slate-500">Manajemen</p>
                        <h1 class="text-xl font-bold">Data Guru</h1>
                    </div>
                    <a href="{{ route('teachers.create') }}" class="rounded-full bg-black px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">+ Tambah Guru</a>
                </div>
            </header>

            <div class="mx-auto max-w-7xl px-6 py-10">
                @if (session('success'))
                    <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">{{ session('success') }}</div>
                @endif

                <form method="GET" action="{{ route('teachers.index') }}" class="mb-6 rounded-2xl border border-[#17243f]/10 bg-[#f3f4f6] p-4 shadow-sm">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-end">
                        <div class="min-w-0 flex-1">
                            <label for="search" class="mb-2 block text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Cari guru</label>
                            <input id="search" name="search" type="search" value="{{ $search }}" placeholder="Cari nama, NIP, atau nomor HP..." class="w-full rounded-xl border border-[#17243f]/10 bg-white px-4 py-3 text-sm focus:border-[#17243f]/30 focus:outline-none">
                        </div>
                        <button type="submit" class="rounded-xl bg-black px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">Cari</button>
                        @if ($search)
                            <a href="{{ route('teachers.index') }}" class="rounded-xl bg-[#e5e7eb] px-5 py-3 text-sm font-semibold hover:bg-[#d1d5db]">Reset</a>
                        @endif
                    </div>
                </form>

                @if ($teachers->isEmpty())
                    <div class="rounded-2xl border border-dashed border-[#17243f]/15 bg-[#f3f4f6] p-8 text-center shadow-sm">
                        <h2 class="text-xl font-bold">{{ $search ? 'Tidak ada guru yang cocok' : 'Belum ada data guru' }}</h2>
                        <p class="mt-2 text-sm text-slate-500">{{ $search ? 'Coba gunakan kata kunci lain.' : 'Tambahkan guru pertama untuk mulai mengatur wali kelas.' }}</p>
                        <a href="{{ route('teachers.create') }}" class="mt-6 inline-flex rounded-full bg-black px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-800">+ Tambah Guru</a>
                    </div>
                @else
                    <div class="overflow-hidden rounded-2xl border border-[#17243f]/10 bg-[#f3f4f6] shadow-sm">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-[#17243f]/10">
                                <thead class="bg-[#e5e7eb]"><tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">NIP</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Nama</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Email Login</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Kelas Diampu</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Aksi</th>
                                </tr></thead>
                                <tbody class="divide-y divide-[#17243f]/10">
                                    @foreach ($teachers as $teacher)
                                        <tr class="hover:bg-white/60">
                                            <td class="px-4 py-3 text-sm">{{ $teacher->nip }}</td>
                                            <td class="px-4 py-3 text-sm font-medium">{{ $teacher->nama }}<div class="text-xs text-slate-500">{{ $teacher->no_hp ?: 'Nomor HP belum diisi' }}</div></td>
                                            <td class="px-4 py-3 text-sm">{{ $teacher->user?->email ?? '-' }}</td>
                                            <td class="px-4 py-3 text-sm">{{ $teacher->classes->pluck('nama_kelas')->join(', ') ?: 'Belum ditentukan' }}</td>
                                            <td class="px-4 py-3 text-right"><div class="flex justify-end gap-2">
                                                <a href="{{ route('teachers.edit', $teacher) }}" class="rounded-lg border border-amber-300 bg-amber-50 px-3 py-1.5 text-xs font-semibold text-[#17243f] hover:bg-amber-100">Edit</a>
                                                <x-delete
                                                    :action="route('teachers.destroy', $teacher)"
                                                    :name="$teacher->nama"
                                                    title="Hapus Data Guru?"
                                                    description="akan dihapus. Kelas yang diampu akan menjadi belum ditentukan."
                                                />
                                            </div></td>
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
</body>
</html>
