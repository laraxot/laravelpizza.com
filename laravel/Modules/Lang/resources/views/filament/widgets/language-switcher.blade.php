<?php

declare(strict_types=1);
?>
{{-- Chrome FO: Alpine + href URL localizzato. Icone ui-flags.{code}. --}}
<div x-data="{ open: false }">
    <button
        @click="open = !open"
        @click.away="open = false"
        data-dropdown-toggle="dropdown-language"
        class="grid py-3 text-sm font-semibold transition rounded-lg place-items-center hover:bg-gray-100"
    >
        <div class="flex items-center space-x-1">
            <x-filament::icon icon="ui-flags.{{ $lang }}" class="w-7 h-7" />
            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
    </button>
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        id="dropdown-language"
        class="absolute z-[45] p-2 overflow-hidden text-sm border border-white rounded-lg bg-gray-50/85 backdrop-blur w-[240px] max-w-sm"
    >
        <ul>
            @foreach ($langs as $localeCode => $properties)
                <li>
                    <a
                        rel="alternate"
                        hreflang="{{ $localeCode }}"
                        href="{{ $properties['url'] }}"
                        class="flex items-center w-full px-2 py-3 space-x-2 transition rounded hover:bg-white"
                    >
                        <x-filament::icon icon="ui-flags.{{ $localeCode }}" class="size-5" />
                        <div>{{ $properties['native'] }}</div>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
