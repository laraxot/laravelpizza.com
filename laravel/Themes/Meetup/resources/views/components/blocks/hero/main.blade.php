{{--
/**
 * Hero Section Block - Laravel Pizza Theme
 *
 * Blocco hero principale per homepage e landing page.
 * Stile rosso Laravel Pizza con design moderno.
 *
 * @var array $title Titolo principale
 * @var array $subtitle Sottotitolo
 * @var array $description Descrizione
 * @var array $background_image Immagine di sfondo (opzionale)
 * @var array $cta_primary Pulsante CTA primario
 * @var array $cta_secondary Pulsante CTA secondario (opzionale)
 */
--}}

<section class="relative bg-gradient-to-b from-slate-200 via-slate-100 to-slate-200 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 text-slate-900 dark:text-white overflow-hidden transition-colors duration-200">
    {{-- Pattern SVG Background Overlay --}}
    <div class="absolute inset-0 opacity-20 dark:opacity-20 text-slate-400 dark:text-white">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" fill="currentColor"></path>
            <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" fill="currentColor" opacity="0.5"></path>
        </svg>
    </div>
    
    {{-- Background Image Overlay (opzionale) --}}
    @if(isset($background_image) && $background_image)
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ $background_image }}');"></div>
    @endif
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32">
        <div class="text-center">
            {{-- Pizza Icon --}}
            <div class="flex justify-center mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-24 w-24 text-red-500" aria-hidden="true">
                    <path d="M15 11h.01"></path>
                    <path d="M11 15h.01"></path>
                    <path d="M16 16h.01"></path>
                    <path d="m2 16 20 6-6-20A20 20 0 0 0 2 16"></path>
                    <path d="M5.71 17.11a17.04 17.04 0 0 1 11.4-11.4"></path>
                </svg>
            </div>
            
            {{-- Main Title --}}
            @if(isset($title) && $title)
                <h1 class="text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-bold mb-6 leading-tight">
                    @php
                        // Parse titolo: "Laravel Developers. Pizza. Community."
                        // Split su ". " (punto + spazio) o "." (solo punto)
                        $titleClean = trim($title);
                        // Se contiene "Pizza.", dividi in due parti
                        if (str_contains($titleClean, 'Pizza.')) {
                            $parts = preg_split('/(?<=\.)\s*(?=Pizza\.)/', $titleClean, 2);
                            $firstPart = trim($parts[0] ?? 'Laravel Developers.');
                            $secondPart = trim($parts[1] ?? 'Pizza. Community.');
                        } else {
                            // Fallback: split su punti
                            $parts = explode('.', $titleClean);
                            $firstPart = trim($parts[0] ?? 'Laravel Developers') . '.';
                            $secondPart = trim(($parts[1] ?? '') . '.' . ($parts[2] ?? ''));
                        }
                    @endphp
                    <span class="text-slate-900 dark:text-white">{{ $firstPart }}</span><br>
                    <span class="text-red-500">{{ $secondPart }}</span>
                </h1>
            @endif

            {{-- Subtitle --}}
            @if(isset($subtitle) && $subtitle)
                <h2 class="text-xl md:text-2xl font-semibold mb-6 text-red-700 dark:text-red-100">
                    {{ $subtitle }}
                </h2>
            @endif

            {{-- Description --}}
            @if(isset($description) && $description)
                <p class="text-xl text-slate-600 dark:text-gray-300 mb-8 max-w-2xl mx-auto leading-relaxed">
                    {{ $description }}
                </p>
            @endif

            {{-- CTA Buttons --}}
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                @if(isset($cta_primary) && is_array($cta_primary))
                    <a 
                        href="{{ $cta_primary['url'] ?? '#' }}" 
                        class="bg-red-600 hover:bg-red-700 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1"
                    >
                        {{ $cta_primary['label'] ?? 'Join the Community' }}
                    </a>
                @endif

                @if(isset($cta_secondary) && is_array($cta_secondary))
                    <a 
                        href="{{ $cta_secondary['url'] ?? '#' }}" 
                        class="border-2 border-slate-700 dark:border-white text-slate-800 dark:text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-slate-800 dark:hover:bg-white hover:text-white dark:hover:text-red-600 transition-all duration-300 transform hover:-translate-y-1"
                    >
                        {{ $cta_secondary['label'] ?? 'View Events' }}
                    </a>
                @endif
            </div>
        </div>
    </div>

    {{-- Decorative Elements --}}
    <div class="absolute bottom-0 left-0 right-0">
        <svg class="w-full h-16 text-slate-200 dark:text-slate-900" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" fill="currentColor"></path>
            <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" fill="currentColor"></path>
            <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" fill="currentColor"></path>
        </svg>
    </div>
</section>
