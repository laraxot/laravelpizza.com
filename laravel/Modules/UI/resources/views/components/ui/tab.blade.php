@props([
    'tabs' => [],
    'activeTab' => 0,
    'variant' => 'default', // default, pills, underline
    'justify' => 'start', // start, center, end
])

@php
    $variants = [
        'default' => 'border-b border-gray-200',
        'pills' => 'bg-gray-100 p-1 rounded-lg',
        'underline' => 'border-b border-gray-200',
    ];
    
    $justifyClasses = [
        'start' => 'justify-start',
        'center' => 'justify-center',
        'end' => 'justify-end',
    ];
    
    $variantClass = $variants[$variant] ?? $variants['default'];
    $justifyClass = $justifyClasses[$justify] ?? $justifyClasses['start'];
@endphp

<div class="ui-tabs" x-data="{ activeTab: {{ $activeTab }} }">
    <!-- Tab Headers -->
    <div class="flex {{ $variantClass }} {{ $justifyClass }} space-x-1">
        @foreach($tabs as $index => $tab)
            <button
                type="button"
                @click="activeTab = {{ $index }}"
                class="px-4 py-2 text-sm font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500 rounded-lg"
                :class="{
                    '{{ $variant === 'pills' ? 'bg-white text-gray-900 shadow' : 'text-primary-600 border-b-2 border-primary-600' }}': activeTab === {{ $index }},
                    '{{ $variant === 'pills' ? 'text-gray-600 hover:text-gray-900' : 'text-gray-600 hover:text-gray-900 border-b-2 border-transparent' }}': activeTab !== {{ $index }}
                }"
                aria-selected="{{ $index === $activeTab ? 'true' : 'false' }}"
                role="tab"
            >
                @if(isset($tab['icon']))
                    <span class="inline-flex items-center">
                        {{ $tab['icon'] }}
                        <span class="ml-2">{{ $tab['label'] ?? '' }}</span>
                    </span>
                @else
                    {{ $tab['label'] ?? '' }}
                @endif
            </button>
        @endforeach
    </div>
    
    <!-- Tab Content -->
    <div class="mt-6">
        @foreach($tabs as $index => $tab)
            <div 
                x-show="activeTab === {{ $index }}"
                class="tab-content"
                role="tabpanel"
                style="display: none;"
            >
                @if(isset($tab['content']))
                    {{ $tab['content'] }}
                @elseif(isset($tab['view']))
                    @include($tab['view'], $tab['data'] ?? [])
                @endif
            </div>
        @endforeach
    </div>
</div>

<style>
.ui-tabs button:focus-visible {
    outline: 2px solid theme('colors.primary.500');
    outline-offset: 2px;
}

@media (max-width: 768px) {
    .ui-tabs .flex {
        flex-wrap: wrap;
    }
    
    .ui-tabs button {
        flex: 1 0 auto;
        min-width: 120px;
    }
}
</style>
