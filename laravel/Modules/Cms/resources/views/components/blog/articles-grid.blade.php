@props([
    'title' => 'Tutti gli Articoli',
    'subtitle' => '',
    'layout' => 'grid',
    'columns' => 3,
    'show_pagination' => true,
    'articles_per_page' => 12,
    'articles' => [],
])

@php
    $categoryColors = [
        'Radioprotezione' => 'blue',
        'Radiation Protection' => 'blue',
        'Normativa' => 'green',
        'Regulations' => 'green',
        'Elettromedicali' => 'orange',
        'Electromedical' => 'orange',
        'Veterinaria' => 'purple',
        'Veterinary' => 'purple',
        'Guide Pratiche' => 'teal',
        'Practical Guides' => 'teal',
        'Formazione' => 'red',
        'Training' => 'red',
    ];
    
    $gridCols = match($columns) {
        2 => 'md:grid-cols-2',
        3 => 'md:grid-cols-2 lg:grid-cols-3',
        4 => 'md:grid-cols-2 lg:grid-cols-4',
        default => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3',
    };
@endphp

<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ $title }}</h2>
            @if(!empty($subtitle))
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">{{ $subtitle }}</p>
            @endif
        </div>

        <div class="grid grid-cols-1 {{ $gridCols }} gap-8">
            @foreach($articles as $article)
                @php
                    $category = $article['category'] ?? 'General';
                    $colorKey = $categoryColors[$category] ?? 'blue';
                    $badgeColor = match($colorKey) {
                        'blue' => 'bg-blue-100 text-blue-700',
                        'green' => 'bg-green-100 text-green-700',
                        'orange' => 'bg-orange-100 text-orange-700',
                        'purple' => 'bg-purple-100 text-purple-700',
                        'teal' => 'bg-teal-100 text-teal-700',
                        'red' => 'bg-red-100 text-red-700',
                        'indigo' => 'bg-indigo-100 text-indigo-700',
                        default => 'bg-blue-100 text-blue-700',
                    };
                    $borderColor = match($colorKey) {
                        'blue' => 'group-hover:border-[#1E5A96]',
                        'green' => 'group-hover:border-[#2D8659]',
                        'orange' => 'group-hover:border-[#E67E22]',
                        'purple' => 'group-hover:border-purple-600',
                        'teal' => 'group-hover:border-teal-600',
                        'red' => 'group-hover:border-red-600',
                        'indigo' => 'group-hover:border-indigo-600',
                        default => 'group-hover:border-[#1E5A96]',
                    };
                @php
                
                <article class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 border-2 border-gray-100 {{ $borderColor }} group">
                    @if(!empty($article['image']))
                        <div class="relative aspect-[16/10] overflow-hidden">
                            <img 
                                src="{{ $article['image'] }}" 
                                alt="{{ $article['title'] }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                loading="lazy"
                            >
                            @if(!empty($article['category']))
                                <span class="absolute top-4 left-4 inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $badgeColor }}">
                                    {{ $article['category'] }}
                                </span>
                            @endif
                        </div>
                    @endif
                    
                    <div class="p-6">
                        @if(!empty($article['title']))
                            <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-[#1E5A96] transition-colors">
                                <a href="{{ $article['url'] ?? '#' }}">
                                    {{ $article['title'] }}
                                </a>
                            </h3>
                        @endif
                        
                        @if(!empty($article['excerpt']))
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3 leading-relaxed">
                                {{ $article['excerpt'] }}
                            </p>
                        @endif
                        
                        <div class="flex flex-wrap items-center gap-4 text-xs text-gray-500 pt-4 border-t border-gray-100">
                            @if(!empty($article['date']))
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <rect width="18" height="18" x="3" y="4" rx="2" ry="2"></rect>
                                        <line x1="16" x2="16" y1="2" y2="6"></line>
                                        <line x1="8" x2="8" y1="2" y2="6"></line>
                                        <line x1="3" x2="21" y1="10" y2="10"></line>
                                    </svg>
                                    {{ $article['date'] }}
                                </span>
                            @endif
                            
                            @if(!empty($article['reading_time']))
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polyline points="12,6 12,12 16,14"></polyline>
                                    </svg>
                                    {{ $article['reading_time'] }}
                                </span>
                            @endif
                            
                            @if(isset($article['views_count']))
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 4 8 11 8 11-4 8-11 8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                    {{ $article['views_count'] }}
                                </span>
                            @endif
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
        
        @if($show_pagination)
            <div class="mt-12 flex justify-center">
                <nav class="flex items-center space-x-2">
                    <a href="#" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 disabled:opacity-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </a>
                    <a href="#" class="px-4 py-2 rounded-lg bg-[#1E5A96] text-white">1</a>
                    <a href="#" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50">2</a>
                    <a href="#" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50">3</a>
                    <span class="px-4 py-2 text-gray-500">...</span>
                    <a href="#" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </nav>
            </div>
        @endif
    </div>
</section>