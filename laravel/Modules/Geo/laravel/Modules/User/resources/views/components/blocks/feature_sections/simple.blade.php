<?php

declare(strict_types=1);

?>
@props([
    'title' => 'Titolo Feature',
    'description' => null,
    'sections' => []
])

<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-xl mx-auto text-center mb-16">
            <h2 class="text-3xl font-bold mb-4">{{ $title }}</h2>
            @if($description)
                <p class="text-gray-500">{{ $description }}</p>
            @endif
        </div>

        <div class="flex flex-wrap -mx-4">
            @foreach($sections as $section)
                <div class="w-full md:w-1/2 lg:w-1/3 px-4 mb-8">
                    <div class="p-8 h-full bg-gray-50 rounded-lg">
                        @if(isset($section['icon']))
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-primary-100 rounded-full mb-6">
                                <svg class="w-8 h-8 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    @if($section['icon'] === 'calendar')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    @elseif($section['icon'] === 'clock')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    @elseif($section['icon'] === 'check-circle')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    @endif
                                </svg>
                            </div>
                        @endif

                        <h3 class="text-xl font-bold mb-3">{{ $section['title'] }}</h3>
                        <p class="text-gray-500">{{ $section['description'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
