# Laravel Pizza Meetups - Theme Folio + Volt Implementation

## Overview

This document details the implementation of Laravel Folio and Volt within the Meetup theme for the Laravel Pizza project. The theme leverages modern Laravel frontend patterns while maintaining the pizza community metaphor.

## Theme-Specific Architecture

### Front Office Implementation

The Meetup theme follows a strict architecture where all public-facing pages use Laravel Folio for routing and Laravel Volt for interactivity:

```
Themes/Meetup/
├── Resources/
│   └── views/
│       ├── pages/                # Public-facing pages (managed by Folio)
│       │   ├── index.blade.php   # Homepage - /
│       │   ├── events/
│       │   │   ├── index.blade.php     # Events listing - /events
│       │   │   ├── [event].blade.php   # Event detail - /events/{event}
│       │   │   └── create.blade.php    # Event creation - /events/create
│       │   ├── profile/
│       │   │   └── [user].blade.php    # User profile - /profile/{user}
│       │   ├── dashboard.blade.php     # User dashboard - /dashboard
│       │   ├── chat.blade.php          # Community chat - /chat
│       │   ├── login.blade.php         # Login page - /login
│       │   └── register.blade.php      # Registration - /register
│       ├── components/           # Reusable Volt/Livewire components
│       │   ├── event-card.blade.php
│       │   ├── navigation.blade.php
│       │   ├── pizza-slice-icon.blade.php  # Theme-specific pizza metaphor
│       │   └── event-calendar.blade.php
│       └── layouts/              # Theme layouts
│           └── app.blade.php
```

## Pizza Metaphor Implementation in Folio + Volt

### Event Cards with Pizza Slices

```php
<?php

use App\Models\Event;
use Livewire\Volt\Component;
use function Laravel\Volt\{mount};

new class extends Component {
    public Event $event;
    
    public function mount(Event $event)
    {
        $this->event = $event;
    }
    
    public function getIsFullProperty()
    {
        return $this->event->current_attendees >= $this->event->capacity;
    }
}; ?>

<div class="bg-slate-800 border border-slate-700 rounded-xl overflow-hidden hover:border-red-500/50 transition-colors">
    <div class="bg-gradient-to-r from-red-600 to-red-700 p-6">
        <div class="flex justify-between items-start">
            <div>
                <div class="flex items-center mb-2">
                    <x-pizza-slice-icon class="w-5 h-5 mr-2" />
                    <span class="text-sm font-semibold text-red-100">{{ $event->category?->name }}</span>
                </div>
                <h3 class="text-xl font-bold text-white">{{ $event->title }}</h3>
            </div>
            @if($this->isFull)
                <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">Full</span>
            @endif
        </div>
    </div>
    <div class="p-6">
        <div class="flex items-center text-gray-400 mb-3">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            {{ $event->start_datetime->format('M j, Y') }} • {{ $event->start_datetime->format('g:i A') }}
        </div>
        <div class="flex items-center text-gray-400 mb-4">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
            </svg>
            {{ $event->venue_name }}, {{ $event->venue_city }}
        </div>
        <div class="flex justify-between items-center">
            <div class="text-sm text-gray-400">
                {{ $event->current_attendees }}/{{ $event->capacity }} attendees
            </div>
            <a href="{{ route('events.show', $event) }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                Details
            </a>
        </div>
    </div>
</div>
```

### Pizza Slice Icon Component

```blade
{{-- Themes/Meetup/Resources/views/components/pizza-slice-icon.blade.php --}}
@props(['class' => ''])

<svg {{ $attributes->merge(['class' => "w-8 h-8 text-red-500 {$class}"]) }} viewBox="0 0 24 24" fill="currentColor">
    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" opacity="0.5"/>
    <circle cx="12" cy="12" r="1.5"/>
    <circle cx="9" cy="10" r="1"/>
    <circle cx="15" cy="10" r="1"/>
    <circle cx="9" cy="14" r="1"/>
    <circle cx="15" cy="14" r="1"/>
</svg>
```

## Folio Route Examples for Theme

### Homepage with Dynamic Content

```php
{{-- Themes/Meetup/Resources/views/pages/index.blade.php --}}
<?php

use function Laravel\Volt\{computed};
use App\Models\Event;

$featuredEvents = computed(fn () => Event::where('is_featured', true)
    ->where('status', 'published')
    ->where('start_datetime', '>', now())
    ->with(['category', 'organizer'])
    ->orderBy('start_datetime')
    ->limit(3)
    ->get());

$stats = computed(fn () => [
    'events' => Event::where('start_datetime', '>', now())->count(),
    'attendees' => \App\Models\EventRegistration::where('status', 'confirmed')->count(),
    'members' => \App\Models\User::count(),
    'pizzaSlices' => rand(100, 500), // Fun statistic for the pizza metaphor
]);
?>

<x-theme-layout>
    <!-- Hero Section -->
    <section id="home" class="relative py-20 md:py-32 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-slate-800/50 to-slate-900"></div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <div class="mb-8 flex justify-center">
                    <x-pizza-slice-icon class="w-24 h-24" />
                </div>
                
                <h1 class="text-5xl md:text-7xl font-bold mb-4">
                    <span class="text-white">Laravel Developers.</span><br>
                    <span class="text-red-500">Pizza. Community.</span>
                </h1>
                
                <p class="text-xl md:text-2xl text-gray-300 mb-10 max-w-3xl mx-auto">
                    Join fellow Laravel, Filament, and Livewire enthusiasts for pizza meetups.
                    <br class="hidden md:block">
                    Share knowledge, build connections, and enjoy great food together.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('events.index') }}" class="bg-red-600 hover:bg-red-700 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-colors inline-flex items-center justify-center">
                        Join the Community
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                    <a href="{{ route('events.index') }}" class="border-2 border-gray-600 hover:border-gray-500 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-colors inline-flex items-center justify-center">
                        View Events
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Stats Section -->
    <section class="py-20 bg-slate-800/30">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="text-4xl font-bold text-red-500 mb-2">{{ $this->stats['events'] }}</div>
                    <div class="text-gray-400">Events</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-red-500 mb-2">{{ $this->stats['attendees'] }}</div>
                    <div class="text-gray-400">Attendees</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-red-500 mb-2">{{ $this->stats['members'] }}</div>
                    <div class="text-gray-400">Members</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-red-500 mb-2">{{ $this->stats['pizzaSlices'] }}</div>
                    <div class="text-gray-400">Pizza Slices</div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Featured Events -->
    <section class="py-20">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl md:text-5xl font-bold text-white mb-4">Featured Events</h2>
                <p class="text-xl text-gray-400">Join us at our next meetup</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                @foreach($this->featuredEvents as $event)
                    <x-event-card :event="$event" />
                @endforeach
            </div>
            
            <div class="text-center mt-12">
                <a href="{{ route('events.index') }}" class="inline-flex items-center text-red-500 hover:text-red-400 font-semibold text-lg">
                    View All Events
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>
</x-theme-layout>
```

## Volt Component Patterns for the Theme

### Interactive Event Filtering

```php
<?php

use Livewire\Volt\Component;
use App\Models\Event;
use App\Models\EventCategory;

new class extends Component {
    public $selectedCategory = 'all';
    public $searchTerm = '';
    public $dateFilter = 'all';
    
    public function getEventsProperty()
    {
        $query = Event::where('status', 'published')
            ->where('start_datetime', '>', now())
            ->with('category');
        
        if ($this->selectedCategory !== 'all') {
            $query->where('category_id', $this->selectedCategory);
        }
        
        if ($this->searchTerm) {
            $query->where('title', 'like', '%' . $this->searchTerm . '%');
        }
        
        if ($this->dateFilter === 'today') {
            $query->whereDate('start_datetime', today());
        } elseif ($this->dateFilter === 'this-week') {
            $query->whereBetween('start_datetime', [now(), now()->addWeek()]);
        } elseif ($this->dateFilter === 'this-month') {
            $query->whereMonth('start_datetime', now()->month);
        }
        
        return $query->orderBy('start_datetime')->get();
    }
    
    public function getCategoriesProperty()
    {
        return EventCategory::where('is_active', true)->get();
    }
}; ?>

<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white mb-6">Upcoming Events</h1>
        
        <!-- Filters -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div>
                <label class="block text-gray-400 mb-2">Category</label>
                <select 
                    wire:model="selectedCategory"
                    class="w-full bg-slate-700 border border-slate-600 rounded-lg px-4 py-2 text-white"
                >
                    <option value="all">All Categories</option>
                    @foreach($this->categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-gray-400 mb-2">Date</label>
                <select 
                    wire:model="dateFilter"
                    class="w-full bg-slate-700 border border-slate-600 rounded-lg px-4 py-2 text-white"
                >
                    <option value="all">All Dates</option>
                    <option value="today">Today</option>
                    <option value="this-week">This Week</option>
                    <option value="this-month">This Month</option>
                </select>
            </div>
            
            <div>
                <label class="block text-gray-400 mb-2">Search</label>
                <input 
                    wire:model.debounce.300ms="searchTerm"
                    type="text"
                    placeholder="Search events..."
                    class="w-full bg-slate-700 border border-slate-600 rounded-lg px-4 py-2 text-white"
                />
            </div>
        </div>
    </div>
    
    <!-- Events Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($this->events as $event)
            <x-event-card :event="$event" />
        @empty
            <div class="col-span-3 text-center py-12">
                <p class="text-gray-400 text-lg">No events found matching your criteria.</p>
            </div>
        @endforelse
    </div>
</div>
```

## Integration with Laravel Pizza Ecosystem

### Module Communication in Volt Components

```php
<?php

use Livewire\Volt\Component;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public Event $event;
    public $registrationData = [
        'num_guests' => 1,
        'special_requests' => '',
    ];
    
    public function mount(Event $event)
    {
        $this->event = $event->load('category', 'organizer');
    }
    
    public function register()
    {
        if (!Auth::check()) {
            return $this->redirect(route('login', [
                'redirect' => request()->url()
            ]));
        }
        
        $this->validate([
            'registrationData.num_guests' => 'required|integer|min:1|max:10',
            'registrationData.special_requests' => 'nullable|string|max:500',
        ]);
        
        // Check if already registered
        $existingRegistration = EventRegistration::where('event_id', $this->event->id)
            ->where('user_id', Auth::id())
            ->first();
            
        if ($existingRegistration) {
            $this->addError('registration', 'You are already registered for this event.');
            return;
        }
        
        // Check event capacity
        if ($this->event->current_attendees >= $this->event->capacity) {
            $this->addError('registration', 'This event is at full capacity.');
            return;
        }
        
        EventRegistration::create([
            'event_id' => $this->event->id,
            'user_id' => Auth::id(),
            'num_guests' => $this->registrationData['num_guests'],
            'special_requests' => $this->registrationData['special_requests'],
            'status' => 'confirmed',
        ]);
        
        // Update event attendance count
        $this->event->increment('current_attendees');
        
        $this->dispatch('registration-success', 
            message: 'Successfully registered for the event!',
            eventId: $this->event->id
        );
    }
    
    public function getIsRegisteredProperty()
    {
        if (!Auth::check()) {
            return false;
        }
        
        return EventRegistration::where('event_id', $this->event->id)
            ->where('user_id', Auth::id())
            ->exists();
    }
}; ?>

<div class="bg-slate-800 rounded-xl p-6 border border-slate-700">
    <h3 class="text-xl font-bold text-white mb-4">Register for Event</h3>
    
    @if(session('success'))
        <div class="bg-green-500/10 border border-green-500 text-green-500 p-4 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif
    
    @if($this->isRegistered)
        <div class="bg-green-500/10 border border-green-500 text-green-500 p-4 rounded-lg">
            You're already registered for this event!
        </div>
    @else
        @error('registration')
            <div class="bg-red-500/10 border border-red-500 text-red-500 p-4 rounded-lg mb-4">
                {{ $message }}
            </div>
        @enderror
        
        <form wire:submit="register" class="space-y-4">
            <div>
                <label class="block text-gray-400 mb-2">Number of Guests</label>
                <select 
                    wire:model="registrationData.num_guests"
                    class="w-full bg-slate-700 border border-slate-600 rounded-lg px-4 py-2 text-white"
                >
                    @for($i = 1; $i <= 10; $i++)
                        <option value="{{ $i }}">{{ $i }} {{ $i == 1 ? 'person' : 'people' }}</option>
                    @endfor
                </select>
            </div>
            
            <div>
                <label class="block text-gray-400 mb-2">Special Requests</label>
                <textarea 
                    wire:model="registrationData.special_requests"
                    class="w-full bg-slate-700 border border-slate-600 rounded-lg px-4 py-2 text-white"
                    rows="3"
                    placeholder="Dietary restrictions, accessibility needs, etc."
                ></textarea>
            </div>
            
            <button 
                type="submit"
                class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg transition-colors"
            >
                Register for Event
            </button>
        </form>
    @endif
</div>
```

## Performance and Optimization

### Caching in Volt Components

```php
<?php

use function Laravel\Volt\{computed};
use Illuminate\Support\Facades\Cache;

$featuredEvents = computed(fn () => Cache::remember(
    'featured_events_theme',
    now()->addHours(2),
    fn () => Event::where('is_featured', true)
        ->where('status', 'published')
        ->where('start_datetime', '>', now())
        ->with(['category', 'organizer'])
        ->orderBy('start_datetime')
        ->limit(6)
        ->get()
));
```

### Lazy Loading Components

```blade
{{-- In a page that might not always show registration --}}
<livewire:event-registration 
    :event="$event" 
    lazy 
    class="mt-8"
/>
```

## Security Considerations

### Authorization in Volt Components

```php
<?php

use Livewire\Volt\Component;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public Event $event;
    
    public function mount(Event $event)
    {
        $this->event = $event;
        
        // Authorization check
        abort_unless($this->event->status === 'published' || Auth::user()?->can('view', $this->event), 403);
    }
    
    public function deleteEvent()
    {
        // Additional authorization check
        abort_unless(Auth::user()?->can('delete', $this->event), 403);
        
        $this->event->delete();
        $this->redirect(route('events.index'));
    }
};
```

## Testing Strategy

### Testing Volt Components

```php
// Tests/Feature/EventPageTest.php
public function test_event_page_shows_registration_form()
{
    $event = Event::factory()->create();
    
    $response = $this->get(route('events.show', $event));
    
    $response->assertSuccessful();
    $response->assertSeeLivewire('event-registration');
}

// Tests/Feature/EventRegistrationTest.php
public function test_user_can_register_for_event()
{
    $this->actingAs(User::factory()->create());
    $event = Event::factory()->create(['capacity' => 10]);
    
    Livewire::test('event-registration', ['event' => $event])
        ->set('registrationData.num_guests', 2)
        ->call('register')
        ->assertDispatched('registration-success');
}
```

## Deployment Considerations

### Production Optimizations

```bash
# Cache Folio routes in production
php artisan folio:cache

# Compile assets
npm run build

# Clear and cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Theme-Specific Best Practices

### Pizza Metaphor Integration

When implementing new components or pages in the theme:

1. **Consistent Iconography**: Use the pizza slice icon and other pizza-related SVGs consistently
2. **Color Palette**: Stick to the Laravel red (#dc2626) with pizza metaphor colors
3. **Terminology**: Use "slices", "ingredients", "flavors" metaphorically for events and features
4. **User Experience**: Ensure the pizza metaphor enhances rather than detracts from the developer experience

### Volt Component Guidelines

1. **Single Responsibility**: Each Volt component should have a clear, focused purpose
2. **Performance**: Use computed properties for expensive operations
3. **Security**: Always validate and sanitize user input
4. **Accessibility**: Include proper ARIA attributes and semantic HTML
5. **Maintainability**: Keep components small and composable

## Conclusion

The Laravel Pizza Meetup theme successfully implements Laravel Folio and Volt to create a modern, efficient frontend that maintains the pizza community metaphor while focusing on the core purpose of connecting Laravel developers. The architecture follows DRY, KISS, SOLID, and Laraxot principles, ensuring maintainability and scalability while providing an excellent user experience for the Laravel developer community.

---

**Document Version**: 1.0  
**Last Updated**: November 28, 2025