{{--
/**
 * Features Grid Block - Theme Sixteen
 *
 * Griglia di funzionalità con icone e descrizioni.
 *
 * @var string $title Titolo della sezione
 * @var string $description Descrizione della sezione
 * @var array $features Array di funzionalità
 */
--}}

<section class="py-16 bg-white" id="features">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header Section --}}
        <div class="text-center mb-16">
            @if(isset($title) && $title)
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    {{ $title }}
                </h2>
            @endif
            
            @if(isset($description) && $description)
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    {{ $description }}
                </p>
            @endif
        </div>

        {{-- Features Grid --}}
        @if(isset($features) && is_array($features))
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($features as $feature)
                    <div class="group bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-8 border border-gray-100 hover:border-{{ $feature['color'] ?? 'blue' }}-200">
                        {{-- Icon --}}
                        @if(isset($feature['icon']))
                            <div class="w-16 h-16 bg-{{ $feature['color'] ?? 'blue' }}-100 rounded-lg flex items-center justify-center mb-6 group-hover:bg-{{ $feature['color'] ?? 'blue' }}-200 transition-colors duration-300">
                                <x-dynamic-component 
                                    :component="$feature['icon']" 
                                    class="w-8 h-8 text-{{ $feature['color'] ?? 'blue' }}-600" 
                                />
                            </div>
                        @endif

                        {{-- Title --}}
                        @if(isset($feature['title']))
                            <h3 class="text-xl font-semibold text-gray-900 mb-4">
                                {{ $feature['title'] }}
                            </h3>
                        @endif

                        {{-- Description --}}
                        @if(isset($feature['description']))
                            <p class="text-gray-600 mb-6 leading-relaxed">
                                {{ $feature['description'] }}
                            </p>
                        @endif

                        {{-- CTA Link --}}
                        @if(isset($feature['url']))
                            <a 
                                href="{{ $feature['url'] }}" 
                                class="inline-flex items-center text-{{ $feature['color'] ?? 'blue' }}-600 hover:text-{{ $feature['color'] ?? 'blue' }}-700 font-medium transition-colors duration-300"
                            >
                                Scopri di più
                                <x-heroicon-o-arrow-right class="w-4 h-4 ml-2" />
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
