@props([
    'title' => 'Articoli in Evidenza',
    'subtitle' => '',
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
    ];
@endphp

<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ $title }}</h2>
            @if(!empty($subtitle))
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">{{ $subtitle }}</p>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @foreach($articles as $index => $article)
                @php
                    $isFeatured = $index === 0;
                    $category = $article['category'] ?? 'General';
                    $colorKey = $categoryColors[$category] ?? 'blue';
                    $colorClass = match($colorKey) {
                        'blue' => 'bg-blue-600',
                        'green' => 'bg-green-600',
                        'orange' => 'bg-orange-600',
                        'purple' => 'bg-purple-600',
                        'teal' => 'bg-teal-600',
                        'indigo' => 'bg-indigo-600',
                        default => 'bg-blue-600',
                    };
                @endphp
                
                <article class="group {{ $isFeatured ? 'lg:col-span-2' : '' }}">
                    @if(!empty($article['image']))
                        <div class="relative overflow-hidden rounded-2xl {{ $isFeatured ? 'aspect-[16/9]' : 'aspect-[4/3]' }} mb-6">
                            <img 
                                src="{{ $article['image'] }}" 
                                alt="{{ $article['title'] }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                loading="lazy"
                            >
                            @if(!empty($article['category']))
                                <span class="absolute top-4 left-4 inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold text-white {{ $colorClass }}">
                                    {{ $article['category'] }}
                                </span>
                            @endif
                            @if($article['trending'] ?? false)
                                <span class="absolute top-4 right-4 flex items-center px-3 py-1 bg-yellow-400 text-yellow-900 rounded-full text-xs font-bold">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13.728 1.686a.75.75 0 0 1 1.06 0l8.691 8.691a1 1 0 0 1 0 1.414l-8.69 8.691a.75.75 0 0 1-1.061-1.06l7.47-7.47a.75.75 0 0 0 0-1.06l-7.47 7.47a.75.75 0 0 1-1.06-1.06l8.69-8.691a.75.75 0 0 1 1.06 0z"></path>
                                    </svg>
                                    Trending
                                </span>
                            @endif
                        </div>
                    @endif
                    
                    <div class="space-y-3">
                        @if(!empty($article['title']))
                            <h3 class="text-2xl font-bold text-gray-900 leading-tight group-hover:text-[#1E5A96] transition-colors">
                                <a href="{{ $article['url'] ?? '#' }}">
                                    {{ $article['title'] }}
                                </a>
                            </h3>
                        @endif
                        
                        @if(!empty($article['excerpt']))
                            <p class="text-gray-600 {{ $isFeatured ? 'text-lg' : 'text-base' }} line-clamp-3">
                                {{ $article['excerpt'] }}
                            </p>
                        @endif
                        
                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 pt-3">
                            @if(!empty($article['author']))
                                <div class="flex items-center">
                                    @if(!empty($article['author_avatar']))
                                        <img 
                                            src="{{ $article['author_avatar'] }}" 
                                            alt="{{ $article['author'] }}"
                                            class="w-8 h-8 rounded-full mr-2"
                                            loading="lazy"
                                        >
                                    @endif
                                    <div>
                                        <span class="font-medium text-gray-900">{{ $article['author'] }}</span>
                                        @if(!empty($article['author_role']))
                                            <span class="block text-xs">{{ $article['author_role'] }}</span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            
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
                        </div>
                        
                        <a 
                            href="{{ $article['url'] ?? '#' }}" 
                            class="inline-flex items-center text-[#1E5A96] hover:text-[#164575] font-semibold group-hover:translate-x-1 transition-all mt-4"
                        >
                            Leggi l'articolo
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>