{{--
    Homepage /it civic content blocks
    Civic portal content blocks parity with Design Comuni
    --}}

@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    {{-- Header Verde PA --}}
    <header class="bg-primary-500 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center">
                    <span class="text-primary-500 font-bold text-xl">C</span>
                </div>
                <div>
                    <h1 class="text-2xl font-bold">{{ __('geo::home.sections.header.title') }}</h1>
                    <p class="text-sm text-primary-100">{{ __('geo::home.sections.header.description') }}</p>
                </div>
                <nav class="hidden md:flex space-x-6">
                    <a href="#" class="hover:text-primary-100 transition">{{ __('geo::home.nav.home.label') }}</a>
                    <a href="#" class="hover:text-primary-100 transition">{{ __('geo::home.nav.news.label') }}</a>
                    <a href="#" class="hover:text-primary-100 transition">{{ __('geo::home.nav.services.label') }}</a>
                    <a href="#" class="hover:text-primary-100 transition">{{ __('geo::home.nav.participate.label') }}</a>
                </nav>
            </div>
        </div>
    </header>

    {{-- Breadcrumb --}}
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <nav class="flex text-sm text-gray-600">
                <a href="/" class="hover:text-primary-500">{{ __('geo::home.nav.home.label') }}</a>
                <span class="mx-2">/</span>
                <span class="text-gray-900">{{ __('geo::home.nav.home.label') }}</span>
            </nav>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Hero Section --}}
        <div class="mb-8">
            <div class="rounded-lg overflow-hidden shadow-lg bg-primary-50">
                <div class="bg-gradient-to-r from-primary-500 to-purple-500">
                    <div class="absolute inset-0 opacity-0">
                        <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2">
                            <h2 class="text-white text-4xl font-extrabold bg-white/40 py-8 px-6 text-center rounded-full shadow-inner animate-pulse">{{ __('geo::home.sections.hero.title') }}</h2>
                        </div>
                    </div>
                    <img src="{{ asset('geo/assets/geo-map-lit-aewYyAGi.js') }}" alt="{{ __('geo::home.hero.image.alt') }}" class="absolute inset-0 w-full h-full object-cover object-center opacity-70">
                </div>
            </div>
            <p class="max-w-2xl mx-auto text-center text-lg text-gray-600 py-4">
                {{ __('geo::home.sections.hero.description') }}
            </p>
        </div>

        {{-- Services Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
            {{-- Service Card 1 - News --}}
            <div class="rounded-lg border border-primary-200 bg-white shadow-sm hover:shadow-lg transition">
                <div class="px-6 py-8 flex flex-col items-start">
                    <div class="flex items-center space-x-3 mb-2">
                        <svg class="w-10 h-10 text-primary-500 flex-shrink-0">
                            <use href="#news-icon"/>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 flex-1">{{ __('geo::home.cards.news.title') }}</h3>
                    </div>
                    <p class="text-sm text-gray-600">{{ __('geo::home.cards.news.description') }}</p>
                    <a href="#" class="mt-3 inline-flex items-center text-primary-500 hover:text-primary-600 transition duration-200">
                        <span>{{ __('geo::home.cards.news.cta') }}</span>
                        <svg class="ml-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m7-7l-7 7m7 7l-7-7" />
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Service Card 2 - Servizi --}}
            <div class="rounded-lg border border-primary-200 bg-white shadow-sm hover:shadow-lg transition">
                <div class="px-6 py-8 flex flex-col items-start">
                    <div class="flex items-center space-x-3 mb-2">
                        <svg class="w-10 h-10 text-primary-500 flex-shrink-0">
                            <use href="#services-icon"/>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 flex-1">{{ __('geo::home.cards.services.title') }}</h3>
                    </div>
                    <p class="text-sm text-gray-600">{{ __('geo::home.cards.services.description') }}</p>
                    <a href="#" class="mt-3 inline-flex items-center text-primary-500 hover:text-primary-600 transition duration-200">
                        <span>{{ __('geo::home.cards.services.cta') }}</span>
                        <svg class="ml-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7m-7 7l-7-7m7 7l-7-7" />
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Service Card 3 - Eventi --}}
            <div class="rounded-lg border border-primary-200 bg-white shadow-sm hover:shadow-lg transition">
                <div class="px-6 py-8 flex flex-col items-start">
                    <div class="flex items-center space-x-3 mb-2">
                        <svg class="w-10 h-10 text-primary-500 flex-shrink-0">
                            <use href="#events-icon"/>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 flex-1">{{ __('geo::home.cards.events.title') }}</h3>
                    </div>
                    <p class="text-sm text-gray-600">{{ __('geo::home.cards.events.description') }}</p>
                    <a href="#" class="mt-3 inline-flex items-center text-primary-500 hover:text-primary-600 transition duration-200">
                        <span>{{ __('geo::home.cards.events.cta') }}</span>
                        <svg class="ml-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8v6m0 0l-1.405 1.405M20 16v6m0 0l1.405 1.405M8 12h16m-6 0V6a2 6 0 012-2h2a2 6 0 012 2v6a6 2 0 01-2 2h-2a2 6 0 01-2-2z" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection