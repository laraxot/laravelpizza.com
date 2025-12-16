<?php

declare(strict_types=1);

?>
@props([
    'title' => 'Titolo Hero',
    'subtitle' => 'Sottotitolo della hero section',
    'image' => null,
    'cta_text' => 'Call to Action',
    'cta_link' => '#',
    'background_color' => '#ffffff',
    'text_color' => '#000000',
    'cta_color' => '#4f46e5'
])

<section
    class="relative py-20 overflow-hidden"
    style="background-color: {{ $background_color }}; color: {{ $text_color }}">
    <div class="container mx-auto px-4">
        <div class="flex flex-wrap items-center -mx-4">
            <div class="w-full lg:w-1/2 px-4 mb-12 lg:mb-0">
                <div class="max-w-lg">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold mb-5">{{ $title }}</h1>
                    <p class="text-xl mb-10">{{ $subtitle }}</p>
                    @if($cta_text)
                        <a
                            href="{{ $cta_link }}"
                            class="inline-block py-3 px-8 text-white font-bold rounded-lg transition duration-200"
                            style="background-color: {{ $cta_color }}"
                        >
                            {{ $cta_text }}
                        </a>
                    @endif
                </div>
            </div>
            <div class="w-full lg:w-1/2 px-4">
                @if($image)
                    <div class="relative">
                        <img
                            class="w-full h-auto rounded-lg shadow-xl"
                            src="{{ $image }}"
                            alt="{{ $title }}"
                        >
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
