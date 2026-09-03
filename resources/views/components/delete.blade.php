@props([
    'action',
    'name',
    'title' => 'Hapus Item Ini?',
    'description' => 'akan dihapus permanen dan tidak bisa dikembalikan.',
])

@php
    $modalId = 'delete-modal-' . md5($action);
@endphp

<button
    type="button"
    onclick="document.getElementById('{{ $modalId }}').classList.remove('hidden'); document.getElementById('{{ $modalId }}').classList.add('flex')"
    class="rounded-lg border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-600 transition hover:bg-red-100"
>
    Hapus
</button>

<div id="{{ $modalId }}" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/40 p-4 backdrop-blur-sm">
    <div class="w-full max-w-sm overflow-hidden rounded-[1.5rem] bg-white shadow-xl">
        <form action="{{ $action }}" method="POST">
            @csrf
            @method('DELETE')

            <div class="p-6 text-center">
                <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-full border-[6px] border-white bg-rose-50 text-rose-600 shadow-sm shadow-rose-100">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 1.732 3z"/>
                    </svg>
                </div>

                <h3 class="mb-2 text-lg font-bold tracking-tight text-slate-900">{{ $title }}</h3>
                <p class="mb-8 text-sm leading-relaxed text-slate-500">
                    <span class="font-semibold text-slate-700">"{{ $name }}"</span> {{ $description }}
                </p>

                <div class="flex gap-3">
                    <button type="button" onclick="document.getElementById('{{ $modalId }}').classList.add('hidden'); document.getElementById('{{ $modalId }}').classList.remove('flex')" class="flex-1 rounded-xl bg-slate-100 px-4 py-3 text-sm font-semibold text-slate-700 transition-colors hover:bg-slate-200">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 rounded-xl bg-rose-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-rose-200 transition-all hover:bg-rose-700 active:scale-95">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('{{ $modalId }}').addEventListener('click', function (event) {
        if (event.target === this) {
            this.classList.add('hidden');
            this.classList.remove('flex');
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            document.getElementById('{{ $modalId }}').classList.add('hidden');
            document.getElementById('{{ $modalId }}').classList.remove('flex');
        }
    });
</script>
