{{--
/**
 * Contact Info Block - Laravel Pizza Theme
 *
 * Sezione informazioni di contatto con cards.
 * Riusa il pattern di features/grid ma con styling specifico per Contact page.
 *
 * @var string $title Titolo della sezione
 * @var string $description Descrizione della sezione
 * @var array $contacts Array di informazioni di contatto
 */
--}}

<section class="py-16 bg-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header Section --}}
        <div class="text-center mb-16">
            @if(isset($title) && $title)
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                    {{ $title }}
                </h2>
            @endif
            
            @if(isset($description) && $description)
                <p class="text-xl text-slate-300 max-w-3xl mx-auto">
                    {{ $description }}
                </p>
            @endif
        </div>

        {{-- Contact Info Grid --}}
        @if(isset($contacts) && is_array($contacts))
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($contacts as $contact)
                    <div class="group bg-slate-800/50 backdrop-blur-sm rounded-xl transition-all duration-300 p-8 border border-slate-700 hover:border-red-500">
                        {{-- Icon --}}
                        @if(isset($contact['icon']))
                            <div class="w-16 h-16 bg-red-600/20 rounded-lg flex items-center justify-center mb-6 transition-colors duration-300 group-hover:bg-red-600/30">
                                <x-dynamic-component 
                                    :component="$contact['icon']" 
                                    class="w-8 h-8 text-red-500" 
                                />
                            </div>
                        @endif

                        {{-- Title --}}
                        @if(isset($contact['title']))
                            <h3 class="text-xl font-semibold text-white mb-2">
                                {{ $contact['title'] }}
                            </h3>
                        @endif

                        {{-- Value/Link --}}
                        @if(isset($contact['value']))
                            @if(isset($contact['url']) && $contact['url'])
                                <a 
                                    href="{{ $contact['url'] }}" 
                                    class="text-red-500 hover:text-red-400 font-medium transition-colors block mb-2"
                                >
                                    {{ $contact['value'] }}
                                </a>
                            @else
                                <p class="text-white font-medium mb-2">
                                    {{ $contact['value'] }}
                                </p>
                            @endif
                        @endif

                        {{-- Description --}}
                        @if(isset($contact['description']))
                            <p class="text-slate-400 text-sm">
                                {{ $contact['description'] }}
                            </p>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
