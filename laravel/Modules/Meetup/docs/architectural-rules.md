# Laravel Pizza Meetups - Architectural Rules & Best Practices

## Core Architecture Principles

### Front Office Architecture
- **Laravel Folio**: File-based routing for all front office pages (NO traditional controllers/routes in web.php/api.php)
- **Laravel Volt**: Declarative components for front office functionality
- **NO Controllers in web.php/api.php**: Front office routes are handled exclusively by Folio
- **Follows DRY, KISS, SOLID, Robust, Laraxot principles**

### Back Office Architecture
- **Filament**: Admin panel and backend UI components
- **Traditional Laravel patterns**: May use controllers, routes in admin areas as appropriate

## Front Office Implementation Rules

### 1. Routing with Laravel Folio
- All front office routes defined via file structure in `/resources/views/pages/`
- No manual route definitions in web.php for front office pages
- Example structure: `/resources/views/pages/events/show.blade.php` becomes `/events/{event}`
- Parameter syntax: `[parameter]` for required, `[[parameter]]` for optional
- Nested routes supported: `/resources/views/pages/events/[event]/attendees.blade.php` becomes `/events/{event}/attendees`
- Use `php artisan folio:list` to view all registered Folio routes

### 2. Laravel Volt Components
- Single-file components with PHP logic and Blade template
- Use namespaced functions: `use function Laravel\Volt\{state, rules, computed, mount}`
- Computed properties for expensive operations: `$events = computed(fn () => Event::all());`
- Validation with Volt's built-in validation features
- Perfect integration with Folio pages as shown in Genesis starter kit

### 3. Genesis Starter Kit Patterns
Based on the Genesis starter kit (https://github.com/thedevdojo/genesis), implement:

**Authentication Flow:**
- `/auth/login` - Login page
- `/auth/register` - Registration page
- `/auth/verify` - Email verification
- `/dashboard` - User dashboard
- `/profile/edit` - Profile editing

**Page Structure:**
```
/resources/views/pages/
├── index.blade.php
├── about.blade.php
├── auth/
│   ├── login.blade.php
│   ├── register.blade.php
│   ├── verify.blade.php
│   └── password/
│       ├── reset.blade.php
│       └── confirm.blade.php
├── dashboard/
│   └── index.blade.php
└── profile/
    └── edit.blade.php
```

**Component Usage:**
- Use layout components: `<x-layout>`
- Implement middleware in pages: `middleware(['auth'])`
- Use computed properties for data loading
- Implement proper error handling and validation

### 4. Laravel News Implementation Patterns
Based on Laravel News articles about Livewire Volt and Folio:

**Computed Properties Best Practices:**
```php
<?php
use function Laravel\Volt\{computed};

// For expensive operations
$events = computed(fn () => Event::where('status', 'published')
    ->where('start_datetime', '>', now())
    ->with(['category', 'organizer'])
    ->orderBy('start_datetime')
    ->get());

// For relationships
$attendees = computed(fn () => $this->event->attendees()->with('user')->get());
```

**State Management:**
```php
<?php
use function Laravel\Volt\{state};

// For simple state
state(['count' => 0, 'name' => '']);

// For complex state
state([
    'filters' => [
        'category' => null,
        'date' => null,
        'search' => ''
    ]
]);
```

**Middleware in Pages:**
```php
<?php
use function Laravel\Folio\MountPath;

// Apply middleware at the page level
middleware(['auth', 'verified']);

// Or conditionally
if (auth()->check()) {
    middleware(['auth']);
} else {
    middleware(['guest']);
}
```

**Form Handling:**
```php
<?php
use Livewire\Volt\Component;

new class extends Component {
    public $name = '';
    public $email = '';

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ];
    }

    public function save()
    {
        $validated = $this->validate();
        // Process form
    }
};
```

### 5. Warriorfolio Implementation Patterns
Based on Warriorfolio (mviniciusca/warriorfolio) project patterns:

**Modular Component Architecture:**
- Components integrate seamlessly like building blocks
- Reusable UI elements following Saturn UI design system
- Page builder with modular content blocks

**Advanced Features Implementation:**
- Portfolio/Projects with categories, tags, and SEO optimization
- Advanced search with debouncing and real-time filtering
- GitHub integration with repository display and contribution graphs
- Real-time notifications and alerts system

**Dashboard and Admin Patterns:**
- Intuitive Filament-powered dashboard
- Real-time notifications
- Analytics integration (Google Analytics)
- Email inbox management
- Module visibility controls

**Performance and Security:**
- Query optimization for performance
- Google reCAPTCHA v2 integration
- Image optimization and enhanced lazy loading
- SEO-friendly URLs and meta tags

**Example: Advanced Search Component**
```php
<?php
use Livewire\Volt\Component;
use function Laravel\Volt\{state, computed};

new class extends Component {
    public $searchTerm = '';
    public $filters = [
        'category' => null,
        'date' => null,
        'tags' => []
    ];

    public function mount()
    {
        $this->searchTerm = request('q', '');
        $this->filters = [
            'category' => request('category', null),
            'date' => request('date', null),
            'tags' => request('tags', [])
        ];
    }

    public function getSearchResultsProperty()
    {
        return \App\Models\Event::when($this->searchTerm, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('title', 'like', '%' . $this->searchTerm . '%')
                             ->orWhere('description', 'like', '%' . $this->searchTerm . '%');
                });
            })
            ->when($this->filters['category'], function ($query) {
                $query->where('category_id', $this->filters['category']);
            })
            ->with(['category', 'organizer'])
            ->orderBy('start_datetime', 'desc')
            ->get();
    }

    // Debounced search method
    public function searchUpdated()
    {
        $this->dispatch('search-updated');
    }
}; ?>

<div>
    <div class="relative">
        <input
            wire:model.live.debounce.500ms="searchTerm"
            wire:keydown="searchUpdated"
            type="text"
            placeholder="Search events..."
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
        />
        @if($searchTerm)
            <div class="absolute top-10 left-0 right-0 bg-white shadow-lg rounded-lg z-10 p-4">
                <div class="text-sm text-gray-600 mb-2">
                    {{ $this->searchResults->count() }} results for "{{ $searchTerm }}"
                </div>
                @foreach($this->searchResults->take(5) as $result)
                    <a href="{{ route('events.show', $result) }}" class="block p-2 hover:bg-gray-100 rounded">
                        {{ $result->title }}
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>
```

### 2. Components with Laravel Volt
- Use Volt for interactive components on front office
- Volt components in `/resources/views/components/`
- Follow Volt syntax and conventions

### 3. Page Structure
- Pages in `/resources/views/pages/` directory
- Layout files in `/resources/views/layouts/`
- Components in `/resources/views/components/`

## Development Best Practices

### 1. DRY (Don't Repeat Yourself)
- Reuse components and functions across the application
- Extract common functionality to shared services/actions
- Use Laravel's built-in features to avoid duplication

### 2. KISS (Keep It Simple, Stupid)
- Simple, readable code over complex solutions
- Avoid over-engineering
- Focus on maintainability

### 3. SOLID Principles
- Single Responsibility: Each class has one reason to change
- Open/Closed: Open for extension, closed for modification
- Liskov Substitution: Subtypes must be substitutable
- Interface Segregation: Clients shouldn't depend on unused interfaces
- Dependency Inversion: Depend on abstractions, not concretions

### 4. Robust Design
- Error handling and validation
- Type safety with strict typing
- Comprehensive testing
- Defensive programming practices

### 5. Laraxot Philosophy
- Follow modular architecture patterns
- Use Actions for business logic (Spatie Action pattern)
- Maintain separation of concerns
- Follow Laravel conventions within module structure

## Front Office Technologies Stack

### Core Components
- **Laravel Folio**: File-based routing for front office
- **Laravel Volt**: Declarative components for UI interactions
- **Tailwind CSS**: Styling framework
- **Alpine.js**: JavaScript framework for interactivity (when needed)
- **Vite**: Asset building and module bundling

### Implementation Examples

**Folio Route Example:**
```
/resources/views/pages/
├── events/
│   ├── index.blade.php      # /events
│   └── show.blade.php       # /events/{event}
├── profile/
│   └── show.blade.php       # /profile/{user}
└── dashboard.blade.php      # /dashboard
```

**Volt Component Example:**
```php
<?php

use Livewire\Volt\Component;
use App\Models\Event;

new class extends Component {
    public Event $event;

    public function register()
    {
        // Registration logic
    }
}; ?>

<div>
    <h1>{{ $event->title }}</h1>
    <button wire:click="register">Register</button>
</div>
```

## Database and Model Layer

### Models
- Traditional Laravel Eloquent models
- Follow Laravel naming conventions
- Use model factories for testing
- Implement proper relationships

### Actions (Spatie Pattern)
- Use Actions for business logic
- Actions in `/app/Actions/` or module equivalent
- Single responsibility per action
- Type-hinted parameters and return values

## Testing Strategy

### Unit Tests
- Test individual functions and methods
- Focus on business logic in Actions
- Test Models and their relationships

### Feature Tests
- Test user flows and interactions
- Test Folio routes and Volt components
- Use Laravel's testing helpers

### Browser Tests
- Test user interface interactions
- Use Laravel Dusk for end-to-end testing
- Test complex user journeys

## Module Structure Integration

### Meetup Module
- Follow nwidart/laravel-modules conventions
- Keep front office logic in appropriate directories
- Use proper namespacing
- Maintain separation between modules

### Front Office Directories
```
Modules/Meetup/
├── Resources/
│   └── views/
│       ├── pages/          # Folio routes
│       ├── components/     # Volt components
│       └── layouts/        # Page layouts
└── Routes/
    └── web.php             # Only for non-Folio routes if needed
```

## Performance Considerations

### Caching Strategy
- Use Laravel's caching for expensive operations
- Cache frequently accessed data
- Implement proper cache invalidation

### Database Optimization
- Proper indexing on frequently queried columns
- Use eager loading to prevent N+1 queries
- Optimize queries with query builder

### Asset Optimization
- Use Vite for efficient asset building
- Implement proper image optimization
- Leverage browser caching

## Security Best Practices

### Input Validation
- Validate all user input
- Use Laravel's validation features
- Sanitize output to prevent XSS

### Authentication & Authorization
- Use Laravel's built-in authentication
- Implement proper authorization with policies
- Secure API endpoints

### Data Protection
- Use HTTPS in production
- Implement proper session management
- Protect against common vulnerabilities

## Deployment & Production

### Environment Management
- Use environment-specific configurations
- Secure sensitive configuration values
- Implement proper logging

### Performance Monitoring
- Monitor application performance
- Track key metrics
- Implement error tracking

## Conclusion

This architectural approach using Laravel Folio + Volt + Filament provides:
- Clean, maintainable code structure
- Separation of concerns
- Scalable architecture
- Modern development practices
- Adherence to DRY, KISS, SOLID, robust, and Laraxot principles

Following these rules ensures consistency across the Laravel Pizza Meetups project and maintains the high-quality standards expected in the Laravel ecosystem.

---

**Document Version**: 1.0
**Last Updated**: November 28, 2025
