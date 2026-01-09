# Laravel Folio + Volt Frontend Implementation Guide

## Overview

This document provides specific guidance for implementing Laravel Folio and Volt within the Meetup theme for the Laravel Pizza project. The theme leverages modern Laravel frontend patterns while maintaining the pizza community metaphor.

## Theme Architecture with Folio + Volt

### Frontend Route Structure

The Meetup theme utilizes Laravel Folio for all public-facing routes, organized within the modular structure as follows. The routing is automatically handled by `Modules\Cms\Providers\FolioVoltServiceProvider`.

```
Themes/Meetup/resources/views/
├── pages/                    # Public-facing pages (Folio routes)
│   ├── index.blade.php       # Home page - / (localized: /en/, /it/, etc.)
│   ├── events/
│   │   ├── index.blade.php   # Event listing - /events (localized: /en/events, etc.)
│   │   └── [event].blade.php # Event detail - /events/{event} (localized: /en/events/{event}, etc.)
│   ├── profile/
│   │   └── [user].blade.php  # User profile - /profile/{user} (localized: /en/profile/{user}, etc.)
│   ├── dashboard.blade.php   # User dashboard - /dashboard (localized: /en/dashboard, etc.)
│   ├── chat.blade.php        # Community chat - /chat (localized: /en/chat, etc.)
│   ├── login.blade.php       # Login page - /login (localized: /en/login, etc.)
│   └── register.blade.php    # Registration - /register (localized: /en/register, etc.)
├── components/               # Reusable Volt/Livewire components
│   ├── event-card.blade.php
│   ├── navigation.blade.php
│   └── event-calendar.blade.php
└── layouts/                  # Theme layouts
    └── app.blade.php
```

### Routing Registration

The routing for these theme pages is automatically handled by the `Modules\Cms\Providers\FolioVoltServiceProvider`, which scans and registers all pages from the theme's pages directory:

```php
// In Modules/Cms/Providers/FolioVoltServiceProvider.php
$theme_path = XotData::make()->getPubThemeViewPath('pages');
if (File::exists($theme_path) && File::isDirectory($theme_path)) {
    Folio::path($theme_path)
        ->uri($locale)  // Adds locale prefix like /en/, /it/, etc.
        ->middleware([
            '*' => $base_middleware,
        ]);
}
```

### Modular Integration

This approach allows the Meetup theme to have its own dedicated pages while integrating seamlessly with the modular architecture. The same service provider also registers pages from modules like Meetup, allowing for a unified routing system across both themes and modules.

### Integration with Laravel Pizza Branding

The theme maintains the pizza metaphor while focusing on developer community aspects:

- **Event "Slices"**: Each event is metaphorically a "slice" of the community
- **Community "Ingredients"**: Different developer skill sets as pizza ingredients
- **Networking "Toppings"**: Additional features that enhance the community experience

## Frontend Implementation Patterns

### 1. Event Listing with Volt

```php
<?php

use function Laravel\Volt\{computed};
use App\Models\Event;
use App\Models\EventCategory;

$events = computed(fn () => Event::where('status', 'published')
    ->where('start_datetime', '>', now())
    ->with(['category', 'organizer'])
    ->orderBy('start_datetime')
    ->paginate(12));

$categories = computed(fn () => EventCategory::where('is_active', true)
    ->orderBy('order_column')
    ->get());

?>

<x-layout>
    <section class="py-12">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-white mb-4">Upcoming Events</h1>
                <p class="text-xl text-gray-400">Join fellow Laravel developers for pizza and knowledge sharing</p>
            </div>

            <!-- Category Filters -->
            <div class="flex flex-wrap justify-center gap-2 mb-8">
                @foreach($this->categories as $category)
                    <span class="px-4 py-2 rounded-full text-sm font-medium"
                          style="background-color: {{ $category->color }}20; color: {{ $category->color }}">
                        {{ $category->name }}
                    </span>
                @endforeach
            </div>

            <!-- Events Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($this->events as $event)
                    <x-event-card :event="$event" />
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $this->events->links() }}
            </div>
        </div>
    </section>
</x-layout>
```

### 2. Interactive Event Registration Component

```php
<?php

use Livewire\Volt\Component;
use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public Event $event;
    public $registrationData = [
        'num_guests' => 1,
        'special_requests' => '',
        'guest_name' => '',
        'guest_email' => '',
    ];

    public function mount(Event $event)
    {
        $this->event = $event;
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

        $registration = EventRegistration::create([
            'event_id' => $this->event->id,
            'user_id' => Auth::id(),
            'num_guests' => $this->registrationData['num_guests'],
            'special_requests' => $this->registrationData['special_requests'],
            'status' => 'confirmed',
        ]);

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

    @if($this->isRegistered)
        <div class="bg-green-500/10 border border-green-500 text-green-500 p-4 rounded-lg">
            You're already registered for this event!
        </div>
    @else
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

### 3. Real-time Chat Component

```php
<?php

use Livewire\Volt\Component;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

new class extends Component {
    public $messages = [];
    public $newMessage = '';
    public $channel = 'general';

    public function mount()
    {
        $this->loadMessages();
    }

    #[On('new-message')]
    public function refreshMessages()
    {
        $this->loadMessages();
    }

    public function loadMessages()
    {
        $this->messages = ChatMessage::where('channel', $this->channel)
            ->with('user')
            ->latest()
            ->limit(50)
            ->get()
            ->reverse()
            ->toArray();
    }

    public function sendMessage()
    {
        if (empty(trim($this->newMessage))) {
            return;
        }

        $message = ChatMessage::create([
            'user_id' => Auth::id(),
            'channel' => $this->channel,
            'content' => $this->newMessage,
        ]);

        $this->newMessage = '';

        $this->dispatch('new-message',
            message: $message->content,
            user: $message->user->name,
            time: $message->created_at->format('H:i')
        );
    }
}; ?>

<div class="flex flex-col h-[500px] bg-slate-800 rounded-lg border border-slate-700">
    <!-- Chat Header -->
    <div class="p-4 border-b border-slate-700">
        <h3 class="text-lg font-bold text-white">#{{ $channel }}</h3>
    </div>

    <!-- Messages Container -->
    <div wire:poll.5s="loadMessages" class="flex-1 overflow-y-auto p-4 space-y-4">
        @foreach($this->messages as $message)
            <div class="flex items-start space-x-3">
                <div class="w-8 h-8 rounded-full bg-red-500 flex items-center justify-center text-white text-xs">
                    {{ substr($message['user']['name'], 0, 1) }}
                </div>
                <div>
                    <div class="flex items-baseline">
                        <span class="font-bold text-white text-sm">{{ $message['user']['name'] }}</span>
                        <span class="text-xs text-gray-500 ml-2">{{ $message['time'] }}</span>
                    </div>
                    <p class="text-gray-300">{{ $message['content'] }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Message Input -->
    <div class="p-4 border-t border-slate-700">
        <div class="flex space-x-2">
            <input
                wire:model="newMessage"
                type="text"
                placeholder="Type your message..."
                class="flex-1 bg-slate-700 border border-slate-600 rounded-lg px-4 py-2 text-white"
                wire:keydown.enter="sendMessage"
            />
            <button
                wire:click="sendMessage"
                class="bg-red-600 hover:bg-red-700 text-white px-4 rounded-lg"
            >
                Send
            </button>
        </div>
    </div>
</div>
```

## Performance Optimization

### 1. Lazy Loading Components

```blade
{{-- resources/views/pages/events/[event].blade.php --}}
<x-layout>
    <div class="container mx-auto px-4 py-8">
        <!-- Event details content -->

        <!-- Lazy load the registration component -->
        <div class="mt-8">
            <livewire:event-registration :event="$event" lazy />
        </div>
    </div>
</x-layout>
```

### 2. Caching Computed Properties

```php
<?php

use function Laravel\Volt\{computed};
use Illuminate\Support\Facades\Cache;

$featuredEvents = computed(fn () => Cache::remember(
    'featured_events',
    now()->addHours(1),
    fn () => Event::where('is_featured', true)
        ->where('status', 'published')
        ->where('start_datetime', '>', now())
        ->orderBy('start_datetime')
        ->limit(6)
        ->get()
));
```

## Styling and Branding

### Theme-Specific CSS

The Meetup theme uses Tailwind CSS with custom configurations to maintain the Laravel Pizza branding:

```js
// tailwind.config.cjs
module.exports = {
  content: [
    './Themes/Meetup/resources/**/*.{blade.php,js,vue,ts}',
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          50: '#fef2f2',
          100: '#fee2e2',
          // ... other shades
          600: '#dc2626', // Laravel red
          700: '#b91c1c',
        }
      },
      fontFamily: {
        sans: ['Inter', 'sans-serif'],
      }
    },
  },
  plugins: [],
}
```

### Pizza Metaphor Implementation

The pizza metaphor is implemented subtly in the design:

- **Pizza Slice Icons**: Used for events, representing "slices" of the community
- **Topping Elements**: Additional features and functionality
- **Ingredient Components**: Different types of events and activities
- **Flavor Categories**: Event categories with different "flavors"

## Integration with Laravel Pizza Ecosystem

### Module Communication

The theme integrates with other Laravel Pizza modules:

- **User Module**: Authentication and user profiles
- **Meetup Module**: Event management and registrations
- **Chat Module**: Real-time community interactions
- **Media Module**: Event images and user avatars
- **SEO Module**: Meta tags and search optimization

### Asset Management

```js
// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'Themes/Meetup/resources/css/app.css',
                'Themes/Meetup/resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
```

## Testing and Quality Assurance

### Frontend Testing

```php
// Tests/Feature/EventsPageTest.php
public function test_events_page_loads()
{
    $response = $this->get('/events');

    $response->assertSuccessful();
    $response->assertSeeLivewire('event-registration');
}

// Tests/Browser/EventRegistrationTest.php
public function test_user_can_register_for_event()
{
    $this->browse(function (Browser $browser) {
        $browser->visit('/events/1')
                ->click('@register-button')
                ->assertSee('Successfully registered');
    });
}
```

## Security Considerations

### Input Validation

All Volt components implement proper validation:

```php
public function rules()
{
    return [
        'registrationData.name' => ['required', 'string', 'max:255'],
        'registrationData.email' => ['required', 'email', 'max:255'],
        'registrationData.special_requests' => ['nullable', 'string', 'max:500'],
    ];
}
```

### Authorization

Components check user permissions:

```php
public function register()
{
    abort_unless(Auth::check(), 403);

    // Additional authorization checks
    if ($this->event->registration_deadline < now()) {
        throw new \Exception('Registration deadline has passed');
    }
}
```

## Deployment Considerations

### Asset Compilation

Ensure proper asset compilation in production:

```bash
npm run build
php artisan folio:cache  # Cache Folio routes in production
```

### Caching Strategy

Implement appropriate caching for optimal performance:

```php
// Cache computed properties
$events = computed(fn () => Cache::remember('events_upcoming', 300, function () {
    return Event::where('start_datetime', '>', now())
        ->orderBy('start_datetime')
        ->take(10)
        ->get();
}));
```

## Conclusion

The Laravel Pizza Meetup theme successfully implements Folio and Volt to create a modern, efficient frontend for the developer community platform. The implementation maintains the pizza metaphor while focusing on the core purpose of connecting Laravel developers.

The architecture follows DRY, KISS, SOLID, and Laraxot principles, ensuring maintainability and scalability. The theme integrates seamlessly with the modular Laravel architecture while providing an excellent user experience for the Laravel developer community.

---

**Document Version**: 1.0
**Last Updated**: November 28, 2025
