# Correzioni COMPLETION_PLAN.md - Folio + Volt Architecture


---

## ❌ Patterns da Rimuovere

Questi pattern sono **SBAGLIATI** per il frontoffice di Laravel Pizza e devono essere corretti:

### 1. Controller References

**RIMUOVERE**:
```php
// ❌ WRONG
Route::get('/pizzas', [PizzaController::class, 'index']);
Route::get('/events', [EventController::class, 'index']);
```

**SOSTITUIRE CON**:
```
✅ Folio page-based routing:
- resources/views/pages/menu.blade.php → /menu
- resources/views/pages/events/index.blade.php → /events
```

---

### 2. API Routes in web.php/api.php

**RIMUOVERE**:
```php
// ❌ WRONG - No routes in web.php for frontend
Route::get('/', [HomeController::class, 'index']);
Route::get('/menu', [MenuController::class, 'index']);
```

```php
// ❌ WRONG - No routes in api.php for frontend
Route::get('/pizzas', [PizzaController::class, 'index']);
Route::post('/orders', [OrderController::class, 'store']);
```

**SOSTITUIRE CON**:
```
✅ Folio handles all frontend routing automatically
✅ API endpoints only for external integrations (if needed)
```

---

### 3. Sitemap Controller

**RIMUOVERE**:
```php
// ❌ WRONG
Route::get('/sitemap.xml', [SitemapController::class, 'index']);

class SitemapController extends Controller
{
    public function index() { }
}
```

**SOSTITUIRE CON**:
```blade
✅ resources/views/pages/sitemap.xml.blade.php

<?php
use App\Models\Pizza;
use App\Models\Event;
use function Livewire\Volt\{computed};

$pizzas = computed(fn () => Pizza::all());
$events = computed(fn () => Event::published()->get());
?>

<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($this->pizzas as $pizza)
    <url>
        <loc>{{ url("/menu/{$pizza->slug}") }}</loc>
        <lastmod>{{ $pizza->updated_at->toAtomString() }}</lastmod>
    </url>
    @endforeach
</urlset>
```

---

### 4. Traditional Form Handling

**RIMUOVERE**:
```php
// ❌ WRONG
class ContactController extends Controller
{
    public function store(Request $request) {
        $validated = $request->validate([...]);
        Mail::send(...);
        return redirect()->back();
    }
}
```

**SOSTITUIRE CON**:
```blade
✅ resources/views/pages/contact.blade.php (Volt component)

<?php
use function Livewire\Volt\{state, rules};

state(['name' => '', 'email' => '', 'message' => '']);
rules(['name' => 'required', 'email' => 'required|email']);

$submit = function () {
    $this->validate();
    Mail::to('info@laravelpizza.com')->send(...);
    session()->flash('success');
};
?>

@volt('contact-form')
    <form wire:submit="submit">
        <!-- Filament form components or simple inputs -->
    </form>
@endvolt
```

---

## ✅ Correct Patterns

### Frontend Pages Structure

```
resources/views/pages/
├── index.blade.php              → / (Homepage delivery)
├── menu.blade.php               → /menu (List pizzas)
├── menu/
│   └── [slug].blade.php         → /menu/{slug} (Pizza detail)
├── cart.blade.php               → /cart
├── checkout.blade.php           → /checkout
├── events/
│   ├── index.blade.php          → /events (List events)
│   └── [slug].blade.php         → /events/{slug} (Event detail)
├── dashboard/
│   ├── index.blade.php          → /dashboard (Protected: auth middleware)
│   └── profile.blade.php        → /dashboard/profile
├── auth/
│   ├── login.blade.php          → /auth/login
│   └── register.blade.php       → /auth/register
```

---

### Volt Component Example (Menu Page)

```blade
<?php
// resources/views/pages/menu.blade.php

use App\Models\Pizza;
use function Livewire\Volt\{computed, state};

state(['search' => '', 'category_id' => null]);

$pizzas = computed(function () {
    return Pizza::query()
        ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
        ->when($this->category_id, fn($q) => $q->where('category_id', $this->category_id))
        ->with('category')
        ->get();
});
?>

<x-layouts.app>
    @volt('menu-page')
        <div class="container mx-auto px-4 py-20">
            <!-- Search & Filters -->
            <input type="text" wire:model.live="search" placeholder="Cerca pizza...">

            <!-- Pizza Grid -->
            <div class="grid md:grid-cols-3 gap-8">
                @foreach($this->pizzas as $pizza)
                    <x-pizza-card :pizza="$pizza" />
                @endforeach
            </div>
        </div>
    @endvolt
</x-layouts.app>
```

---

### Dynamic Route Example (Pizza Detail)

```blade
<?php
// resources/views/pages/menu/[slug].blade.php

use App\Models\Pizza;
use function Livewire\Volt\{computed, state};

state(['slug']);

$pizza = computed(fn () => Pizza::where('slug', $this->slug)->firstOrFail());

$addToCart = function () {
    session()->push('cart', [
        'id' => $this->pizza->id,
        'name' => $this->pizza->name,
        'price' => $this->pizza->price,
    ]);
    $this->dispatch('cart-updated');
};
?>

<x-layouts.app>
    @volt('pizza-detail')
        <div class="container mx-auto px-4 py-20">
            <h1>{{ $this->pizza->name }}</h1>
            <p>€{{ $this->pizza->price }}</p>
            <button wire:click="addToCart">Aggiungi al Carrello</button>
        </div>
    @endvolt
</x-layouts.app>
```

---

### Protected Page Example (Dashboard)

```blade
<?php
// resources/views/pages/dashboard/index.blade.php

use function Livewire\Volt\{middleware, computed};

middleware(['auth']); // Protect this page

$stats = computed(function () {
    return [
        'orders' => auth()->user()->orders()->count(),
        'events' => auth()->user()->events()->count(),
    ];
});
?>

<x-layouts.app>
    @volt('dashboard')
        <div class="container mx-auto px-4 py-20">
            <h1>Dashboard</h1>
            <p>Ordini: {{ $this->stats['orders'] }}</p>
            <p>Eventi: {{ $this->stats['events'] }}</p>
        </div>
    @endvolt
</x-layouts.app>
```

---

## 🔧 Backend API (Se Necessario)

### Solo per External Integrations

Se serve un'API per integrazioni esterne (mobile app, webhook Stripe, etc.):

**File**: `Modules/Pizza/routes/api.php`

```php
<?php

use Modules\Pizza\Actions\CreateOrderAction;
use Illuminate\Support\Facades\Route;

// Only for external integrations
Route::post('/webhooks/stripe', function (Request $request) {
    // Handle Stripe webhook
    $event = Stripe\Webhook::constructEvent(...);
    // Process event
})->name('webhooks.stripe');

// Mobile app API (if needed)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/pizzas', fn () => Pizza::all());
    Route::post('/orders', fn (Request $request) => app(CreateOrderAction::class)->execute($request->all()));
});
```

**MA**: Il frontend web usa **SOLO Volt components**, NON chiama queste API.

---

## 📝 Sezioni COMPLETION_PLAN.md da Correggere

### Giorno 39-42: API Endpoints

**SOSTITUIRE**:
```php
// ❌ Remove this entire section about API endpoints for frontend
Route::get('/pizzas', [PizzaController::class, 'index']);
```

**CON**:
```
✅ Frontend uses Volt components directly accessing Eloquent models
✅ API endpoints only for:
   - Stripe webhooks
   - Mobile app (if developed later)
   - External integrations
```

---

### Giorno 73: SEO Optimization - Sitemap

**SOSTITUIRE**:
```php
// ❌ SitemapController
Route::get('/sitemap.xml', [SitemapController::class, 'index']);
```

**CON**:
```blade
✅ resources/views/pages/sitemap.xml.blade.php (Folio + Volt)
```

---

### JavaScript API Calls

**SOSTITUIRE**:
```javascript
// ❌ WRONG - Don't fetch from API
const pizzas = await fetch('/api/pizzas').then(r => r.json());
```

**CON**:
```blade
✅ Use Livewire/Volt reactive properties
<div wire:loading>Loading...</div>
{{ $this->pizzas }} <!-- Loaded server-side -->
```

---

## 🎯 Riassunto Modifiche

| Cosa | Da Rimuovere | Da Usare |
|------|--------------|----------|
| Routing | `Route::get()` in web.php | Folio file structure |
| Logic | Controllers | Volt functional API |
| Forms | Form requests + controllers | Volt + Filament components |
| API calls | fetch('/api/...') | Livewire wire:model |
| Views | Separate .blade.php files | Single-file Volt components |

---

## ✅ Checklist Correzioni

- [ ] Rimuovere tutti i riferimenti a `Controller` nel frontend
- [ ] Rimuovere esempi di `Route::get()` in `web.php`
- [ ] Rimuovere esempi di `Route::post()` per form submissions
- [ ] Sostituire con esempi Folio + Volt
- [ ] Aggiungere nota: "API solo per integrazioni esterne"
- [ ] Verificare ogni esempio di codice
- [ ] Aggiungere link a `architecture-folio-volt-filament.md`

---

**Nota Importante**: Queste correzioni si applicano **SOLO al FRONTOFFICE**. Il backend admin (Filament) usa normalmente Resources, Actions, e l'architettura Laraxot.
