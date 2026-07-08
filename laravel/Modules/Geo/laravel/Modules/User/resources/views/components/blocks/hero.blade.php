<?php

declare(strict_types=1);

?>
@props(['title', 'subtitle', 'image', 'cta-text', 'cta-link', 'background-color' => 'bg-gradient-to-br from-primary/5 via-base-100 to-primary/10', 'text-color' => 'text-base-content', 'cta-color' => 'btn-primary'])

<div class="relative overflow-hidden {{ $background-color }}">
    @if(isset($image))
        <div class="absolute inset-0 z-0">
            <img src="{{ $image }}" alt="" class="w-full h-full object-cover opacity-10">
        </div>
    @endif

    <!-- Decorative blob shapes -->
    <div class="absolute top-0 left-0 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] rounded-full bg-primary/20 blur-3xl"></div>
    <div class="absolute bottom-0 right-0 translate-x-1/2 translate-y-1/2 w-[500px] h-[500px] rounded-full bg-secondary/20 blur-3xl"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center gap-12 py-16 lg:py-24">
            <div class="flex-1 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary/10 text-primary mb-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-sm font-semibold tracking-wide">Innovazione nella </span>
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight {{ $text-color }} font-inter leading-[1.1] mb-8">
                    {!! nl2br(e($title)) !!}
                </h1>

                <p class="text-xl {{ $text-color }} opacity-90 font-inter max-w-2xl lg:max-w-none mb-12">
                    {{ $subtitle }}
                </p>

                @if(isset($cta-text) && isset($cta-link))
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="{{ $cta-link }}" class="btn {{ $cta-color }} btn-lg gap-3 min-w-[200px]">
                            {{ $cta-text }}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#come-funziona" class="btn btn-outline gap-3 btn-lg">
                            Scopri di più
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                @endif
            </div>

            <div class="flex-1 relative">
                <div class="aspect-square rounded-3xl bg-gradient-to-br from-primary/20 to-secondary/20 p-8">
                    <img src="{{ asset('images/hero-image.png') }}" alt="" class="w-full h-full object-cover rounded-2xl shadow-2xl">

                    <!-- Floating badges -->
                    <div class="absolute -left-8 top-1/4 bg-base-100 shadow-lg rounded-2xl p-4 flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-primary/20 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold">Assistenza Garantita</p>
                            <p class="text-sm opacity-70">Supporto Specialistico</p>
                        </div>
                    </div>

                    <div class="absolute -right-8 bottom-1/4 bg-base-100 shadow-lg rounded-2xl p-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-secondary/20 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-secondary" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold">Community</p>
                                <p class="text-sm opacity-70">Sempre al tuo fianco</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 py-12 border-t border-base-200">
            <div class="text-center">
                <p class="text-3xl font-bold text-primary">500+</p>
                <p class="text-sm opacity-70">Pazienti Assistite</p>
            </div>
            <div class="text-center">
                <p class="text-3xl font-bold text-primary">15+</p>
                <p class="text-sm opacity-70">Specialisti</p>
            </div>
            <div class="text-center">
                <p class="text-3xl font-bold text-primary">98%</p>
                <p class="text-sm opacity-70">Soddisfazione</p>
            </div>
            <div class="text-center">
                <p class="text-3xl font-bold text-primary">24/7</p>
                <p class="text-sm opacity-70">Supporto Online</p>
            </div>
        </div>
    </div>
</div>
