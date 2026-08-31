<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Siswa — SMK Wira Cipta Karya</title>

    {{-- Tailwind CSS CDN --}}
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

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-cream text-ink min-h-screen">

    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        @include('partials.sidebar')


        {{-- Main Content --}}
        <main class="flex-1 min-w-0 bg-cream">

            {{-- Header --}}
            <header class="bg-[#f3f4f6] border-b border-ink/10">

                <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between gap-4">

                    <div>

                        <p class="text-sm text-slate">
                            Manajemen
                        </p>

                        <h1 class="font-bold text-xl text-ink">
                            Data Siswa
                        </h1>

                    </div>


                    <a
                        href="{{ route('students.create') }}"
                        class="bg-black text-white px-4 py-2 rounded-full text-sm font-semibold hover:bg-slate-800 transition"
                    >
                        + Tambah Siswa
                    </a>

                </div>

            </header>


            {{-- Content --}}
            <div class="max-w-7xl mx-auto px-6 py-10">

                {{-- Success Message --}}
                @if (session('success'))

                    <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">

                        {{ session('success') }}

                    </div>

                @endif

                <form id="studentSearchForm" method="GET" action="{{ route('students.index') }}" class="mb-6 rounded-2xl border border-ink/10 bg-[#f3f4f6] p-4 shadow-sm">
                    <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
                        <div class="flex-1 min-w-0">
                            <label for="search" class="mb-2 block text-xs font-semibold uppercase tracking-[0.2em] text-slate">Cari siswa</label>
                            <input
                                id="search"
                                name="search"
                                type="search"
                                value="{{ $search ?? '' }}"
                                placeholder="Cari nama, NISN, atau kelas..."
                                class="w-full rounded-xl border border-ink/10 bg-white px-4 py-3 text-sm text-ink placeholder:text-slate-400 focus:border-ink/30 focus:outline-none"
                            >
                        </div>

                        <div class="flex shrink-0 items-center gap-2 md:self-auto">
                            <button type="submit" class="rounded-xl bg-black px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800 transition">
                                Cari
                            </button>

                            @if ($search)
                                <a href="{{ route('students.index') }}" class="rounded-xl bg-[#e5e7eb] px-5 py-3 text-sm font-semibold text-ink hover:bg-[#d1d5db] transition">
                                    Reset
                                </a>
                            @endif
                        </div>
                    </div>
                </form>


                {{-- Empty Data --}}
                @if ($students->isEmpty())

                    <div class="rounded-2xl border border-dashed border-ink/15 bg-[#f3f4f6] p-8 text-center shadow-sm">

                        <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-navy/5 text-3xl">
                            👥
                        </div>


                        <h2 class="text-xl font-bold text-ink">
                            @if ($search)
                                Tidak ada siswa yang cocok dengan pencarian
                            @else
                                Belum ada data siswa
                            @endif
                        </h2>


                        <p class="mt-2 text-sm text-slate">
                            @if ($search)
                                Coba cari dengan nama, NISN, atau kelas lain.
                            @else
                                Mulai dengan menambahkan data siswa pertama di sekolah ini.
                            @endif
                        </p>


                        <div class="mt-6 flex justify-center gap-3">
                            <a
                                href="{{ route('students.create') }}"
                                class="inline-flex rounded-full bg-black px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-slate-800 transition"
                            >
                                + Tambah Siswa
                            </a>

                            @if ($search)
                                <a
                                    href="{{ route('students.index') }}"
                                    class="inline-flex rounded-full bg-[#e5e7eb] px-5 py-2.5 text-sm font-semibold text-ink shadow-sm hover:bg-[#d1d5db] transition"
                                >
                                    Reset Pencarian
                                </a>
                            @endif
                        </div>

                    </div>


                {{-- Table --}}
                @else

                    <div class="overflow-hidden rounded-2xl border border-ink/10 bg-[#f3f4f6] shadow-sm">

                        <div class="overflow-x-auto">

                            <table class="min-w-full divide-y divide-ink/10">

                                <thead class="bg-[#e5e7eb]">

                                    <tr>

                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate">
                                            NISN
                                        </th>

                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate">
                                            Nama
                                        </th>

                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate">
                                            Kelas
                                        </th>

                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate">
                                            Jenis Kelamin
                                        </th>

                                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate">
                                            Aksi
                                        </th>

                                    </tr>

                                </thead>


                                <tbody class="divide-y divide-ink/10">

                                    @foreach ($students as $student)

                                        <tr class="hover:bg-white/60 transition">

                                            <td class="px-4 py-3 text-sm text-ink">
                                                {{ $student->nisn }}
                                            </td>

                                            <td class="px-4 py-3 text-sm text-ink font-medium">
                                                {{ $student->nama }}
                                            </td>

                                            <td class="px-4 py-3 text-sm text-ink">
                                                {{ $student->classRoom->nama_kelas ?? '-' }}
                                            </td>

                                            <td class="px-4 py-3 text-sm text-ink">
                                                {{ $student->jenis_kelamin }}
                                            </td>

                                            <td class="px-4 py-3 text-right">

                                                <div class="flex justify-end gap-2">

                                                    {{-- Edit --}}
                                                    <a
                                                        href="{{ route('students.edit', $student) }}"
                                                        class="rounded-lg border border-amber/50 bg-amber/10 px-3 py-1.5 text-xs font-semibold text-navy hover:bg-amber/20 transition"
                                                    >
                                                        Edit
                                                    </a>


                                                    {{-- Delete --}}
                                                    <button
                                                        type="button"
                                                        onclick="openDeleteModal(
                                                            '{{ route('students.destroy', $student) }}',
                                                            '{{ addslashes($student->nama) }}'
                                                        )"
                                                        class="rounded-lg border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-100 transition"
                                                    >
                                                        Hapus
                                                    </button>

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


    {{-- Delete Modal --}}
    <div
        id="deleteModal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4"
    >

        <div class="bg-white rounded-[1.5rem] shadow-xl w-full max-w-sm overflow-hidden">

            <form
                id="deleteForm"
                action=""
                method="POST"
            >

                @csrf

                @method('DELETE')


                <div class="p-6 text-center">

                    <div
                        class="w-16 h-16 mx-auto bg-rose-50 text-rose-600 rounded-full flex items-center justify-center mb-5 border-[6px] border-white shadow-sm shadow-rose-100"
                    >

                        <svg
                            class="w-7 h-7"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                            />

                        </svg>

                    </div>


                    <h3 class="text-lg font-bold text-slate-900 tracking-tight mb-2">
                        Hapus Item Ini?
                    </h3>


                    <p class="text-sm text-slate-500 leading-relaxed mb-8">

                        <span
                            id="modal-item-name"
                            class="font-semibold text-slate-700"
                        ></span>

                        akan dihapus permanen dan tidak bisa dikembalikan.

                    </p>


                    <div class="flex gap-3">

                        <button
                            type="button"
                            onclick="closeDeleteModal()"
                            class="flex-1 px-4 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl transition-colors"
                        >
                            Batal
                        </button>


                        <button
                            type="submit"
                            class="flex-1 px-4 py-3 bg-rose-600 hover:bg-rose-700 text-white text-sm font-semibold rounded-xl transition-all active:scale-95 shadow-lg shadow-rose-200"
                        >
                            Ya, Hapus
                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- JavaScript --}}
    <script>

        function openDeleteModal(action, name) {

            document.getElementById('deleteForm').action = action;

            document.getElementById('modal-item-name').textContent = '"' + name + '"';

            document.getElementById('deleteModal').classList.remove('hidden');

        }


        function closeDeleteModal() {

            document.getElementById('deleteModal').classList.add('hidden');

        }


        // Tutup modal ketika klik area luar
        document.getElementById('deleteModal').addEventListener('click', function (event) {

            if (event.target === this) {

                closeDeleteModal();

            }

        });


        // Tutup modal dengan tombol Escape
        document.addEventListener('keydown', function (event) {

            if (event.key === 'Escape') {

                closeDeleteModal();

            }

        });

        const studentSearchForm = document.getElementById('studentSearchForm');
        const studentSearchInput = document.getElementById('search');

        if (studentSearchForm && studentSearchInput) {
            let searchTimer = null;

            studentSearchInput.addEventListener('input', function () {
                clearTimeout(searchTimer);

                searchTimer = setTimeout(function () {
                    studentSearchForm.requestSubmit();
                }, 300);
            });
        }

    </script>

</body>

</html>