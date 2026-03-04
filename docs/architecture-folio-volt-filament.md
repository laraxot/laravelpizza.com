# Laravel Pizza - Architecture: Folio + Volt + Filament

**Versione**: 1.0
**Principi**: DRY + KISS + SOLID + ROBUST + LARAXOT

---

## 🏗️ Architettura Frontend

### Regola Fondamentale

**NEL FRONTOFFICE NON USIAMO:**
- ❌ Controller
- ❌ Route definitions in `routes/web.php`
- ❌ Route definitions in `routes/api.php`
- ❌ Traditional MVC pattern

**NEL FRONTOFFICE USIAMO:**
- ✅ **Laravel Folio** (Page-based routing)
- ✅ **Volt** (Solo per logica semplice in pagine Folio)
- ✅ **Filament Widgets** (Per componenti dinamici con interazione server)

### ⚠️ CRITICAL: Filament Widgets, NOT Livewire Pure!
Per OGNI componente dinamico che necessita interazione server (form, dropdown, modali, ecc.):
- ✅ **SEMPRE usare Filament Widgets** in `Modules/ModuleName/app/Filament/Widgets/`
- ❌ **MAI usare componenti Livewire puri**

**Esempi:**
- ✅ `Modules/Meetup/app/Filament/Widgets/EventCalendarWidget.php`
- ✅ `Modules/User/app/Filament/Widgets/LoginWidget.php`
- ❌ `Modules/Meetup/app/Http/Livewire/EventForm.php`

**Volt** si usa SOLO nelle pagine Folio per logica UI semplice. Per componenti complessi usare Filament Widgets.

---

## 📁 Struttura File

### Directory Pages (Folio)

In the modular Laravel Pizza architecture, Folio pages can be organized in both theme and module directories. The actual routing is handled by `Modules\Cms\Providers\FolioVoltServiceProvider`.

#### Theme-Specific Pages (Recommended for Meetup Theme)
```
Themes/Meetup/resources/views/pages/
├── index.blade.php                 # Homepage → / (localized: /en/, /it/, etc.)
├── about.blade.php                 # Chi Siamo → /about (localized: /en/about, /it/about, etc.)
├── contact.blade.php               # Contatti → /contact (localized: /en/contact, etc.)
├── events/index.blade.php          # Eventi list → /events (localized: /en/events, etc.)
└── events/[event].blade.php        # Evento detail → /events/{event} (localized: /en/events/{event}, etc.)
```

#### Module-Specific Pages (For Meetup Module Backend)
```
Modules/Meetup/Resources/views/pages/
├── admin/index.blade.php           # Admin dashboard → /admin (if needed)
└── api/[endpoint].blade.php        # API endpoints → /api/{endpoint} (if needed as Folio pages)
```

### Routing Registration

The routing for both theme and module pages is automatically registered by the `FolioVoltServiceProvider`:

```php
// In Modules/Cms/Providers/FolioVoltServiceProvider.php
public function boot(): void
{
    // Theme pages
    $theme_path = XotData::make()->getPubThemeViewPath('pages');
    if (File::exists($theme_path) && File::isDirectory($theme_path)) {
        Folio::path($theme_path)
            ->uri($locale)  // Adds locale prefix
            ->middleware(['*' => $base_middleware]);
    }

    // Module pages
    foreach (Module::all() as $module) {
        $path = $module->getPath().'/resources/views/pages';
        if (File::exists($path) && File::isDirectory($path)) {
            Folio::path($path)
                ->uri($locale)  // Adds locale prefix
                ->middleware(['*' => $base_middleware]);
        }
    }
}
```

### File Structure for Laravel Pizza Meetups

For the Meetup theme specifically, organize your pages as:

```
Themes/Meetup/resources/views/pages/
├── index.blade.php                 # Homepage → /
├── about.blade.php                 # About → /about
├── events/index.blade.php          # Events list → /events
├── events/[event].blade.php        # Event detail → /events/{event}
├── events/[event]/register.blade.php # Event registration → /events/{event}/register
├── login.blade.php                 # Login → /login
├── register.blade.php              # Register → /register
├── dashboard/index.blade.php       # Dashboard → /dashboard
├── dashboard/profile.blade.php     # Profile → /dashboard/profile
├── dashboard/events.blade.php      # User's events → /dashboard/events
└── chat.blade.php                  # Community chat → /chat
```

### Routing Automatico (Folio)

**NO route definition needed!** Folio creates routes automatically from file structure:

- `resources/views/pages/index.blade.php` → `/`
- `resources/views/pages/menu.blade.php` → `/menu`
- `resources/views/pages/events/index.blade.php` → `/events`
- `resources/views/pages/events/[slug].blade.php` → `/events/{slug}`

---

## 🎯 Esempi Pratici

### Example 1: Simple Page (Contact)

**File**: `resources/views/pages/contact.blade.php`

```blade
<?php

use function Livewire\Volt\{state, rules};

state(['name' => '', 'email' => '', 'message' => '']);

rules([
    'name' => 'required|min:3',
    'email' => 'required|email',
    'message' => 'required|min:10',
]);

$submit = function () {
    $this->validate();

    // Send email
    Mail::to('info@laravelpizza.com')->send(new ContactFormMail($this->all()));

    session()->flash('message', 'Messaggio inviato con successo!');
    $this->reset();
};

?>

<x-layouts.app>
    <div class="container mx-auto px-4 py-20">
        <h1 class="text-4xl font-bold mb-8">Contattaci</h1>

        @volt('contact-form')
            <form wire:submit="submit" class="max-w-2xl">
                <!-- Name -->
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2">Nome</label>
                    <input type="text" wire:model="name" class="w-full px-4 py-2 border rounded-lg">
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Email -->
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2">Email</label>
                    <input type="email" wire:model="email" class="w-full px-4 py-2 border rounded-lg">
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Message -->
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2">Messaggio</label>
                    <textarea wire:model="message" rows="5" class="w-full px-4 py-2 border rounded-lg"></textarea>
                    @error('message') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="bg-primary-600 text-white px-8 py-3 rounded-lg">
                    Invia Messaggio
                </button>

                @if (session()->has('message'))
                    <div class="mt-4 p-4 bg-green-100 text-green-800 rounded-lg">
                        {{ session('message') }}
                    </div>
                @endif
            </form>
        @endvolt
    </div>
</x-layouts.app>
```

**URL**: Automatically available at `/contact`

---

### Example 2: Dynamic Route (Pizza Detail)

**File**: `resources/views/pages/menu/[slug].blade.php`

```blade
<?php

use App\Models\Pizza;
use function Livewire\Volt\{computed, state};

state(['slug']);

$pizza = computed(function () {
    return Pizza::where('slug', $this->slug)
        ->with('category', 'ingredients')
        ->firstOrFail();
});

$addToCart = function () {
    $cartItem = [
        'id' => $this->pizza->id,
        'name' => $this->pizza->name,
        'price' => $this->pizza->price,
        'quantity' => 1,
    ];

    session()->push('cart', $cartItem);

    $this->dispatch('cart-updated');

    session()->flash('message', 'Pizza aggiunta al carrello!');
};

?>

<x-layouts.app>
    @volt('pizza-detail')
        <div class="container mx-auto px-4 py-20">
            <div class="grid md:grid-cols-2 gap-12">
                <!-- Image -->
                <div>
                    <img src="{{ $this->pizza->image_url }}"
                         alt="{{ $this->pizza->name }}"
                         class="w-full rounded-xl shadow-lg">
                </div>

                <!-- Details -->
                <div>
                    <h1 class="text-4xl font-bold mb-4">{{ $this->pizza->name }}</h1>

                    <p class="text-gray-600 mb-6">{{ $this->pizza->description }}</p>

                    <div class="mb-6">
                        <h3 class="font-semibold mb-2">Ingredienti:</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($this->pizza->ingredients as $ingredient)
                                <span class="bg-gray-100 px-3 py-1 rounded-full text-sm">
                                    {{ $ingredient }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex items-center justify-between mb-8">
                        <span class="text-3xl font-bold text-primary-600">
                            €{{ number_format($this->pizza->price, 2) }}
                        </span>

                        @if($this->pizza->is_vegetarian)
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                                Vegetariana
                            </span>
                        @endif
                    </div>

                    <button wire:click="addToCart"
                            class="w-full bg-primary-600 text-white px-8 py-4 rounded-lg font-semibold hover:bg-primary-700">
                        Aggiungi al Carrello
                    </button>

                    @if (session()->has('message'))
                        <div class="mt-4 p-4 bg-green-100 text-green-800 rounded-lg">
                            {{ session('message') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endvolt
</x-layouts.app>
```

**URL**: Automatically available at `/menu/{slug}` (e.g., `/menu/margherita`)

---

### Example 3: Protected Page (Dashboard)

**File**: `resources/views/pages/dashboard/index.blade.php`

```blade
<?php

use function Livewire\Volt\{computed, middleware};

// Protect this page - only authenticated users
middleware(['auth']);

$stats = computed(function () {
    return [
        'events_attended' => auth()->user()->events()->count(),
        'orders_count' => auth()->user()->orders()->count(),
        'total_spent' => auth()->user()->orders()->sum('total'),
        'member_since' => auth()->user()->created_at->diffForHumans(),
    ];
});

?>

<x-layouts.app>
    @volt('user-dashboard')
        <div class="container mx-auto px-4 py-20">
            <div class="mb-8">
                <h1 class="text-4xl font-bold">Dashboard</h1>
                <p class="text-gray-600">Benvenuto, {{ auth()->user()->name }}!</p>
            </div>

            <!-- Stats Grid -->
            <div class="grid md:grid-cols-4 gap-6 mb-12">
                <!-- Events Attended -->
                <div class="bg-white rounded-xl p-6 shadow-lg">
                    <div class="text-3xl font-bold text-primary-600 mb-2">
                        {{ $this->stats['events_attended'] }}
                    </div>
                    <div class="text-gray-600">Eventi Partecipati</div>
                </div>

                <!-- Orders -->
                <div class="bg-white rounded-xl p-6 shadow-lg">
                    <div class="text-3xl font-bold text-primary-600 mb-2">
                        {{ $this->stats['orders_count'] }}
                    </div>
                    <div class="text-gray-600">Ordini Effettuati</div>
                </div>

                <!-- Total Spent -->
                <div class="bg-white rounded-xl p-6 shadow-lg">
                    <div class="text-3xl font-bold text-primary-600 mb-2">
                        €{{ number_format($this->stats['total_spent'], 2) }}
                    </div>
                    <div class="text-gray-600">Totale Speso</div>
                </div>

                <!-- Member Since -->
                <div class="bg-white rounded-xl p-6 shadow-lg">
                    <div class="text-sm font-bold text-primary-600 mb-2">
                        {{ $this->stats['member_since'] }}
                    </div>
                    <div class="text-gray-600">Membro da</div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid md:grid-cols-3 gap-6">
                <a href="/events" class="bg-primary-600 text-white p-6 rounded-xl text-center hover:bg-primary-700">
                    <div class="text-2xl mb-2">📅</div>
                    <div class="font-semibold">Sfoglia Eventi</div>
                </a>

                <a href="/menu" class="bg-primary-600 text-white p-6 rounded-xl text-center hover:bg-primary-700">
                    <div class="text-2xl mb-2">🍕</div>
                    <div class="font-semibold">Ordina Pizza</div>
                </a>

                <a href="/dashboard/profile" class="bg-primary-600 text-white p-6 rounded-xl text-center hover:bg-primary-700">
                    <div class="text-2xl mb-2">👤</div>
                    <div class="font-semibold">Modifica Profilo</div>
                </a>
            </div>
        </div>
    @endvolt
</x-layouts.app>
```

**URL**: Automatically available at `/dashboard` (protected by auth middleware)

---

### Example 4: List with Filtering (Menu)

**File**: `resources/views/pages/menu.blade.php`

```blade
<?php

use App\Models\Pizza;
use App\Models\Category;
use function Livewire\Volt\{computed, state};

state([
    'search' => '',
    'category_id' => null,
    'vegetarian_only' => false,
]);

$categories = computed(fn () => Category::all());

$pizzas = computed(function () {
    return Pizza::query()
        ->when($this->search, fn ($q) => $q->where('name', 'like', "%{$this->search}%"))
        ->when($this->category_id, fn ($q) => $q->where('category_id', $this->category_id))
        ->when($this->vegetarian_only, fn ($q) => $q->where('is_vegetarian', true))
        ->with('category')
        ->get();
});

?>

<x-layouts.app>
    @volt('menu-page')
        <div class="container mx-auto px-4 py-20">
            <h1 class="text-4xl font-bold mb-12">Le Nostre Pizze</h1>

            <!-- Filters -->
            <div class="mb-8 flex flex-wrap gap-4">
                <!-- Search -->
                <input type="text"
                       wire:model.live="search"
                       placeholder="Cerca pizza..."
                       class="px-4 py-2 border rounded-lg">

                <!-- Category Filter -->
                <select wire:model.live="category_id" class="px-4 py-2 border rounded-lg">
                    <option value="">Tutte le categorie</option>
                    @foreach($this->categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>

                <!-- Vegetarian Filter -->
                <label class="flex items-center gap-2">
                    <input type="checkbox" wire:model.live="vegetarian_only">
                    <span>Solo Vegetariane</span>
                </label>
            </div>

            <!-- Pizza Grid -->
            <div class="grid md:grid-cols-3 gap-8">
                @foreach($this->pizzas as $pizza)
                    <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                        <img src="{{ $pizza->image_url }}" alt="{{ $pizza->name }}" class="w-full h-48 object-cover">

                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-2">{{ $pizza->name }}</h3>
                            <p class="text-gray-600 text-sm mb-4">{{ Str::limit($pizza->description, 100) }}</p>

                            <div class="flex items-center justify-between">
                                <span class="text-2xl font-bold text-primary-600">
                                    €{{ number_format($pizza->price, 2) }}
                                </span>

                                <a href="/menu/{{ $pizza->slug }}"
                                   class="bg-primary-600 text-white px-6 py-2 rounded-lg hover:bg-primary-700">
                                    Dettagli
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($this->pizzas->isEmpty())
                <div class="text-center py-12 text-gray-500">
                    Nessuna pizza trovata. Prova a modificare i filtri.
                </div>
            @endif
        </div>
    @endvolt
</x-layouts.app>
```

**URL**: Automatically available at `/menu`

---

## 🔧 Volt Component Types

### Functional API (Recommended for this project)

```blade
<?php

use function Livewire\Volt\{state, rules, computed};

state(['email' => '', 'password' => '']);

rules(['email' => 'required|email', 'password' => 'required']);

$login = function () {
    $this->validate();
    // Login logic
};

?>

@volt('login-form')
    <form wire:submit="login">
        <!-- Form fields -->
    </form>
@endvolt
```

### Class-based (Alternative)

```blade
<?php

use Livewire\Volt\Component;

new class extends Component {
    public string $email = '';
    public string $password = '';

    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

    public function login(): void
    {
        $this->validate();
        // Login logic
    }
}

?>

@volt('login-form')
    <form wire:submit="login">
        <!-- Form fields -->
    </form>
@endvolt
```

**Scegliere Functional API** per questo progetto (più conciso, KISS principle).

---

## 🎨 Filament Integration

### Using Filament Form Components in Volt

```blade
<?php

use function Livewire\Volt\{state, form};
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;

new class extends Component implements HasForms {
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->email()
                    ->required(),
                Textarea::make('message')
                    ->required(),
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        // Handle submission
    }
}

?>

@volt('contact-form')
    <form wire:submit="submit">
        {{ $this->form }}

        <button type="submit" class="bg-primary-600 text-white px-6 py-2 rounded-lg mt-4">
            Invia
        </button>
    </form>
@endvolt
```

---

## 📚 Best Practices

### 1. DRY Principle

**❌ BAD** (Ripetere codice):
```blade
<!-- page1.blade.php -->
<div class="container mx-auto px-4 py-20">
    <h1>Page 1</h1>
</div>

<!-- page2.blade.php -->
<div class="container mx-auto px-4 py-20">
    <h1>Page 2</h1>
</div>
```

**✅ GOOD** (Usare layouts):
```blade
<!-- layouts/app.blade.php -->
<x-layouts.base>
    <div class="container mx-auto px-4 py-20">
        {{ $slot }}
    </div>
</x-layouts.base>

<!-- page1.blade.php -->
<x-layouts.app>
    <h1>Page 1</h1>
</x-layouts.app>

<!-- page2.blade.php -->
<x-layouts.app>
    <h1>Page 2</h1>
</x-layouts.app>
```

### 2. KISS Principle

Keep components simple and focused:

**❌ BAD** (Too complex):
```blade
<?php
// Single component doing everything: filtering, sorting, pagination, export...
state([
    'search', 'category', 'sort', 'direction', 'per_page',
    'filters', 'export_format', 'selected_items'
]);
?>
```

**✅ GOOD** (Focused):
```blade
<?php
// Simple component: just display pizzas
state(['pizzas']);
?>
```

### 3. Component Reusability

**Create reusable Volt components**:

```blade
<!-- components/pizza-card.blade.php -->
@props(['pizza'])

<div class="bg-white rounded-xl shadow-lg p-6">
    <h3 class="text-xl font-bold">{{ $pizza->name }}</h3>
    <p class="text-gray-600">{{ $pizza->description }}</p>
    <div class="mt-4 flex items-center justify-between">
        <span class="text-2xl font-bold">€{{ $pizza->price }}</span>
        <button class="bg-primary-600 text-white px-4 py-2 rounded-lg">
            Aggiungi
        </button>
    </div>
</div>

<!-- Use in pages -->
<x-pizza-card :pizza="$pizza" />
```

---

## 🚫 Anti-Patterns to Avoid

### ❌ DON'T Create Controllers

```php
// ❌ WRONG - Don't do this!
class PizzaController extends Controller
{
    public function index() {
        return view('pizzas.index');
    }
}
```

**WHY**: We use Folio for routing, not controllers.

### ❌ DON'T Define Routes in web.php

```php
// ❌ WRONG - Don't do this!
Route::get('/menu', function () {
    return view('menu');
});
```

**WHY**: Folio automatically creates routes from file structure.

### ❌ DON'T Create Separate View Files

```php
// ❌ WRONG - Don't do this!
// resources/views/menu/index.blade.php (just view)
// app/Livewire/MenuPage.php (logic)
```

**WHY**: Volt allows single-file components with both logic and view.

### ❌ DON'T Mix Traditional and Folio Routing

```php
// ❌ WRONG - Don't do this!
// Some pages with controllers
// Some pages with Folio
```

**WHY**: Consistency is key. All frontend pages use Folio.

---

## 📖 Learning Resources

### Official Documentation
- [Laravel Folio Docs](https://laravel.com/docs/folio)
- [Livewire Volt Docs](https://livewire.laravel.com/docs/volt)
- [Filament Docs](https://filamentphp.com/docs)

### Example Projects
- [Jason Beggs: Laravel News Example](https://github.com/jasonlbeggs/laravel-news-volt-folio-example)
- [Nuno Maduro: Todo App](https://nunomaduro.com/todo_application_with_laravel_folio_and_volt)
- [Laracasts: Online Store](https://laracasts.com/blog/build-a-simple-online-store-using-laravel-folio-and-volt)

### Tutorials
- [Podcast Player Tutorial](https://jasonlbeggs.com/blog/livewire-volt-and-folio)
- [Multi-Step Form Guide](https://neon.com/guides/laravel-volt-folio-multi-step-form)
- [Volt Introduction](https://www.honeybadger.io/blog/laravel-volt/)

---

## 🎯 Summary

### Frontend Architecture Rules

1. ✅ **Folio** for page-based routing (no `web.php` routes)
2. ✅ **Volt** for single-file components (no separate Livewire classes)
3. ✅ **Filament** for form components, tables, widgets
4. ✅ **Functional API** preferred over class-based
5. ✅ **DRY**: Use layouts and components
6. ✅ **KISS**: Keep components simple and focused
7. ✅ **SOLID**: Single responsibility per component

### File Naming Conventions

- Regular pages: `menu.blade.php`
- Dynamic routes: `[slug].blade.php`, `[id].blade.php`
- Index pages: `index.blade.php`
- Nested: `events/index.blade.php`, `events/[slug].blade.php`

### Backend (Admin Panel)

- ✅ **Filament Resources** for admin CRUD
- ✅ **XotBase classes** (as per Laraxot architecture)
- ✅ **Actions** instead of Services
- ✅ **API endpoints** only where needed (for external consumption)

---

**Remember**: This architecture maximizes developer productivity by eliminating boilerplate while maintaining Laravel/Filament power and flexibility.

🍕 Happy coding with Laravel Pizza!
