# Laravel Folio + Volt Implementation Guide

## Overview

Laravel Folio and Laravel Volt represent a modern approach to building Laravel applications, particularly for front office implementations. This combination provides a clean, efficient way to build dynamic web applications without traditional controllers.

## Laravel Folio

### What is Laravel Folio?

Laravel Folio is a page-based router that simplifies routing in Laravel applications. Instead of defining routes in web.php, you create Blade templates in your application's `resources/views/pages` directory, and Laravel automatically creates routes for them.

### Key Features

- **File-based routing**: Create routes by creating Blade files
- **Automatic route generation**: `/resources/views/pages/events/index.blade.php` becomes `/events`
- **Parameter capture**: Use `[parameter]` syntax to capture route parameters
- **Nested routing**: Create complex URL structures with directory nesting

### Installation and Setup

```bash
composer require laravel/folio
php artisan folio:install
```

### Directory Structure

```
resources/
└── views/
    └── pages/
        ├── events/
        │   ├── index.blade.php      # /events
        │   └── [event].blade.php    # /events/{event}
        ├── profile/
        │   └── [user].blade.php     # /profile/{user}
        └── dashboard.blade.php      # /dashboard
```

### Route Parameters

- `[parameter]` - Required parameter
- `[[parameter]]` - Optional parameter
- `[parameter:slug]` - Specify column for model binding

## Laravel Volt

### What is Laravel Volt?

Laravel Volt brings the power of single-file Livewire components to Laravel, working seamlessly with Folio. It allows you to write PHP logic and Blade templates in the same file with reduced boilerplate.

### Key Features

- **Single-file components**: PHP logic and Blade template in one file
- **Reduced boilerplate**: Less code needed for interactive components
- **Functional API**: Elegant way to define component logic
- **Seamless Folio integration**: Works perfectly with file-based routing

### Installation and Setup

```bash
composer require livewire/volt
php artisan volt:install
```

### Basic Component Example

```php
<?php

use function Laravel\Volt\{state, rules, withValidator, mount, computed};
use App\Models\Event;
use Livewire\Volt\Component;

new class extends Component {
    public Event $event;
    public $registrationData = [];
    
    public function mount(Event $event)
    {
        $this->event = $event;
    }
    
    public function register()
    {
        $validated = $this->validate([
            'registrationData.name' => 'required|string|max:255',
            'registrationData.email' => 'required|email',
        ]);
        
        // Registration logic here
        
        return $this->redirect(route('events.show', $this->event));
    }
}; ?>

<div>
    <h1>{{ $event->title }}</h1>
    <p>{{ $event->description }}</p>
    
    <form wire:submit="register">
        <input 
            wire:model="registrationData.name" 
            type="text" 
            placeholder="Your name" 
        />
        <input 
            wire:model="registrationData.email" 
            type="email" 
            placeholder="Your email" 
        />
        <button type="submit">Register</button>
    </form>
</div>
```

## Folio + Volt Integration

### Page with Volt Components

```blade
{{-- resources/views/pages/events/show.blade.php --}}
<x-layout>
    <livewire:event-registration :event="$event" />
</x-layout>
```

### Shared State Between Components

Volt components can share state and communicate effectively:

```php
<?php

use function Laravel\Volt\{state};
use Livewire\Volt\Component;

// In a layout component
new class extends Component {
    public function with()
    {
        return [
            'appName' => config('app.name')
        ];
    }
}; ?>

<div>
    <header>
        <h1>{{ $appName }}</h1>
    </header>
    <main>
        {{ $slot }}
    </main>
</div>
```

## Best Practices

### 1. Directory Organization

```
resources/views/
├── pages/              # Folio routes
│   ├── events/
│   │   ├── index.blade.php
│   │   ├── [event].blade.php
│   │   └── create.blade.php
│   ├── profile/
│   │   └── [user].blade.php
│   └── dashboard.blade.php
├── components/         # Reusable Volt/Livewire components
│   ├── event-card.blade.php
│   └── registration-form.blade.php
├── layouts/            # Layout templates
│   └── app.blade.php
└── sections/           # Page sections
    └── navigation.blade.php
```

### 2. Component Design

- Keep components focused on a single responsibility
- Use descriptive names for components
- Leverage computed properties for expensive operations
- Use proper validation and error handling

### 3. Performance Optimization

- Use lazy loading for components that aren't immediately needed
- Implement proper caching strategies
- Optimize database queries within components
- Use eager loading to prevent N+1 queries

### 4. Security Considerations

- Validate all user input in Volt components
- Use Laravel's built-in authorization
- Implement proper CSRF protection
- Sanitize output to prevent XSS attacks

## Real-World Example: Event Registration System

### Event Listing Page

```php
{{-- resources/views/pages/events/index.blade.php --}}
<?php

use App\Models\Event;
use function Laravel\Volt\{computed};

$events = computed(fn () => Event::where('start_datetime', '>', now())
    ->orderBy('start_datetime')
    ->limit(10)
    ->get());

?>

<x-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">Upcoming Events</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($this->events as $event)
                <x-event-card :event="$event" />
            @endforeach
        </div>
    </div>
</x-layout>
```

### Individual Event Page

```php
<?php

use App\Models\Event;
use Livewire\Volt\Component;
use function Laravel\Volt\{mount};

new class extends Component {
    public Event $event;
    
    public function mount(Event $event)
    {
        $this->event = $event->load('organizer');
    }
    
    public function register()
    {
        if (!auth()->check()) {
            return $this->redirect(route('login', ['redirect' => request()->url()]));
        }
        
        // Registration logic
        $this->dispatch('registration-success', eventId: $this->event->id);
    }
}; ?>

<x-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-6">
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $event->title }}</h1>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div>
                            <p class="text-gray-600">Date</p>
                            <p class="font-medium">{{ $event->start_datetime->format('M j, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Time</p>
                            <p class="font-medium">{{ $event->start_datetime->format('g:i A') }} - {{ $event->end_datetime->format('g:i A') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Location</p>
                            <p class="font-medium">{{ $event->venue_name }}</p>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold mb-3">Description</h2>
                        <div class="text-gray-700">
                            {!! Str::markdown($event->description) !!}
                        </div>
                    </div>
                    
                    <button 
                        wire:click="register"
                        class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg"
                    >
                        Register Now
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-layout>
```

## Integration with Modular Architecture

### Module-Specific Pages

In this Laravel Pizza application using nwidart/laravel-modules, Folio pages are organized within each module and theme using a centralized service provider approach. The actual registration is handled by the `Modules\Cms\Providers\FolioVoltServiceProvider`.

```
Modules/
└── Meetup/
    └── Resources/
        └── views/
            └── pages/           # Module-specific Folio pages
                └── events/
                    ├── index.blade.php
                    └── [event].blade.php
Themes/
└── Meetup/
    └── resources/
        └── views/
            └── pages/          # Theme-specific Folio pages
                ├── index.blade.php
                └── about.blade.php
```

### Service Provider Integration (Actual Implementation)

The Folio paths are registered in `Modules\Cms\Providers\FolioVoltServiceProvider.php` which automatically scans and registers pages from both module and theme directories:

```php
// Modules/Cms/app/Providers/FolioVoltServiceProvider.php
public function boot(): void
{
    // Register theme-specific Folio paths
    $theme_path = XotData::make()->getPubThemeViewPath('pages');
    if (File::exists($theme_path) && File::isDirectory($theme_path)) {
        Folio::path($theme_path)
            ->middleware([
                '*' => $base_middleware,
            ]);
    }

    // Register module-specific Folio paths
    $modules = Module::all();
    foreach ($modules as $module) {
        $path = $module->getPath().'/resources/views/pages';
        if (File::exists($path) && File::isDirectory($path)) {
            Folio::path($path)
                ->middleware([
                    '*' => $base_middleware,
                ]);
        }
    }
}
```

### Creating Folio Pages in Modules

To create Folio pages in the Meetup module, place your Blade files in:
```
Modules/Meetup/Resources/views/pages/
├── index.blade.php          # Route: /
├── events/index.blade.php   # Route: /events
└── events/[event].blade.php # Route: /events/{event}
```

### Creating Folio Pages in Themes

To create Folio pages in the Meetup theme, place your Blade files in:
```
Themes/Meetup/resources/views/pages/
├── index.blade.php          # Route: /
├── about.blade.php          # Route: /about
└── contact.blade.php        # Route: /contact
```

### Multi-Source Routing Priority

When both a module and theme have the same route (e.g., both have an `index.blade.php`), the order of registration determines which takes precedence. The system typically registers theme routes first, followed by module routes.

### Localization Support

The Folio system is integrated with the Laravel localization system:

```php
// In the actual service provider
$locale = LaravelLocalization::setLocale() ?: app()->getLocale();
Folio::path($theme_path)
    ->uri($locale)  // This adds locale prefix to routes
    ->middleware([
        '*' => $base_middleware,
    ]);
```

This means routes will be automatically prefixed with the current locale (e.g., `/en/events`, `/it/events`, etc.).

## Performance Considerations

### Caching Strategies

- Cache computed properties that perform expensive operations
- Use Laravel's caching for data that doesn't change frequently
- Implement proper cache invalidation when data changes

### Database Optimization

- Use eager loading to prevent N+1 queries
- Implement proper indexing on frequently queried columns
- Use database read replicas for read-heavy operations

### Asset Optimization

- Leverage Vite for efficient asset building
- Implement proper image optimization
- Use CDN for static assets

## Testing Strategy

### Unit Tests

- Test Volt component logic separately from UI
- Test computed properties and their dependencies
- Test validation logic and error handling

### Feature Tests

- Test full user flows across Folio pages
- Test Volt component interactions
- Test route parameter handling

### Browser Tests

- Use Laravel Dusk for end-to-end testing
- Test complex user interactions with Volt components
- Test JavaScript functionality

## Migration from Traditional Architecture

### Converting Controllers to Folio

**Before (Traditional Controller):**
```php
// routes/web.php
Route::get('/events', [EventController::class, 'index']);
Route::get('/events/{event}', [EventController::class, 'show']);

// app/Http/Controllers/EventController.php
class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return view('events.index', compact('events'));
    }
    
    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }
}
```

**After (Folio + Volt):**
```blade
{{-- resources/views/pages/events/index.blade.php --}}
<?php
use function Laravel\Volt\{computed};
use App\Models\Event;

$events = computed(fn () => Event::all());
?>

<x-layout>
    @foreach($this->events as $event)
        <div>{{ $event->title }}</div>
    @endforeach
</x-layout>
```

## Common Patterns and Solutions

### Form Handling

```php
<?php
use function Laravel\Volt\{state, rules};
use Livewire\Volt\Component;

new class extends Component {
    public $title = '';
    public $description = '';
    
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ];
    }
    
    public function createEvent()
    {
        $validated = $this->validate();
        
        $event = Event::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'user_id' => auth()->id(),
        ]);
        
        $this->redirect(route('events.show', $event));
    }
};
```

### Real-time Updates

```php
<?php
use Livewire\Volt\Component;
use Livewire\Attributes\On;

new class extends Component {
    public $attendees = [];
    
    #[On('user-joined-event')]
    public function refreshAttendees($eventId)
    {
        if (request()->route('event') == $eventId) {
            $this->attendees = Event::find($eventId)->attendees;
        }
    }
};
```

## Conclusion

Laravel Folio and Volt provide a modern, efficient approach to building Laravel applications. They reduce boilerplate code, improve developer experience, and maintain the power and flexibility of Laravel. When combined with proper architectural patterns and best practices, they enable the creation of maintainable and scalable applications.

For the Laravel Pizza Meetups project, this approach aligns perfectly with the DRY, KISS, SOLID, and Laraxot principles while providing a clean separation between front office (Folio + Volt) and back office (Filament) functionality.

---

**Document Version**: 1.0  
**Last Updated**: November 28, 2025