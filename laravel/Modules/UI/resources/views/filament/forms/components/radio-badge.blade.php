<?php

declare(strict_types=1);

?>
@php
    $statePath = $getStatePath();
    $selected = $getState();
@endphp

<div class="flex flex-wrap gap-2">
    @foreach ($getOptions() as $value => $label)
        @php
            $isSelected = $value == $selected;
            $color = $isSelected ? $getColorForOption($value) : 'gray';
            $icon = $getIconForOption($value);
        @endphp
        <x-filament::button 
            icon="{{ $icon }}" 
            wire:click="$set('{{ $statePath }}', '{{ $value }}')"
            class="px-4 py-2 text-sm rounded-xl border font-medium transition
            {{ $isSelected ? 'text-white' : 'text-gray-700' }}
            {{ $isSelected ? 'bg-' . $color . '' : 'bg-gray-200' }}
            hover:opacity-80"
            >
                {{ $label }}
        </x-filament::button>

    @endforeach
</div>
