@props([
    'title' => 'Esplora per Categoria',
    'subtitle' => 'Filtra gli articoli per area di interesse',
    'style' => 'pills',
    'show_descriptions' => true,
    'categories' => [],
])

@php
    $colorClasses = [
        'blue' => [
            'bg' => 'bg-blue-50',
            'text' => 'text-blue-700',
            'border' => 'border-blue-200',
            'hover-bg' => 'hover:bg-blue-100',
        ],
        'green' => [
            'bg' => 'bg-green-50',
            'text' => 'text-green-700',
            'border' => 'border-green-200',
            'hover-bg' => 'hover:bg-green-100',
        ],
        'orange' => [
            'bg' => 'bg-orange-50',
            'text' => 'text-orange-700',
            'border' => 'border-orange-200',
            'hover-bg' => 'hover:bg-orange-100',
        ],
        'teal' => [
            'bg' => 'bg-teal-50',
            'text' => 'text-teal-700',
            'border' => 'border-teal-200',
            'hover-bg' => 'hover:bg-teal-100',
        ],
        'purple' => [
            'bg' => 'bg-purple-50',
            'text' => 'text-purple-700',
            'border' => 'border-purple-200',
            'hover-bg' => 'hover:bg-purple-100',
        ],
        'indigo' => [
            'bg' => 'bg-indigo-50',
            'text' => 'text-indigo-700',
            'border' => 'border-indigo-200',
            'hover-bg' => 'hover:bg-indigo-100',
        ],
    ];
@endphp

<section class="py-12 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-gray-900 mb-3">{{ $title }}</h2>
            @if(!empty($subtitle))
                <p class="text-lg text-gray-600">{{ $subtitle }}</p>
            @endif
        </div>
        
        @if($style === 'pills')
            <div class="flex flex-wrap justify-center gap-3">
                <a 
                    href="{{ request()->path() }}" 
                    class="inline-flex flex-col items-center px-6 py-4 bg-gray-50 border-2 border-gray-200 rounded-2xl hover:border-[#1E5A96] hover:bg-[#1E5A96]/5 transition-all group"
                >
                    <span class="text-lg font-semibold text-gray-700 group-hover:text-[#1E5A96]">Tutti</span>
                    <span class="text-xs text-gray-500">Tutti gli articoli</span>
                </a>
                
                @foreach($categories as $category)
                    @php
                        $color = $colorClasses[$category['color']] ?? $colorClasses['blue'];
                    @endphp
                    <a 
                        href="{{ request()->path() }}?category={{ $category['slug'] }}" 
                        class="inline-flex flex-col items-center px-6 py-4 {{ $color['bg'] }} border-2 {{ $color['border'] }} rounded-2xl {{ $color['hover-bg'] }} transition-all group"
                    >
                        <span class="text-lg font-semibold {{ $color['text'] }} group-hover:text-gray-900">{{ $category['name'] }}</span>
                        <span class="text-xs text-gray-500">{{ $category['count'] }} articoli</span>
                    </a>
                @endforeach
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <a 
                    href="{{ request()->path() }}" 
                    class="flex items-center justify-between p-4 bg-gray-50 border-2 border-gray-200 rounded-xl hover:border-[#1E5A96] hover:bg-[#1E5A96]/5 transition-all group"
                >
                    <div>
                        <span class="text-lg font-semibold text-gray-700 group-hover:text-[#1E5A96]">Tutti</span>
                        <span class="text-sm text-gray-500">Tutti gli articoli</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 group-hover:text-[#1E5A96]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
                
                @foreach($categories as $category)
                    @php
                        $color = $colorClasses[$category['color']] ?? $colorClasses['blue'];
                    @endphp
                    <a 
                        href="{{ request()->path() }}?category={{ $category['slug'] }}" 
                        class="flex items-center justify-between p-4 {{ $color['bg'] }} border-2 {{ $color['border'] }} rounded-xl {{ $color['hover-bg'] }} transition-all group"
                    >
                        <div>
                            <span class="text-lg font-semibold {{ $color['text'] }} group-hover:text-gray-900">{{ $category['name'] }}</span>
                            @if($show_descriptions)
                                <span class="text-sm text-gray-600">{{ $category['description'] }}</span>
                            @endif
                        </div>
                        <span class="text-xs font-semibold {{ $color['text'] }}">{{ $category['count'] }}</span>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>