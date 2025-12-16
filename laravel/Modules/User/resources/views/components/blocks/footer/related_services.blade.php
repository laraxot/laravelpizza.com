<?php

declare(strict_types=1);

?>
@props([
    'title' => 'Servizi correlati',
    'services' => []
])

<div class="mb-6">
    <h4 class="text-lg font-bold mb-4">{{ $title }}</h4>

    @if(count($services) > 0)
        <ul class="space-y-2">
            @foreach($services as $service)
                <li>
                    <a
                        href="{{ $service['link'] }}"
                        class="text-gray-600 hover:text-primary-500 transition-colors flex items-center"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        {{ $service['title'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
