{{--
/**
 * Quick Links Sidebar Block - Theme Sixteen
 *
 * Lista di link di accesso rapido per la sidebar.
 *
 * @var string $title Titolo della sezione
 * @var array $links Array di link
 */
--}}

<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    {{-- Title --}}
    @if(isset($title) && $title)
        <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">
            {{ $title }}
        </h3>
    @endif

    {{-- Links List --}}
    @if(isset($links) && is_array($links))
        <ul class="space-y-3">
            @foreach($links as $link)
                <li>
                    <a 
                        href="{{ $link['url'] ?? '#' }}" 
                        class="flex items-center p-3 rounded-lg hover:bg-blue-50 transition-colors duration-200 group"
                    >
                        {{-- Icon --}}
                        @if(isset($link['icon']))
                            <x-dynamic-component 
                                :component="$link['icon']" 
                                class="w-5 h-5 text-blue-600 mr-3 group-hover:text-blue-700" 
                            />
                        @endif

                        {{-- Label --}}
                        <span class="text-gray-700 group-hover:text-blue-700 font-medium">
                            {{ $link['label'] ?? 'Link' }}
                        </span>

                        {{-- Arrow --}}
                        <x-heroicon-o-chevron-right class="w-4 h-4 text-gray-400 ml-auto group-hover:text-blue-600" />
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
