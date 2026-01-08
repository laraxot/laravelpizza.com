# Laravel Folio + Volt + Filament - Architettura Frontend

## Principi Architetturali Fondamentali

### Stack Tecnologico
- **Laravel Folio**: File-based routing (NO controllers, NO web.php routes)
- **Laravel Volt**: Declarative components (NO Livewire class components)
- **Filament**: Admin panel e UI components
- **Tailwind CSS**: Styling system

### Regole Assolute

#### ❌ COSA NON FARE MAI
- ❌ **NON** creare controllers tradizionali
- ❌ **NON** scrivere rotte in `web.php` o `api.php`
- ❌ **NON** usare Livewire class components
- ❌ **NON** creare nuove cartelle docs - usare quelle esistenti
- ❌ **NON** usare nomi file .md con maiuscole (eccetto README.md e CHANGELOG.md)

#### ✅ COSA FARE SEMPRE
- ✅ Usare **Folio** per tutte le rotte frontend
- ✅ Usare **Volt** per tutti i componenti reattivi
- ✅ Usare **Filament** solo per admin panel
- ✅ Seguire principi **DRY + KISS + SOLID + Robust + Laraxot**
- ✅ Usare nomi file .md in lowercase (solo README.md e CHANGELOG.md possono avere maiuscole)

## Implementazione Pratica

### Struttura Folio

```
resources/views/pages/
├── index.blade.php              # Homepage (/)
├── events/
│   ├── index.blade.php          # Lista eventi (/events)
│   └── [event].blade.php        # Dettaglio evento (/events/{event})
├── dashboard/
│   └── index.blade.php          # Dashboard utente (/dashboard)
├── profile/
│   └── index.blade.php          # Profilo utente (/profile)
└── auth/
    ├── login.blade.php          # Login (/login)
    └── register.blade.php       # Registrazione (/register)
```

### Esempi Volt Components

#### Componente Event List (Volt)
```php
<?php

use function Livewire\Volt\state;
use function Livewire\Volt\computed;
use App\Models\Event;

state(['search' => '']);

$events = computed(function () {
    return Event::query()
        ->when($this->search, fn($query, $search) =>
            $query->where('title', 'like', "%{$search}%")
        )
        ->where('status', 'published')
        ->orderBy('start_date')
        ->get();
});

?>

<div>
    <input type="text" wire:model.live="search" placeholder="Cerca eventi...">

    @foreach($this->events as $event)
        <div class="event-card">
            <h3>{{ $event->title }}</h3>
            <p>{{ $event->description }}</p>
            <span>{{ $event->start_date->format('d/m/Y H:i') }}</span>
        </div>
    @endforeach
</div>
```

#### Componente Event RSVP (Volt)
```php
<?php

use function Livewire\Volt\state;
use function Livewire\Volt\action;
use App\Models\Event;
use App\Models\EventRegistration;

state(['eventId', 'isRegistered' => false]);

mount(function (Event $event) {
    $this->eventId = $event->id;
    $this->isRegistered = EventRegistration::where('event_id', $event->id)
        ->where('user_id', auth()->id())
        ->exists();
});

$register = action(function () {
    if ($this->isRegistered) {
        return;
    }

    EventRegistration::create([
        'event_id' => $this->eventId,
        'user_id' => auth()->id(),
    ]);

    $this->isRegistered = true;
});

?>

<div>
    @if($this->isRegistered)
        <button disabled class="btn btn-success">Già registrato</button>
    @else
        <button wire:click="register" class="btn btn-primary">
            Registrati all'evento
        </button>
    @endif
</div>
```

### Integrazione Filament (Solo Admin)

Filament viene usato **SOLO** per:
- Gestione admin panel
- CRUD eventi
- Gestione utenti
- Report e analytics

**NON** usare Filament per il frontend pubblico.

## Best Practices

### DRY (Don't Repeat Yourself)
- Creare componenti Blade riutilizzabili
- Usare layout comuni
- Centralizzare logica business in Actions

### KISS (Keep It Simple, Stupid)
- Componenti Volt semplici e focalizzati
- Folio pages minimali
- Evitare over-engineering

### SOLID Principles
- **Single Responsibility**: Ogni componente fa una cosa sola
- **Open/Closed**: Estendibile senza modificare codice esistente
- **Liskov Substitution**: Componenti intercambiabili
- **Interface Segregation**: API chiare e minimali
- **Dependency Injection**: Iniezione dipendenze via constructor

### Robust Architecture
- Error handling appropriato
- Validation input
- Transaction safety
- Fallback mechanisms

### Laraxot Patterns
- Modular architecture
- Service providers per feature discovery
- Configuration per environment
- Testing strategy integrata

## Esempi Real-World

### Siti che usano Folio + Volt

1. **Laravel Documentation** - Usa Folio per routing
2. **Laravel News** - Componenti reattivi con Livewire/Volt
3. **Siti community** - Per semplicità e velocità di sviluppo

### Pattern Comuni

#### Authentication Flow
```php
// resources/views/pages/auth/login.blade.php
<?php

use function Livewire\Volt\state;
use function Livewire\Volt\rules;
use function Livewire\Volt\action;

state(['email' => '', 'password' => '']);

rules([
    'email' => 'required|email',
    'password' => 'required',
]);

$login = action(function () {
    $this->validate();

    if (auth()->attempt($this->only(['email', 'password']))) {
        session()->regenerate();
        return redirect('/dashboard');
    }

    $this->addError('email', 'Credenziali non valide.');
});

?>

<form wire:submit="login">
    <input type="email" wire:model="email">
    @error('email') <span>{{ $message }}</span> @enderror

    <input type="password" wire:model="password">
    @error('password') <span>{{ $message }}</span> @enderror

    <button type="submit">Login</button>
</form>
```

#### Dashboard con Dati Utente
```php
// resources/views/pages/dashboard/index.blade.php
<?php

use function Livewire\Volt\computed;
use App\Models\Event;
use App\Models\EventRegistration;

$upcomingEvents = computed(function () {
    return Event::where('start_date', '>', now())
        ->where('status', 'published')
        ->orderBy('start_date')
        ->limit(5)
        ->get();
});

$registeredEvents = computed(function () {
    return EventRegistration::with('event')
        ->where('user_id', auth()->id())
        ->whereHas('event', function ($query) {
            $query->where('start_date', '>', now());
        })
        ->get()
        ->pluck('event');
});

?>

<x-layouts.app>
    <h1>Dashboard</h1>

    <div class="grid grid-cols-2 gap-6">
        <div>
            <h2>Prossimi Eventi</h2>
            @foreach($this->upcomingEvents as $event)
                <x-event-card :event="$event" />
            @endforeach
        </div>

        <div>
            <h2>I Tuoi Eventi</h2>
            @foreach($this->registeredEvents as $event)
                <x-event-card :event="$event" />
            @endforeach
        </div>
    </div>
</x-layouts.app>
```

## Testing Strategy

### Folio Pages Testing
```php
// tests/Feature/EventsPageTest.php
public function test_events_page_loads()
{
    $response = $this->get('/events');
    $response->assertOk();
}

public function test_event_detail_page_loads()
{
    $event = Event::factory()->create();

    $response = $this->get("/events/{$event->slug}");
    $response->assertOk();
}
```

### Volt Components Testing
```php
// tests/Feature/EventRegistrationTest.php
public function test_user_can_register_for_event()
{
    $user = User::factory()->create();
    $event = Event::factory()->create();

    $this->actingAs($user);

    Livewire::test('event-registration', ['event' => $event])
        ->call('register')
        ->assertSet('isRegistered', true);
}
```

## Deployment Considerations

### Asset Compilation
```bash
npm run build
php artisan optimize
php artisan view:cache
```

### Environment Configuration
```env
FOLIO_PATH=resources/views/pages
VOLT_PATH=resources/views/livewire
```

## Troubleshooting

### Problemi Comuni

1. **Route non trovata**
   - Verificare che il file esista in `resources/views/pages/`
   - Controllare naming convention

2. **Componente Volt non funziona**
   - Verificare che Livewire sia configurato correttamente
   - Controllare che il componente sia nella cartella giusta

3. **Filament non si integra**
   - Verificare che Filament sia configurato solo per admin
   - Controllare che non ci siano conflitti con Folio

## Risorse

- [Laravel Folio Documentation](https://laravel.com/docs/folio)
- [Laravel Volt Documentation](https://laravel.com/docs/livewire/volt)
- [Filament Documentation](https://filamentphp.com/docs)

---

**Regole da Ricordare Sempre:**
1. ❌ NO controllers, NO web.php routes
2. ✅ Folio + Volt per tutto il frontend
3. ✅ Filament SOLO per admin panel
4. ✅ DRY + KISS + SOLID + Robust + Laraxot
5. ✅ Nomi file .md in lowercase (eccetto README.md e CHANGELOG.md)
6. ✅ Usare cartelle docs esistenti, NON crearne di nuove