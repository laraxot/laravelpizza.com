@props(['data'])

@php
    $navItems = collect($data['items'] ?? [])->map(function ($item) {
        $item['url'] = LaravelLocalization::localizeURL($item['url']);
        return $item;
    });

    $ctaButton = $data['cta_button'] ?? null;
    if ($ctaButton) {
        $ctaButton['url'] = LaravelLocalization::localizeURL($ctaButton['url']);
    }
@endphp

<header class="bg-[#0f2b46] text-white p-4 sticky top-0 z-50 shadow-lg backdrop-blur-md">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Left: Brand with Logo -->
        <a href="{{ LaravelLocalization::localizeURL($data['home_url']) }}" class="flex items-center space-x-2">
            @if(isset($data['logo']) && $data['logo'])
                <img src="{{ $data['logo'] }}" alt="{{ $data['brand'] }}" class="h-8 w-auto">
            @endif
            <span class="text-xl font-bold">{{ $data['brand'] }}</span>
            @if(isset($data['tagline']) && $data['tagline'])
                <span class="hidden md:inline text-sm text-gray-300 ml-2">{{ $data['tagline'] }}</span>
            @endif
        </a>

        <!-- Center: Navigation Links -->
        <nav class="hidden md:flex space-x-6">
            @foreach($navItems as $item)
                <a href="{{ $item['url'] }}" class="hover:text-red-500 transition-colors duration-200">{{ $item['label'] }}</a>
            @endforeach
        </nav>

        <!-- Right: CTA Button -->
        @if($ctaButton)
            <a href="{{ $ctaButton['url'] }}"
               class="bg-[#ef4444] hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200">
                {{ $ctaButton['label'] }}
            </a>
        @endif

        <!-- Mobile Navigation Toggle (Hamburger Icon) - To be implemented -->
        <div class="md:hidden">
            <button class="text-white focus:outline-none">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-4 6h4"></path>
                </svg>
            </button>
        </div>
    </div>
</header>
