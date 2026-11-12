{{-- Campo di un form di autenticazione (scheda scura): etichetta, input Livewire, errore collegato con aria-describedby. --}}
@props(['label', 'id', 'type' => 'text', 'autocomplete' => null, 'autofocus' => false])

@php $model = $attributes->wire('model')->value(); @endphp

<div>
    <label for="{{ $id }}" class="mb-1.5 block text-sm font-medium text-slate-200">{{ $label }}</label>
    <input
        {{ $attributes->whereStartsWith('wire:model') }}
        id="{{ $id }}"
        name="{{ $id }}"
        type="{{ $type }}"
        @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
        @if($autofocus) autofocus @endif
        required
        @error($model) aria-invalid="true" aria-describedby="{{ $id }}-error" @enderror
        class="block w-full rounded-xl border border-slate-600 bg-slate-900/60 px-4 py-3 text-white placeholder-slate-500 transition focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/40 @error($model) border-red-500 @enderror"
    />
    @error($model)
        <p id="{{ $id }}-error" class="mt-2 text-sm text-red-400">{{ $message }}</p>
    @enderror
</div>
