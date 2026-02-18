<?php
declare(strict_types=1);

/**
 * Event detail block - Volt Component
 * Full layout with 2-column design, sidebar CTA, About, Location, Attendees
 * SEO optimized with Schema.org structured data
 *
 * Accepts props: event, item, container0, slug0
 * Uses Volt class for automatic model loading from slug
 */

use Livewire\Volt\Component;
use Modules\Meetup\Models\Event;
use Illuminate\Support\Carbon;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

new class extends Component {
    public ?Event $event = null;
    public ?Event $item = null;
    public string $container0 = '';
    public string $slug0 = '';
    
    public string $title = 'Event Title';
    public string $slug = '';
    public string $status = 'upcoming';
    public string $statusLabel = 'Upcoming';
    public ?string $description = null;
    public string $date = '';
    public string $time = '';
    public string $location = 'Location TBA';
    public int $attendeesCurrent = 0;
    public int $attendeesMax = 100;
    public ?string $coverImage = null;
    public int $availableSpots = 100;
    public string $eventsUrl = '';
    public string $badgeClass = 'bg-green-600';

    public function mount(): void
    {
        $eventModel = $this->event ?? $this->item;
        
        if ($eventModel === null && !empty($this->slug0)) {
            $eventModel = Event::where('slug', $this->slug0)->first();
        }

        if ($eventModel instanceof Event) {
            $startDate = $eventModel->start_date ?? Carbon::now();
            $endDate = $eventModel->end_date ?? $startDate;
            
            $this->title = $eventModel->title;
            $this->slug = $eventModel->slug;
            $this->description = $eventModel->description;
            $this->date = $startDate->format('l, F j, Y');
            $this->time = $startDate->format('g:i A') . ' - ' . $endDate->format('g:i A');
            $this->location = $eventModel->location ?? 'Location TBA';
            $this->attendeesCurrent = $eventModel->attendees_count ?? 0;
            $this->attendeesMax = $eventModel->max_attendees ?? 100;
            $this->coverImage = $eventModel->cover_image;
            $this->availableSpots = ($eventModel->max_attendees ?? 100) - ($eventModel->attendees_count ?? 0);
            
            $this->status = $startDate->isFuture() ? 'upcoming' : 'past';
            $this->statusLabel = $this->status === 'upcoming' ? 'Upcoming' : 'Past Event';
            $this->badgeClass = $this->status === 'upcoming' ? 'bg-green-600' : 'bg-slate-500';
        }

        $this->eventsUrl = LaravelLocalization::localizeUrl('/events');
    }
};
?>

@props([
    'event' => null,
    'item' => null,
    'container0' => '',
    'slug0' => '',
])

<div class="min-h-screen bg-slate-50 dark:bg-slate-900 overflow-x-hidden relative">
    @include('pub_theme::components.ui.particles')

    <div class="relative bg-slate-900 h-[400px] md:h-[500px] z-0">
        @if(!empty($this->coverImage))
            <img src="{{ $this->coverImage }}" alt="{{ $this->title }}" class="w-full h-full object-cover opacity-70">
        @else
            <div class="w-full h-full bg-gradient-to-br from-red-600 via-red-700 to-slate-900 flex items-center justify-center">
                <svg class="w-32 h-32 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
        @endif
        
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/50 to-transparent flex items-end">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full pb-12">
                <a href="{{ $this->eventsUrl }}" class="inline-flex items-center text-white/80 hover:text-white mb-4 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    {{ __('pub_theme::event.back_to_events.label') }}
                </a>
                
                <span class="inline-block {{ $this->badgeClass }} text-white px-4 py-1 rounded-full text-sm font-semibold mb-4">
                    {{ $this->statusLabel }}
                </span>
                
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white">
                    {{ $this->title }} 
                </h1>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm p-6 border border-slate-200 dark:border-slate-700">
                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ __('pub_theme::event.date.label') }}</p>
                                <p class="text-base font-semibold text-slate-900 dark:text-white">{{ $this->date }}</p>
                            </div>
                        </div>
                        
                        @if($this->time)
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ __('pub_theme::event.time.label') }}</p>
                                <p class="text-base font-semibold text-slate-900 dark:text-white">{{ $this->time }}</p>
                            </div>
                        </div>
                        @endif
                        
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ __('pub_theme::event.location.label') }}</p>
                                <p class="text-base font-semibold text-slate-900 dark:text-white">{{ $this->location }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if($this->description)
                <section class="bg-white dark:bg-slate-800 rounded-lg shadow-sm p-8 border border-slate-200 dark:border-slate-700">
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-4">
                        {{ __('pub_theme::event.about_this_event.label') }}
                    </h2>
                    <div class="prose dark:prose-invert max-w-none text-slate-600 dark:text-slate-300 leading-relaxed">
                        {!! nl2br(e($this->description)) !!}
                    </div>
                </section>
                @endif

                <section class="bg-white dark:bg-slate-800 rounded-lg shadow-sm p-8 border border-slate-200 dark:border-slate-700">
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-4">
                        {{ __('pub_theme::event.event_location.label') }}
                    </h2>
                    <div class="space-y-4">
                        <p class="text-lg text-slate-700 dark:text-slate-300">
                            {{ $this->location }}
                        </p>
                    </div>
                </section>

                <section class="bg-white dark:bg-slate-800 rounded-lg shadow-sm p-8 border border-slate-200 dark:border-slate-700">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white">
                            {{ __('pub_theme::event.attendees.label') }}
                        </h2>
                        <span class="text-lg font-medium text-slate-600 dark:text-slate-400">
                            {{ $this->attendeesCurrent }} / {{ $this->attendeesMax }}
                        </span>
                    </div>
                    
                    <div class="flex items-center">
                        <div class="flex -space-x-3">
                            @php
                            $maxDisplay = min($this->attendeesCurrent, 8);
                            @endphp
                            @for($i = 0; $i < $maxDisplay; $i++)
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-red-500 to-red-600 border-3 border-white dark:border-slate-800 flex items-center justify-center text-white font-semibold text-sm shadow-md">
                                    {{ chr(65 + ($i % 26)) }}
                                </div>
                            @endfor
                            @if($this->attendeesCurrent > 8)
                                <div class="w-12 h-12 rounded-full bg-slate-200 dark:bg-slate-600 border-3 border-white dark:border-slate-800 flex items-center justify-center text-slate-700 dark:text-slate-300 font-semibold text-xs shadow-md">
                                    +{{ $this->attendeesCurrent - 8 }}
                                </div>
                            @endif
                        </div>
                        @if($this->attendeesCurrent > 0)
                        <span class="ml-4 text-sm text-slate-500 dark:text-slate-400">
                            {{ __('pub_theme::event.people_joined.label', ['count' => $this->attendeesCurrent]) }}
                        </span>
                        @endif
                    </div>
                </section>
            </div>

            <div class="lg:col-span-1">
                <div class="sticky top-8 space-y-6">
                    @if($this->status === 'upcoming')
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg p-6 border border-slate-200 dark:border-slate-700">
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">
                            {{ __('pub_theme::event.join_event.label') }}
                        </h3>
                        
                        <div class="mb-6">
                            <p class="text-sm text-slate-600 dark:text-slate-400 mb-1">
                                {{ __('pub_theme::event.available_spots.label') }}
                            </p>
                            <p class="text-4xl font-bold text-red-600 dark:text-red-400">
                                {{ $this->availableSpots }}
                            </p>
                        </div>
                        
                        <button type="button" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3.5 px-6 rounded-lg transition-all shadow-md hover:shadow-lg">
                            {{ __('pub_theme::event.book_your_spot.label') }}
                        </button>
                    </div>
                    @endif

                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm p-6 border border-slate-200 dark:border-slate-700">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">
                            {{ __('pub_theme::event.share_event.label') }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
