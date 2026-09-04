@props([
    'action',
    'title' => 'Konfirmasi Aksi',
    'message' => 'Apakah kamu yakin ingin melanjutkan aksi ini?',
    'confirmText' => 'Ya, Lanjutkan',
    'buttonText' => 'Lanjutkan',
    'method' => 'POST',
    'formId' => null,
    'confirmAction' => null,
])

@php
    $modalId = 'confirm-modal-' . md5($action . $title . $message);
@endphp

<button
    type="button"
    onclick="document.getElementById('{{ $modalId }}').classList.remove('hidden'); document.getElementById('{{ $modalId }}').classList.add('flex')"
    class="rounded-xl bg-black px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800"
>
    {{ $buttonText }}
</button>

<div id="{{ $modalId }}" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/40 p-4 backdrop-blur-sm">
    <div class="w-full max-w-sm overflow-hidden rounded-[1.5rem] bg-white shadow-xl">
        @if ($formId || $confirmAction)
            <div class="p-6 text-center">
                <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-full border-[6px] border-white bg-amber-50 text-amber-600 shadow-sm shadow-amber-100">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v3.75m0 3h.008M10.34 3.94 2.87 17a1.9 1.9 0 0 0 1.65 2.85h14.96A1.9 1.9 0 0 0 21.13 17L13.66 3.94a1.9 1.9 0 0 0-3.32 0Z" />
                    </svg>
                </div>

                <h3 class="mb-2 text-lg font-bold tracking-tight text-slate-900">{{ $title }}</h3>
                <p class="mb-8 text-sm leading-relaxed text-slate-500">{{ $message }}</p>

                <div class="flex gap-3">
                    <button type="button" onclick="document.getElementById('{{ $modalId }}').classList.add('hidden'); document.getElementById('{{ $modalId }}').classList.remove('flex')" class="flex-1 rounded-xl bg-slate-100 px-4 py-3 text-sm font-semibold text-slate-700 transition-colors hover:bg-slate-200">
                        Batal
                    </button>
                    <button type="{{ $confirmAction ? 'button' : 'submit' }}" @if ($confirmAction) onclick="document.getElementById('{{ $modalId }}').classList.add('hidden'); document.getElementById('{{ $modalId }}').classList.remove('flex'); {{ $confirmAction }}" @else form="{{ $formId }}" @endif class="flex-1 rounded-xl bg-emerald-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-200 transition-all hover:bg-emerald-700 active:scale-95">
                        {{ $confirmText }}
                    </button>
                </div>
            </div>
        @else
            <form action="{{ $action }}" method="POST">
                @csrf
                @if ($method !== 'POST')
                    @method($method)
                @endif
                <div class="p-6 text-center">
                    <h3 class="mb-2 text-lg font-bold tracking-tight text-slate-900">{{ $title }}</h3>
                    <p class="mb-8 text-sm leading-relaxed text-slate-500">{{ $message }}</p>
                    <div class="flex gap-3">
                        <button type="button" onclick="document.getElementById('{{ $modalId }}').classList.add('hidden'); document.getElementById('{{ $modalId }}').classList.remove('flex')" class="flex-1 rounded-xl bg-slate-100 px-4 py-3 text-sm font-semibold text-slate-700 transition-colors hover:bg-slate-200">Batal</button>
                        <button type="submit" class="flex-1 rounded-xl bg-emerald-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-200 transition-all hover:bg-emerald-700 active:scale-95">{{ $confirmText }}</button>
                    </div>
                </div>
            </form>
        @endif
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
