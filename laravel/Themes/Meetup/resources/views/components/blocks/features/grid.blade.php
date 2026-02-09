{{--
/**
 * Features Grid Block - Laravel Pizza Theme
 *
 * Griglia di funzionalità con icone e descrizioni per Laravel Pizza Meetups.
 *
 * @var string $title Titolo della sezione
 * @var string $description Descrizione della sezione
 * @var array $features Array di funzionalità
 */
--}}

<section class="py-16 bg-slate-900" id="features" aria-labelledby="features-heading">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header Section --}}
        <div class="text-center mb-16">
            @if(isset($title) && $title)
                <h2 id="features-heading" class="text-3xl md:text-4xl font-bold text-white mb-4">
                    {{ $title }}
                </h2>
            @endif

            @if(isset($description) && $description)
                <p class="text-xl text-slate-300 max-w-3xl mx-auto">
                    {{ $description }}
                </p>
            @endif
        </div>

        {{-- Features Grid --}}
        @if(isset($features) && is_array($features))
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8" role="list">
                @foreach($features as $feature)
                    <article class="group bg-slate-800/50 backdrop-blur-sm rounded-xl transition-all duration-300 p-8 border border-slate-700 hover:border-red-500" role="listitem">
                        {{-- Icon --}}
                        @if(isset($feature['icon']))
                            <div class="w-16 h-16 bg-red-600/20 rounded-lg flex items-center justify-center mb-6 transition-colors duration-300" aria-hidden="true">
                                <x-dynamic-component
                                    :component="$feature['icon']"
                                    class="w-8 h-8 text-red-500"
                                />
                            </div>
                        @endif

                        {{-- Title --}}
                        @if(isset($feature['title']))
                            <h3 class="text-xl font-semibold text-white mb-4">
                                {{ $feature['title'] }}
                            </h3>
                        @endif

                        {{-- Description --}}
                        @if(isset($feature['description']))
                            <p class="text-slate-300 mb-6 leading-relaxed">
                                {{ $feature['description'] }}
                            </p>
                        @endif
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</section>
