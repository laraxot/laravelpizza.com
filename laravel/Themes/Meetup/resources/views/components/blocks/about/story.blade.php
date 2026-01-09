{{--
/**
 * About Story Block - Laravel Pizza Theme
 *
 * Sezione storia/testo con immagine per pagina About.
 *
 * @var string $title Titolo della sezione
 * @var string $content Contenuto testuale
 * @var string $image URL immagine (opzionale)
 * @var string $image_alt Testo alternativo immagine
 */
--}}

<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            {{-- Content --}}
            <div class="order-2 lg:order-1">
                @if(isset($title) && $title)
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                        {{ $title }}
                    </h2>
                @endif

                @if(isset($content) && $content)
                    <div class="prose prose-lg max-w-none text-gray-700">
                        @php
                            // Convert newlines to paragraphs
                            $paragraphs = explode("\n\n", $content);
                        @endphp
                        @foreach($paragraphs as $paragraph)
                            @if(trim($paragraph))
                                <p class="mb-4 leading-relaxed">
                                    {{ trim($paragraph) }}
                                </p>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Image --}}
            <div class="order-1 lg:order-2">
                @if(isset($image) && $image)
                    <div class="relative rounded-xl overflow-hidden shadow-2xl">
                        <img 
                            src="{{ $image }}" 
                            alt="{{ $image_alt ?? $title ?? 'About us' }}"
                            class="w-full h-auto object-cover"
                            loading="lazy"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                    </div>
                @else
                    {{-- Placeholder --}}
                    <div class="relative rounded-xl overflow-hidden shadow-2xl bg-gradient-to-br from-red-500 to-red-700 aspect-[4/3] flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-24 h-24 text-white opacity-50">
                            <path d="M15 11h.01"></path>
                            <path d="M11 15h.01"></path>
                            <path d="M16 16h.01"></path>
                            <path d="m2 16 20 6-6-20A20 20 0 0 0 2 16"></path>
                            <path d="M5.71 17.11a17.04 17.04 0 0 1 11.4-11.4"></path>
                        </svg>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
