@props([
    'title' => '',
    'subtitle' => '',
    'description' => '',
    'image' => null,
    'imageAlt' => '',
    'backgroundImage' => null,
    'primaryButton' => null,
    'secondaryButton' => null,
    'alignment' => 'left', // left, center, right
    'size' => 'md', // sm, md, lg, xl
    'overlay' => true,
])

@php
    $alignments = [
        'left' => 'text-left items-start',
        'center' => 'text-center items-center',
        'right' => 'text-right items-end',
    ];
    
    $sizes = [
        'sm' => 'py-16',
        'md' => 'py-24',
        'lg' => 'py-32',
        'xl' => 'py-40',
    ];
    
    $alignClass = $alignments[$alignment] ?? $alignments['left'];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
@endphp

<section class="ui-hero relative {{ $sizeClass }} {{ $alignClass }} overflow-hidden">
    <!-- Background Image -->
    @if($backgroundImage)
        <div 
            class="absolute inset-0 bg-cover bg-center bg-no-repeat"
            style="background-image: url('{{ $backgroundImage }}');"
        >
            @if($overlay)
                <div class="absolute inset-0 bg-black/50"></div>
            @endif
        </div>
    @else
        <div class="absolute inset-0 bg-gradient-to-br from-primary-600 to-primary-800">
            @if($overlay)
                <div class="absolute inset-0 bg-black/20"></div>
            @endif
        </div>
    @endif
    
    <!-- Content -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-center gap-12">
            <!-- Text Content -->
            <div class="flex-1">
                @if($subtitle)
                    <p class="text-primary-200 text-lg font-medium mb-4">
                        {{ $subtitle }}
                    </p>
                @endif
                
                @if($title)
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6">
                        {{ $title }}
                    </h1>
                @endif
                
                @if($description)
                    <p class="text-lg text-gray-200 mb-8 max-w-2xl">
                        {{ $description }}
                    </p>
                @endif
                
                <!-- Buttons -->
                @if($primaryButton || $secondaryButton)
                    <div class="flex flex-wrap gap-4">
                        @if($primaryButton)
                            <a 
                                href="{{ $primaryButton['url'] ?? '#' }}"
                                class="px-8 py-3 bg-white text-primary-600 rounded-lg font-medium hover:bg-gray-100 transition-colors focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-primary-600"
                            >
                                {{ $primaryButton['label'] ?? __('Scopri di più') }}
                            </a>
                        @endif
                        
                        @if($secondaryButton)
                            <a 
                                href="{{ $secondaryButton['url'] ?? '#' }}"
                                class="px-8 py-3 bg-transparent border-2 border-white text-white rounded-lg font-medium hover:bg-white hover:text-primary-600 transition-colors focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-primary-600"
                            >
                                {{ $secondaryButton['label'] ?? __('Contattaci') }}
                            </a>
                        @endif
                    </div>
                @endif
            </div>
            
            <!-- Hero Image -->
            @if($image)
                <div class="flex-1">
                    <img 
                        src="{{ $image }}"
                        alt="{{ $imageAlt }}"
                        class="w-full h-auto rounded-2xl shadow-2xl"
                    >
                </div>
            @endif
        </div>
    </div>
    
    <!-- Decorative Elements -->
    <div class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
</section>