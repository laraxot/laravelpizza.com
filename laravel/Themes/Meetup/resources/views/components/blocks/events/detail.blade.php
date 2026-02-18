<?php

/**
 * Event Detail - Volt Component with Flat Properties
 * 
 * Pattern: Flat public properties populated in mount()
 * No computed properties for static data
 * All formatting logic centralized in mount()
 * 
 * @see Themes/Meetup/docs/volt-flat-properties-pattern.md
 */

use Livewire\Volt\Component;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Meetup\Models\Event;

new class extends Component {
    // Input properties (from route or props)
    public ?Event $event = null;
    public ?Event $item = null;
    public string $container0 = '';
    public string $slug0 = '';
    
    // Flat properties - populated in mount()
    public string $title = 'Event Title';
    public string $slug = '';
    public string $status = 'upcoming';
    public string $statusLabel = 'Upcoming';
    public ?string $description = null;
    public string $date = '';
    public string $time = '';
    public string $location = 'Location TBA';
    public string $address = '';
    public string $category = 'Meetup';
    public ?string $imageUrl = null;
    public int $attendeesCurrent = 0;
    public int $attendeesMax = 100;
    public int $availableSpots = 100;
    public string $eventsUrl = '';
    public string $badgeClass = 'bg-green-600';
    public bool $isUpcoming = true;
    
    // UI state (reactive)
    public bool $showBookingModal = false;
    public bool $showShareModal = false;

    public function mount(): void
    {
        // Resolve event from props or slug
        $eventModel = $this->event ?? $this->item;
        
        if ($eventModel === null && !empty($this->slug0)) {
            $eventModel = Event::where('slug', $this->slug0)->first();
        }
        
        // Fallback: try to get from URL segment
        if ($eventModel === null) {
            $slugFromUrl = Request::segment(3);
            if (!empty($slugFromUrl)) {
                $eventModel = Event::where('slug', $slugFromUrl)->first();
            }
        }

        // Populate all flat properties from model
        if ($eventModel instanceof Event) {
            $this->event = $eventModel;
            
            $startDate = $eventModel->start_date ?? Carbon::now();
            $endDate = $eventModel->end_date ?? $startDate;
            
            $this->title = $eventModel->title;
            $this->slug = $eventModel->slug;
            $this->description = $eventModel->description;
            $this->location = $eventModel->location ?? 'Location TBA';
            $this->address = $eventModel->address ?? 'Details to be announced';
            $this->category = $eventModel->category ?? 'Meetup';
            $this->attendeesCurrent = $eventModel->attendees_count ?? 0;
            $this->attendeesMax = $eventModel->max_attendees ?? 100;
            $this->imageUrl = $eventModel->image_url ?? $eventModel->cover_image;
            $this->availableSpots = max(0, $this->attendeesMax - $this->attendeesCurrent);
            
            // Date formatting
            $this->date = $startDate->format('l, F j, Y');
            $this->time = $startDate->format('H:i') . ' - ' . $endDate->format('H:i');
            
            // Status logic
            $this->isUpcoming = $startDate->isFuture();
            $this->status = $this->isUpcoming ? 'upcoming' : 'past';
            $this->statusLabel = $this->isUpcoming ? 'Upcoming' : 'Past Event';
            $this->badgeClass = $this->isUpcoming ? 'bg-green-600' : 'bg-slate-500';
        }

        // URLs
        $this->eventsUrl = LaravelLocalization::localizeUrl('/events');
    }
    
    public function openBooking(): void
    {
        $this->showBookingModal = true;
    }
    
    public function closeBooking(): void
    {
        $this->showBookingModal = false;
    }
    
    public function openShare(): void
    {
        $this->showShareModal = true;
    }
    
    public function closeShare(): void
    {
        $this->showShareModal = false;
    }
};

?>

<div>
@if (!$this->event)
    {{-- Event Not Found State --}}
    <div class="py-24 text-center">
        <h2 class="text-2xl font-bold text-white">{{ __('pub_theme::event.not_found.label') }}</h2>
        <p class="mt-4 text-slate-400">{{ __('pub_theme::event.not_found_description.label') }}</p>
        <a href="{{ $this->eventsUrl }}" class="mt-8 inline-block rounded-full bg-orange-600 px-8 py-3 font-semibold text-white transition hover:bg-orange-700">
            {{ __('pub_theme::event.back_to_events.label') }}
        </a>
    </div>
@else
    {{-- Event Found --}}
    <section class="relative py-12 lg:py-20 overflow-hidden">
        {{-- Background Elements --}}
        <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/4 w-[500px] h-[500px] bg-orange-600/10 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 translate-y-1/4 -translate-x-1/4 w-[400px] h-[400px] bg-blue-600/10 rounded-full blur-[100px] pointer-events-none"></div>

        <div class="container mx-auto px-4 relative">
            {{-- Breadcrumbs --}}
            <nav class="flex mb-8 text-sm font-medium" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li>
                        <a href="{{ LaravelLocalization::localizeUrl('/') }}" class="text-slate-400 hover:text-white transition">{{ __('pub_theme::event.home.label') }}</a>
                    </li>
                    <li class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-slate-600" fill="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ $this->eventsUrl }}" class="text-slate-400 hover:text-white transition">{{ __('pub_theme::event.events.label') }}</a>
                    </li>
                    <li class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-slate-600" fill="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-orange-500 truncate max-w-[200px]">{{ $this->title }}</span>
                    </li>
                </ol>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                {{-- Left Column: Main Content --}}
                <div class="lg:col-span-2">
                    <div class="relative rounded-3xl overflow-hidden bg-slate-900 border border-slate-800 shadow-2xl">
                        {{-- Hero Image --}}
                        <div class="aspect-video relative">
                            <img src="{{ $this->imageUrl ?? 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?auto=format&fit=crop&q=80&w=2070' }}" 
                                 alt="{{ $this->title }}" 
                                 class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
                            
                            {{-- Status Badge --}}
                            <div class="absolute top-6 left-6">
                                <span class="{{ $this->badgeClass }} text-white px-4 py-1.5 rounded-full text-sm font-bold shadow-lg flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                                    {{ $this->statusLabel }}
                                </span>
                            </div>
                        </div>

                        {{-- Header Info --}}
                        <div class="p-8 lg:p-12">
                            <div class="flex flex-wrap items-center gap-4 mb-6">
                                <span class="bg-orange-500/10 text-orange-500 px-4 py-1 rounded-full text-sm font-bold border border-orange-500/20">
                                    {{ $this->category }}
                                </span>
                                <div class="flex items-center text-slate-400 text-sm">
                                    <svg class="w-5 h-5 mr-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $this->time }}
                                </div>
                            </div>

                            <h1 class="text-4xl lg:text-5xl font-black text-white mb-8 leading-tight">
                                {{ $this->title }}
                            </h1>

                            {{-- Description --}}
                            <div class="prose prose-invert prose-orange max-w-none mb-12">
                                {!! nl2br(e($this->description)) !!}
                            </div>

                            {{-- Tech Stack Tags --}}
                            <div class="border-t border-slate-800 pt-12">
                                <h3 class="text-xl font-bold text-white mb-6">{{ __('pub_theme::event.topics.label') }}</h3>
                                <div class="flex flex-wrap gap-3">
                                    @foreach(['Laravel', 'Livewire', 'Tailwind CSS', 'Vite', 'Filament'] as $tag)
                                        <span class="bg-slate-800 hover:bg-slate-700 text-slate-300 px-4 py-2 rounded-xl text-sm transition cursor-default border border-slate-700/50">
                                            #{{ $tag }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Column: Sidebar --}}
                <div class="space-y-8">
                    {{-- RSVP Card --}}
                    <div class="bg-slate-900 border border-slate-800 rounded-3xl p-8 sticky top-8 shadow-2xl">
                        <div class="space-y-6">
                            {{-- Date info --}}
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-orange-500/10 flex flex-col items-center justify-center border border-orange-500/20 text-orange-500 shrink-0">
                                    <span class="text-xs font-bold uppercase leading-none">{{ Carbon::parse($this->date)->format('M') }}</span>
                                    <span class="text-xl font-black leading-none">{{ Carbon::parse($this->date)->format('d') }}</span>
                                </div>
                                <div>
                                    <p class="text-white font-bold">{{ $this->date }}</p>
                                    <p class="text-slate-400 text-sm">{{ $this->time }}</p>
                                </div>
                            </div>

                            {{-- Location info --}}
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-blue-500/10 flex items-center justify-center border border-blue-500/20 text-blue-500 shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-white font-bold">{{ $this->location }}</p>
                                    <p class="text-slate-400 text-sm line-clamp-2">{{ $this->address }}</p>
                                    <a href="#" class="text-blue-400 text-xs font-bold mt-1 inline-block hover:underline">{{ __('pub_theme::event.view_map.label') }}</a>
                                </div>
                            </div>

                            {{-- Capacity info --}}
                            <div class="bg-slate-800/50 rounded-2xl p-4 border border-slate-700/50">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-slate-400 text-sm">{{ __('pub_theme::event.spots_available.label') }}</span>
                                    <span class="text-white font-bold text-sm">{{ $this->availableSpots }} {{ __('pub_theme::event.of.label') }} {{ $this->attendeesMax }}</span>
                                </div>
                                <div class="w-full h-2 bg-slate-700 rounded-full overflow-hidden">
                                    <div class="h-full bg-orange-500 rounded-full" style="width: {{ ($this->attendeesCurrent / max($this->attendeesMax, 1)) * 100 }}%"></div>
                                </div>
                            </div>

                            {{-- RSVP Button --}}
                            @if($this->isUpcoming)
                                @guest
                                    <a href="{{ LaravelLocalization::localizeUrl('/register') }}" class="w-full bg-white hover:bg-slate-200 text-slate-900 font-bold py-4 rounded-2xl transition shadow-lg shadow-white/5 flex items-center justify-center gap-2 group">
                                        {{ __('pub_theme::event.sign_in_to_rsvp.label') }}
                                        <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                    </a>
                                @else
                                    <button wire:click="openBooking" class="w-full bg-orange-600 hover:bg-orange-500 text-white font-bold py-4 rounded-2xl transition shadow-lg shadow-orange-600/20 flex items-center justify-center gap-2 group">
                                        {{ __('pub_theme::event.rsvp_now.label') }}
                                        <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </button>
                                @endguest
                            @else
                                <button disabled class="w-full bg-slate-800 text-slate-500 font-bold py-4 rounded-2xl cursor-not-allowed">
                                    {{ __('pub_theme::event.registration_closed.label') }}
                                </button>
                            @endif
                        </div>
                    </div>
                    
                    {{-- Share Card --}}
                    <div class="bg-slate-900 border border-slate-800 rounded-3xl p-8 shadow-xl">
                        <h3 class="text-lg font-bold text-white mb-4">{{ __('pub_theme::event.share.label') }}</h3>
                        <div class="flex gap-3">
                            <button wire:click="openShare" class="flex-1 bg-sky-500 hover:bg-sky-600 text-white py-3 rounded-xl transition-colors font-medium flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.84 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                                {{ __('pub_theme::event.twitter.label') }}
                            </button>
                            <button wire:click="openShare" class="flex-1 bg-blue-700 hover:bg-blue-800 text-white py-3 rounded-xl transition-colors font-medium flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                {{ __('pub_theme::event.facebook.label') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    {{-- Booking Modal --}}
    @if($this->showBookingModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-slate-900/75 transition-opacity" aria-hidden="true" wire:click="closeBooking"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white dark:bg-slate-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white dark:bg-slate-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-slate-900 dark:text-white mb-4">
                            {{ __('pub_theme::event.book_event.label') }}
                        </h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">{{ $this->title }}</p>
                        {{-- Booking form handled by Filament Widget --}}
                        <div class="p-4 bg-slate-50 dark:bg-slate-700/50 rounded-lg">
                            <p class="text-sm text-slate-600 dark:text-slate-400 text-center">
                                {{ __('pub_theme::event.booking_via_filament.label') }}
                            </p>
                        </div>
                    </div>
                    <div class="bg-slate-50 dark:bg-slate-700/50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" wire:click="closeBooking" class="mt-3 w-full inline-flex justify-center rounded-md border border-slate-300 dark:border-slate-600 shadow-sm px-4 py-2 bg-white dark:bg-slate-800 text-base font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            {{ __('pub_theme::event.close.label') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    
    {{-- Share Modal --}}
    @if($this->showShareModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-slate-900/75 transition-opacity" aria-hidden="true" wire:click="closeShare"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white dark:bg-slate-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white dark:bg-slate-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-slate-900 dark:text-white mb-4">
                            {{ __('pub_theme::event.share_event.label') }}
                        </h3>
                        <div class="flex justify-center space-x-4">
                            <button wire:click="closeShare" class="p-3 rounded-full bg-sky-500 text-white hover:bg-sky-600 transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.84 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                            </button>
                            <button wire:click="closeShare" class="p-3 rounded-full bg-blue-700 text-white hover:bg-blue-800 transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </button>
                            <button wire:click="closeShare" class="p-3 rounded-full bg-blue-600 text-white hover:bg-blue-700 transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.14-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                            </button>
                        </div>
                    </div>
                    <div class="bg-slate-50 dark:bg-slate-700/50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" wire:click="closeShare" class="mt-3 w-full inline-flex justify-center rounded-md border border-slate-300 dark:border-slate-600 shadow-sm px-4 py-2 bg-white dark:bg-slate-800 text-base font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            {{ __('pub_theme::event.close.label') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif
</div>

@push('meta')
@if($this->event instanceof Event)
<script type="application/ld+json">
{!! json_encode($this->event->toSchemaOrg(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endif
@endpush
