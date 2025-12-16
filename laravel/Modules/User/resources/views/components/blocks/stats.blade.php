<?php

declare(strict_types=1);

?>
@props(['title', 'stats'])

<div class="py-16 bg-base-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-base text-primary font-semibold tracking-wide uppercase font-inter">{{ $title }}</h2>
        </div>

        <div class="mt-16">
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($stats as $stat)
                    <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300">
                        <div class="card-body items-center text-center">
                            <div class="stat-title text-base-content/70 font-inter">{{ $stat['label'] }}</div>
                            <div class="stat-value text-primary font-inter">{{ $stat['value'] }}</div>
                            @if(isset($stat['description']))
                                <div class="stat-desc text-base-content/60 font-inter">{{ $stat['description'] }}</div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
