{{--
/**
 * Event detail page - SEO optimized with slug URLs
 * Displays full event information with structured data for SEO
 */
--}}

@props([
    'event' => null,
])

@php
use Modules\Meetup\Models\Event;

if ($event instanceof Event) {
    $eventArray = $event->toBlockArray();
    $status = $event->start_date->isFuture() ? 'upcoming' : 'past';
} else {
    $status = 'upcoming';
    $eventArray = [];
}
@endphp

<section class="py-12 md:py-16 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white transition-colors">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Breadcrumb --}}
        <nav class="mb-8 text-sm">
            <ol class="flex items-center space-x-2">
                <li><a href="{{ url('/it/events') }}" class="text-red-600 hover:text-red-700 dark:text-red-400">Events</a></li>
                <li class="text-slate-500 dark:text-gray-400">/</li>
                <li class="text-slate-500 dark:text-gray-400">{{ $event->title ?? 'Event' }}</li>
            </ol>
        </nav>

        {{-- Event Header --}}
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-lg overflow-hidden">
            {{-- Cover Image --}}
            <div class="aspect-video bg-slate-200 dark:bg-slate-700 flex items-center justify-center">
                @if(!empty($event->cover_image))
                    <img src="{{ $event->cover_image }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                @else
                    <div class="text-center text-slate-500 dark:text-gray-400">
                        <svg class="w-24 h-24 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-lg">Event</p>
                    </div>
                @endif
            </div>

            {{-- Status Badge --}}
            <div class="relative px-6 py-4">
                @if($status === 'upcoming')
                    <span class="absolute top-4 right-4 bg-green-600 text-white px-4 py-1 rounded-full text-sm font-semibold">Upcoming</span>
                @else
                    <span class="absolute top-4 right-4 bg-slate-500 text-white px-4 py-1 rounded-full text-sm font-semibold">Past Event</span>
                @endif

                {{-- Title --}}
                <h1 class="text-3xl md:text-4xl font-bold text-slate-900 dark:text-white mb-4">
                    {{ $event->title ?? 'Event Title' }}
                </h1>

                {{-- Event Details --}}
                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    <div class="space-y-3">
                        <div class="flex items-center text-slate-600 dark:text-gray-300">
                            <svg class="w-6 h-6 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>{{ $event->start_date->format('l, F j, Y') ?? 'Date' }}</span>
                        </div>
                        <div class="flex items-center text-slate-600 dark:text-gray-300">
                            <svg class="w-6 h-6 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ $event->start_date->format('g:i A') }} - {{ $event->end_date->format('g:i A') }}</span>
                        </div>
                        <div class="flex items-center text-slate-600 dark:text-gray-300">
                            <svg class="w-6 h-6 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>{{ $event->location ?? 'Location TBA' }}</span>
                        </div>
                    </div>
                    <div class="space-y-3">
                        @if($event->in_language)
                        <div class="flex items-center text-slate-600 dark:text-gray-300">
                            <svg class="w-6 h-6 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" />
                            </svg>
                            <span>Language: {{ strtoupper($event->in_language) }}</span>
                        </div>
                        @endif
                        @if($event->max_attendees > 0)
                        <div class="flex items-center text-slate-600 dark:text-gray-300">
                            <svg class="w-6 h-6 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>{{ $event->attendees_count }} / {{ $event->max_attendees }} spots filled</span>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Description --}}
                @if($event->description)
                <div class="mb-6">
                    <h2 class="text-xl font-semibold mb-3">About this event</h2>
                    <div class="prose prose-slate dark:prose-invert max-w-none">
                        {!! nl2br(e($event->description)) !!}
                    </div>
                </div>
                @endif

                {{-- CTA Button --}}
                @if($status === 'upcoming' && $event->registration_url)
                <div class="mt-6">
                    <a href="{{ $event->registration_url }}" 
                       class="inline-block bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-8 rounded-lg transition-colors">
                        Register Now
                    </a>
                </div>
                @endif
            </div>
        </div>

        {{-- Back to Events --}}
        <div class="mt-8 text-center">
            <a href="{{ url('/it/events') }}" class="text-red-600 hover:text-red-700 dark:text-red-400 font-medium">
                ← Back to all events
            </a>
        </div>
    </div>
</section>

{{-- SEO Structured Data --}}
@push('meta')
@if($event)
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Event",
    "name": "{{ $event->title }}",
    "description": "{{ strip_tags($event->description ?? '') }}",
    "startDate": "{{ $event->start_date->toIso8601String() }}",
    "endDate": "{{ $event->end_date->toIso8601String() }}",
    "eventStatus": "https://schema.org/EventScheduled",
    "eventAttendanceMode": "https://schema.org/OfflineEventAttendanceMode",
    "location": {
        "@type": "Place",
        "name": "{{ $event->location }}",
        "address": "{{ $event->location }}"
    },
    "image": "{{ $event->cover_image ?? '' }}",
    "organizer": {
        "@type": "Organization",
        "name": "Laravel Pizza Meetups"
    }
}
</script>
@endif
@endpush
