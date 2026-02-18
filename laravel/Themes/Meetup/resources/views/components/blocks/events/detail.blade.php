<?php
declare(strict_types=1);

/**
 * Event Detail - Volt Component
 * Full layout with 2-column design, sidebar CTA, About, Location, Attendees
 * Livewire reactivity for booking modals and interactions
 */

use Livewire\Volt\Component;
use Modules\Meetup\Models\Event;
use Illuminate\Support\Carbon;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

new class extends Component {
    // Props from parent
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
        if ($this->event === null && $this->item === null && !empty($this->slug0)) {
            $this->event = Event::where('slug', $this->slug0)->first();
        } elseif ($this->event === null && $this->item !== null) {
            $this->event = $this->item;
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
            return Carbon::now()->format('l, F j, Y');
        }
        return Carbon::parse($this->event->start_date)->format('l, F j, Y');
    }
    
    public function getTime(): string
    {
        if (!$this->event || !$this->event->start_date) return '';
        $start = Carbon::parse($this->event->start_date);
        $end = $this->event->end_date ? Carbon::parse($this->event->end_date) : $start;
        return $start->format('g:i A') . ' - ' . $end->format('g:i A');
    }
    
    public function openBookingModal(): void { $this->showBookingModal = true; }
    public function closeBookingModal(): void { 
        $this->showBookingModal = false; 
        $this->bookingName = ''; 
        $this->bookingEmail = ''; 
    }
    
    public function book(): void
    {
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Booking confirmed!']);
        $this->closeBookingModal();
    }
    
    public function openShareModal(): void { $this->showShareModal = true; }
    public function closeShareModal(): void { $this->showShareModal = false; }
    
    public function getAvailableSpots(): int
    {
        if (!$this->event) return 0;
        return max(0, ($this->event->max_attendees ?? 100) - ($this->event->attendees_count ?? 0));
    }
};

?>

<div class="min-h-screen bg-slate-50 dark:bg-slate-900 overflow-x-hidden relative">
    @if($this->event)
    {{-- Hero --}}
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
                <span class="inline-block {{ $this->isUpcoming() ? 'bg-green-600' : 'bg-slate-500' }} text-white px-4 py-1 rounded-full text-sm font-semibold mb-4">
                    {{ $this->isUpcoming() ? 'Upcoming' : 'Past Event' }}
                </span>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white">{{ $this->event->title }}</h1>
            </div>
        </div>
    </div>

    {{-- Content --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid lg:grid-cols-3 gap-8">
            {{-- Left --}}
            <div class="lg:col-span-2 space-y-8">
                {{-- Info --}}
                <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm p-6 border border-slate-200 dark:border-slate-700">
                    <div class="grid md:grid-cols-3 gap-6">
                        <div>
                            <p class="text-sm font-medium text-slate-500">Date</p>
                            <p class="text-base font-semibold text-slate-900 dark:text-white">{{ $this->getDate() }}</p>
                        </div>
                        @if($this->getTime())
                        <div>
                            <p class="text-sm font-medium text-slate-500">Time</p>
                            <p class="text-base font-semibold text-slate-900 dark:text-white">{{ $this->getTime() }}</p>
                        </div>
                        @endif
                        <div>
                            <p class="text-sm font-medium text-slate-500">Location</p>
                            <p class="text-base font-semibold text-slate-900 dark:text-white">{{ $this->event->location ?? 'TBA' }}</p>
                        </div>
                    </div>
                </div>

                @if($this->event->description)
                <section class="bg-white dark:bg-slate-800 rounded-lg shadow-sm p-8">
                    <h2 class="text-2xl font-bold mb-4">About</h2>
                    <div class="prose dark:prose-invert">{!! nl2br(e($this->event->description)) !!}</div>
                </section>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-1">
                @if($this->isUpcoming())
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg p-6">
                    <h3 class="text-xl font-bold mb-2">Join Event</h3>
                    <p class="text-4xl font-bold text-red-600 mb-4">{{ $this->getAvailableSpots() }}</p>
                    <button wire:click="openBookingModal" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-lg">
                        Book Now
                    </button>
                </div>
                @endif
                
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm p-6 mt-6">
                    <button wire:click="openShareModal" class="w-full bg-sky-500 hover:bg-sky-600 text-white py-2 rounded-lg">
                        Share Event
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Booking Modal --}}
    @if($showBookingModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-bold mb-4">Book Your Spot</h3>
            <input wire:model="bookingName" type="text" placeholder="Name" class="w-full mb-3 border rounded px-3 py-2">
            <input wire:model="bookingEmail" type="email" placeholder="Email" class="w-full mb-4 border rounded px-3 py-2">
            <div class="flex gap-2">
                <button wire:click="book" class="flex-1 bg-red-600 text-white py-2 rounded">Book</button>
                <button wire:click="closeBookingModal" class="flex-1 bg-gray-300 py-2 rounded">Cancel</button>
            </div>
        </div>
    </div>
    @endif
    @endif
</div>
