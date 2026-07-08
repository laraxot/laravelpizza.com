@props([
    'id' => null,
    'name' => 'toggle',
    'label' => '',
    'checked' => false,
    'disabled' => false,
    'wire:model' => null,
    'onChange' => null,
])

@php
    $uniqueId = $id ?? 'toggle-' . uniqid();
    $wireModel = $wireModel ?? $name;
@endphp

<div class="ui-toggle">
    @if($label)
        <label for="{{ $uniqueId }}" class="block text-sm font-medium text-gray-700 mb-2">
            {{ $label }}
        </label>
    @endif
    
    <div class="relative inline-flex items-center">
        <input
            type="checkbox"
            id="{{ $uniqueId }}"
            name="{{ $name }}"
            {{ $wireModel ? 'wire:model="' . $wireModel . '"' : '' }}
            {{ $checked ? 'checked' : '' }}
            {{ $disabled ? 'disabled' : '' }}
            {{ $onChange ? 'onchange="' . $onChange . '"' : '' }}
            class="peer sr-only"
        >
        
        <label 
            for="{{ $uniqueId }}"
            class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-200 ease-in-out
                {{ $disabled 
                    ? 'bg-gray-300 cursor-not-allowed' 
                    : 'bg-gray-200 peer-checked:bg-primary-600 cursor-pointer' }}"
        >
            <span 
                class="inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out
                    {{ $checked 
                        ? 'translate-x-6' 
                        : 'translate-x-1' }}
                {{ $disabled 
                    ? 'bg-gray-400' 
                    : '' }}"
            ></span>
        </label>
    </div>
</div>

<style>
.ui-toggle input:focus + label {
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
}

.ui-toggle input:focus:not(:focus-visible) + label {
    box-shadow: none;
}
</style>