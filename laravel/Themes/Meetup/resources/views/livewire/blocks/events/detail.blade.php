<?php
declare(strict_types=1);

use Illuminate\Support\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Volt\Component;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Meetup\Models\Event;

new class extends Component {
    public ?string $container0 = null;
    public ?string $slug0 = null;
    public $event = null;
    public $item = null;
    public $eventModel = null;

    public function mount(): void
    {
        $model = $this->event ?? $this->item;
        if ($model === null && $this->slug0 !== null && $this->slug0 !== '') {
            $model = Event::where('slug', $this->slug0)->first();
        }
        $this->eventModel = $model;
    }

    #[Computed]
    public function eventData(): array
    {
        $e = $this->eventModel;
        if ($e instanceof Event) {
            $start = $e->start_date ?? Carbon::now();
            $end = $e->end_date ?? $start;
            $status = $start->isFuture() ? 'upcoming' : 'past';
            return [
                'title' => $e->title,
                'slug' => $e->slug,
                'status' => $status,
                'status_label' => $status === 'upcoming' ? 'Upcoming' : 'Past Event',
                'description' => $e->description,
                'date' => $start->format('l, F j, Y'),
                'time' => $start->format('g:i A').' - '.$end->format('g:i A'),
                'location' => $e->location ?? 'Location TBA',
                'attendees_current' => $e->attendees_count ?? 0,
                'attendees_max' => $e->max_attendees ?? 100,
                'cover_image' => $e->cover_image,
                'available_spots' => ($e->max_attendees ?? 100) - ($e->attendees_count ?? 0),
            ];
        }
        return [
            'title' => 'Event Title',
            'slug' => '',
            'status' => 'upcoming',
            'status_label' => 'Upcoming',
            'description' => null,
            'date' => Carbon::now()->format('l, F j, Y'),
            'time' => '',
            'location' => 'Location TBA',
            'attendees_current' => 0,
            'attendees_max' => 100,
            'cover_image' => null,
            'available_spots' => 100,
        ];
    }

    #[Computed]
    public function eventsUrl(): string
    {
        return LaravelLocalization::localizeUrl('/events');
    }

    #[Computed]
    public function badgeClass(): string
    {
        return $this->eventData['status'] === 'upcoming' ? 'bg-green-600' : 'bg-slate-500';
    }
}; ?>

<div class="min-h-screen bg-slate-50 dark:bg-slate-900 overflow-x-hidden relative">
    @include('pub_theme::components.ui.particles')

    <div class="relative bg-slate-900 h-[400px] md:h-[500px] z-0">
        @if(!empty($this->eventData['cover_image']))
            <img src="{{ $this->eventData['cover_image'] }}" alt="{{ $this->eventData['title'] }}" class="w-full h-full object-cover opacity-70">
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
                    {{ $this->eventData['status_label'] }}
                </span>
                
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white">
                    {{ $this->eventData['title'] }}
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
                                <p class="text-base font-semibold text-slate-900 dark:text-white">{{ $this->eventData['date'] }}</p>
                            </div>
                        </div>
                        
                        @if($this->eventData['time'])
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ __('pub_theme::event.time.label') }}</p>
                                <p class="text-base font-semibold text-slate-900 dark:text-white">{{ $this->eventData['time'] }}</p>
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
                                <p class="text-base font-semibold text-slate-900 dark:text-white">{{ $this->eventData['location'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if($this->eventData['description'])
                <section class="bg-white dark:bg-slate-800 rounded-lg shadow-sm p-8 border border-slate-200 dark:border-slate-700">
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-4">
                        {{ __('pub_theme::event.about_this_event.label') }}
                    </h2>
                    <div class="prose dark:prose-invert max-w-none text-slate-600 dark:text-slate-300 leading-relaxed">
                        {!! nl2br(e($this->eventData['description'])) !!}
                    </div>
                </section>
                @endif

                <section class="bg-white dark:bg-slate-800 rounded-lg shadow-sm p-8 border border-slate-200 dark:border-slate-700">
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-4">
                        {{ __('pub_theme::event.event_location.label') }}
                    </h2>
                    <div class="space-y-4">
                        <p class="text-lg text-slate-700 dark:text-slate-300">
                            {{ $this->eventData['location'] }}
                        </p>
                        <div class="aspect-video bg-slate-100 dark:bg-slate-700 rounded-lg flex items-center justify-center border-2 border-dashed border-slate-300 dark:border-slate-600">
                            <div class="text-center text-slate-500 dark:text-slate-400">
                                <svg class="w-16 h-16 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0121 18.382V7.618a1 1 0 01-.553-.894L15 4m0 13V4m0 0L9 7" />
                                </svg>
                                <p class="text-sm font-medium">{{ __('pub_theme::event.map_loading.label') }}</p>
                                <p class="text-xs mt-1">{{ __('pub_theme::event.click_to_view.label') }}</p>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="bg-white dark:bg-slate-800 rounded-lg shadow-sm p-8 border border-slate-200 dark:border-slate-700">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white">
                            {{ __('pub_theme::event.attendees.label') }}
                        </h2>
                        <span class="text-lg font-medium text-slate-600 dark:text-slate-400">
                            {{ $this->eventData['attendees_current'] }} / {{ $this->eventData['attendees_max'] }}
                        </span>
                    </div>
                    
                    <div class="flex items-center">
                        <div class="flex -space-x-3">
                            @php $maxDisplay = min($this->eventData['attendees_current'], 8); @endphp
                            @for($i = 0; $i < $maxDisplay; $i++)
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-red-500 to-red-600 border-3 border-white dark:border-slate-800 flex items-center justify-center text-white font-semibold text-sm shadow-md">
                                    {{ chr(65 + ($i % 26)) }}
                                </div>
                            @endfor
                            @if($this->eventData['attendees_current'] > 8)
                                <div class="w-12 h-12 rounded-full bg-slate-200 dark:bg-slate-600 border-3 border-white dark:border-slate-800 flex items-center justify-center text-slate-700 dark:text-slate-300 font-semibold text-xs shadow-md">
                                    +{{ $this->eventData['attendees_current'] - 8 }}
                                </div>
                            @endif
                        </div>
                        @if($this->eventData['attendees_current'] > 0)
                        <span class="ml-4 text-sm text-slate-500 dark:text-slate-400">
                            {{ __('pub_theme::event.people_joined.label', ['count' => $this->eventData['attendees_current']]) }}
                        </span>
                        @endif
                    </div>
                </section>
            </div>

            <div class="lg:col-span-1">
                <div class="sticky top-8 space-y-6">
                    @if($this->eventData['status'] === 'upcoming')
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg p-6 border border-slate-200 dark:border-slate-700">
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">
                            {{ __('pub_theme::event.join_event.label') }}
                        </h3>
                        
                        <div class="mb-6">
                            <p class="text-sm text-slate-600 dark:text-slate-400 mb-1">
                                {{ __('pub_theme::event.available_spots.label') }}
                            </p>
                            <p class="text-4xl font-bold text-red-600 dark:text-red-400">
                                {{ $this->eventData['available_spots'] }}
                            </p>
                        </div>
                        
                        <button type="button" class="w-full bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 text-white font-bold py-3.5 px-6 rounded-lg transition-all shadow-md hover:shadow-lg">
                            {{ __('pub_theme::event.book_your_spot.label') }}
                        </button>
                        
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-4 text-center">
                            {{ __('pub_theme::event.spots_filling_fast.label') }}
                        </p>
                    </div>
                    @endif

                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm p-6 border border-slate-200 dark:border-slate-700">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">
                            {{ __('pub_theme::event.share_event.label') }}
                        </h3>
                        <div class="flex gap-3">
                            <button type="button" class="flex-1 bg-sky-500 hover:bg-sky-600 text-white py-2.5 px-4 rounded-lg transition-colors font-medium text-sm flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.84 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                                Twitter
                            </button>
                            <button type="button" class="flex-1 bg-blue-700 hover:bg-blue-800 text-white py-2.5 px-4 rounded-lg transition-colors font-medium text-sm flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.14-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                LinkedIn
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('meta')
@if($this->eventModel instanceof \Modules\Meetup\Models\Event)
<script type="application/ld+json">
{!! json_encode($this->eventModel->toSchemaOrg(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endif
@endpush
