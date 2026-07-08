<?php

declare(strict_types=1);

?>
@props(['title', 'description', 'button-text', 'button-link'])

<div class="py-16 bg-primary text-primary-content">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-3xl font-extrabold tracking-tight sm:text-4xl font-inter">
                {{ $title }}
            </h2>
            <p class="mt-4 text-lg leading-6 font-inter opacity-90">
                {{ $description }}
            </p>
            <div class="mt-8">
                <a href="{{ $button-link }}" class="btn btn-secondary btn-lg font-inter">
                    {{ $button-text }}
                </a>
            </div>
        </div>
    </div>
</div>
