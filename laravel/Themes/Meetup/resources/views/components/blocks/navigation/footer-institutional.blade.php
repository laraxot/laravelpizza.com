{{--
/**
 * Footer Institutional Block - Laravel Pizza Meetups
 * Modern footer with dark theme and community links
 * 
 * @props string $logo - Footer logo source
 * @props string $brand - Brand name
 * @props string $tagline - Brand tagline
 * @props string $copyright - Copyright text
 * @props array $social_links - Social media links
 * @props array $links - Footer links grouped by section
 */
--}}

@props([
    'logo' => '/images/pizza-icon.png',
    'brand' => 'Laravel Pizza Meetups',
    'tagline' => 'Connecting Laravel developers over pizza since 2023',
    'copyright' => '© 2026 Laravel Pizza Meetups. All rights reserved.',
    'socialLinks' => [],
    'links' => []
])

<footer role="contentinfo" class="bg-slate-900 text-slate-300">
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Brand Info -->
            <div class="lg:col-span-2">
                <div class="flex items-center space-x-3 mb-4">
                    @if($logo)
                        <img src="{{ $logo }}" 
                             alt="{{ $brand }}" 
                             class="h-10 w-10">
                    @endif
                    <span class="text-xl font-bold text-white">{{ $brand }}</span>
                </div>
                <p class="text-slate-400 mb-6 max-w-md">
                    {{ $tagline }}
                </p>
                
                <!-- Social Links -->
                @if(!empty($socialLinks))
                    <div class="flex space-x-4">
                        @foreach($socialLinks as $social)
                            <a 
                                href="{{ $social['url'] ?? '#' }}" 
                                class="text-slate-400 hover:text-white transition-colors"
                                aria-label="{{ $social['name'] }}"
                            >
                                <x-dynamic-component 
                                    :component="$social['icon'] ?? 'heroicon-m-social-twitter'" 
                                    class="w-5 h-5" 
                                />
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
            
            <!-- Footer Links -->
            @if(!empty($links))
                @foreach($links as $linkGroup)
                    @if(isset($linkGroup['title']) && isset($linkGroup['items']))
                        <div>
                            <h4 class="text-white font-semibold mb-4">{{ $linkGroup['title'] }}</h4>
                            <ul class="space-y-2">
                                @foreach($linkGroup['items'] as $item)
                                    <li>
                                        <a 
                                            href="{{ $item['url'] }}" 
                                            class="text-slate-400 hover:text-white transition-colors text-sm"
                                        >
                                            {{ $item['label'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
        
        <!-- Additional Content Slot -->
        @if($slot->isNotEmpty())
            <div class="mt-8 pt-8 border-t border-slate-700">
                {{ $slot }}
            </div>
        @endif
        
        <!-- Copyright -->
        <div class="mt-12 pt-8 border-t border-slate-700 text-center text-sm">
            <p class="text-slate-400">{{ $copyright }}</p>
        </div>
    </div>
</footer>
