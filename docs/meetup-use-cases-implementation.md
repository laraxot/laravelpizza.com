# Laravel Pizza Meetups - Practical Implementation Examples

## overview

questo documento fornisce esempi pratici e pronti all'uso per implementare le funzionalità principali della piattaforma Laravel Pizza Meetups usando Folio + Volt.

**basato su ricerca di progetti reali:**
- Genesis Starter Kit (thedevdojo)
- Laravel News tutorials
- Multi-step form (Neon)
- Podcast Player (Jason Beggs)
- Todo Application (Nuno Maduro)

## use case 1: event listing with live search and filters

**file:** `Themes/Meetup/resources/views/pages/events/index.blade.php`

```blade
<?php
use Modules\Meetup\Models\Event;
use function Laravel\Folio\{name};
use function Livewire\Volt\{state, computed};

name('events.index');

state([
    'search' => '',
    'category' => 'all',
    'location' => 'all',
    'dateFilter' => 'upcoming', // upcoming, past, all
    'sortBy' => 'date', // date, popularity, title
]);

$events = computed(function() {
    $query = Event::query()
        ->with(['organizer', 'venue', 'registrations'])
        ->where('published', true);

    // Search filter
    if (filled($this->search)) {
        $query->where(function($q) {
            $q->where('title', 'like', "%{$this->search}%")
              ->orWhere('description', 'like', "%{$this->search}%");
        });
    }

    // Category filter
    if ($this->category !== 'all') {
        $query->where('category', $this->category);
    }

    // Location filter
    if ($this->location !== 'all') {
        $query->whereHas('venue', fn($q) => $q->where('city', $this->location));
    }

    // Date filter
    match($this->dateFilter) {
        'upcoming' => $query->where('starts_at', '>', now()),
        'past' => $query->where('starts_at', '<', now()),
        default => null,
    };

    // Sorting
    match($this->sortBy) {
        'date' => $query->orderBy('starts_at', 'asc'),
        'popularity' => $query->withCount('registrations')->orderBy('registrations_count', 'desc'),
        'title' => $query->orderBy('title', 'asc'),
    };

    return $query->paginate(12);
});

$locations = computed(fn() =>
    Event::query()
        ->join('venues', 'events.venue_id', '=', 'venues.id')
        ->distinct()
        ->pluck('venues.city')
        ->sort()
);

$categories = ['all', 'meetup', 'workshop', 'conference', 'webinar'];
?>

<x-layouts.app title="Browse Events">
    @volt('events.index')
    <div class="space-y-8">
        <!-- Header -->
        <div>
            <h1 class="text-4xl font-bold mb-2">Discover Laravel Events</h1>
            <p class="text-slate-400">Find and join Laravel community meetups near you</p>
        </div>

        <!-- Filters -->
        <div class="bg-slate-800 rounded-lg p-6 space-y-4">
            <!-- Search Bar -->
            <div>
                <x-ui.input
                    wire:model.live.debounce.300ms="search"
                    placeholder="Search events by title or description..."
                    class="w-full"
                >
                    <x-slot:prefix>
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </x-slot:prefix>
                </x-ui.input>
            </div>

            <!-- Filter Row -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Category Filter -->
                <x-ui.select
                    wire:model.live="category"
                    label="Category"
                >
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}">{{ ucfirst($cat) }}</option>
                    @endforeach
                </x-ui.select>

                <!-- Location Filter -->
                <x-ui.select
                    wire:model.live="location"
                    label="Location"
                >
                    <option value="all">All Locations</option>
                    @foreach($this->locations as $loc)
                        <option value="{{ $loc }}">{{ $loc }}</option>
                    @endforeach
                </x-ui.select>

                <!-- Date Filter -->
                <x-ui.select
                    wire:model.live="dateFilter"
                    label="When"
                >
                    <option value="upcoming">Upcoming Events</option>
                    <option value="past">Past Events</option>
                    <option value="all">All Events</option>
                </x-ui.select>

                <!-- Sort By -->
                <x-ui.select
                    wire:model.live="sortBy"
                    label="Sort By"
                >
                    <option value="date">By Date</option>
                    <option value="popularity">By Popularity</option>
                    <option value="title">By Title</option>
                </x-ui.select>
            </div>

            <!-- Active Filters Summary -->
            @if($search || $category !== 'all' || $location !== 'all' || $dateFilter !== 'upcoming')
                <div class="flex flex-wrap gap-2">
                    <span class="text-sm text-slate-400">Active filters:</span>

                    @if($search)
                        <span class="inline-flex items-center gap-2 px-3 py-1 bg-red-600 rounded-full text-sm">
                            Search: "{{ $search }}"
                            <button wire:click="$set('search', '')" class="hover:text-white">✕</button>
                        </span>
                    @endif

                    @if($category !== 'all')
                        <span class="inline-flex items-center gap-2 px-3 py-1 bg-red-600 rounded-full text-sm">
                            {{ ucfirst($category) }}
                            <button wire:click="$set('category', 'all')" class="hover:text-white">✕</button>
                        </span>
                    @endif

                    @if($location !== 'all')
                        <span class="inline-flex items-center gap-2 px-3 py-1 bg-red-600 rounded-full text-sm">
                            {{ $location }}
                            <button wire:click="$set('location', 'all')" class="hover:text-white">✕</button>
                        </span>
                    @endif
                </div>
            @endif
        </div>

        <!-- Loading State -->
        <div wire:loading wire:target="search, category, location, dateFilter, sortBy" class="text-center py-8">
            <div class="inline-flex items-center gap-2 text-slate-400">
                <svg class="animate-spin h-5 w-5" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                </svg>
                <span>Loading events...</span>
            </div>
        </div>

        <!-- Events Grid -->
        <div wire:loading.remove wire:target="search, category, location, dateFilter, sortBy">
            @if($this->events->isEmpty())
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-slate-300">No events found</h3>
                    <p class="mt-1 text-sm text-slate-400">Try adjusting your search or filters</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($this->events as $event)
                        <x-event.card :event="$event" />
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $this->events->links() }}
                </div>
            @endif
        </div>
    </div>
    @endvolt
</x-layouts.app>
```

## use case 2: event detail with registration

**file:** `Themes/Meetup/resources/views/pages/events/[Event:slug].blade.php`

```blade
<?php
use Modules\Meetup\Models\Event;
use Modules\Meetup\Actions\Event\RegisterUserAction;
use Modules\Meetup\Actions\Event\CancelRegistrationAction;
use function Laravel\Folio\{name, render};
use function Livewire\Volt\{state, computed, protect};

name('events.show');

render(function (Event $event) {
    if (!$event->published && !auth()->user()?->can('manage-events')) {
        abort(404);
    }

    return view('pages.events.[Event:slug]', [
        'event' => $event->load(['organizer', 'venue', 'registrations.user']),
    ]);
});

state(['eventId' => fn() => $this->event->id]);

$isRegistered = computed(function() {
    return auth()->check() && $this->event->registrations()
        ->where('user_id', auth()->id())
        ->exists();
});

$canRegister = computed(function() {
    if (!auth()->check()) return false;
    if ($this->isRegistered) return false;
    if ($this->event->starts_at < now()) return false;
    if ($this->event->registrations()->count() >= $this->event->max_attendees) return false;

    return true;
});

$spotsLeft = computed(fn() =>
    $this->event->max_attendees - $this->event->registrations()->count()
);

$register = function() {
    if (!auth()->check()) {
        session()->put('intended_registration', $this->event->id);
        return redirect()->route('auth.login');
    }

    if (!$this->canRegister) {
        $this->dispatch('toast', message: 'Cannot register for this event', type: 'error');
        return;
    }

    try {
        app(RegisterUserAction::class)->execute($this->event, auth()->user());

        $this->dispatch('toast', message: 'Successfully registered!', type: 'success');
        $this->dispatch('registration-updated');
    } catch (\Exception $e) {
        $this->dispatch('toast', message: $e->getMessage(), type: 'error');
    }
};

$cancelRegistration = function() {
    try {
        app(CancelRegistrationAction::class)->execute($this->event, auth()->user());

        $this->dispatch('toast', message: 'Registration cancelled', type: 'info');
        $this->dispatch('registration-updated');
    } catch (\Exception $e) {
        $this->dispatch('toast', message: $e->getMessage(), type: 'error');
    }
};

$addToCalendar = protect(function($type = 'google') {
    // Generate calendar link
    $title = urlencode($this->event->title);
    $description = urlencode(strip_tags($this->event->description));
    $location = urlencode($this->event->venue->full_address ?? '');
    $startDate = $this->event->starts_at->format('Ymd\THis\Z');
    $endDate = $this->event->ends_at->format('Ymd\THis\Z');

    $url = match($type) {
        'google' => "https://calendar.google.com/calendar/render?action=TEMPLATE&text={$title}&dates={$startDate}/{$endDate}&details={$description}&location={$location}",
        'outlook' => "https://outlook.live.com/calendar/0/action/compose?subject={$title}&startdt={$startDate}&enddt={$endDate}&body={$description}&location={$location}",
        default => null,
    };

    return redirect($url);
});
?>

<x-layouts.app :title="$event->title">
    @volt('events.show')
    <div class="max-w-5xl mx-auto">
        <!-- Hero Section -->
        <div class="relative h-96 rounded-lg overflow-hidden mb-8">
            @if($event->cover_image)
                <img
                    src="{{ Storage::url($event->cover_image) }}"
                    alt="{{ $event->title }}"
                    class="w-full h-full object-cover"
                >
            @else
                <div class="w-full h-full bg-gradient-to-br from-red-600 to-red-800 flex items-center justify-center">
                    <svg class="w-32 h-32 text-white/20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L22 20H2L12 2z"/>
                        <circle cx="8" cy="14" r="1" fill="white"/>
                        <circle cx="12" cy="12" r="1" fill="white"/>
                        <circle cx="14" cy="16" r="1" fill="white"/>
                    </svg>
                </div>
            @endif

            <!-- Event Badge -->
            <div class="absolute top-4 left-4">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-600 text-white">
                    {{ ucfirst($event->category) }}
                </span>
            </div>

            <!-- Spots Left Badge -->
            @if($this->spotsLeft <= 10 && $this->spotsLeft > 0)
                <div class="absolute top-4 right-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-600 text-white">
                        Only {{ $this->spotsLeft }} spots left!
                    </span>
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Title & Organizer -->
                <div>
                    <h1 class="text-4xl font-bold mb-4">{{ $event->title }}</h1>

                    <div class="flex items-center gap-4 text-slate-400">
                        <div class="flex items-center gap-2">
                            <img
                                src="{{ $event->organizer->avatar_url }}"
                                alt="{{ $event->organizer->name }}"
                                class="w-8 h-8 rounded-full"
                            >
                            <span>Organized by <strong class="text-white">{{ $event->organizer->name }}</strong></span>
                        </div>

                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <span>{{ $event->registrations()->count() }} / {{ $event->max_attendees }} registered</span>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="prose prose-invert max-w-none">
                    <h2>About this event</h2>
                    {!! Str::markdown($event->description) !!}
                </div>

                <!-- Attendees -->
                @if($event->registrations->isNotEmpty())
                    <div>
                        <h3 class="text-xl font-bold mb-4">Attendees ({{ $event->registrations->count() }})</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($event->registrations->take(20) as $registration)
                                <img
                                    src="{{ $registration->user->avatar_url }}"
                                    alt="{{ $registration->user->name }}"
                                    title="{{ $registration->user->name }}"
                                    class="w-10 h-10 rounded-full border-2 border-slate-700"
                                >
                            @endforeach

                            @if($event->registrations->count() > 20)
                                <div class="w-10 h-10 rounded-full bg-slate-700 border-2 border-slate-600 flex items-center justify-center text-sm">
                                    +{{ $event->registrations->count() - 20 }}
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Date & Time Card -->
                <div class="bg-slate-800 rounded-lg p-6 space-y-4">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-red-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <div>
                            <div class="font-medium">{{ $event->starts_at->format('l, F j, Y') }}</div>
                            <div class="text-sm text-slate-400">
                                {{ $event->starts_at->format('g:i A') }} - {{ $event->ends_at->format('g:i A') }}
                            </div>
                            <div class="text-sm text-slate-400 mt-1">
                                {{ $event->starts_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>

                    @if($event->venue)
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-red-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <div>
                                <div class="font-medium">{{ $event->venue->name }}</div>
                                <div class="text-sm text-slate-400">
                                    {{ $event->venue->address }}<br>
                                    {{ $event->venue->city }}, {{ $event->venue->country }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Registration Actions -->
                <div class="space-y-3">
                    @if($this->isRegistered)
                        <div class="bg-green-600/20 border border-green-600 rounded-lg p-4 text-center">
                            <svg class="w-6 h-6 text-green-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <p class="font-medium text-green-500">You're registered!</p>
                        </div>

                        <x-ui.button
                            wire:click="cancelRegistration"
                            variant="danger"
                            class="w-full"
                            wire:confirm="Are you sure you want to cancel your registration?"
                        >
                            Cancel Registration
                        </x-ui.button>
                    @else
                        @if($this->canRegister)
                            <x-ui.button wire:click="register" variant="primary" class="w-full">
                                Register for Event
                            </x-ui.button>
                        @elseif(!auth()->check())
                            <x-ui.button href="{{ route('auth.login') }}" variant="primary" class="w-full">
                                Login to Register
                            </x-ui.button>
                        @elseif($event->starts_at < now())
                            <div class="bg-slate-700 rounded-lg p-4 text-center text-slate-400">
                                This event has ended
                            </div>
                        @else
                            <div class="bg-red-600/20 border border-red-600 rounded-lg p-4 text-center">
                                <p class="font-medium text-red-500">Event is full</p>
                            </div>
                        @endif
                    @endif

                    <!-- Add to Calendar -->
                    <div class="relative" x-data="{ open: false }">
                        <x-ui.button
                            @click="open = !open"
                            variant="secondary"
                            class="w-full"
                        >
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Add to Calendar
                        </x-ui.button>

                        <div
                            x-show="open"
                            @click.away="open = false"
                            x-transition
                            class="absolute w-full mt-2 bg-slate-800 rounded-lg shadow-lg py-2 z-10"
                            style="display: none;"
                        >
                            <a
                                href="#"
                                wire:click.prevent="addToCalendar('google')"
                                class="block px-4 py-2 hover:bg-slate-700"
                            >
                                Google Calendar
                            </a>
                            <a
                                href="#"
                                wire:click.prevent="addToCalendar('outlook')"
                                class="block px-4 py-2 hover:bg-slate-700"
                            >
                                Outlook Calendar
                            </a>
                        </div>
                    </div>

                    <!-- Share Event -->
                    <x-ui.button variant="ghost" class="w-full">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                        </svg>
                        Share Event
                    </x-ui.button>
                </div>
            </div>
        </div>
    </div>
    @endvolt
</x-layouts.app>
```

**continuazione nel prossimo file con altri use cases...**

## references

- [Genesis Starter Kit - UI Patterns](https://github.com/thedevdojo/genesis)
- [Neon Multi-Step Form Guide](https://neon.com/guides/laravel-volt-folio-multi-step-form)
- [Jason Beggs Podcast Player](https://jasonlbeggs.com/blog/livewire-volt-and-folio)
- [Nuno Maduro Todo App](https://nunomaduro.com/todo_application_with_laravel_folio_and_volt)
- [Livewire Volt Documentation](https://livewire.laravel.com/docs/3.x/volt)
- [Laravel Folio Documentation](https://laravel.com/docs/12.x/folio)

---


