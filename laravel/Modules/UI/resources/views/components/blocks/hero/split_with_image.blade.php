<?php

declare(strict_types=1);
?>
@props([
    'title' => __('ui::blocks_hero.shared.title_placeholder.title'),
    'description' => __('ui::blocks_demo_shared.copy.paragraph_3.description'),
    'primaryButtonText' => __('ui::blocks_demo_shared.labels.get_started.label'),
    'primaryButtonUrl' => '#',
    'secondaryButtonText' => __('ui::blocks_demo_shared.labels.learn_more.label'),
    'secondaryButtonUrl' => '#',
    'announcement' => __('ui::blocks_hero.shared.announcement.message'),
    'announcementUrl' => '#',
    'logoUrl' => 'https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600',
    'logoAlt' => __('ui::blocks_hero.shared.your_company.alt'),
    'imageUrl' => 'https://images.unsplash.com/photo-1498758536662-35b82cd15e29?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2102&q=80',
    'imageAlt' => ''
])

<div class="relative bg-white">
    <div class="mx-auto max-w-7xl lg:grid lg:grid-cols-12 lg:gap-x-8 lg:px-8">
        <div class="px-6 pb-24 pt-10 sm:pb-32 lg:col-span-7 lg:px-0 lg:pb-56 lg:pt-48 xl:col-span-6">
            <div class="mx-auto max-w-2xl lg:mx-0">
                @if($logoUrl)
                    <img class="h-11" src="{{ $logoUrl }}" alt="{{ $logoAlt }}">
                @endif
                
                @if($announcement)
                    <div class="hidden sm:mt-32 sm:flex lg:mt-16">
                        <div class="relative rounded-full px-3 py-1 text-sm leading-6 text-gray-500 ring-1 ring-gray-900/10 hover:ring-gray-900/20">
                            {{ $announcement }}
                            <a href="{{ $announcementUrl }}" class="whitespace-nowrap font-semibold text-indigo-600">
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                {{ __('ui::blocks_hero.shared.read_more.label') }} <span aria-hidden="true">&rarr;</span>
                            </a>
                        </div>
                    </div>
                @endif

                <h1 class="mt-24 text-4xl font-bold tracking-tight text-gray-900 sm:mt-10 sm:text-6xl">{{ $title }}</h1>
                <p class="mt-6 text-lg leading-8 text-gray-600">{{ $description }}</p>
                
                <div class="mt-10 flex items-center gap-x-6">
                    <a href="{{ $primaryButtonUrl }}" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        {{ $primaryButtonText }}
                    </a>
                    <a href="{{ $secondaryButtonUrl }}" class="text-sm font-semibold leading-6 text-gray-900">
                        {{ $secondaryButtonText }} <span aria-hidden="true">→</span>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="relative lg:col-span-5 lg:-mr-8 xl:absolute xl:inset-0 xl:left-1/2 xl:mr-0">
            <img 
                class="aspect-[3/2] w-full bg-gray-50 object-cover lg:absolute lg:inset-0 lg:aspect-auto lg:h-full" 
                src="{{ $imageUrl }}" 
                alt="{{ $imageAlt }}"
            >
        </div>
    </div>
</div>
