# Folio + Volt Best Practices - Laravel Pizza Meetups

## Panoramica

Questo documento descrive le best practices per utilizzare Laravel Folio e Livewire Volt insieme nel progetto Laravel Pizza Meetups, seguendo i principi DRY, KISS, SOLID e ROBUST.

## Architettura Folio + Volt

### Cos'è Laravel Folio?

Laravel Folio è un sistema di routing file-based che crea automaticamente rotte basate sulla struttura delle directory in `resources/views/pages/`.

**Vantaggi:**
- Zero configurazione routing
- Struttura chiara e intuitiva
- Type-safe route model binding
- Middleware per pagina o directory

### Cos'è Livewire Volt?

Livewire Volt è un modo dichiarativo per creare componenti Livewire direttamente nelle Blade views, senza creare classi PHP separate.

**Vantaggi:**
- Meno boilerplate code
- Logica e template insieme
- Type-safe properties e methods
- Reattività automatica

**⚠️ CRITICAL: Volt Route Parameter Injection**
Volt automaticamente inietta i parametri della route nelle proprietà pubbliche. MAI usare `request()->route()`:

```php
// ❌ SBAGLIATO - Ridondante!
public function mount(): void
{
    $this->container0 = request()->route('container0') ?? '';  // NO!
}

// ✅ CORRETTO - Volt inietta automaticamente!
new class extends Component {
    public string $container0 = '';  // Volt popola dalla route!
    public string $slug0 = '';        // Volt popola dalla route!
    public array $data = [];         // Per passare dati ai componenti
    public string $pageSlug = '';    // Proprietà calcolata

    public function mount(): void
    {
        // Solo logica di inizializzazione, non iniettare parametri!
        $this->pageSlug = $this->container0 . '.view';
        $this->data = [
            'container0' => $this->container0,
            'slug0' => $this->slug0,
        ];
    }
};
```

## Pattern Architetturale

### Pattern Standard Frontoffice

```
Request HTTP
    ↓
Folio (routing automatico da file)
    ↓
Blade Page (resources/views/pages/*.blade.php)
    ↓
Volt Component (@volt('component-name'))
    ↓
Action (Spatie QueableAction)
    ↓
Service/Model
    ↓
Response
```

## Esempi Pratici

### Esempio 1: Pagina Eventi con Lista

**File**: `Themes/Meetup/resources/views/pages/events.blade.php`

```blade
<x-layouts.app>
    @volt('events')
        @php
            use Modules\Meetup\Services\EventService;

            $eventService = app(EventService::class);
            $events = $eventService->getUpcomingEvents();
            $categories = ['all', 'meetups', 'workshops', 'conferences'];

            $selectedCategory = request()->query('category', 'all');
            $filteredEvents = $selectedCategory === 'all'
                ? $events
                : $events->filter(fn($e) => $e->category === $selectedCategory);
        @endphp

        <div class="container mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold mb-6">Upcoming Events</h1>

            {{-- Filtri --}}
            <div class="mb-6 flex gap-4">
                @foreach($categories as $category)
                    <a
                        href="?category={{ $category }}"
                        class="px-4 py-2 rounded {{ $selectedCategory === $category ? 'bg-red-600 text-white' : 'bg-gray-200' }}"
                    >
                        {{ ucfirst($category) }}
                    </a>
                @endforeach
            </div>

            {{-- Lista Eventi --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($filteredEvents as $event)
                    <x-event-card :event="$event" />
                @endforeach
            </div>
        </div>
    @endvolt
</x-layouts.app>
```

### Esempio 2: Pagina Dettaglio Evento con Registrazione

**File**: `Themes/Meetup/resources/views/pages/events/[event].blade.php`

```blade
<x-layouts.app>
    @volt('event-detail')
        @php
            use Modules\Meetup\Actions\Event\RegisterEventAction;
            use Modules\Meetup\Actions\Event\CancelEventRegistrationAction;
            use Modules\Meetup\Models\Event;

            // Folio fa automaticamente route model binding
            // $event è già disponibile come variabile
        @endphp

        <div class="container mx-auto px-4 py-8">
            <h1 class="text-4xl font-bold mb-4">{{ $event->title }}</h1>
            <p class="text-gray-600 mb-6">{{ $event->description }}</p>

            <div class="mb-6">
                <p><strong>Date:</strong> {{ $event->start_date->format('F j, Y') }}</p>
                <p><strong>Location:</strong> {{ $event->location }}</p>
                <p><strong>Attendees:</strong> {{ $event->attendees_count }} / {{ $event->max_attendees }}</p>
            </div>

            {{-- Componente Registrazione --}}
            @volt('event-registration')
                @php
                    $user = auth()->user();
                    $isRegistered = $user && $event->attendees()->where('user_id', $user->id)->exists();
                @endphp

                @if($user)
                    @if($isRegistered)
                        <button
                            wire:click="cancelRegistration"
                            class="bg-red-600 text-white px-6 py-2 rounded"
                        >
                            Cancel Registration
                        </button>
                    @else
                        <button
                            wire:click="register"
                            class="bg-green-600 text-white px-6 py-2 rounded"
                            {{ $event->attendees_count >= $event->max_attendees ? 'disabled' : '' }}
                        >
                            Register for Event
                        </button>
                    @endif
                @else
                    <a href="/login" class="bg-blue-600 text-white px-6 py-2 rounded">
                        Login to Register
                    </a>
                @endif

                @script
                <script>
                    $wire.on('registered', () => {
                        alert('Successfully registered!');
                    });

                    $wire.on('registration-cancelled', () => {
                        alert('Registration cancelled');
                    });
                </script>
                @endscript
            @endvolt

            function register()
            {
                $action = app(RegisterEventAction::class);
                $action->execute($this->event, auth()->user());

                $this->dispatch('registered');
            }

            function cancelRegistration()
            {
                $action = app(CancelEventRegistrationAction::class);
                $action->execute($this->event, auth()->user());

                $this->dispatch('registration-cancelled');
            }
        </div>
    @endvolt
</x-layouts.app>
```

### Esempio 3: Dashboard con Statistiche Reattive

**File**: `Themes/Meetup/resources/views/pages/dashboard.blade.php`

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
            <h1 class="text-3xl font-bold mb-6">Dashboard</h1>

            {{-- Statistiche Cards --}}
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

            {{-- Eventi Prossimi --}}
            @volt('upcoming-events')
                @php
                    $upcomingEvents = $user->registeredEvents()
                        ->where('start_date', '>', now())
                        ->orderBy('start_date')
                        ->limit(5)
                        ->get();
                @endphp

                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-2xl font-bold mb-4">Your Upcoming Events</h2>

                    @if($upcomingEvents->isEmpty())
                        <p class="text-gray-500">No upcoming events</p>
                    @else
                        <div class="space-y-4">
                            @foreach($upcomingEvents as $event)
                                <div class="border-b pb-4">
                                    <h3 class="font-semibold">{{ $event->title }}</h3>
                                    <p class="text-sm text-gray-600">
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

## Best Practices

### 1. Organizzazione File

**✅ CORRETTO:**
```
Themes/Meetup/resources/views/pages/
├── index.blade.php              → /
├── events.blade.php             → /events
├── events/
│   └── [event].blade.php        → /events/{event}
├── dashboard.blade.php          → /dashboard
└── auth/
    ├── login.blade.php          → /login
    └── register.blade.php       → /register
```

**❌ ERRATO:**
```
routes/web.php                   → NON creare rotte qui per frontoffice
app/Http/Controllers/            → NON creare controller per frontoffice
```

### 2. Componenti Volt

**✅ CORRETTO:**
- Usare `@volt()` direttamente nelle pagine Folio
- Mantenere logica semplice e leggibile
- Chiamare Actions per operazioni complesse
- Usare `@script` per JavaScript quando necessario

**❌ ERRATO:**
- Creare classi Livewire separate quando non necessario
- Mettere tutta la logica business nei componenti Volt
- Usare controller per gestire form submissions

### 3. Route Model Binding

Folio supporta automaticamente route model binding:

```blade
{{-- File: pages/events/[event].blade.php --}}
@volt('event-detail')
    {{-- $event è automaticamente disponibile --}}
    <h1>{{ $event->title }}</h1>
@endvolt
```

### 4. Middleware

Applicare middleware a livello di pagina o directory:

```php
// Nel Service Provider
Folio::path(resource_path('views/pages'))
    ->middleware([
        'dashboard' => ['auth'],
        'profile' => ['auth'],
        'chat' => ['auth'],
    ]);
```

### 5. Type Safety

Usare type hints nelle funzioni Volt:

```blade
@volt('example')
    function register(Event $event): void
    {
        // Type-safe!
    }
@endvolt
```

## Anti-Pattern da Evitare

### ❌ Anti-Pattern 1: Controller per Frontoffice

```php
// ❌ NON FARE
Route::get('/events', [EventController::class, 'index']);

// ✅ FARE
// Creare: resources/views/pages/events.blade.php
// Folio crea automaticamente la rotta
```

### ❌ Anti-Pattern 2: Logica Business nei Componenti Volt

```blade
{{-- ❌ NON FARE --}}
@volt('events')
    function getEvents()
    {
        // Troppa logica qui
        $events = Event::where('status', 'published')
            ->where('start_date', '>', now())
            ->with(['attendees', 'location'])
            ->orderBy('start_date')
            ->get();

        // Elaborazione complessa...
        foreach($events as $event) {
            // ...
        }
    }
@endvolt

{{-- ✅ FARE --}}
@volt('events')
    @php
        $eventService = app(EventService::class);
        $events = $eventService->getUpcomingEvents();
    @endphp
@endvolt
```

### ❌ Anti-Pattern 3: Rotte in web.php

```php
// ❌ NON FARE
Route::get('/events', function() {
    return view('pages.events');
});

// ✅ FARE
// Creare: resources/views/pages/events.blade.php
// Folio gestisce automaticamente
```

## Testing

### Test Folio Pages

```php
// tests/Feature/EventsPageTest.php
public function test_events_page_loads(): void
{
    $response = $this->get('/events');

    $response->assertStatus(200);
    $response->assertSee('Upcoming Events');
}
```

### Test Volt Components

```php
// tests/Feature/EventRegistrationTest.php
public function test_user_can_register_for_event(): void
{
    $user = User::factory()->create();
    $event = Event::factory()->create();

    Livewire::actingAs($user)
        ->test('events.event-registration', ['event' => $event])
        ->call('register')
        ->assertDispatched('registered');

    $this->assertTrue($event->attendees()->where('user_id', $user->id)->exists());
}
```

## Performance

### Lazy Loading

```blade
@volt('events')
    @php
        // Eager loading per evitare N+1
        $events = Event::with(['attendees', 'location'])
            ->get();
    @endphp
@endvolt
```

### Caching

```blade
@volt('events')
    @php
        $events = Cache::remember('upcoming-events', 3600, function() {
            return EventService::getUpcomingEvents();
        });
    @endphp
@endvolt
```

## Pattern osservati da progetti reali Folio + Volt

### 1. Genesis Starter Kit (thedevdojo)

**Repository**: [github.com/thedevdojo/genesis](https://github.com/thedevdojo/genesis)

**Pattern chiave osservati:**

#### Layout hierarchy
Genesis usa una gerarchia di 3 livelli per i layout:
```
resources/views/components/layouts/
├── main.blade.php         # Base HTML structure (<!DOCTYPE>, <head>, Vite, Livewire)
├── app.blade.php          # Authenticated pages (inherits main + app/header + app/footer)
└── marketing.blade.php    # Public pages (inherits main + marketing/header + marketing/breadcrumbs)
```

**Usage**:
```blade
<x-layouts.app>
    <!-- Authenticated user content -->
</x-layouts.app>

<x-layouts.marketing>
    <!-- Public marketing content -->
</x-layouts.marketing>
```

#### Middleware patterns
Genesis usa middleware a livello di pagina con `redirect-to-dashboard` custom middleware:
```blade
{{-- pages/index.blade.php --}}
@php
use function Laravel\Folio\middleware;

middleware(['redirect-to-dashboard']);
@endphp

{{-- Redirects authenticated users to dashboard automatically --}}
```

#### UI Component organization
```
resources/views/components/ui/
├── button.blade.php
├── checkbox.blade.php
├── input.blade.php
├── select.blade.php
├── link.blade.php
├── text-link.blade.php
├── nav-link.blade.php
├── modal.blade.php
├── placeholder.blade.php
└── light-dark-switch.blade.php
```

Pattern: componenti UI riutilizzabili piccoli e focalizzati.

#### Testing approach
Genesis usa **Pest** per testing con struttura che rispecchia le pagine:
```
tests/Feature/
├── Pages/
│   ├── IndexTest.php
│   ├── DashboardTest.php
│   └── ProfileTest.php
```

**Esempio test**:
```php
use function Pest\Laravel\get;

it('displays dashboard page for authenticated users', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Dashboard');
});
```

#### Command utili
- `php artisan folio:list` - Lista tutte le rotte Folio
- `composer run dev` - Laravel asset watcher (equivalente a `npm run dev`)
- `./vendor/bin/pest` - Run tests

### 2. Multi-step form (Neon + DEV Community)

**Tutorial**: [neon.com/guides/laravel-volt-folio-multi-step-form](https://neon.com/guides/laravel-volt-folio-multi-step-form)

**Pattern wizard multi-step**:

```blade
@volt('application-wizard')
    @php
        use function Livewire\Volt\{state, computed, rules};

        // Step state
        state([
            'currentStep' => 1,
            'totalSteps' => 3,

            // Step 1: Personal Info
            'name' => '',
            'email' => '',

            // Step 2: Preferences
            'interests' => [],
            'experience_level' => '',

            // Step 3: Confirmation
            'terms_accepted' => false,
        ]);

        // Computed property
        $canProceed = computed(function() {
            return match($this->currentStep) {
                1 => filled($this->name) && filled($this->email),
                2 => count($this->interests) > 0 && filled($this->experience_level),
                3 => $this->terms_accepted,
                default => false,
            };
        });

        // Navigation
        $nextStep = function() {
            $this->validateStep();
            $this->currentStep++;
        };

        $prevStep = function() {
            $this->currentStep--;
        };

        $validateStep = function() {
            $rules = match($this->currentStep) {
                1 => ['name' => 'required', 'email' => 'required|email'],
                2 => ['interests' => 'required|array', 'experience_level' => 'required'],
                3 => ['terms_accepted' => 'accepted'],
            };

            $this->validate($rules);
        };

        $submit = function() {
            $this->validate([
                'name' => 'required',
                'email' => 'required|email',
                'interests' => 'required|array',
                'experience_level' => 'required',
                'terms_accepted' => 'accepted',
            ]);

            // Save to database
            Application::create($this->all());

            return redirect()->route('success');
        };
    @endphp

    <div class="max-w-2xl mx-auto">
        {{-- Progress Bar --}}
        <div class="mb-8">
            <div class="flex justify-between mb-2">
                @for($i = 1; $i <= $totalSteps; $i++)
                    <span @class([
                        'font-bold text-red-600' => $currentStep === $i,
                        'text-gray-400' => $currentStep !== $i,
                    ])>
                        Step {{ $i }}
                    </span>
                @endfor
            </div>
            <div class="w-full bg-gray-200 h-2 rounded">
                <div
                    class="bg-red-600 h-2 rounded transition-all"
                    style="width: {{ ($currentStep / $totalSteps) * 100 }}%"
                ></div>
            </div>
        </div>

        {{-- Step Content --}}
        <div class="bg-white p-6 rounded-lg shadow">
            @if($currentStep === 1)
                <h2 class="text-2xl mb-4">Personal Information</h2>
                <input wire:model="name" type="text" placeholder="Full Name" class="w-full mb-4">
                @error('name') <span class="text-red-500">{{ $message }}</span> @enderror

                <input wire:model="email" type="email" placeholder="Email" class="w-full">
                @error('email') <span class="text-red-500">{{ $message }}</span> @enderror
            @endif

            @if($currentStep === 2)
                <h2 class="text-2xl mb-4">Your Preferences</h2>
                {{-- Interests checkboxes --}}
                {{-- Experience level select --}}
            @endif

            @if($currentStep === 3)
                <h2 class="text-2xl mb-4">Confirm & Submit</h2>
                {{-- Summary --}}
                <label>
                    <input wire:model="terms_accepted" type="checkbox">
                    I accept the terms and conditions
                </label>
            @endif
        </div>

        {{-- Navigation Buttons --}}
        <div class="flex justify-between mt-6">
            @if($currentStep > 1)
                <button wire:click="prevStep" class="px-6 py-2 bg-gray-300 rounded">
                    Previous
                </button>
            @endif

            @if($currentStep < $totalSteps)
                <button
                    wire:click="nextStep"
                    class="px-6 py-2 bg-red-600 text-white rounded ml-auto"
                    @disabled(!$this->canProceed)
                >
                    Next
                </button>
            @else
                <button
                    wire:click="submit"
                    class="px-6 py-2 bg-green-600 text-white rounded ml-auto"
                    @disabled(!$this->canProceed)
                >
                    Submit Application
                </button>
            @endif
        </div>
    </div>
@endvolt
```

**Lezione chiave**: Volt è perfetto per wizard forms con state management complesso, validazione per step, e UI reattiva.

### 3. Podcast Player (Jason Beggs)

**Tutorial**: [jasonlbeggs.com/blog/livewire-volt-and-folio](https://jasonlbeggs.com/blog/livewire-volt-and-folio)
**Laravel News**: [laravel-news.com/livewire-volt-and-folio](https://laravel-news.com/livewire-volt-and-folio)

**Pattern media player interattivo**:

```blade
@volt('podcast-player')
    @php
        use function Livewire\Volt\{state, on};

        state([
            'currentEpisode' => null,
            'isPlaying' => false,
            'currentTime' => 0,
            'duration' => 0,
        ]);

        $play = function($episodeId) {
            $this->currentEpisode = Episode::find($episodeId);
            $this->isPlaying = true;
            $this->dispatch('play-audio', url: $this->currentEpisode->audio_url);
        };

        $pause = function() {
            $this->isPlaying = false;
            $this->dispatch('pause-audio');
        };

        on(['time-update' => function($time) {
            $this->currentTime = $time;
        }]);
    @endphp

    <div class="fixed bottom-0 left-0 right-0 bg-slate-800 p-4">
        @if($currentEpisode)
            <div class="flex items-center gap-4">
                <img src="{{ $currentEpisode->artwork }}" class="w-16 h-16 rounded">

                <div class="flex-1">
                    <h3 class="font-bold text-white">{{ $currentEpisode->title }}</h3>
                    <p class="text-gray-400">{{ $currentEpisode->podcast->name }}</p>
                </div>

                <button wire:click="{{ $isPlaying ? 'pause' : 'play' }}">
                    @if($isPlaying)
                        <x-icon.pause />
                    @else
                        <x-icon.play />
                    @endif
                </button>

                <div class="w-64">
                    <input
                        type="range"
                        min="0"
                        max="{{ $duration }}"
                        value="{{ $currentTime }}"
                        class="w-full"
                    >
                </div>
            </div>
        @endif
    </div>

    @script
    <script>
        const audio = new Audio();

        $wire.on('play-audio', (event) => {
            audio.src = event.url;
            audio.play();
        });

        $wire.on('pause-audio', () => {
            audio.pause();
        });

        audio.addEventListener('timeupdate', () => {
            $wire.dispatch('time-update', { time: audio.currentTime });
        });
    </script>
    @endscript
@endvolt
```

**Lezione chiave**: Volt + `@script` per integrazioni JavaScript complesse (Web Audio API, media controls, etc.).

### 4. Todo Application (Nuno Maduro)

**Tutorial**: [nunomaduro.com/todo_application_with_laravel_folio_and_volt](https://nunomaduro.com/todo_application_with_laravel_folio_and_volt)

**Pattern CRUD semplice e pulito**:

```blade
{{-- pages/todos/index.blade.php --}}
@volt('todos.index')
    @php
        use App\Models\Todo;
        use function Livewire\Volt\{state, computed};

        state(['newTodo' => '']);

        $todos = computed(fn() => Todo::orderBy('created_at', 'desc')->get());

        $add = function() {
            Todo::create(['title' => $this->newTodo, 'user_id' => auth()->id()]);
            $this->newTodo = '';
        };

        $toggle = function(Todo $todo) {
            $todo->update(['completed' => !$todo->completed]);
        };

        $delete = function(Todo $todo) {
            $todo->delete();
        };
    @endphp

    <div class="max-w-2xl mx-auto p-8">
        <h1 class="text-3xl font-bold mb-6">My Todos</h1>

        {{-- Add Form --}}
        <form wire:submit="add" class="flex gap-2 mb-6">
            <input
                wire:model="newTodo"
                type="text"
                placeholder="Add a new todo..."
                class="flex-1 px-4 py-2 border rounded"
            >
            <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded">
                Add
            </button>
        </form>

        {{-- Todo List --}}
        <div class="space-y-2">
            @foreach($this->todos as $todo)
                <div class="flex items-center gap-4 p-4 bg-white rounded shadow">
                    <input
                        type="checkbox"
                        wire:click="toggle({{ $todo->id }})"
                        {{ $todo->completed ? 'checked' : '' }}
                    >

                    <span @class([
                        'flex-1',
                        'line-through text-gray-400' => $todo->completed,
                    ])>
                        {{ $todo->title }}
                    </span>

                    <button
                        wire:click="delete({{ $todo->id }})"
                        class="text-red-600 hover:text-red-800"
                    >
                        Delete
                    </button>
                </div>
            @endforeach
        </div>
    </div>
@endvolt
```

**Lezione chiave**: Volt eccelle in CRUD semplici dove tutta la logica può stare in un file single-file component.

### 5. Pattern generali dalla documentazione ufficiale

**Source**: [livewire.laravel.com/docs/3.x/volt](https://livewire.laravel.com/docs/3.x/volt)

#### Functional API Functions

**State management**:
```php
use function Livewire\Volt\{state};

// Basic state
state(['count' => 0]);

// Locked state (cannot be updated from frontend)
state(['userId' => auth()->id()])->locked();

// Multiple properties
state([
    'name' => '',
    'email' => '',
    'role' => 'user',
]);
```

**Computed properties**:
```php
use function Livewire\Volt\{computed};

// Basic computed
$fullName = computed(fn() => "{$this->firstName} {$this->lastName}");

// Cached computed (persisted in cache)
$stats = computed(function() {
    return DB::table('events')->count();
})->persist(seconds: 3600);
```

**Methods**:
```php
// Public method (callable from frontend)
$save = function() {
    $this->validate();
    Event::create($this->all());
};

// Protected method (NOT callable from frontend)
use function Livewire\Volt\{protect};

$sendEmail = protect(function() {
    Mail::to($this->email)->send(new Welcome());
});
```

**Lifecycle hooks**:
```php
use function Livewire\Volt\{mount, updated, hydrate};

mount(function() {
    // Runs when component is first mounted
});

updated(function($property) {
    // Runs after any property update
});

hydrate(function() {
    // Runs when component is hydrated (subsequent requests)
});
```

### 6. Artisan commands

I progetti studiati usano sistematicamente command Artisan invece di creare file manualmente:

```bash
# Create Folio page
php artisan folio:page events/index

# Create Folio page with route model binding
php artisan folio:page events/{event}

# Create standalone Volt component
php artisan make:volt event-card

# List all Folio routes
php artisan folio:list

# Cache routes for production
php artisan route:cache
```

### 7. Best practices consolidate

✅ **Layout hierarchy** (da Genesis):
- `main.blade.php` → `app.blade.php` / `marketing.blade.php` → page

✅ **Middleware per pagina** (da Genesis):
- Usare `middleware(['auth'])` nelle pagine Folio

✅ **State locked** (da docs ufficiali):
- Dati sensibili: `state(['userId'])->locked()`

✅ **Computed con cache** (da docs ufficiali):
- Query pesanti: `->persist(seconds: 3600)`

✅ **Testing con Pest** (da Genesis):
- Struttura tests che rispecchia pages/

✅ **UI components riutilizzabili** (da Genesis):
- Piccoli componenti focalizzati in `components/ui/`

✅ **@script per JavaScript** (da Podcast Player):
- Integrazioni JS complesse con `@script` + `$wire`

✅ **Validation per step** (da Multi-step Form):
- `match()` expression per validazione condizionale

✅ **Debouncing** (da best practices):
- `wire:model.live.debounce.300ms` per search inputs

## Riferimenti

- [Laravel Folio Documentation](https://laravel.com/docs/folio)
- [Livewire Volt Documentation](https://livewire.laravel.com/docs/volt)
- [Filament Documentation](https://filamentphp.com/docs)

---

**Versione**: 1.0
