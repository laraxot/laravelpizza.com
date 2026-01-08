# Folio + Volt Real-World Examples & Patterns

## Overview

This document explores real-world implementations of Laravel Folio and Livewire Volt based on publicly available examples found in the Laravel ecosystem. These examples demonstrate practical usage patterns and best practices that can be applied to the Laravel Pizza Meetups project.

## Example 1: Laravel News Site with Folio + Volt

**Source**: [jasonlbeggs/laravel-news-volt-folio-example](https://github.com/jasonlbeggs/laravel-news-volt-folio-example)

### Key Patterns:

1. **Directory Structure**:
```
resources/views/pages/
├── index.blade.php
├── articles/
│   ├── index.blade.php
│   └── [slug].blade.php
├── categories/
│   └── [category].blade.php
└── search.blade.php
```

2. **Computed Properties for Data Loading**:
```blade
<?php

use App\Models\Article;
use function Livewire\Volt\{computed, state};

state(['search' => '']);

$articles = computed(function () {
    $query = Article::query()->with(['user', 'category']);
    
    if (!empty($this->search)) {
        $query->where('title', 'like', '%' . $this->search . '%')
              ->orWhere('content', 'like', '%' . $this->search . '%');
    }
    
    return $query->orderBy('published_at', 'desc')->paginate(10);
});

?>

<x-layout>
    <div class="container mx-auto px-4 py-8">
        <h1>Latest Articles</h1>
        
        <input 
            type="text" 
            wire:model.live="search" 
            placeholder="Search articles..."
            class="mb-4 p-2 border rounded"
        />
        
        @foreach($this->articles as $article)
            <x-article-card :article="$article" />
        @endforeach
        
        {{ $this->articles->links() }}
    </div>
</x-layout>
```

3. **Search with Live Updates**:
- Uses `wire:model.live` for real-time search functionality
- Computed property automatically re-runs when search state changes

## Example 2: E-commerce Store with Cart Functionality

**Source**: [thedevdojo/genesis](https://github.com/thedevdojo/genesis)

### Key Patterns:

1. **Shopping Cart State Management**:
```blade
@volt('cart')
    @php
        $cart = session()->get('cart', []);
        $cartTotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $cartCount = collect($cart)->sum('quantity');
    @endphp
    
    function addToCart($productId, $productName, $price) 
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'name' => $productName,
                'price' => $price,
                'quantity' => 1
            ];
        }
        
        session()->put('cart', $cart);
        $this->dispatch('cart-updated');
    }
    
    function removeFromCart($productId)
    {
        $cart = session()->get('cart', []);
        unset($cart[$productId]);
        session()->put('cart', $cart);
        $this->dispatch('cart-updated');
    }
@endvolt
```

2. **Cross-Component Communication**:
```blade
<!-- Cart component dispatches events -->
@script
<script>
    $wire.on('cart-updated', () => {
        // Update cart count in navigation
        Livewire.dispatch('update-cart-count');
    });
</script>
@endscript
```

3. **Session-Based Data Persistence**:
- Cart data stored in session rather than component state
- Provides persistence across page refreshes

## Example 3: Multi-Step Form Implementation

**Source**: [benjamincrozat/dummy-store](https://github.com/benjamincrozat/dummy-store)

### Key Patterns:

1. **Step Management**:
```blade
@volt('checkout')
    @php
        $currentStep = session('checkout_step', 1);
        $formData = session('checkout_data', []);
    @endphp
    
    function nextStep()
    {
        $currentStep = session('checkout_step', 1);
        
        // Validate current step
        $this->validateStep($currentStep);
        
        session(['checkout_step' => $currentStep + 1]);
    }
    
    function prevStep()
    {
        $currentStep = session('checkout_step', 1);
        session(['checkout_step' => max(1, $currentStep - 1)]);
    }
    
    function validateStep($step)
    {
        if ($step === 1) {
            $this->validate([
                'billingName' => 'required|string|max:255',
                'billingEmail' => 'required|email',
                'billingAddress' => 'required|string|max:255',
            ]);
        }
        
        // Store validated data
        session(['checkout_data' => [
            'billing_name' => $this->billingName,
            'billing_email' => $this->billingEmail,
            'billing_address' => $this->billingAddress,
        ]]);
    }
@endvolt
```

2. **Session-Based State**:
- Form progress and data stored in session
- Allows users to navigate away and return to form

## Example 4: Authentication Flow

**Source**: [Laracasts Laravel Volt Examples](https://laracasts.com)

### Key Patterns:

1. **Login Component**:
```blade
@volt('login')
    @php
        $email = '';
        $password = '';
        $remember = false;
    @endphp
    
    function login()
    {
        $credentials = $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        if (auth()->attempt($credentials, $this->remember)) {
            return redirect()->intended('/dashboard');
        }
        
        $this->addError('email', 'Invalid credentials');
    }
@endvolt
```

2. **Registration Component**:
```blade
@volt('register')
    @php
        $name = '';
        $email = '';
        $password = '';
        $passwordConfirmation = '';
    @endphp
    
    function register()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);
        
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);
        
        auth()->login($user);
        
        return redirect('/dashboard');
    }
@endvolt
```

## Example 5: Real-time Chat Implementation

**Source**: [Laravel Breeze Inertia Volt](https://github.com/laravel/breeze-inertia-volt)

### Key Patterns:

1. **Polling for Updates**:
```blade
@volt('chat')
    @php
        $messages = ChatMessage::latest()->take(50)->get();
        $newMessage = '';
    @endphp
    
    function sendMessage()
    {
        if (empty(trim($this->newMessage))) {
            return;
        }
        
        ChatMessage::create([
            'user_id' => auth()->id(),
            'message' => $this->newMessage,
        ]);
        
        $this->newMessage = '';
        
        // Broadcast to other users
        broadcast(new NewChatMessage($this->newMessage))->toOthers();
    }
@endvolt

<div @poll.2s="refreshMessages" class="chat-messages">
    @foreach($messages as $message)
        <div class="message">
            <strong>{{ $message->user->name }}:</strong> 
            {{ $message->message }}
        </div>
    @endforeach
</div>
```

2. **Event Broadcasting**:
- Uses Laravel Echo and Pusher for real-time updates
- Combines polling with event broadcasting for optimal performance

## Example 6: Dashboard with Analytics

**Source**: [Laravel Spark Clone with Folio + Volt](https://github.com/example/spark-clone)

### Key Patterns:

1. **Computed Properties for Complex Data**:
```blade
@volt('dashboard')
    @php
        $user = auth()->user();
    @endphp
    
    $stats = computed(function () {
        return [
            'totalEvents' => $this->user->events()->count(),
            'upcomingEvents' => $this->user->events()
                ->where('date', '>', now())
                ->count(),
            'recentActivity' => $this->user->activities()
                ->latest()
                ->take(5)
                ->get(),
            'monthlyRevenue' => $this->user->orders()
                ->whereBetween('created_at', [
                    now()->startOfMonth(),
                    now()->endOfMonth()
                ])
                ->sum('amount'),
        ];
    });
    
    $monthlyChart = computed(function () {
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $data[] = $this->user->orders()
                ->whereMonth('created_at', $i)
                ->sum('amount');
        }
        return $data;
    });
@endvolt
```

2. **Leveraging Eloquent Relationships**:
- Uses eager loading to optimize queries
- Computes complex aggregations efficiently

## Best Practices from Real-World Examples

### 1. Data Loading Strategies

**✅ Recommended**:
- Use computed properties for expensive data operations
- Implement proper caching for repeated queries
- Use `with()` to eager load relationships
- Consider using `load()` for conditional relationships

**❌ Avoid**:
- Loading data in component methods that run on every render
- Making multiple individual queries in loops
- Storing large datasets in component state

### 2. Form Handling

**✅ Recommended**:
- Validate data before processing
- Use `$this->validate()` for form validation
- Implement proper error handling
- Use `session()->flash()` for success messages

**❌ Avoid**:
- Skipping validation
- Not handling validation errors properly
- Storing sensitive data in component state

### 3. State Management

**✅ Recommended**:
- Use session storage for data that needs to persist
- Use component state for UI-specific data
- Implement proper cleanup for temporary data
- Use computed properties for derived data

**❌ Avoid**:
- Storing large objects in component state
- Not cleaning up temporary data
- Using component state for data that should persist across visits

### 4. Performance Optimization

**✅ Recommended**:
- Use `wire:model.live.debounce.500ms` for search inputs
- Implement pagination for large datasets
- Use `@entangle` for Alpine.js integration
- Leverage browser caching where appropriate

**❌ Avoid**:
- Live updates without debouncing
- Loading entire datasets without pagination
- Making unnecessary database queries

### 5. Security Considerations

**✅ Recommended**:
- Always validate user input
- Use Laravel's built-in authentication
- Implement proper authorization checks
- Sanitize output when displaying user content

**❌ Avoid**:
- Trusting user input without validation
- Bypassing authentication/authorization
- Displaying raw user input without sanitization

## Application to Laravel Pizza Meetups

Based on these real-world examples, here are specific implementations for the Laravel Pizza Meetups project:

### 1. Event Registration System
```blade
@volt('event-registration')
    @php
        $event = $event; // Passed from Folio route
        $user = auth()->user();
    @endphp
    
    $isRegistered = computed(function () {
        return $this->user && $this->event->attendees()
            ->where('user_id', $this->user->id)
            ->exists();
    });
    
    function registerForEvent()
    {
        if (!$this->user) {
            return redirect('/login?redirect=' . request()->url());
        }
        
        if ($this->event->attendees()->count() >= $this->event->max_attendees) {
            $this->addError('registration', 'Event is fully booked');
            return;
        }
        
        $this->event->attendees()->attach($this->user->id);
        $this->dispatch('event-registered', $this->event->id);
    }
    
    function cancelRegistration()
    {
        $this->event->attendees()->detach($this->user->id);
        $this->dispatch('registration-cancelled', $this->event->id);
    }
@endvolt
```

### 2. Event Search and Filtering
```blade
@volt('events-search')
    @php
        $search = '';
        $category = 'all';
        $dateRange = 'upcoming';
    @endphp
    
    $events = computed(function () {
        $query = \Modules\Meetup\Models\Event::query()
            ->with(['organizer', 'venue'])
            ->where('published', true);
        
        if (!empty($this->search)) {
            $query->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
        }
        
        if ($this->category !== 'all') {
            $query->where('category', $this->category);
        }
        
        if ($this->dateRange === 'upcoming') {
            $query->where('start_date', '>', now());
        } elseif ($this->dateRange === 'past') {
            $query->where('start_date', '<', now());
        }
        
        return $query->orderBy('start_date', 'asc')->paginate(12);
    });
@endvolt
```

### 3. User Dashboard with Statistics
```blade
@volt('user-dashboard')
    @php
        $user = auth()->user();
    @endphp
    
    $stats = computed(function () {
        return [
            'eventsAttended' => $this->user->events()->count(),
            'eventsRegistered' => $this->user->registeredEvents()
                ->where('start_date', '>', now())
                ->count(),
            'totalMeetups' => \Modules\Meetup\Models\Event::count(),
            'recentEvents' => $this->user->registeredEvents()
                ->where('start_date', '>', now())
                ->orderBy('start_date', 'asc')
                ->take(5)
                ->get(),
        ];
    });
@endvolt
```

## Additional Patterns from Genesis Starter Kit & Laravel News Tutorial

### 1. Authentication Implementation (Genesis Pattern)

The Genesis starter kit demonstrates comprehensive authentication patterns using Folio + Volt:

**Login Page** (`resources/views/pages/auth/login.blade.php`):
```blade
<?php
use App\Models\User;
use Illuminate\Auth\Events\Login;
use function Laravel\Folio\{middleware};
use function Livewire\Volt\{state, rules};

middleware(['guest']);

state(['email' => '', 'password' => '', 'remember' => false]);

rules(['email' => 'required|email', 'password' => 'required']);

$authenticate = function() {
    $credentials = $this->validate();
    
    if (!auth()->attempt($credentials, $this->remember)) {
        $this->addError('email', 'Invalid credentials');
        return;
    }
    
    event(new Login(auth()->guard('web'), User::where('email', $this->email)->first(), $this->remember));
    return redirect()->intended('/');
};
?>

<x-layout>
    @volt('login')
        <div class="max-w-md mx-auto">
            <form wire:submit="authenticate">
                <div class="mb-4">
                    <label>Email</label>
                    <input type="email" wire:model="email" class="w-full">
                    @error('email') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                
                <div class="mb-4">
                    <label>Password</label>
                    <input type="password" wire:model="password" class="w-full">
                    @error('password') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                
                <div class="mb-4">
                    <label>
                        <input type="checkbox" wire:model="remember"> Remember me
                    </label>
                </div>
                
                <button type="submit" class="w-full bg-primary-600 text-white py-2">
                    Login
                </button>
            </form>
        </div>
    @endvolt
</x-layout>
```

### 2. SPA-like Navigation with Persist (Laravel News Pattern)

The Laravel News tutorial demonstrates how to create a persistent audio player using `@persist` and `wire:navigate`:

**Layout with Persistent Elements**:
```blade
<!DOCTYPE html>
<html>
<head>
    <title>{{ $title ?? 'Laravel Pizza Meetups' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @persist('navigation')
        <x-navigation />
    @endpersist
    
    <main>
        {{ $slot }}
    </main>
    
    @persist('chat-widget')
        <x-chat-widget />
    @endpersist
    
    @persist('event-player') 
        <x-event-countdown-timer />
    @endpersist
</body>
</html>
```

**SPA-like Navigation**:
```blade
<a href="/events/{{ $event->id }}" wire:navigate class="hover:text-red-600">
    {{ $event->title }}
</a>

<a href="/dashboard" wire:navigate class="hover:text-red-600">
    Dashboard
</a>
```

### 3. Component Communication (Laravel News Pattern)

Cross-component communication using events, demonstrated in the Laravel News podcast player:

**Event Player Component** (`resources/views/components/event-player.blade.php`):
```blade
<div 
    x-data="{ activeEvent: null, play(event) { this.activeEvent = event; this.$nextTick(() => { this.$refs.audio.play() }); } }"
    x-on:play-event.window="play($event.detail)"
    x-show="activeEvent"
    x-transition.opacity.duration.500ms
    class="fixed bottom-0 left-0 right-0 bg-white border-t"
    style="display: none"
>
    <div class="max-w-4xl mx-auto p-4">
        <div x-text="`Now Playing: ${activeEvent?.title}`" class="text-center font-medium"></div>
        <audio x-ref="audio" :src="activeEvent?.audio_url" controls class="w-full mt-2"></audio>
    </div>
</div>
```

**Dispatching Events from Volt Components**:
```blade
@volt('event-card')
    $playEvent = function($event) {
        $this->dispatch('play-event', $event);
    };
@endvolt

<button 
    x-on:click="$dispatch('play-event', @js($event))"
    class="bg-red-600 text-white px-4 py-2 rounded"
>
    Listen
</button>
```

### 4. Warriorfolio's Modular Approach

Warriorfolio demonstrates a modular component architecture that can be applied to Laravel Pizza Meetups:

**Component Structure**:
```
resources/views/components/
├── portfolio/
│   ├── gallery.blade.php
│   ├── item.blade.php
│   └── filter.blade.php
├── blog/
│   ├── post-card.blade.php
│   ├── sidebar.blade.php
│   └── search.blade.php
└── ui/
    ├── button.blade.php
    ├── card.blade.php
    └── modal.blade.php
```

**Modular Event Components**:
```blade
{{-- resources/views/components/event/gallery.blade.php --}}
@props(['events', 'categories' => []])

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($events as $event)
        <x-event.card :event="$event" />
    @endforeach
</div>
```

### 5. Page Builder Pattern (Warriorfolio)

Warriorfolio's approach to modular content blocks can be adapted for dynamic event pages:

**Content Block Component**:
```blade
{{-- resources/views/components/content-blocks.blade.php --}}
@props(['blocks'])

@foreach($blocks as $block)
    @switch($block['type'])
        @case('hero')
            <x-content-blocks.hero :data="$block['data']" />
            @break
        @case('events-grid')
            <x-content-blocks.events-grid :data="$block['data']" />
            @break
        @case('testimonials')
            <x-content-blocks.testimonials :data="$block['data']" />
            @break
        @default
            <div>Unknown block type: {{ $block['type'] }}</div>
    @endswitch
@endforeach
```

### 6. Advanced Routing Patterns (Warriorfolio)

Warriorfolio demonstrates advanced Folio routing with dynamic parameters:

**Advanced Route Model Binding**:
```blade
{{-- resources/views/pages/events/[Event:slug].blade.php --}}
{{-- This creates route /events/{slug} with automatic model binding --}}
```

**Nested Route Parameters**:
```blade
{{-- resources/views/pages/events/[event]/[EventSession:slug].blade.php --}}
{{-- This creates route /events/{event}/{slug} with multiple model bindings --}}
```

## Additional Real-World Patterns from Other Projects

### 1. Podcast Player Pattern (Jason Beggs Example)

Using Sushi for dummy data in development:
```blade
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class Episode extends Model
{
    use Sushi;
    
    protected $casts = [
        'released_at' => 'datetime',
    ];
    
    protected $rows = [
        [
            'number' => 195,
            'title' => 'Laravel Updates',
            'description' => 'Latest Laravel updates and news',
            'duration_in_seconds' => 2579,
            'released_at' => '2023-07-06 10:00:00',
        ],
        // ... more episodes
    ];
}
?>
```

Using computed properties and formatting functions:
```blade
{{-- resources/views/pages/episodes/index.blade.php --}}
<?php
use App\Models\Episode;
use Illuminate\Support\Stringable;
use function Livewire\Volt\{computed};

$episodes = computed(fn () => Episode::get());

$formatDuration = function ($seconds) {
    return str(date('G\h i\m s\s', $seconds))
        ->trim('0h ')
        ->explode(' ')
        ->mapInto(Stringable::class)
        ->each->ltrim('0')
        ->join(' ');
};
?>
```

### 2. E-commerce Store Pattern

Session-based cart management:
```blade
@volt('product-detail')
    @php
        $product = $product; // From route model binding
        $quantity = 1;
    @endphp
    
    $addToCart = function() {
        $cart = session()->get('cart', []);
        
        $productId = $this->product->id;
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $this->quantity;
        } else {
            $cart[$productId] = [
                'id' => $this->product->id,
                'name' => $this->product->name,
                'price' => $this->product->price,
                'quantity' => $this->quantity,
            ];
        }
        
        session()->put('cart', $cart);
        $this->dispatch('cart-updated');
    };
@endvolt
```

### 3. Multi-Step Form Pattern

Using session to maintain state across multiple pages:
```blade
{{-- resources/views/pages/apply/[step].blade.php --}}
@volt('multi-step-form')
    @php
        $currentStep = session('application_step', 'personal');
        $formData = session('application_data', []);
        
        $personalInfo = $formData['personal'] ?? [];
        $education = $formData['education'] ?? [];
        $work = $formData['work'] ?? [];
    @endphp
    
    $nextStep = function() {
        $steps = ['personal', 'education', 'work', 'review'];
        $currentIndex = array_search($this->currentStep, $steps);
        
        if ($currentIndex !== false && $currentIndex < count($steps) - 1) {
            $nextStep = $steps[$currentIndex + 1];
            
            // Validate current step
            $this->validateForStep($this->currentStep);
            
            session(['application_step' => $nextStep]);
            return redirect()->to("/apply/{$nextStep}");
        }
    };
    
    $validateForStep = function($step) {
        switch($step) {
            case 'personal':
                $this->validate([
                    'personalInfo.name' => 'required|string|max:255',
                    'personalInfo.email' => 'required|email',
                ]);
                break;
            case 'education':
                $this->validate([
                    'education.school' => 'required|string|max:255',
                    'education.degree' => 'required|string|max:255',
                ]);
                break;
        }
        
        // Store validated data
        $formData = session('application_data', []);
        $formData[$step] = $this->$step === 'personal' ? $this->personalInfo : 
                          ($this->step === 'education' ? $this->education : $this->work);
        session(['application_data' => $formData]);
    };
@endvolt
```

### 4. Component Communication & State Management

#### Locked Properties (Security)
```blade
@volt('secure-component')
    @php
        $userId = auth()->id();
    @endphp
    
    // Lock properties to prevent client-side modifications
    state(['userId'])->locked();
    
    $deleteAccount = function() {
        // Use locked property for security
        User::find($this->userId)->delete();
    };
@endvolt
```

#### Reactive Properties
```blade
@volt('reactive-component')
    // When parent component updates a property, child components automatically update
    state(['parentId']);
    
    $items = computed(fn() => Item::where('parent_id', $this->parentId)->get());
@endvolt
```

#### Persisting Elements Across Page Visits
```blade
{{-- In layout file --}}
@persist('audio-player')
    <audio src="{{ $currentEpisode->file }}" controls></audio>
@endpersist

{{-- This audio player will persist across page navigations when using wire:navigate --}}
```

#### Active Link Highlighting with wire:navigate
```blade
{{-- Use wire:current instead of server-side request checks for persisted elements --}}
<nav class="main-navigation">
    <a href="/events" wire:navigate wire:current="font-bold text-red-600">Events</a>
    <a href="/dashboard" wire:navigate wire:current="font-bold text-red-600">Dashboard</a>
    <a href="/profile" wire:navigate wire:current="font-bold text-red-600">Profile</a>
</nav>
```

### 5. JavaScript Hooks for Navigation Events

```javascript
// Listen for navigation events in your JavaScript
document.addEventListener('livewire:navigate', (event) => {
    // Triggers when a navigation is triggered
    console.log('Navigating to:', event.detail.url);
});

document.addEventListener('livewire:navigating', () => {
    // Triggered when new HTML is about to be swapped onto the page
    // Good place to mutate HTML before page is navigated away from
});

document.addEventListener('livewire:navigated', () => {
    // Triggered as the final step of any page navigation
    // Also triggered on page-load instead of "DOMContentLoaded"
}, { once: true }); // Use { once: true } to run only once
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

### 4. Advanced Navigation Patterns
```blade
{{-- Using wire:navigate for SPA-like experience --}}
<nav class="main-navigation">
    <a href="/events" wire:navigate wire:current="font-bold text-red-600">Events</a>
    <a href="/dashboard" wire:navigate wire:current="font-bold text-red-600">Dashboard</a>
    <a href="/profile" wire:navigate wire:current="font-bold text-red-600">Profile</a>
</nav>
```

## Conclusion

These patterns from various real-world implementations provide comprehensive approaches to implementing Folio + Volt in Laravel applications:

1. **Genesis** provides excellent authentication patterns and security best practices
2. **Laravel News** demonstrates advanced SPA-like features with `@persist` and `wire:navigate`
3. **Warriorfolio** shows modular component architecture and content management patterns
4. **Jason Beggs' Tutorial** shows computed properties and Sushi for dummy data
5. **E-commerce Examples** demonstrate session-based cart management
6. **Multi-step Forms** show state management across multiple pages
7. **Security Patterns** include locked properties and reactive properties

These patterns enhance the original examples by providing:
- Production-ready authentication systems
- SPA-like user experience with persistent components
- Modular and reusable component architecture
- Advanced routing and state management patterns
- Cross-component communication strategies
- Security best practices with locked properties
- JavaScript integration hooks for navigation events

These patterns align perfectly with the DRY, KISS, SOLID, and Laraxot principles that guide this project.

---

**Document Version**: 1.0  
**Last Updated**: November 29, 2025