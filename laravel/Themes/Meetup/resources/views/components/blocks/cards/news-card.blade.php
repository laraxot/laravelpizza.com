{{--
/**
 * News Card Component
 * 
 * Componente per la visualizzazione di card di notizie.
 * Conforme alle linee guida AGID e accessibilità.
 * 
 * @package Themes\Sixteen
 * @author Marco Xot <marco.sottana@gmail.com>
 * @version 1.0.0
 */
--}}

@props([
    'title' => '',
    'excerpt' => '',
    'image' => null,
    'url' => '#',
    'date' => null,
    'category' => null,
    'author' => null,
    'featured' => false,
    'size' => 'default' // default, large, small
])

@php
    $sizeClasses = [
        'small' => 'max-w-sm',
        'default' => 'max-w-md',
        'large' => 'max-w-lg'
    ];
    
    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['default'];
    
    $featuredClass = $featured ? 'ring-2 ring-blue-500 shadow-lg' : '';
@endphp

<article 
    class="news-card bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 {{ $sizeClass }} {{ $featuredClass }}"
    data-news-card
>
    @if($image)
        <div class="news-card-image relative overflow-hidden rounded-t-lg">
            <img 
                src="{{ $image }}" 
                alt="{{ $title }}"
                class="w-full h-48 object-cover transition-transform duration-300 hover:scale-105"
                loading="lazy"
            />
            @if($featured)
                <div class="absolute top-2 left-2">
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-600 text-white">
                        In evidenza
                    </span>
                </div>
            @endif
            @if($category)
                <div class="absolute top-2 right-2">
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-800 text-white">
                        {{ $category }}
                    </span>
                </div>
            @endif
        </div>
    @endif
    
    <div class="news-card-content p-6">
        @if($date)
            <time 
                class="text-sm text-gray-500 mb-2 block"
                datetime="{{ $date->format('Y-m-d') }}"
            >
                {{ $date->format('d/m/Y') }}
            </time>
        @endif
        
        <h3 class="news-card-title text-xl font-semibold text-gray-900 mb-3 line-clamp-2">
            <a 
                href="{{ $url }}" 
                class="hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded"
                aria-label="Leggi l'articolo: {{ $title }}"
            >
                {{ $title }}
            </a>
        </h3>
        
        @if($excerpt)
            <p class="news-card-excerpt text-gray-600 mb-4 line-clamp-3">
                {{ $excerpt }}
            </p>
        @endif
        
        <div class="news-card-footer flex items-center justify-between">
            <div class="news-card-meta flex items-center space-x-4 text-sm text-gray-500">
                @if($author)
                    <span class="flex items-center">
                        <x-heroicon-o-user class="w-4 h-4 mr-1" />
                        {{ $author }}
                    </span>
                @endif
            </div>
            
            <a 
                href="{{ $url }}" 
                class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded"
                aria-label="Leggi l'articolo completo: {{ $title }}"
            >
                Leggi tutto
                <x-heroicon-o-arrow-right class="w-4 h-4 ml-1" />
            </a>
        </div>
    </div>
</article>

@push('styles')
<style>
/* Stili per news card */
.news-card {
    transition: all 0.3s ease;
}

.news-card:hover {
    transform: translateY(-2px);
}

.news-card-title a {
    text-decoration: none;
}

.news-card-title a:hover {
    text-decoration: underline;
}

/* Line clamp per limitare le righe di testo */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Stili per alto contrasto */
.high-contrast .news-card {
    border: 2px solid #fff !important;
    background-color: #000 !important;
    color: #fff !important;
}

.high-contrast .news-card-title a {
    color: #ffff00 !important;
}

.high-contrast .news-card-title a:hover {
    background-color: #ffff00 !important;
    color: #000 !important;
}

.high-contrast .news-card-excerpt {
    color: #cccccc !important;
}

/* Responsive */
@media (max-width: 640px) {
    .news-card {
        margin-bottom: 1rem;
    }
    
    .news-card-content {
        padding: 1rem;
    }
    
    .news-card-title {
        font-size: 1.125rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Aggiungi supporto per navigazione da tastiera
    const newsCards = document.querySelectorAll('[data-news-card]');
    
    newsCards.forEach(card => {
        const links = card.querySelectorAll('a');
        
        links.forEach(link => {
            link.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    this.click();
                }
            });
        });
    });
    
    // Lazy loading per immagini
    const images = document.querySelectorAll('.news-card-image img[loading="lazy"]');
    
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.src;
                    img.classList.remove('lazy');
                    observer.unobserve(img);
                }
            });
        });
        
        images.forEach(img => imageObserver.observe(img));
    }
});
</script>
@endpush
