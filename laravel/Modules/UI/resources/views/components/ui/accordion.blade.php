@props([
    'items' => [],
    'allowMultiple' => false,
    'defaultOpen' => null,
])

<div class="ui-accordion space-y-2">
    @foreach($items as $index => $item)
        <div class="accordion-item border border-gray-200 rounded-lg overflow-hidden">
            <!-- Accordion Header -->
            <button
                type="button"
                @click="$wire.toggleAccordion({{ $index }})"
                class="w-full px-6 py-4 flex items-center justify-between text-left focus:outline-none focus:ring-2 focus:ring-primary-500 bg-white hover:bg-gray-50 transition-colors"
                aria-expanded="{{ $item['open'] ?? false }}"
            >
                <span class="font-medium text-gray-900">
                    {{ $item['title'] ?? '' }}
                </span>
                
                <svg 
                    class="w-5 h-5 text-gray-500 transition-transform duration-200 
                        {{ ($item['open'] ?? false) ? 'rotate-180' : '' }}"
                    fill="none" 
                    stroke="currentColor" 
                    viewBox="0 0 24 24"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            
            <!-- Accordion Content -->
            <div 
                class="accordion-content overflow-hidden transition-all duration-300
                    {{ ($item['open'] ?? false) ? 'max-h-screen opacity-100' : 'max-h-0 opacity-0' }}"
            >
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    {{ $item['content'] ?? '' }}
                </div>
            </div>
        </div>
    @endforeach
</div>