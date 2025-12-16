<?php

declare(strict_types=1);

?>
@props([
    'title' => 'Titolo CTA',
    'description' => 'Descrizione della call to action',
    'cta_primary_text' => 'Call to Action',
    'cta_primary_link' => '#',
    'cta_secondary_text' => null,
    'cta_secondary_link' => '#',
    'background_color' => 'bg-primary-500',
    'text_color' => 'text-white'
])

<section class="py-16 {{ $background_color }} {{ $text_color }}">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">{{ $title }}</h2>
            <p class="text-lg opacity-90 mb-8">{{ $description }}</p>

            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ $cta_primary_link }}" class="inline-block py-3 px-8 bg-white text-primary-700 font-bold rounded-lg transition duration-200 hover:bg-gray-100">
                    {{ $cta_primary_text }}
                </a>

                @if($cta_secondary_text)
                    <a href="{{ $cta_secondary_link }}" class="inline-block py-3 px-8 border border-white {{ $text_color }} font-bold rounded-lg transition duration-200 hover:bg-white/10">
                        {{ $cta_secondary_text }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>
