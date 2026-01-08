{{--
/**
 * CTA Banner Block - Laravel Pizza Theme
 *
 * Banner call-to-action per conversioni.
 *
 * @var string $title Titolo del CTA
 * @var string $description Descrizione
 * @var string $background_color Colore di sfondo
 * @var string $text_color Colore del testo
 * @var array $cta_primary Pulsante CTA primario
 * @var array $cta_secondary Pulsante CTA secondario (opzionale)
 */
--}}

<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-red-600 to-red-700 rounded-2xl p-8 md:p-12 text-center {{ $text_color ?? 'text-white' }}">
            {{-- Title --}}
            @if(isset($title) && $title)
                <h2 class="text-3xl md:text-4xl font-bold mb-4">
                    {{ $title }}
                </h2>
            @endif

            {{-- Description --}}
            @if(isset($description) && $description)
                <p class="text-lg md:text-xl mb-8 max-w-2xl mx-auto text-red-100">
                    {{ $description }}
                </p>
            @endif

            {{-- CTA Buttons --}}
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                @if(isset($cta_primary) && is_array($cta_primary))
                    @php
                        $primaryClasses = match($cta_primary['style'] ?? 'primary') {
                            'white' => 'bg-white text-red-600 hover:bg-gray-100',
                            'outline-white' => 'border-2 border-white text-white hover:bg-white hover:text-red-600',
                            default => 'bg-white text-red-600 hover:bg-gray-100'
                        };
                    @endphp
                    <a 
                        href="{{ $cta_primary['url'] ?? '#' }}" 
                        class="{{ $primaryClasses }} px-8 py-4 rounded-lg font-semibold text-lg transition-colors duration-300 shadow-lg inline-flex items-center"
                    >
                        {{ $cta_primary['label'] ?? 'Create Your Account' }}
                        @if(isset($cta_primary['style']) && $cta_primary['style'] === 'white')
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        @endif
                    </a>
                @endif

                @if(isset($cta_secondary) && is_array($cta_secondary))
                    @php
                        $secondaryClasses = match($cta_secondary['style'] ?? 'secondary') {
                            'outline-white' => 'border-2 border-white text-white hover:bg-white hover:text-red-600',
                            'white' => 'bg-white text-red-600 hover:bg-gray-100',
                            default => 'border-2 border-white text-white hover:bg-white hover:text-red-600'
                        };
                    @endphp
                    <a 
                        href="{{ $cta_secondary['url'] ?? '#' }}" 
                        class="{{ $secondaryClasses }} px-8 py-4 rounded-lg font-semibold text-lg transition-colors duration-300"
                    >
                        {{ $cta_secondary['label'] ?? 'Browse Events' }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>
