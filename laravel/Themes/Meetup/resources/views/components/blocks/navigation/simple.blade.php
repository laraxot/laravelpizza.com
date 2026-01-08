{{--
/**
 * Simple Navigation Component - Theme Sixteen
 *
 * Componente di navigazione semplice per il tema Sixteen.
 * Utilizzato per blocchi CMS di navigazione base.
 *
 * @var array $data Dati di configurazione del blocco
 */
--}}

<nav class="simple-navigation" role="navigation" aria-label="@lang('pub_theme::navigation.main')">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between py-4">
            {{-- Logo o titolo --}}
            @if(isset($data['title']) || isset($data['brand']))
                <div class="flex items-center">
                    @if(isset($data['logo']))
                        <img src="{{ $data['logo'] }}" alt="{{ $data['brand'] ?? $data['title'] ?? 'Logo' }}" class="h-8 w-auto mr-3">
                    @endif
                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                        {{ $data['brand'] ?? $data['title'] ?? @lang('pub_theme::navigation.site_title') }}
                    </h2>
                </div>
            @endif

            {{-- Menu di navigazione --}}
            @if(isset($data['menu_items']) && is_array($data['menu_items']))
                <ul class="flex space-x-8">
                    @foreach($data['menu_items'] as $item)
                        <li>
                            <a 
                                href="{{ $item['url'] ?? '#' }}" 
                                class="text-gray-600 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 transition-colors duration-300 font-medium
                                       {{ ($item['active'] ?? false) ? 'text-blue-600 dark:text-blue-400' : '' }}"
                                @if($item['external'] ?? false) target="_blank" rel="noopener noreferrer" @endif
                            >
                                {{ $item['label'] ?? $item['title'] ?? 'Menu Item' }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                {{-- Fallback menu --}}
                <ul class="flex space-x-8">
                    <li>
                        <a href="/" class="text-gray-600 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 transition-colors duration-300 font-medium">
                            @lang('pub_theme::navigation.home')
                        </a>
                    </li>
                    <li>
                        <a href="/about" class="text-gray-600 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 transition-colors duration-300 font-medium">
                            @lang('pub_theme::navigation.about')
                        </a>
                    </li>
                    <li>
                        <a href="/contact" class="text-gray-600 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 transition-colors duration-300 font-medium">
                            @lang('pub_theme::navigation.contact')
                        </a>
                    </li>
                </ul>
            @endif
        </div>
    </div>
</nav>

