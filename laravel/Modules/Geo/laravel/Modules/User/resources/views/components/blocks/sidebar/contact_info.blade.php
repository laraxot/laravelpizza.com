<?php

declare(strict_types=1);

?>
@props([
    'title' => 'Contattaci',
    'description' => null,
    'phone' => null,
    'email' => null,
    'hours' => []
])

<div class="bg-white rounded-lg shadow-sm p-6 mb-6">
    <h3 class="text-xl font-bold mb-4">{{ $title }}</h3>

    @if($description)
        <p class="text-gray-600 mb-4">{{ $description }}</p>
    @endif

    <div class="space-y-4">
        @if($phone)
            <div class="flex items-start">
                <div class="flex-shrink-0 mr-3">
                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                </div>
                <div>
                    <p class="font-medium mb-1">Telefono</p>
                    <a href="tel:{{ preg_replace('/\s+/', '', $phone) }}" class="text-primary-600 hover:underline">{{ $phone }}</a>
                </div>
            </div>
        @endif

        @if($email)
            <div class="flex items-start">
                <div class="flex-shrink-0 mr-3">
                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="font-medium mb-1">Email</p>
                    <a href="mailto:{{ $email }}" class="text-primary-600 hover:underline">{{ $email }}</a>
                </div>
            </div>
        @endif

        @if(count($hours) > 0)
            <div class="flex items-start">
                <div class="flex-shrink-0 mr-3">
                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="font-medium mb-2">Orari</p>
                    <div class="space-y-1">
                        @foreach($hours as $hour)
                            <div class="flex justify-between">
                                <span class="text-gray-600">{{ $hour['days'] }}</span>
                                <span class="font-medium">{{ $hour['hours'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
