<?php

declare(strict_types=1);

?>
@props([
    'title' => 'Informazioni',
    'content' => null,
    'icon' => null,
    'button_text' => null,
    'button_link' => '#'
])

<div class="bg-white rounded-lg shadow-sm p-6 mb-6">
    <div class="flex items-start">
        @if($icon)
            <div class="flex-shrink-0 mr-4">
                <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center">
                    @if($icon === 'phone')
                        <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                    @elseif($icon === 'mail')
                        <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    @elseif($icon === 'info')
                        <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @else
                        <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @endif
                </div>
            </div>
        @endif
        <div>
            <h3 class="text-lg font-bold mb-2">{{ $title }}</h3>

            @if($content)
                <p class="text-gray-600 mb-4">{{ $content }}</p>
            @endif

            @if($button_text)
                <a href="{{ $button_link }}" class="inline-block px-4 py-2 bg-primary-500 text-white rounded hover:bg-primary-600 transition-colors">
                    {{ $button_text }}
                </a>
            @endif
        </div>
    </div>
</div>
