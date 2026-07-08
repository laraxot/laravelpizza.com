<?php

declare(strict_types=1);

?>
@props([
    'title' => 'Emergenza',
    'content' => null,
    'emergency_number' => '112',
    'icon' => 'alert-circle'
])

<div class="bg-red-50 border border-red-100 rounded-lg p-6 mb-6">
    <div class="flex items-start">
        <div class="flex-shrink-0 mr-4">
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                @if($icon === 'alert-circle')
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                @elseif($icon === 'phone')
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                @else
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                @endif
            </div>
        </div>
        <div>
            <h3 class="text-lg font-bold text-red-800 mb-2">{{ $title }}</h3>

            @if($content)
                <p class="text-red-700 mb-4">{{ $content }}</p>
            @endif

            @if($emergency_number)
                <div class="flex items-center">
                    <span class="font-bold text-red-800 mr-2">Numero:</span>
                    <a href="tel:{{ $emergency_number }}" class="text-lg font-bold text-red-600 hover:underline">
                        {{ $emergency_number }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
