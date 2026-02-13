# Folio + Volt Real-World Implementation Guide

## Overview

This document provides practical guidance for implementing Laravel Folio and Livewire Volt based on real-world examples and best practices. The Laravel Pizza Meetups project follows these patterns to ensure maintainability, scalability, and developer productivity.

## Real-World Implementation Patterns

### 1. Event Management System

Based on analysis of community platforms like Laravel News and event management systems:

#### Event Listing with Dynamic Filtering
```blade
@volt('events-list')
    @php
        use Modules\Meetup\Services\EventService;

        $filter = [
            'category' => request()->query('category', 'all'),
            'location' => request()->query('location', 'all'),
            'date_range' => request()->query('date', 'upcoming'),
            'search' => request()->query('q', ''),
        ];

        $events = app(EventService::class)->getFilteredEvents($filter);
    @endphp

    <div class="filter-controls">
        <input
            type="text"
            wire:model.live.debounce.500ms="search"
            placeholder="Search events..."
            class="search-input"
        />

        <select wire:model.live="category" class="category-select">
            <option value="all">All Categories</option>
            <option value="laravel">Laravel</option>
            <option value="filament">Filament</option>
            <option value="livewire">Livewire</option>
        </select>
    </div>

    <div class="events-grid">
        @foreach($events as $event)
            <x-event-card
                :event="$event"
                :show-registration-status="auth()->check()"
            />
        @endforeach
    </div>
@endvolt
```

#### Event Detail with Registration
```blade
@volt('event-detail')
    @php
        use Modules\Meetup\Actions\Event\RegisterForEventAction;
        use Modules\Meetup\Actions\Event\CancelRegistrationAction;

        $event = $event; // Passed via Folio route model binding
        $user = auth()->user();
    @endphp

    $isRegistered = computed(fn() => $this->user && $this->event->attendees()->where('user_id', $this->user->id)->exists());

    $register = function () {
        if (!$this->user) {
            return redirect()->route('login', ['redirect' => request()->fullUrl()]);
        }

        $action = app(RegisterForEventAction::class);
        $result = $action->execute($this->event, $this->user);

        if ($result->success) {
            $this->dispatch('event-registered', eventId: $this->event->id);
        } else {
            $this->addError('registration', $result->message);
        }
    };

    $cancel = function () {
        $action = app(CancelRegistrationAction::class);
        $result = $action->execute($this->event, $this->user);

        if ($result->success) {
            $this->dispatch('registration-cancelled', eventId: $this->event->id);
        }
    };
@endvolt
```

### 2. User Authentication & Profile Management

Based on Laravel Breeze and Spark implementations:

#### Login Component
```blade
@volt('login')
    @php
        $email = '';
        $password = '';
        $remember = false;
        $error = '';
    @endphp

    $login = function () {
        $credentials = $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt($credentials, $this->remember)) {
            // Redirect to intended page or dashboard
            $intended = session()->get('url.intended', '/dashboard');
            session()->forget('url.intended');
            return redirect($intended);
        }

        $this->addError('email', __('auth.failed'));
    };
@endvolt
```

#### User Profile Component
```blade
@volt('user-profile')
    @php
        use Modules\Meetup\Actions\User\UpdateUserProfileAction;

        $user = auth()->user();
        $name = $user->name;
        $email = $user->email;
        $bio = $user->profile->bio ?? '';
        $location = $user->profile->location ?? '';
    @endphp

    $updateProfile = function () {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'bio' => 'nullable|string|max:1000',
            'location' => 'nullable|string|max:255',
        ]);

        $action = app(UpdateUserProfileAction::class);
        $result = $action->execute($this->user, $validated);

        if ($result->success) {
            $this->dispatch('profile-updated');
        }
    };
@endvolt
```

### 3. Real-Time Community Features

Based on implementations in Laravel.io and community platforms:

#### Live Chat Component
```blade
@volt('community-chat')
    @php
        use Modules\Meetup\Models\ChatMessage;

        $channel = request()->query('channel', 'general');
        $messageText = '';
    @endphp

    $messages = computed(function () {
        return ChatMessage::with('user')
            ->where('channel', $this->channel)
            ->orderBy('created_at', 'desc')
            ->take(50)
            ->get()
            ->reverse(); // Show newest last
    });

    $sendMessage = function () {
        if (trim($this->messageText) === '') {
            return;
        }

        $message = ChatMessage::create([
            'user_id' => auth()->id(),
            'channel' => $this->channel,
            'message' => $this->messageText,
        ]);

        broadcast(new \Modules\Meetup\Events\NewChatMessage($message))->toOthers();
        $this->messageText = '';
    };
@endvolt

<div class="chat-container">
    <div class="chat-messages" @poll.2s="loadMessages">
        @foreach($this->messages as $message)
            <x-chat-message :message="$message" />
        @endforeach
    </div>

    @volt('send-message')
        <form wire:submit="sendMessage" class="chat-form">
            <input
                type="text"
                wire:model="messageText"
                placeholder="Type your message..."
                class="message-input"
            />
            <button type="submit" class="send-button">Send</button>
        </form>
    @endvolt
</div>
```

### 4. Dashboard with Analytics

Based on dashboard implementations in Laravel apps:

#### User Dashboard Component
```blade
@volt('user-dashboard')
    @php
        use Modules\Meetup\Services\UserStatsService;

        $user = auth()->user();
    @endphp

    $stats = computed(function () {
        $service = app(UserStatsService::class);
        return $service->getUserStats($this->user);
    });

    $recentActivity = computed(function () {
        return $this->user->activities()
            ->with('subject')
            ->latest()
            ->take(10)
            ->get();
    });
@endvolt

<div class="dashboard-container">
    <div class="stats-grid">
        <x-stat-card
            label="Events Attended"
            :value="$this->stats['events_attended']"
            icon="calendar"
        />
        <x-stat-card
            label="Pizza Slices Shared"
            :value="$this->stats['pizza_slices_shared']"
            icon="pizza"
        />
        <x-stat-card
            label="Community Points"
            :value="$this->stats['community_points']"
            icon="trophy"
        />
    </div>

    <div class="dashboard-sections">
        <x-recent-activity :activities="$this->recentActivity" />
        <x-upcoming-events :user="$this->user" />
    </div>
</div>
```

## Performance Optimization Patterns

### 1. Efficient Data Loading
```blade
@volt('optimized-list')
    @php
        $page = request()->query('page', 1);
        $limit = 20;
    @endphp

    $items = computed(function () {
        return \Modules\Meetup\Models\Event::query()
            ->with(['organizer', 'location']) // Eager load relationships
            ->orderBy('start_date', 'desc')
            ->paginate($this->limit, ['*'], 'page', $this->page);
    });
@endvolt
```

### 2. Search with Debouncing
```blade
@volt('search-component')
    @php
        $searchQuery = '';
    @endphp

    $results = computed(function () {
        if (strlen($this->searchQuery) < 3) {
            return collect();
        }

        return \Modules\Meetup\Models\Event::where('title', 'like', '%' . $this->searchQuery . '%')
            ->limit(10)
            ->get();
    });
@endvolt

<input
    type="text"
    wire:model.live.debounce.300ms="searchQuery"
    placeholder="Search events..."
/>
```

### 3. Lazy Loading Components
```blade
@volt('lazy-content')
    @php
        $showContent = false;
    @endphp

    $loadContent = function () {
        $this->showContent = true;
    };
@endvolt

@if($showContent)
    <x-heavy-component :data="$computedData" />
@else
    <button wire:click="loadContent">Load Content</button>
@endif
```

## Security Best Practices from Real-World Examples

### 1. Authorization Checks
```blade
@volt('protected-content')
    @php
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Additional policy checks
        $this->authorize('view', $event);
    @endphp
@endvolt
```

### 2. Input Sanitization
```blade
@volt('form-component')
    $processData = function () {
        $cleanInput = strip_tags($this->userInput);
        $this->userInput = e($cleanInput); // Escape for output

        // Or use Laravel's built-in sanitization
        $this->userInput = clean($this->userInput); // If using mews/purifier
    };
@endvolt
```

## Integration with Laraxot Architecture

### 1. Action Pattern Implementation
```blade
// In Volt component
@volt('event-creation')
    @php
        use Modules\Meetup\Actions\Event\CreateEventAction;

        $title = '';
        $description = '';
        $date = '';
    @endphp

    $createEvent = function () {
        $validated = $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
        ]);

        $action = app(CreateEventAction::class);
        $result = $action->execute($validated + ['user_id' => auth()->id()]);

        if ($result->success) {
            return redirect()->route('events.show', $result->event->id);
        } else {
            $this->addError('general', $result->message);
        }
    };
@endvolt
```

### 2. Service Integration
```blade
@volt('dashboard-stats')
    @php
        use Modules\Meetup\Services\AnalyticsService;

        $analytics = app(AnalyticsService::class);
    @endphp

    $monthlyEvents = computed(fn() => $this->analytics->getMonthlyEventCounts());
    $userEngagement = computed(fn() => $this->analytics->getUserEngagementStats());
@endvolt
```

## Testing Strategies

### 1. Unit Testing Volt Components
```php
// tests/Feature/Volt/EventRegistrationTest.php
public function test_user_can_register_for_event(): void
{
    $user = User::factory()->create();
    $event = Event::factory()->create();

    Livewire::actingAs($user)
        ->test('event-registration', ['event' => $event])
        ->call('register')
        ->assertDispatched('event-registered');
}
```

### 2. Feature Testing Folio Pages
```php
// tests/Feature/Pages/EventsPageTest.php
public function test_events_page_shows_events(): void
{
    $event = Event::factory()->create();

    $response = $this->get('/events');

    $response->assertStatus(200);
    $response->assertSee($event->title);
}
```

## Advanced Patterns from Genesis, Laravel News & Warriorfolio

### 1. Genesis Authentication Patterns

The Genesis starter kit provides comprehensive authentication implementations:

#### Login Component with Security
```blade
@volt('login')
    @php
        use App\Models\User;
        use Illuminate\Auth\Events\Login;

        middleware(['guest']); // Ensure only guests can access

        $email = '';
        $password = '';
        $remember = false;
    @endphp

    $authenticate = function() {
        $credentials = $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!auth()->attempt($credentials, $this->remember)) {
            $this->addError('email', __('auth.failed'));
            return;
        }

        // Fire login event for tracking
        event(new Login(
            auth()->guard('web'),
            User::where('email', $this->email)->first(),
            $this->remember
        ));

        return redirect()->intended('/');
    };
@endvolt
```

#### Registration with Validation
```blade
@volt('register')
    @php
        use Modules\Meetup\Actions\User\RegisterUserAction;

        middleware(['guest']);

        $name = '';
        $email = '';
        $password = '';
        $passwordConfirmation = '';
    @endphp

    $register = function() {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        $action = app(RegisterUserAction::class);
        $result = $action->execute($validated);

        if ($result->success) {
            auth()->login($result->user);
            return redirect('/dashboard');
        } else {
            $this->addError('general', $result->message);
        }
    };
@endvolt
```

### 2. Laravel News SPA-like Experience

Implement persistent components and smooth navigation using `@persist` and `wire:navigate`:

#### Layout with Persistent Elements
```blade
<!DOCTYPE html>
<html>
<head>
    <title>{{ $title ?? 'Laravel Pizza Meetups' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50">
    @persist('header')
        <x-layouts.header />
    @endpersist

    <main class="py-8">
        {{ $slot }}
    </main>

    @persist('chat-widget')
        <x-chat.widget />
    @endpersist

    @persist('event-notifications')
        <x-event.notifications />
    @endpersist
</body>
</html>
```

#### SPA-like Navigation Links
```blade
{{-- Use wire:navigate for smooth page transitions --}}
<a href="/events" wire:navigate class="text-gray-600 hover:text-red-600 transition-colors">
    Events
</a>

<a href="/dashboard" wire:navigate class="text-gray-600 hover:text-red-600 transition-colors">
    Dashboard
</a>

<a href="/profile" wire:navigate class="text-gray-600 hover:text-red-600 transition-colors">
    Profile
</a>
```

### 3. Warriorfolio's Modular Architecture

Implement modular, reusable components following Warriorfolio's approach:

#### Modular Event Components
```blade
{{-- resources/views/components/event/gallery.blade.php --}}
@props(['events', 'categories' => [], 'showFilters' => true])

<div class="event-gallery">
    @if($showFilters)
        <x-event.filters :categories="$categories" />
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($events as $event)
            <x-event.card
                :event="$event"
                :show-registration-status="auth()->check()"
            />
        @endforeach
    </div>

    @if($events->hasPages())
        <div class="mt-8">
            {{ $events->links() }}
        </div>
    @endif
</div>
```

#### Content Block System
```blade
{{-- resources/views/components/page-builder/blocks.blade.php --}}
@props(['contentBlocks'])

@foreach($contentBlocks as $block)
    @switch($block['type'])
        @case('hero-section')
            <x-content-blocks.hero :data="$block['data']" />
            @break
        @case('events-grid')
            <x-content-blocks.events-grid :data="$block['data']" />
            @break
        @case('speakers-list')
            <x-content-blocks.speakers :data="$block['data']" />
            @break
        @case('sponsors-grid')
            <x-content-blocks.sponsors :data="$block['data']" />
            @break
        @case('call-to-action')
            <x-content-blocks.cta :data="$block['data']" />
            @break
        @default
            <div class="p-4 bg-yellow-50 border border-yellow-200 rounded">
                <p class="text-yellow-800">Unknown content block: {{ $block['type'] }}</p>
            </div>
    @endswitch
@endforeach
```

### 4. Advanced Communication Patterns

Implement cross-component communication as demonstrated in Laravel News:

#### Event-based Communication
```blade
{{-- resources/views/components/chat/widget.blade.php --}}
<div
    x-data="{
        showChat: false,
        toggle() { this.showChat = !this.showChat; },
        openWithUser(user) {
            this.showChat = true;
            $dispatch('chat-opened-with-user', user);
        }
    }"
    x-on:open-chat-with-user.window="openWithUser($event.detail)"
    class="fixed bottom-4 right-4"
>
    <button @click="toggle" class="bg-red-600 text-white p-3 rounded-full">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
        </svg>
    </button>

    <div x-show="showChat" class="absolute bottom-16 right-0 w-80 h-96 bg-white border rounded-lg shadow-lg">
        <x-chat.interface />
    </div>
</div>
```

#### Dispatching Events from Volt Components
```blade
@volt('event-detail')
    $contactSpeaker = function($speakerId) {
        $this->dispatch('open-chat-with-user', [
            'userId' => $speakerId,
            'type' => 'speaker'
        ]);
    };

    $contactOrganizer = function($organizerId) {
        $this->dispatch('open-chat-with-user', [
            'userId' => $organizerId,
            'type' => 'organizer'
        ]);
    };
@endvolt

<button
    wire:click="contactSpeaker({{ $event->organizer->id }})"
    class="bg-blue-600 text-white px-4 py-2 rounded"
>
    Contact Speaker
</button>
```

### 5. Advanced Routing Patterns

Leverage Folio's advanced routing capabilities:

#### Route Model Binding with Custom Keys
```blade
{{-- resources/views/pages/events/[Event:slug].blade.php --}}
{{-- Creates route /events/{slug} with automatic model binding --}}

{{-- resources/views/pages/events/[event]/sessions/[EventSession:id].blade.php --}}
{{-- Creates route /events/{event}/sessions/{id} with multiple model bindings --}}
```

#### Middleware in Pages
```blade
{{-- resources/views/pages/dashboard.blade.php --}}
<?php
use function Laravel\Folio\middleware;

middleware(['auth', 'verified']);
?>

<x-layout>
    <!-- Dashboard content -->
</x-layout>
```

## Best Practices for Laravel Pizza Meetups Implementation

Based on all these real-world examples, here are specific implementation patterns for Laravel Pizza Meetups:

### 1. Authentication & User Management
```blade
{{-- Following Genesis patterns --}}
@volt('auth.login')
    middleware(['guest']);

    $email = '';
    $password = '';
    $remember = false;

    $login = function() {
        $credentials = $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt($credentials, $this->remember)) {
            return redirect()->intended('/dashboard');
        }

        $this->addError('email', 'Invalid credentials');
    };
@endvolt
```

### 2. Event Management with SPA Experience
```blade
{{-- Using Laravel News patterns for persistent elements --}}
@volt('event-registration')
    $registerForEvent = function() {
        if (!$this->user) {
            return redirect('/login?redirect=' . request()->fullUrl());
        }

        // Registration logic
        $this->dispatch('event-registered', $this->event->id);
    };

    $unregisterFromEvent = function() {
        // Unregistration logic
        $this->dispatch('event-unregistered', $this->event->id);
    };
@endvolt
```

### 3. Modular Component Architecture
```blade
{{-- Following Warriorfolio patterns --}}
@volt('event.gallery')
    $events = computed(function() {
        return \Modules\Meetup\Models\Event::with(['organizer', 'venue'])
            ->where('published', true)
            ->orderBy('start_date', 'desc')
            ->paginate(12);
    });

    $filters = [
        'categories' => ['laravel', 'filament', 'livewire', 'php'],
        'formats' => ['online', 'in-person', 'hybrid'],
        'dates' => ['upcoming', 'past', 'this-month']
    ];
@endvolt

<x-event.gallery
    :events="$this->events"
    :filters="$this->filters"
    :show-filters="true"
/>
```

## Conclusion

These real-world implementation patterns from Genesis, Laravel News, and Warriorfolio demonstrate that Folio + Volt provide a robust foundation for building modern Laravel applications. The Laravel Pizza Meetups project can leverage these patterns to create:

- Production-ready authentication systems (Genesis)
- SPA-like user experience with persistent components (Laravel News)
- Modular and reusable component architecture (Warriorfolio)
- Advanced routing and state management patterns
- Cross-component communication strategies
- Efficient, maintainable code structures
- Responsive, interactive user interfaces
- Secure and performant applications
- Scalable systems that follow DRY, KISS, SOLID, and Laraxot principles

By following these proven patterns, the project will benefit from the collective experience of the Laravel community while maintaining its unique identity as a Laravel-focused community platform with pizza.

---

**Document Version**: 1.0
