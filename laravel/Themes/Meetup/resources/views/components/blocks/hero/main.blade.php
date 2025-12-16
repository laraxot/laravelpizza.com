@props([
    'data' => [],
    'title' => null,
    'subtitle' => null,
    'description' => null,
    'cta_primary' => null,
    'cta_secondary' => null,
    'background_image' => null,
])

@php
    // Supporto per entrambi i formati: variabili separate o array $data
    // Quando @include passa $block->data, Laravel espande l'array in variabili separate
    // Quindi controlliamo prima le variabili separate, poi l'array $data
    $title = $title ?? ($data['title'] ?? null);
    $subtitle = $subtitle ?? ($data['subtitle'] ?? 'Join fellow Laravel, Filament, and Livewire enthusiasts for pizza meetups.');
    $description = $description ?? ($data['description'] ?? null);
    $cta_primary = $cta_primary ?? ($data['cta_primary'] ?? null);
    $cta_secondary = $cta_secondary ?? ($data['cta_secondary'] ?? null);
    $background_image = $background_image ?? ($data['background_image'] ?? null);
    
    // Parse del titolo: "Laravel Developers. Pizza. Community." → due parti
    $titleParts = [];
    if ($title) {
        // Dividi per "Pizza." per separare le due parti
        if (str_contains($title, 'Pizza.')) {
            $parts = explode('Pizza.', $title, 2);
            $titleParts['first'] = trim($parts[0] ?? 'Laravel Developers.');
            $titleParts['second'] = 'Pizza. ' . trim($parts[1] ?? 'Community.');
        } else {
            // Fallback: usa tutto il titolo come prima parte
            $titleParts['first'] = $title;
            $titleParts['second'] = 'Pizza. Community.';
        }
    } else {
        // Default se nessun titolo
        $titleParts['first'] = 'Laravel Developers.';
        $titleParts['second'] = 'Pizza. Community.';
    }
@endphp

{{-- Hero Section - Laravel Pizza Meetups Style --}}
<section id="home" class="relative py-20 md:py-32 overflow-hidden">
    {{-- Background gradient --}}
    <div class="absolute inset-0 bg-gradient-to-b from-slate-800/50 to-slate-900"></div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            {{-- Pizza Icon --}}
            <div class="mb-8 flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-24 w-24 text-red-500" aria-hidden="true">
                    <path d="M12 2L22 20H2L12 2z" fill="currentColor"/>
                    <circle cx="8" cy="14" r="1.2" fill="#fef2f2"/>
                    <circle cx="12" cy="12" r="1.2" fill="#fef2f2"/>
                    <circle cx="14" cy="16" r="1.2" fill="#fef2f2"/>
                    <circle cx="10" cy="17" r="1.2" fill="#fef2f2"/>
                    <circle cx="15" cy="13" r="1.2" fill="#fef2f2"/>
                </svg>
            </div>

            {{-- Heading --}}
            <h1 class="text-5xl md:text-7xl font-bold mb-4">
                <span class="text-white">{{ $titleParts['first'] }}</span><br>
                <span class="text-red-500">{{ $titleParts['second'] }}</span>
            </h1>

            {{-- Subheading --}}
            <p class="text-xl md:text-2xl text-gray-300 mb-10 max-w-3xl mx-auto">
                {{ $subtitle }}
                @if($description)
                    <br class="hidden md:block">
                    {{ $description }}
                @endif
            </p>

            {{-- CTA Buttons --}}
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @if($cta_primary)
                    @php
                        $cta_primary_url = is_array($cta_primary) ? ($cta_primary['url'] ?? '#') : '#';
                        $cta_primary_label = is_array($cta_primary) ? ($cta_primary['label'] ?? 'Join the Community') : 'Join the Community';
                    @endphp
                    <a href="{{ $cta_primary_url }}" class="bg-red-600 hover:bg-red-700 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-colors inline-flex items-center justify-center">
                        {{ $cta_primary_label }}
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                @endif
                @if($cta_secondary)
                    @php
                        $cta_secondary_url = is_array($cta_secondary) ? ($cta_secondary['url'] ?? '#') : '#';
                        $cta_secondary_label = is_array($cta_secondary) ? ($cta_secondary['label'] ?? 'View Events') : 'View Events';
                    @endphp
                    <a href="{{ $cta_secondary_url }}" class="border-2 border-gray-600 hover:border-gray-500 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-colors inline-flex items-center justify-center">
                        {{ $cta_secondary_label }}
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>
