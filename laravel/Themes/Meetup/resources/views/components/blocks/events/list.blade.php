@props([
    'data' => [],
    'title' => null,
    'description' => null,
    'events' => [],
    'view_all_url' => null,
])

@php
    // Support both formats: separate variables or $data array
    // When @include passes $block->data, Laravel expands the array into separate variables
    $title = $title ?? ($data['title'] ?? 'Upcoming Events');
    $description = $description ?? ($data['description'] ?? 'Join us at our next meetup');
    $events = $events ?? ($data['events'] ?? []);
    $view_all_url = $view_all_url ?? ($data['view_all_url'] ?? null);
@endphp

{{-- Event Cards Section --}}
<section class="py-20">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-4">{{ $title }}</h2>
            <p class="text-xl text-gray-400">{{ $description }}</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8 mb-12">
            @foreach($events as $event)
            <!-- Event Card -->
            <div class="bg-slate-800 border border-slate-700 rounded-xl overflow-hidden hover:border-red-500/50 transition-colors">
                <div class="bg-gradient-to-r from-red-600 to-red-700 p-6">
                    <div class="text-sm font-semibold text-red-100 mb-2">{{ $event['category'] ?? 'Laravel Meetup' }}</div>
                    <h3 class="text-2xl font-bold text-white">{{ $event['title'] ?? 'Event Title' }}</h3>
                </div>
                <div class="p-6">
                    <div class="flex items-center text-gray-400 mb-3">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ $event['date'] ?? 'December 15, 2024' }} - {{ $event['time'] ?? '18:00' }}
                    </div>
                    <div class="flex items-center text-gray-400 mb-4">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        </svg>
                        {{ $event['location'] ?? 'New York, USA' }}
                    </div>
                    <a href="{{ $event['url'] ?? '#' }}" class="block w-full bg-red-600 hover:bg-red-700 text-white text-center px-4 py-2 rounded-lg font-medium transition-colors">
                        View Details
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        @if($view_all_url)
        <div class="text-center">
            <a href="{{ $view_all_url }}" class="inline-flex items-center text-red-500 hover:text-red-400 font-semibold text-lg">
                View All Events
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
        </div>
        @endif
    </div>
</section>