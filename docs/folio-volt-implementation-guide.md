# Guida Implementazione Folio + Volt - Laravel Pizza Meetups

## Panoramica

Questa guida pratica fornisce istruzioni step-by-step per implementare pagine e componenti utilizzando Laravel Folio e Livewire Volt nel progetto Laravel Pizza Meetups.

**Versione**: 1.0

---

## 🚀 Quick Start

### Prerequisiti

- Laravel 11+
- Laravel Folio installato
- Livewire 3+ con Volt
- Modulo Meetup configurato

### Setup Iniziale

```bash
# Verifica installazione
composer show laravel/folio
composer show livewire/livewire

# Crea prima pagina Folio
php artisan folio:page events

# Crea componente Volt
php artisan make:volt EventList
```

---

## 📁 Struttura File

### Organizzazione Standard

```
Themes/Meetup/resources/views/
├── layouts/
│   ├── app.blade.php          # Layout principale
│   └── auth.blade.php          # Layout autenticazione
├── components/
│   ├── navigation.blade.php   # Navigation riutilizzabile
│   ├── footer.blade.php       # Footer riutilizzabile
│   ├── event-card.blade.php   # Card evento
│   └── statistics-card.blade.php
└── pages/                      # Pagine Folio (routing automatico)
    ├── index.blade.php         → /
    ├── events.blade.php        → /events
    ├── events/
    │   └── [event].blade.php   → /events/{event}
    ├── dashboard.blade.php     → /dashboard
    ├── profile.blade.php       → /profile
    ├── chat.blade.php          → /chat
    └── auth/
        ├── login.blade.php     → /login
        └── register.blade.php  → /register
```

---

## 🎯 Pattern di Implementazione

### Pattern 1: Pagina Lista Semplice

**File**: `pages/events.blade.php`

```blade
<x-layouts.app>
    @volt('events')
        @php
            use Modules\Meetup\Services\EventService;

            $eventService = app(EventService::class);
            $events = $eventService->getUpcomingEvents();
        @endphp

        <div class="container mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold mb-6">Upcoming Events</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($events as $event)
                    <x-event-card :event="$event" />
                @endforeach
            </div>
        </div>
    @endvolt
</x-layouts.app>
```

**Caratteristiche**:
- ✅ Nessun controller necessario
- ✅ Routing automatico da Folio
- ✅ Logica semplice nel componente Volt
- ✅ Chiamata a Service per dati complessi

### Pattern 2: Pagina Dettaglio con Route Model Binding

**File**: `pages/events/[event].blade.php`

```blade
<x-layouts.app>
    @volt('event-detail')
        {{-- $event è automaticamente disponibile grazie a Folio --}}
        {{-- Folio fa route model binding automatico --}}

        <div class="container mx-auto px-4 py-8">
            <h1 class="text-4xl font-bold mb-4">{{ $event->title }}</h1>
            <p class="text-gray-400 mb-6">{{ $event->description }}</p>

            <div class="mb-6 space-y-2">
                <p><strong>Date:</strong> {{ $event->start_date->format('F j, Y') }}</p>
                <p><strong>Location:</strong> {{ $event->location }}</p>
                <p><strong>Attendees:</strong> {{ $event->attendees_count }} / {{ $event->max_attendees }}</p>
            </div>

            {{-- Componente Registrazione --}}
            @volt('event-registration')
                @php
                    $user = auth()->user();
                    $isRegistered = $user && $event->attendees()
                        ->where('user_id', $user->id)
                        ->exists();
                @endphp

                @if($user)
                    @if($isRegistered)
                        <button
                            wire:click="cancelRegistration"
                            class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700"
                        >
                            Cancel Registration
                        </button>
                    @else
                        <button
                            wire:click="register"
                            class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700"
                            {{ $event->attendees_count >= $event->max_attendees ? 'disabled' : '' }}
                        >
                            Register for Event
                        </button>
                    @endif
                @else
                    <a href="/login" class="bg-blue-600 text-white px-6 py-2 rounded inline-block">
                        Login to Register
                    </a>
                @endif
            @endvolt

            function register(): void
            {
                $action = app(\Modules\Meetup\Actions\Event\RegisterEventAction::class);
                $action->execute($this->event, auth()->user());

                $this->dispatch('registered');
            }

            function cancelRegistration(): void
            {
                $action = app(\Modules\Meetup\Actions\Event\CancelEventRegistrationAction::class);
                $action->execute($this->event, auth()->user());

                $this->dispatch('registration-cancelled');
            }
        </div>
    @endvolt
</x-layouts.app>
```

**Caratteristiche**:
- ✅ Route model binding automatico
- ✅ Componente Volt annidato per azioni
- ✅ Chiamata Actions per business logic
- ✅ Event dispatching per feedback

### Pattern 3: Dashboard con Statistiche

**File**: `pages/dashboard.blade.php`

```blade
<x-layouts.app>
    @volt('dashboard')
        @php
            use Modules\Meetup\Services\UserStatsService;

            $statsService = app(UserStatsService::class);
            $user = auth()->user();
            $stats = $statsService->getUserStats($user);
        @endphp

        <div class="container mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold mb-6">Welcome back, {{ $user->name }}!</h1>

            {{-- Statistics Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <x-statistics-card
                    label="Events Attended"
                    :value="$stats['events_attended']"
                    icon="calendar"
                />
                <x-statistics-card
                    label="Messages Sent"
                    :value="$stats['messages_sent']"
                    icon="chat"
                />
                <x-statistics-card
                    label="Pizza Slices"
                    :value="$stats['pizza_slices']"
                    icon="pizza"
                />
            </div>

            {{-- Upcoming Events Widget --}}
            @volt('upcoming-events')
                @php
                    $upcomingEvents = $user->registeredEvents()
                        ->where('start_date', '>', now())
                        ->orderBy('start_date')
                        ->limit(5)
                        ->get();
                @endphp

                <div class="bg-slate-800 border border-slate-700 rounded-xl p-6">
                    <h2 class="text-2xl font-bold mb-4">Your Upcoming Events</h2>

                    @if($upcomingEvents->isEmpty())
                        <p class="text-gray-400">No upcoming events</p>
                    @else
                        <div class="space-y-4">
                            @foreach($upcomingEvents as $event)
                                <div class="border-b border-slate-700 pb-4 last:border-0">
                                    <h3 class="font-semibold text-white">{{ $event->title }}</h3>
                                    <p class="text-sm text-gray-400">
                                        {{ $event->start_date->format('F j, Y g:i A') }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endvolt
        </div>
    @endvolt
</x-layouts.app>
```

### Pattern 4: Form con Validazione

**File**: `pages/auth/register.blade.php`

```blade
<x-layouts.auth>
    @volt('register')
        <div class="max-w-md mx-auto bg-slate-800 border border-slate-700 rounded-xl p-8">
            <h2 class="text-2xl font-bold mb-6 text-white">Join the Community</h2>

            <form wire:submit="register">
                {{-- Name --}}
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-300 mb-2">
                        Name
                    </label>
                    <input
                        type="text"
                        id="name"
                        wire:model="name"
                        class="w-full bg-slate-700 border border-slate-600 rounded-lg px-4 py-2 text-white"
                        required
                    />
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                        Email
                    </label>
                    <input
                        type="email"
                        id="email"
                        wire:model="email"
                        class="w-full bg-slate-700 border border-slate-600 rounded-lg px-4 py-2 text-white"
                        required
                    />
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-2">
                        Password
                    </label>
                    <input
                        type="password"
                        id="password"
                        wire:model="password"
                        class="w-full bg-slate-700 border border-slate-600 rounded-lg px-4 py-2 text-white"
                        required
                    />
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="w-full bg-red-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-red-700 transition-colors"
                    wire:loading.attr="disabled"
                >
                    <span wire:loading.remove>Create Account</span>
                    <span wire:loading>Creating...</span>
                </button>
            </form>

            <p class="mt-4 text-center text-gray-400 text-sm">
                Already have an account?
                <a href="/login" class="text-red-500 hover:text-red-400">Sign in</a>
            </p>
        </div>
    @endvolt

    public string $name = '';
    public string $email = '';
    public string $password = '';

    function register(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $action = app(\Modules\Meetup\Actions\Auth\RegisterUserAction::class);
        $user = $action->execute([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ]);

        auth()->login($user);

        return redirect('/dashboard');
    }
</x-layouts.auth>
```

---

## 🔧 Comandi Artisan Utili

### Creare Pagine Folio

```bash
# Crea pagina semplice
php artisan folio:page events

# Crea pagina con route model binding
php artisan folio:page events/[event]

# Crea pagina in sottodirectory
php artisan folio:page auth/login
```

### Creare Componenti Volt

```bash
# Crea componente Volt standalone
php artisan make:volt EventCard

# Crea componente Volt in directory specifica
php artisan make:volt Components/EventCard
```

### Testing

```bash
# Test pagina Folio
php artisan test --filter EventsPageTest

# Test componente Volt
php artisan test --filter EventRegistrationTest
```

---

## 📋 Checklist Implementazione

### Per Ogni Nuova Pagina

- [ ] Creare file in `resources/views/pages/`
- [ ] Usare layout appropriato (`app` o `auth`)
- [ ] Implementare componente Volt se necessario
- [ ] Chiamare Actions per business logic
- [ ] Aggiungere validazione se form
- [ ] Testare routing automatico
- [ ] Verificare mobile responsiveness
- [ ] Aggiungere error handling
- [ ] Documentare in docs

### Per Ogni Nuovo Componente Volt

- [ ] Definire properties con type hints
- [ ] Implementare metodi con return types
- [ ] Aggiungere validazione se necessario
- [ ] Gestire loading states
- [ ] Gestire error states
- [ ] Testare componente isolatamente
- [ ] Documentare props e usage

---

## 🎨 Best Practices

### 1. Type Safety

**✅ CORRETTO:**
```blade
@volt('example')
    public Event $event;
    public ?User $user = null;

    function register(): void
    {
        // ...
    }
@endvolt
```

**❌ ERRATO:**
```blade
@volt('example')
    public $event;  // No type hint
    function register()  // No return type
    {
        // ...
    }
@endvolt
```

### 2. Business Logic

**✅ CORRETTO:**
```blade
function register(): void
{
    $action = app(RegisterEventAction::class);
    $action->execute($this->event, auth()->user());
}
```

**❌ ERRATO:**
```blade
function register(): void
{
    // Troppa logica qui
    $event->attendees()->create([
        'user_id' => auth()->id(),
        'status' => 'registered',
    ]);
    $event->increment('attendees_count');
    // ...
}
```

### 3. Error Handling

**✅ CORRETTO:**
```blade
function register(): void
{
    try {
        $action = app(RegisterEventAction::class);
        $action->execute($this->event, auth()->user());
        $this->dispatch('success', 'Registered successfully!');
    } catch (\Exception $e) {
        $this->dispatch('error', $e->getMessage());
    }
}
```

---

## 🐛 Troubleshooting

### Problema: Rotte non funzionano

**Causa**: File non in directory corretta o nome file errato

**Soluzione**:
```bash
# Verifica struttura
ls -la resources/views/pages/

# Verifica Folio config
php artisan route:list | grep folio
```

### Problema: Componente Volt non reattivo

**Causa**: Manca `wire:` directive o properties non definite

**Soluzione**:
```blade
{{-- Assicurati di avere --}}
@volt('component-name')
    public string $property = '';

    <div wire:click="method">
        {{ $property }}
    </div>
@endvolt
```

### Problema: Route Model Binding non funziona

**Causa**: Nome file non segue convenzione Folio

**Soluzione**:
```bash
# ✅ CORRETTO
pages/events/[event].blade.php

# ❌ ERRATO
pages/events/{event}.blade.php
pages/events/event.blade.php
```

---

## 📚 Riferimenti

- [Folio + Volt Best Practices](./folio-volt-best-practices.md)
- [Folio + Volt Projects Review](./folio-volt-projects-review.md)
- [Architecture](./architecture.md)
- [Laravel Folio Docs](https://laravel.com/docs/folio)
- [Livewire Volt Docs](https://livewire.laravel.com/docs/volt)

---

**Versione**: 1.0
