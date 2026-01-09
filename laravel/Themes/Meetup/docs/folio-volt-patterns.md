# Folio + Volt Patterns - Meetup Theme

## Panoramica

Questo documento descrive i pattern comuni utilizzati nel tema Meetup per implementare pagine con Folio e componenti Volt.

## Pattern Comuni

### Pattern 1: Lista con Filtri

**Uso**: Pagine che mostrano liste di elementi con filtri

**Esempio**: `events.blade.php`

```blade
<x-layouts.app>
    @volt('events')
        @php
            $category = request()->query('category', 'all');
            $events = app(EventService::class)->getFilteredEvents($category);
        @endphp

        <div class="filters">
            <a href="?category=all">All</a>
            <a href="?category=meetups">Meetups</a>
            <a href="?category=workshops">Workshops</a>
        </div>

        <div class="events-list">
            @foreach($events as $event)
                <x-event-card :event="$event" />
            @endforeach
        </div>
    @endvolt
</x-layouts.app>
```

### Pattern 2: Dettaglio con Azioni

**Uso**: Pagine di dettaglio con azioni interattive

**Esempio**: `events/[event].blade.php`

```blade
<x-layouts.app>
    @volt('event-detail')
        <h1>{{ $event->title }}</h1>

        @volt('event-actions')
            @if(auth()->check())
                <button wire:click="register">Register</button>
            @else
                <a href="/login">Login to Register</a>
            @endif
        @endvolt

        function register()
        {
            app(RegisterEventAction::class)->execute($this->event, auth()->user());
        }
    @endvolt
</x-layouts.app>
```

### Pattern 3: Form con Validazione

**Uso**: Form di registrazione, login, modifica profilo

**Esempio**: `auth/register.blade.php`

```blade
<x-layouts.auth>
    @volt('register')
        <form wire:submit="register">
            <input type="text" wire:model="name" />
            @error('name') <span>{{ $message }}</span> @enderror

            <input type="email" wire:model="email" />
            @error('email') <span>{{ $message }}</span> @enderror

            <input type="password" wire:model="password" />
            @error('password') <span>{{ $message }}</span> @enderror

            <button type="submit">Register</button>
        </form>
    @endvolt

    function register()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        app(RegisterUserAction::class)->execute([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ]);

        return redirect('/dashboard');
    }
</x-layouts.auth>
```

### Pattern 4: Dashboard con Statistiche

**Uso**: Dashboard con dati aggregati e liste

**Esempio**: `dashboard.blade.php`

```blade
<x-layouts.app>
    @volt('dashboard')
        @php
            $stats = app(UserStatsService::class)->getUserStats(auth()->user());
        @endphp

        <div class="stats-grid">
            <x-stat-card label="Events" :value="$stats['events']" />
            <x-stat-card label="Messages" :value="$stats['messages']" />
        </div>

        @volt('recent-activity')
            @php
                $activities = auth()->user()->activities()->latest()->limit(10)->get();
            @endphp

            <div class="activity-list">
                @foreach($activities as $activity)
                    <x-activity-item :activity="$activity" />
                @endforeach
            </div>
        @endvolt
    @endvolt
</x-layouts.app>
```

### Pattern 5: Chat Real-time

**Uso**: Chat community con aggiornamenti real-time

**Esempio**: `chat.blade.php`

```blade
<x-layouts.app>
    @volt('chat')
        @php
            $channel = request()->query('channel', 'general');
            $messages = app(ChatService::class)->getChannelMessages($channel);
        @endphp

        <div class="chat-container">
            <div class="channels">
                <a href="?channel=general">General</a>
                <a href="?channel=laravel">Laravel</a>
            </div>

            @volt('chat-messages')
                <div class="messages" wire:poll.2s>
                    @foreach($messages as $message)
                        <x-chat-message :message="$message" />
                    @endforeach
                </div>

                <form wire:submit="sendMessage">
                    <input type="text" wire:model="messageText" />
                    <button type="submit">Send</button>
                </form>
            @endvolt

            function sendMessage()
            {
                app(SendChatMessageAction::class)->execute(
                    $this->channel,
                    auth()->user(),
                    $this->messageText
                );

                $this->messageText = '';
            }
        </div>
    @endvolt
</x-layouts.app>
```

## Componenti Riutilizzabili

### Event Card Component

**File**: `components/event-card.blade.php`

```blade
@props(['event'])

<div class="event-card">
    <h3>{{ $event->title }}</h3>
    <p>{{ $event->description }}</p>
    <p>{{ $event->start_date->format('F j, Y') }}</p>
    <a href="/events/{{ $event->id }}">View Details</a>
</div>
```

### Statistics Card Component

**File**: `components/statistics-card.blade.php`

```blade
@props(['label', 'value', 'icon'])

<div class="stat-card">
    <div class="icon">{{ $icon }}</div>
    <div class="value">{{ $value }}</div>
    <div class="label">{{ $label }}</div>
</div>
```

## Layout Structure

### Layout App

**File**: `layouts/app.blade.php`

```blade
<!DOCTYPE html>
<html>
<head>
    <title>{{ $title ?? 'Laravel Pizza Meetups' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <x-navigation />

    <main>
        {{ $slot }}
    </main>

    <x-footer />
</body>
</html>
```

### Layout Auth

**File**: `layouts/auth.blade.php`

```blade
<!DOCTYPE html>
<html>
<head>
    <title>{{ $title ?? 'Authentication' }}</title>
    @vite(['resources/css/app.css'])
</head>
<body class="auth-page">
    <div class="auth-container">
        {{ $slot }}
    </div>
</body>
</html>
```

## Best Practices per il Tema

### 1. Organizzazione File

```
Themes/Meetup/resources/views/
├── layouts/
│   ├── app.blade.php
│   └── auth.blade.php
├── components/
│   ├── navigation.blade.php
│   ├── footer.blade.php
│   ├── event-card.blade.php
│   └── statistics-card.blade.php
└── pages/
    ├── index.blade.php
    ├── events.blade.php
    ├── events/
    │   └── [event].blade.php
    ├── dashboard.blade.php
    ├── profile.blade.php
    ├── chat.blade.php
    └── auth/
        ├── login.blade.php
        └── register.blade.php
```

### 2. Naming Conventions

- **Pagine**: `kebab-case.blade.php` (es: `event-detail.blade.php`)
- **Componenti**: `kebab-case.blade.php` (es: `event-card.blade.php`)
- **Volt Components**: `snake_case` (es: `@volt('event_detail')`)

### 3. Type Safety

Sempre usare type hints nelle funzioni Volt:

```blade
@volt('example')
    function register(Event $event, User $user): void
    {
        // Type-safe!
    }
@endvolt
```

### 4. Error Handling

```blade
@volt('example')
    function register()
    {
        try {
            app(RegisterEventAction::class)->execute($this->event, auth()->user());
            $this->dispatch('success', 'Registered successfully!');
        } catch (\Exception $e) {
            $this->dispatch('error', $e->getMessage());
        }
    }
@endvolt
```

## UI Component Patterns (da Genesis Starter Kit)

### Button Component

**File**: `components/ui/button.blade.php`

```blade
@props([
    'variant' => 'primary', // primary, secondary, danger, ghost
    'size' => 'md', // sm, md, lg
    'type' => 'button',
])

@php
$classes = match($variant) {
    'primary' => 'bg-red-600 hover:bg-red-700 text-white',
    'secondary' => 'bg-slate-600 hover:bg-slate-700 text-white',
    'danger' => 'bg-red-500 hover:bg-red-600 text-white',
    'ghost' => 'bg-transparent hover:bg-slate-100 text-slate-900',
};

$sizes = match($size) {
    'sm' => 'px-3 py-1.5 text-sm',
    'md' => 'px-4 py-2',
    'lg' => 'px-6 py-3 text-lg',
};
@endphp

<button
    type="{{ $type }}"
    {{ $attributes->merge(['class' => "rounded-lg font-medium transition-colors {$classes} {$sizes}"]) }}
>
    {{ $slot }}
</button>
```

**Usage**:
```blade
<x-ui.button variant="primary" wire:click="register">
    Register for Event
</x-ui.button>

<x-ui.button variant="ghost" size="sm" wire:click="cancel">
    Cancel
</x-ui.button>
```

### Input Component

**File**: `components/ui/input.blade.php`

```blade
@props([
    'label' => null,
    'error' => null,
    'type' => 'text',
    'required' => false,
])

<div class="space-y-1">
    @if($label)
        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <input
        type="{{ $type }}"
        {{ $attributes->merge([
            'class' => 'w-full px-4 py-2 border rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white border-slate-300 dark:border-slate-600 focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors'
        ]) }}
    >

    @if($error)
        <p class="text-sm text-red-600 dark:text-red-400">{{ $error }}</p>
    @endif
</div>
```

**Usage**:
```blade
<x-ui.input
    label="Event Title"
    wire:model="title"
    :error="$errors->first('title')"
    required
/>
```

### Modal Component (Volt + Alpine.js)

**File**: `components/ui/modal.blade.php`

```blade
@props([
    'name',
    'show' => false,
    'maxWidth' => '2xl'
])

@php
$maxWidthClass = match($maxWidth) {
    'sm' => 'max-w-sm',
    'md' => 'max-w-md',
    'lg' => 'max-w-lg',
    'xl' => 'max-w-xl',
    '2xl' => 'max-w-2xl',
    default => 'max-w-2xl'
};
@endphp

<div
    x-data="{
        show: @js($show),
        focusables() {
            let selector = 'a, button, input:not([type=\'hidden\']), textarea, select'
            return [...$el.querySelectorAll(selector)]
                .filter(el => ! el.hasAttribute('disabled'))
        },
        firstFocusable() { return this.focusables()[0] },
        lastFocusable() { return this.focusables().slice(-1)[0] },
        nextFocusable() { return this.focusables()[this.nextFocusableIndex()] || this.firstFocusable() },
        prevFocusable() { return this.focusables()[this.prevFocusableIndex()] || this.lastFocusable() },
        nextFocusableIndex() { return (this.focusables().indexOf(document.activeElement) + 1) % (this.focusables().length + 1) },
        prevFocusableIndex() { return Math.max(0, this.focusables().indexOf(document.activeElement)) - 1 },
    }"
    x-on:open-modal.window="$event.detail == '{{ $name }}' ? show = true : null"
    x-on:close-modal.window="$event.detail == '{{ $name }}' ? show = false : null"
    x-on:close.stop="show = false"
    x-on:keydown.escape.window="show = false"
    x-on:keydown.tab.prevent="$event.shiftKey || nextFocusable().focus()"
    x-on:keydown.shift.tab.prevent="prevFocusable().focus()"
    x-show="show"
    class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50"
    style="display: none;"
>
    <div
        x-show="show"
        class="fixed inset-0 transform transition-all"
        x-on:click="show = false"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        <div class="absolute inset-0 bg-slate-900/75 dark:bg-black/75"></div>
    </div>

    <div
        x-show="show"
        class="mb-6 bg-white dark:bg-slate-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:mx-auto {{ $maxWidthClass }}"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    >
        {{ $slot }}
    </div>
</div>
```

**Usage with Volt**:
```blade
@volt('event-registration-modal')
    @php
        use function Livewire\Volt\{state};

        state(['showModal' => false, 'eventId' => null]);

        $openModal = function($eventId) {
            $this->eventId = $eventId;
            $this->dispatch('open-modal', 'event-registration');
        };

        $register = function() {
            // Registration logic
            $this->dispatch('close-modal', 'event-registration');
        };
    @endphp

    <x-ui.modal name="event-registration" max-width="md">
        <div class="p-6">
            <h2 class="text-2xl font-bold mb-4">Register for Event</h2>
            <p class="mb-6">Confirm your registration for this event.</p>

            <div class="flex gap-4">
                <x-ui.button wire:click="register" variant="primary">
                    Confirm Registration
                </x-ui.button>
                <x-ui.button
                    variant="ghost"
                    x-on:click="$dispatch('close-modal', 'event-registration')"
                >
                    Cancel
                </x-ui.button>
            </div>
        </div>
    </x-ui.modal>
@endvolt
```

### Select Component

**File**: `components/ui/select.blade.php`

```blade
@props([
    'label' => null,
    'error' => null,
    'options' => [],
    'placeholder' => 'Select an option',
])

<div class="space-y-1">
    @if($label)
        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">
            {{ $label }}
        </label>
    @endif

    <select
        {{ $attributes->merge([
            'class' => 'w-full px-4 py-2 border rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white border-slate-300 dark:border-slate-600 focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors'
        ]) }}
    >
        @if($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif

        @foreach($options as $value => $label)
            <option value="{{ $value }}">{{ $label }}</option>
        @endforeach
    </select>

    @if($error)
        <p class="text-sm text-red-600 dark:text-red-400">{{ $error }}</p>
    @endif
</div>
```

### Checkbox Component

**File**: `components/ui/checkbox.blade.php`

```blade
@props([
    'label' => null,
    'description' => null,
])

<div class="flex items-start">
    <div class="flex items-center h-5">
        <input
            type="checkbox"
            {{ $attributes->merge([
                'class' => 'w-4 h-4 text-red-600 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-600 rounded focus:ring-red-500 focus:ring-2'
            ]) }}
        >
    </div>

    @if($label || $description)
        <div class="ml-3">
            @if($label)
                <label class="text-sm font-medium text-slate-900 dark:text-white">
                    {{ $label }}
                </label>
            @endif

            @if($description)
                <p class="text-sm text-slate-500 dark:text-slate-400">
                    {{ $description }}
                </p>
            @endif
        </div>
    @endif
</div>
```

## Layout Hierarchy Pattern (da Genesis)

### main.blade.php (Base)

**File**: `layouts/main.blade.php`

```blade
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Laravel Pizza Meetups') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Livewire Styles -->
    @livewireStyles
</head>
<body class="bg-slate-900 text-white antialiased">
    {{ $slot }}

    <!-- Livewire Scripts -->
    @livewireScripts
</body>
</html>
```

### app.blade.php (Authenticated)

**File**: `layouts/app.blade.php`

```blade
<x-layouts.main>
    <!-- App Header (Navigation) -->
    <x-app.header />

    <!-- Page Content -->
    <main class="min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{ $slot }}
        </div>
    </main>

    <!-- App Footer -->
    <x-app.footer />
</x-layouts.main>
```

### marketing.blade.php (Public)

**File**: `layouts/marketing.blade.php`

```blade
<x-layouts.main>
    <!-- Marketing Header -->
    <x-marketing.header />

    <!-- Breadcrumbs (optional) -->
    @if(isset($breadcrumbs))
        <x-marketing.breadcrumbs :breadcrumbs="$breadcrumbs" />
    @endif

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>

    <!-- Marketing Footer -->
    <x-marketing.footer />
</x-layouts.main>
```

## Advanced Patterns

### Pattern: Search with Debouncing

```blade
@volt('event-search')
    @php
        use App\Models\Event;
        use function Livewire\Volt\{state, computed};

        state([
            'search' => '',
            'category' => 'all',
            'sortBy' => 'date',
        ]);

        $events = computed(function() {
            return Event::query()
                ->when($this->search, fn($q) => $q->where('title', 'like', "%{$this->search}%"))
                ->when($this->category !== 'all', fn($q) => $q->where('category', $this->category))
                ->orderBy($this->sortBy === 'date' ? 'starts_at' : 'title')
                ->paginate(12);
        });
    @endphp

    <div class="space-y-6">
        <!-- Search Bar -->
        <div class="flex gap-4">
            <x-ui.input
                wire:model.live.debounce.300ms="search"
                placeholder="Search events..."
                class="flex-1"
            />

            <x-ui.select
                wire:model.live="category"
                :options="['all' => 'All Categories', 'meetup' => 'Meetups', 'workshop' => 'Workshops']"
            />

            <x-ui.select
                wire:model.live="sortBy"
                :options="['date' => 'By Date', 'title' => 'By Title']"
            />
        </div>

        <!-- Results -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($this->events as $event)
                <x-ui.event-card :event="$event" />
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $this->events->links() }}
        </div>
    </div>
@endvolt
```

### Pattern: Infinite Scroll

```blade
@volt('event-feed')
    @php
        use App\Models\Event;
        use function Livewire\Volt\{state};

        state([
            'events' => fn() => Event::latest()->paginate(10),
            'page' => 1,
        ]);

        $loadMore = function() {
            $this->page++;
            $newEvents = Event::latest()->paginate(10, ['*'], 'page', $this->page);
            $this->events = $this->events->merge($newEvents);
        };
    @endphp

    <div>
        <div class="space-y-4">
            @foreach($events as $event)
                <x-ui.event-card :event="$event" />
            @endforeach
        </div>

        <div
            x-data
            x-intersect="$wire.loadMore()"
            class="text-center py-4"
        >
            <div wire:loading wire:target="loadMore">
                <span class="text-slate-400">Loading more events...</span>
            </div>
        </div>
    </div>
@endvolt
```

### Pattern: Tabs Navigation

```blade
@volt('profile-tabs')
    @php
        use function Livewire\Volt\{state};

        state(['activeTab' => 'about']); // about, events, activity

        $switchTab = function($tab) {
            $this->activeTab = $tab;
        };
    @endphp

    <div>
        <!-- Tab Navigation -->
        <div class="border-b border-slate-700 mb-6">
            <nav class="flex gap-8">
                @foreach(['about' => 'About', 'events' => 'Events', 'activity' => 'Activity'] as $key => $label)
                    <button
                        wire:click="switchTab('{{ $key }}')"
                        @class([
                            'py-4 px-1 border-b-2 font-medium text-sm transition-colors',
                            'border-red-500 text-red-500' => $activeTab === $key,
                            'border-transparent text-slate-400 hover:text-slate-300 hover:border-slate-300' => $activeTab !== $key,
                        ])
                    >
                        {{ $label }}
                    </button>
                @endforeach
            </nav>
        </div>

        <!-- Tab Content -->
        <div>
            @if($activeTab === 'about')
                <div>About content...</div>
            @elseif($activeTab === 'events')
                <div>Events content...</div>
            @elseif($activeTab === 'activity')
                <div>Activity content...</div>
            @endif
        </div>
    </div>
@endvolt
```

### Pattern: Toast Notifications

**Component**: `components/ui/toast.blade.php`

```blade
@volt('toast-notifications')
    @php
        use function Livewire\Volt\{state, on};

        state(['toasts' => []]);

        on(['show-toast' => function($message, $type = 'success') {
            $this->toasts[] = [
                'id' => uniqid(),
                'message' => $message,
                'type' => $type,
            ];

            // Auto-remove after 5 seconds
            $this->dispatch('remove-toast', id: end($this->toasts)['id'])->delay(5000);
        }]);

        $remove = function($id) {
            $this->toasts = array_filter($this->toasts, fn($toast) => $toast['id'] !== $id);
        };
    @endphp

    <div class="fixed top-4 right-4 z-50 space-y-2">
        @foreach($toasts as $toast)
            <div
                @class([
                    'p-4 rounded-lg shadow-lg max-w-sm',
                    'bg-green-600 text-white' => $toast['type'] === 'success',
                    'bg-red-600 text-white' => $toast['type'] === 'error',
                    'bg-blue-600 text-white' => $toast['type'] === 'info',
                ])
                x-data
                x-init="setTimeout(() => $wire.remove('{{ $toast['id'] }}'), 5000)"
            >
                <div class="flex items-center justify-between">
                    <p>{{ $toast['message'] }}</p>
                    <button
                        wire:click="remove('{{ $toast['id'] }}')"
                        class="ml-4 text-white/80 hover:text-white"
                    >
                        ✕
                    </button>
                </div>
            </div>
        @endforeach
    </div>
@endvolt
```

**Usage**:
```blade
<x-ui.toast />

@volt('some-component')
    $save = function() {
        // Save logic...
        $this->dispatch('show-toast', message: 'Event saved successfully!', type: 'success');
    };
@endvolt
```

### Pattern: Light/Dark Theme Toggle

**Component**: `components/ui/theme-toggle.blade.php`

```blade
@volt('theme-toggle')
    @php
        use function Livewire\Volt\{state};

        state(['theme' => fn() => session('theme', 'dark')]);

        $toggle = function() {
            $this->theme = $this->theme === 'dark' ? 'light' : 'dark';
            session(['theme' => $this->theme]);
            $this->dispatch('theme-changed', theme: $this->theme);
        };
    @endphp

    <button
        wire:click="toggle"
        class="p-2 rounded-lg hover:bg-slate-800 dark:hover:bg-slate-700 transition-colors"
        x-data
        x-on:click="
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', $wire.theme);
        "
    >
        @if($theme === 'dark')
            <!-- Moon Icon -->
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/>
            </svg>
        @else
            <!-- Sun Icon -->
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"/>
            </svg>
        @endif
    </button>

    @script
    <script>
        // Initialize theme on page load
        if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    @endscript
@endvolt
```

## Testing UI Components

**Test**: `tests/Feature/Components/ButtonComponentTest.php`

```php
use function Pest\Laravel\{get};

it('renders button with default variant', function () {
    $view = $this->blade('<x-ui.button>Click me</x-ui.button>');

    $view->assertSee('Click me')
        ->assertSee('bg-red-600');
});

it('renders button with ghost variant', function () {
    $view = $this->blade('<x-ui.button variant="ghost">Click me</x-ui.button>');

    $view->assertSee('bg-transparent');
});
```

## References

- [Genesis Starter Kit](https://github.com/thedevdojo/genesis) - UI component patterns
- [Tailwind CSS Dark Mode](https://tailwindcss.com/docs/dark-mode)
- [Alpine.js Documentation](https://alpinejs.dev)
- [Folio + Volt Best Practices](../Modules/Meetup/docs/folio-volt-best-practices.md)

---

**Versione**: 2.0
**Ultimo Aggiornamento**: 2025-01-29
