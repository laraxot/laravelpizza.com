# Laravel Folio + Volt - Best Practices and Patterns Analysis

## Overview

Based on research of multiple Laravel Folio + Volt repositories and official documentation, this document outlines the best practices and patterns for implementing Folio + Volt in applications.

## Key Patterns Identified

### 1. File Structure
- **Pages Directory**: Folio automatically maps files in `resources/views/pages/` to routes
  - Example: `resources/views/pages/events.blade.php` → `/events`
  - Example: `resources/views/pages/events/[event].blade.php` → `/events/{event}`
- **Subdirectories**: Organize related pages in subdirectories (e.g., `resources/views/pages/auth/`)
- **Blade Components**: Store reusable UI components in `resources/views/components/`

### 2. Volt Component Structure
- Volt components can exist within Folio pages using the `@volt` directive
- Components can also be standalone files in `resources/views/livewire/` or custom mounted directories
- Single-file components combine PHP logic and Blade template

Example of a Volt component in a Folio page:
```blade
<?php
use App\Models\Event;
use function Livewire\Volt\{computed, mount};

$events = computed(fn () => Event::upcoming()->get());
?>

<x-layout>
    @volt('events-list')
        <div class="events-container">
            @foreach($this->events as $event)
                <div class="event-card">
                    <h3>{{ $event->title }}</h3>
                    <p>{{ $event->date }}</p>
                </div>
            @endforeach
        </div>
    @endvolt
</x-layout>
```

### 3. Authentication Patterns
- Apply middleware using the `middleware()` function within page files
- Common authentication routes: `login.blade.php`, `register.blade.php`, `verify.blade.php`
- Use `middleware(['auth', 'verified'])` for protected pages
- Authentication files typically located in `resources/views/pages/auth/`

### 4. Layout and Component Structure
- Create a main layout component (e.g., `resources/views/components/layout.blade.php`)
- Use anonymous Blade components for consistent page structure
- Implement a consistent navigation component that can be included across pages

### 5. Data Handling
- Use `computed()` for data that should be cached until dependencies change
- Use `state()` for reactive properties
- Use `mount()` for initialization logic when component loads
- Sushi package can be used for dummy data in development

### 6. Middleware Application
Middleware can be applied in multiple ways:
- Per page: `middleware(['auth'])` inside the page file
- Per directory: Using Folio path configuration with middleware
- Globally: Through Laravel's HTTP kernel

Example:
```php
<?php
use function Laravel\Folio\middleware;

middleware(['auth', 'verified']);
```

### 7. Naming and Routing Conventions
- Folio automatically creates routes based on file names
- Use `[parameter].blade.php` for route parameters (e.g., `[event].blade.php` → `/events/{event}`)
- Use `[...wildcard].blade.php` for wildcard parameters
- Use `index.blade.php` for default page in a directory (e.g., `events/index.blade.php` → `/events`)

### 8. Component Organization
- Reusable components go in `resources/views/components/`
- Page-specific interactive elements can use inline `@volt` directive
- Complex reusable components can be full Livewire class components

## Best Practices Summary
1. Keep page logic minimal and focused
2. Use computed properties for data that doesn't change frequently
3. Apply appropriate middleware for access control
4. Organize files in a logical directory structure
5. Use consistent layouts across the application
6. Leverage Laravel's built-in authentication features
7. Take advantage of route caching with `php artisan route:cache`
8. Use type hints and return types where possible for better code quality

## References
- Laravel Folio Documentation: https://laravel.com/docs/folio
- Laravel Volt Documentation: https://livewire.laravel.com/docs/volt
- Jason Beggs Laravel News Example: https://github.com/jasonlbeggs/laravel-news-volt-folio-example
- Genesis Starter Kit: https://github.com/thedevdojo/genesis

## Date
2025-11-29
