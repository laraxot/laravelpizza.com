{{--
/**
 * Hero Section Block - Theme Sixteen
 *
 * Blocco hero principale per homepage e landing page.
 *
 * @var array $title Titolo principale
 * @var array $subtitle Sottotitolo
 * @var array $description Descrizione
 * @var array $background_image Immagine di sfondo (opzionale)
 * @var array $cta_primary Pulsante CTA primario
 * @var array $cta_secondary Pulsante CTA secondario (opzionale)
 */
--}}

<section class="relative bg-gradient-to-r from-blue-600 to-blue-800 text-white overflow-hidden">
    {{-- Background Image Overlay --}}
    @if(isset($background_image) && $background_image)
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ $background_image }}');"></div>
    @endif
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div class="text-center">
            {{-- Main Title --}}
            @if(isset($title) && $title)
                <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                    {{ $title }}
                </h1>
            @endif

            {{-- Subtitle --}}
            @if(isset($subtitle) && $subtitle)
                <h2 class="text-xl md:text-2xl font-semibold mb-6 text-blue-100">
                    {{ $subtitle }}
                </h2>
            @endif

            {{-- Description --}}
            @if(isset($description) && $description)
                <p class="text-lg md:text-xl mb-10 max-w-3xl mx-auto text-blue-50 leading-relaxed">
                    {{ $description }}
                </p>
            @endif

            {{-- CTA Buttons --}}
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                @if(isset($cta_primary) && is_array($cta_primary))
                    <a 
                        href="{{ $cta_primary['url'] ?? '#' }}" 
                        class="bg-white text-blue-600 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-blue-50 transition-colors duration-300 shadow-lg"
                    >
                        {{ $cta_primary['label'] ?? 'Scopri di Più' }}
                    </a>
                @endif

                @if(isset($cta_secondary) && is_array($cta_secondary))
                    <a 
                        href="{{ $cta_secondary['url'] ?? '#' }}" 
                        class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-white hover:text-blue-600 transition-colors duration-300"
                    >
                        {{ $cta_secondary['label'] ?? 'Contattaci' }}
                    </a>
                @endif
            </div>
        </div>
    </div>

    {{-- Decorative Elements --}}
    <div class="absolute bottom-0 left-0 right-0">
        <svg class="w-full h-16 text-white" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" fill="currentColor"></path>
            <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" fill="currentColor"></path>
            <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" fill="currentColor"></path>
        </svg>
    </div>
</section>
