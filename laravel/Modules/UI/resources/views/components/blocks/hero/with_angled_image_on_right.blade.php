<?php

declare(strict_types=1);

?>
@props([
    'title' => 'Data to enrich your online business',
    'description' => 'Anim aute id magna aliqua ad ad non deserunt sunt. Qui irure qui lorem cupidatat commodo. Elit sunt amet fugiat veniam occaecat fugiat aliqua.',
    'primaryButtonText' => 'Get started',
    'primaryButtonUrl' => '#',
    'secondaryButtonText' => 'Learn more',
    'secondaryButtonUrl' => '#',
    'announcement' => 'Anim aute id magna aliqua ad ad non deserunt sunt.',
    'announcementUrl' => '#',
    'logoUrl' => 'https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600',
    'logoAlt' => 'Your Company',
    'imageUrl' => 'https://images.unsplash.com/photo-1521737711867-e3b97375f902?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1587&q=80',
    'imageAlt' => '',
    'navigation' => [
        ['text' => 'Product', 'url' => '#'],
        ['text' => 'Features', 'url' => '#'],
        ['text' => 'Marketplace', 'url' => '#'],
        ['text' => 'Company', 'url' => '#'],
        ['text' => 'Log in', 'url' => '#']
    ]
])

<div class="bg-white">
    <header class="absolute inset-x-0 top-0 z-50">
        <div class="mx-auto max-w-7xl">
            <div class="px-6 pt-6 lg:max-w-2xl lg:pl-8 lg:pr-0">
                <nav class="flex items-center justify-between lg:justify-start" aria-label="Global">
                    @if($logoUrl)
                        <a href="#" class="-m-1.5 p-1.5">
                            <span class="sr-only">{{ $logoAlt }}</span>
                            <img alt="{{ $logoAlt }}" class="h-8 w-auto" src="{{ $logoUrl }}">
                        </a>
                    @endif
                    <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700 lg:hidden">
                        <span class="sr-only">Open main menu</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                    <div class="hidden lg:ml-12 lg:flex lg:gap-x-14">
                        @foreach($navigation as $item)
                            <a href="{{ $item['url'] }}" class="text-sm font-semibold leading-6 text-gray-900">{{ $item['text'] }}</a>
                        @endforeach
                    </div>
                </nav>
            </div>
        </div>
        <!-- Mobile menu, show/hide based on menu open state. -->
        <div class="lg:hidden" role="dialog" aria-modal="true">
            <!-- Background backdrop, show/hide based on slide-over state. -->
            <div class="fixed inset-0 z-50"></div>
            <div class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
                <div class="flex items-center justify-between">
                    @if($logoUrl)
                        <a href="#" class="-m-1.5 p-1.5">
                            <span class="sr-only">{{ $logoAlt }}</span>
                            <img class="h-8 w-auto" src="{{ $logoUrl }}" alt="">
                        </a>
                    @endif
                    <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700">
                        <span class="sr-only">Close menu</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="mt-6 flow-root">
                    <div class="-my-6 divide-y divide-gray-500/10">
                        <div class="space-y-2 py-6">
                            @foreach($navigation as $item)
                                <a href="{{ $item['url'] }}" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">{{ $item['text'] }}</a>
                            @endforeach
                        </div>
                        <div class="py-6">
                            <a href="#" class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Log in</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="relative">
        <div class="mx-auto max-w-7xl">
            <div class="relative z-10 pt-14 lg:w-full lg:max-w-2xl">
                <svg class="absolute inset-y-0 right-8 hidden h-full w-80 translate-x-1/2 transform fill-white lg:block" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                    <polygon points="0,0 90,0 50,100 0,100" />
                </svg>

                <div class="relative px-6 py-32 sm:py-40 lg:px-8 lg:py-56 lg:pr-0">
                    <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-xl">
                        @if($announcement)
                            <div class="hidden sm:mb-10 sm:flex">
                                <div class="relative rounded-full px-3 py-1 text-sm leading-6 text-gray-500 ring-1 ring-gray-900/10 hover:ring-gray-900/20">
                                    {{ $announcement }}
                                    <a href="{{ $announcementUrl }}" class="whitespace-nowrap font-semibold text-indigo-600">
                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                        Read more <span aria-hidden="true">&rarr;</span>
                                    </a>
                                </div>
                            </div>
                        @endif
                        <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">{{ $title }}</h1>
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
            </div>
        </div>
        <div class="bg-gray-50 lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
            <img class="aspect-[3/2] object-cover lg:aspect-auto lg:h-full lg:w-full" src="{{ $imageUrl }}" alt="{{ $imageAlt }}">
        </div>
    </div>
</div>
