{{--
/**
 * About Values Block - Laravel Pizza Theme
 *
 * Sezione valori della community con cards.
 * Riusa il pattern di features/grid ma con styling specifico per About page.
 *
 * @var string $title Titolo della sezione
 * @var string $description Descrizione della sezione
 * @var array $values Array di valori
 */
--}}

<section class="py-16 bg-gray-50">
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

        {{-- Values Grid --}}
        @if(isset($values) && is_array($values))
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($values as $value)
                    <div class="group bg-white rounded-xl transition-all duration-300 p-8 border border-gray-200 hover:border-red-500 hover:shadow-xl">
                        {{-- Icon --}}
                        @if(isset($value['icon']))
                            <div class="w-16 h-16 bg-red-600/10 rounded-lg flex items-center justify-center mb-6 transition-colors duration-300 group-hover:bg-red-600/20">
                                <x-dynamic-component 
                                    :component="$value['icon']" 
                                    class="w-8 h-8 text-red-600" 
                                />
                            </div>
                        @endif

                        {{-- Title --}}
                        @if(isset($value['title']))
                            <h3 class="text-xl font-semibold text-gray-900 mb-4 group-hover:text-red-600 transition-colors">
                                {{ $value['title'] }}
                            </h3>
                        @endif

                        {{-- Description --}}
                        @if(isset($value['description']))
                            <p class="text-gray-600 leading-relaxed">
                                {{ $value['description'] }}
                            </p>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
