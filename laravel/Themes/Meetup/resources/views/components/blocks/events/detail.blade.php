<?php

/**
 * Event Detail - Volt Component
 * Full layout with 2-column design, sidebar CTA, About, Location, Attendees
 * Unica fonte di verità: Modello Event.
 */

use Livewire\Volt\Component;
use Modules\Meetup\Models\Event;
use Illuminate\Support\Carbon;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

new class extends Component {
    // Props from parent/route
    public ?Event $event = null;
    public ?Event $item = null;
    public string $container0 = '';
    public string $slug0 = '';
    
    // Component state
    public bool $showBookingModal = false;
    public bool $showShareModal = false;
    public string $bookingName = '';
    public string $bookingEmail = '';
    public string $shareUrl = '';
    
    public function mount(): void
    {
        // Support both 'event' (specific) and 'item' (generic) props, or load from slug0
        if ($this->event === null && $this->item === null && !empty($this->slug0)) {
            $this->event = Event::where('slug', $this->slug0)->first();
        } elseif ($this->event === null && $this->item !== null) {
            $this->event = $this->item instanceof Event ? $this->item : null;
        }
        
        if ($this->event) {
            $this->shareUrl = LaravelLocalization::localizeUrl('/events/' . $this->event->slug);
        }
    }
    
    public function isUpcoming(): bool
    {
        if (!$this->event || !$this->event->start_date) return false;
        return Carbon::parse($this->event->start_date)->isFuture();
    }
    
    public function getDate(): string
    {
        if (!$this->event || !$this->event->start_date) {
            return Carbon::now()->translatedFormat('l, j F Y');
        }
        return Carbon::parse($this->event->start_date)->translatedFormat('l, j F Y');
    }
    
    public function getTime(): string
    {
        if (!$this->event || !$this->event->start_date) return '';
        $start = Carbon::parse($this->event->start_date);
        $end = $this->event->end_date ? Carbon::parse($this->event->end_date) : $start;
        return $start->format('g:i A') . ' - ' . $end->format('g:i A');
    }
    
    public function getAvailableSpots(): int
    {
        if (!$this->event) return 0;
        return max(0, ($this->event->max_attendees ?? 100) - ($this->event->attendees_count ?? 0));
    }

    public function openBookingModal(): void { $this->showBookingModal = true; }
    public function closeBookingModal(): void { 
        $this->showBookingModal = false; 
        $this->bookingName = ''; 
        $this->bookingEmail = ''; 
    }
    
    public function book(): void
    {
        // In a real scenario, this would create a booking record
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Booking confirmed!']);
        $this->closeBookingModal();
    }
    
    public function openShareModal(): void { $this->showShareModal = true; }
    public function closeShareModal(): void { $this->showShareModal = false; }
};

?>

<div class="min-h-screen bg-slate-50 dark:bg-slate-900 overflow-x-hidden relative">
    @include('pub_theme::components.ui.particles')

    @if($this->event)
    {{-- Hero Section --}}
    <div class="relative bg-slate-900 h-[400px] md:h-[500px] z-0">
        @if($this->event->cover_image)
            <img src="{{ $this->event->cover_image }}" alt="{{ $this->event->title }}" class="w-full h-full object-cover opacity-70">
        @else
            <div class="w-full h-full bg-gradient-to-br from-red-600 via-red-700 to-slate-900 flex items-center justify-center">
                <svg class="w-32 h-32 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
        @endif

        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/50 to-transparent flex items-end">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full pb-12">
                <a href="{{ LaravelLocalization::localizeUrl('/events') }}" class="inline-flex items-center text-white/80 hover:text-white mb-4 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    {{ __('pub_theme::event.actions.back_to_events.label') }}
                </a>

                <span class="inline-block {{ $this->isUpcoming() ? 'bg-green-600' : 'bg-slate-500' }} text-white px-4 py-1 rounded-full text-sm font-semibold mb-4">
                    {{ $this->isUpcoming() ? __('pub_theme::event.status.upcoming.label') : __('pub_theme::event.status.past.label') }}
                </span>

                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white">
                    {{ $this->event->title }}
                </h1>
            </div>
        </div>
    </div>

    {{-- Content Section --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                {{-- Quick Info Card --}}
                <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm p-6 border border-slate-200 dark:border-slate-700">
                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ __('pub_theme::event.fields.date.label') }}</p>
                                <p class="text-base font-semibold text-slate-900 dark:text-white">{{ $this->getDate() }}</p>
                            </div>
                        </div>

                        @if($this->getTime())
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ __('pub_theme::event.fields.time.label') }}</p>
                                <p class="text-base font-semibold text-slate-900 dark:text-white">{{ $this->getTime() }}</p>
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
                                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ __('pub_theme::event.fields.location.label') }}</p>
                                <p class="text-base font-semibold text-slate-900 dark:text-white">{{ $this->event->location ?? 'Location TBA' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- About Section --}}
                @if($this->event->description)
                <section class="bg-white dark:bg-slate-800 rounded-lg shadow-sm p-8 border border-slate-200 dark:border-slate-700">
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-4">
                        {{ __('pub_theme::event.fields.about_this_event.label') }}
                    </h2>
                    <div class="prose dark:prose-invert max-w-none text-slate-600 dark:text-slate-300 leading-relaxed">
                        {!! nl2br(e($this->event->description)) !!}
                    </div>
                </section>
                @endif

                {{-- Attendees Section --}}
                <section class="bg-white dark:bg-slate-800 rounded-lg shadow-sm p-8 border border-slate-200 dark:border-slate-700">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white">
                            {{ __('pub_theme::event.fields.attendees.label') }}
                        </h2>
                        <span class="text-lg font-medium text-slate-600 dark:text-slate-400">
                            {{ $this->event->attendees_count ?? 0 }} / {{ $this->event->max_attendees ?? 100 }}
                        </span>
                    </div>

                    <div class="flex items-center">
                        <div class="flex -space-x-3">
                            @php $maxDisplay = min($this->event->attendees_count ?? 0, 8); @endphp
                            @for($i = 0; $i < $maxDisplay; $i++)
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-red-500 to-red-600 border-3 border-white dark:border-slate-800 flex items-center justify-center text-white font-semibold text-sm shadow-md">
                                    {{ chr(65 + ($i % 26)) }}
                                </div>
                            @endfor
                            @if(($this->event->attendees_count ?? 0) > 8)
                                <div class="w-12 h-12 rounded-full bg-slate-200 dark:bg-slate-600 border-3 border-white dark:border-slate-800 flex items-center justify-center text-slate-700 dark:text-slate-300 font-semibold text-xs shadow-md">
                                    +{{ ($this->event->attendees_count ?? 0) - 8 }}
                                </div>
                            @endif
                        </div>
                        @if(($this->event->attendees_count ?? 0) > 0)
                        <span class="ml-4 text-sm text-slate-500 dark:text-slate-400">
                            {{ __('pub_theme::event.fields.people_joined.label', ['count' => $this->event->attendees_count ?? 0]) }}
                        </span>
                        @endif
                    </div>
                </section>
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-1">
                <div class="sticky top-8 space-y-6">
                    @if($this->isUpcoming())
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg p-6 border border-slate-200 dark:border-slate-700">
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">
                            {{ __('pub_theme::event.actions.rsvp_now.label') }}
                        </h3>

                        <div class="mb-6">
                            <p class="text-sm text-slate-600 dark:text-slate-400 mb-1">
                                {{ __('pub_theme::event.fields.spots_available.label') }}
                            </p>
                            <p class="text-4xl font-bold text-red-600 dark:text-red-400">
                                {{ $this->getAvailableSpots() }}
                            </p>
                        </div>

                        <button wire:click="openBookingModal" type="button" class="w-full bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 text-white font-bold py-3.5 px-6 rounded-lg transition-all shadow-md hover:shadow-lg">
                            {{ __('pub_theme::event.actions.rsvp_now.label') }}
                        </button>

                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-4 text-center">
                            {{ __('pub_theme::event.spots_filling_fast.label') }}
                        </p>
                    </div>
                    @endif

                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm p-6 border border-slate-200 dark:border-slate-700">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">
                            {{ __('pub_theme::event.actions.share_event.label') }}
                        </h3>
                        <div class="flex gap-3">
                            <button wire:click="openShareModal" type="button" class="flex-1 bg-sky-500 hover:bg-sky-600 text-white py-2.5 px-4 rounded-lg transition-colors font-medium text-sm flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.84 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                                Twitter
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="flex flex-col items-center justify-center min-h-[60vh] text-center px-4">
        <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">{{ __('pub_theme::event.no_events_found.label') }}</h2>
        <p class="text-slate-600 dark:text-slate-400 mb-8">{{ __('pub_theme::event.check_back_later.label') }}</p>
        <a href="{{ LaravelLocalization::localizeUrl('/events') }}" class="bg-red-600 text-white px-6 py-3 rounded-lg font-bold">
            {{ __('pub_theme::event.back_to_events.label') }}
        </a>
    </div>
    @endif
</div>

{{-- Booking Modal --}}
@if($this->showBookingModal)
<div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="closeBookingModal"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white dark:bg-slate-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full p-8">
            <div>
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-4" id="modal-title">
                    {{ __('pub_theme::event.actions.rsvp_now.label') }}
                </h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Name</label>
                        <input type="text" wire:model="bookingName" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2 text-slate-900 dark:text-white focus:ring-2 focus:ring-red-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Email</label>
                        <input type="email" wire:model="bookingEmail" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2 text-slate-900 dark:text-white focus:ring-2 focus:ring-red-500 outline-none transition-all">
                    </div>
                </div>
            </div>
            <div class="mt-8 flex gap-3">
                <button type="button" wire:click="book" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg transition-colors">
                    Confirm Booking
                </button>
                <button type="button" wire:click="closeBookingModal" class="flex-1 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 font-bold py-3 px-4 rounded-lg transition-colors">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>
@endif

@push('meta')
@if($this->event)
<script type="application/ld+json">
{!! json_encode($this->event->toSchemaOrg(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endif
@endpush
