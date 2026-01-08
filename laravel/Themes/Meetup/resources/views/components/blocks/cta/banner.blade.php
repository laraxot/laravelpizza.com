{{--
/**
 * CTA Banner Block - Theme Sixteen
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

<section class="py-16 {{ $background_color ?? 'bg-blue-600' }}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center {{ $text_color ?? 'text-white' }}">
            {{-- Title --}}
            @if(isset($title) && $title)
                <h2 class="text-3xl md:text-4xl font-bold mb-4">
                    {{ $title }}
                </h2>
            @endif

            {{-- Description --}}
            @if(isset($description) && $description)
                <p class="text-lg md:text-xl mb-10 max-w-3xl mx-auto opacity-90">
                    {{ $description }}
                </p>
            @endif

            {{-- CTA Buttons --}}
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                @if(isset($cta_primary) && is_array($cta_primary))
                    @php
                        $primaryClasses = match($cta_primary['style'] ?? 'primary') {
                            'white' => 'bg-white text-blue-600 hover:bg-gray-50',
                            'outline-white' => 'border-2 border-white text-white hover:bg-white hover:text-blue-600',
                            default => 'bg-blue-800 text-white hover:bg-blue-900'
                        };
                    @endphp
                    <a 
                        href="{{ $cta_primary['url'] ?? '#' }}" 
                        class="{{ $primaryClasses }} px-8 py-4 rounded-lg font-semibold text-lg transition-colors duration-300 shadow-lg"
                    >
                        {{ $cta_primary['label'] ?? 'Inizia Ora' }}
                    </a>
                @endif

                @if(isset($cta_secondary) && is_array($cta_secondary))
                    @php
                        $secondaryClasses = match($cta_secondary['style'] ?? 'secondary') {
                            'outline-white' => 'border-2 border-white text-white hover:bg-white hover:text-blue-600',
                            'white' => 'bg-white text-blue-600 hover:bg-gray-50',
                            default => 'border-2 border-blue-800 text-blue-800 hover:bg-blue-800 hover:text-white'
                        };
                    @endphp
                    <a 
                        href="{{ $cta_secondary['url'] ?? '#' }}" 
                        class="{{ $secondaryClasses }} px-8 py-4 rounded-lg font-semibold text-lg transition-colors duration-300"
                    >
                        {{ $cta_secondary['label'] ?? 'Scopri di Più' }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>
