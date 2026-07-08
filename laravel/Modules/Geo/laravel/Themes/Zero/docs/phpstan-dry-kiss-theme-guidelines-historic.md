# PHPStan Level 10 + DRY/KISS Guidelines for Themes

## Theme Code Quality Standards

Il tema Zero segue gli stessi standard di qualità del codice applicati ai moduli, con alcune specifiche per i temi.

---

## PHPStan Level 10 for Themes

### What to Check in Themes

Anche se i temi sono principalmente presentation layer, alcune parti contengono codice PHP che deve essere PHPStan compliant:

1. **Folio Pages con logic**
2. **View Composers**
3. **Service Providers**
4. **Custom Components (se presenti)**

### Running PHPStan on Themes

```bash
# Analyze theme PHP code
./vendor/bin/phpstan analyse Themes/Zero/app --level=10

# Analyze Folio pages with PHP logic
./vendor/bin/phpstan analyse Themes/Zero/resources/views/pages --level=10
```

---

## DRY Principle in Themes

### ✅ DO: Reuse Module Components

**Good**:
```blade
{{-- Theme view using module widget --}}
@livewire(\Modules\User\Filament\Widgets\LoginWidget::class)
```

**Bad**:
```blade
{{-- ❌ Duplicating login logic in theme --}}
@volt('auth.login')
    // ... duplicate authentication logic
@endvolt
```

### ✅ DO: Use Layouts

**Good**:
```blade
{{-- resources/views/pages/products/index.blade.php --}}
<x-layouts.main>
    <h1>Products</h1>
    {{-- Content --}}
</x-layouts.main>
```

**Bad**:
```blade
{{-- ❌ Duplicating layout in every page --}}
<!DOCTYPE html>
<html>
<head>...</head>
<body>
    {{-- Repeated in every file --}}
</body>
</html>
```

### ✅ DO: Extract Reusable Components

**Good**:
```blade
{{-- components/product-card.blade.php --}}
<div class="product-card">
    <h3>{{ $product->name }}</h3>
    <p>{{ $product->price }}</p>
</div>

{{-- Usage in multiple views --}}
<x-product-card :product="$product" />
```

---

## KISS Principle in Themes

### Keep Views Simple

**Rule**: Theme views should be **presentation only**. No business logic!

**Good** ✅:
```blade
{{-- Simple, clear presentation --}}
<div class="user-profile">
    <h1>{{ $user->name }}</h1>
    <p>{{ $user->email }}</p>

    @if($canEdit)
        <a href="{{ route('users.edit', $user) }}">Edit</a>
    @endif
</div>
```

**Bad** ❌:
```blade
{{-- ❌ Business logic in view --}}
<div class="user-profile">
    @php
        $permissions = \Modules\User\Models\Permission::where('user_id', $user->id)->get();
        $canEdit = $permissions->contains('name', 'edit_users');
        $formattedName = ucwords(strtolower($user->name));
    @endphp

    <h1>{{ $formattedName }}</h1>

    @if($canEdit)
        <a href="/users/{{ $user->id }}/edit">Edit</a>
    @endif
</div>
```

**Why bad?**:
- Business logic in view (permissions check)
- Database query in view
- String manipulation in view
- Hardcoded URLs

**Fix** ✅:
```php
// In Folio page or controller
use Modules\User\Models\User;

render(fn (User $user) => view('pub_theme::pages.users.show', [
    'user' => $user,
    'canEdit' => auth()->user()->can('edit', $user),
    'formattedName' => $user->formatted_name, // Accessor on model
]));
```

```blade
{{-- In view - simple & clear --}}
<div class="user-profile">
    <h1>{{ $formattedName }}</h1>

    @if($canEdit)
        <a href="{{ route('users.edit', $user) }}">Edit</a>
    @endif
</div>
```

---

## Type Safety in Folio Pages

### Use Type Hints

**Good** ✅:
```php
<?php

use Modules\User\Models\User;
use Illuminate\Database\Eloquent\Collection;
use function Laravel\Folio\{name, render};

name('users.index');

render(fn (): array => [
    'users' => User::query()->latest()->paginate(20),
    'totalCount' => User::count(),
]);

?>

<x-layouts.main>
    @foreach($users as $user)
        <div>{{ $user->name }}</div>
    @endforeach
</x-layouts.main>
```

**Why good?**:
- ✅ PHPStan knows types
- ✅ IDE autocomplete works
- ✅ Type-safe refactoring
- ✅ Clear what data view receives

**Bad** ❌:
```php
<?php

render(function () {
    return [
        'users' => \DB::table('users')->get(), // ❌ No type hint
        'count' => \DB::table('users')->count(),
    ];
});

?>
```

---

## Avoid Code Duplication in Themes

### Common Duplications to Avoid

#### 1. Duplicate Navigation

**Bad** ❌:
```blade
{{-- In layout1.blade.php --}}
<nav>
    <a href="/">Home</a>
    <a href="/products">Products</a>
    <a href="/about">About</a>
</nav>

{{-- In layout2.blade.php --}}
<nav>
    <a href="/">Home</a>
    <a href="/products">Products</a>
    <a href="/about">About</a>
</nav>
```

**Good** ✅:
```blade
{{-- components/navigation.blade.php --}}
<nav>
    <a href="/">Home</a>
    <a href="/products">Products</a>
    <a href="/about">About</a>
</nav>

{{-- In all layouts --}}
<x-navigation />
```

#### 2. Duplicate Styling Logic

**Bad** ❌:
```blade
{{-- Repeated in multiple places --}}
<button class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
    Click me
</button>
```

**Good** ✅:
```blade
{{-- components/button.blade.php --}}
@props(['variant' => 'primary'])

<button {{ $attributes->merge(['class' => "px-4 py-2 rounded {$variant}"]) }}>
    {{ $slot }}
</button>

{{-- Usage --}}
<x-button variant="primary">Click me</x-button>
```

#### 3. Duplicate Data Fetching

**Bad** ❌:
```blade
{{-- In multiple Folio pages --}}
<?php
render(fn () => [
    'settings' => \Modules\Xot\Models\Setting::all(), // ❌ Duplicated
]);
?>
```

**Good** ✅:
```php
// In service provider - share with all views
View::composer('pub_theme::*', function ($view) {
    $view->with('settings', cache()->remember('global_settings', 3600, fn () =>
        \Modules\Xot\Models\Setting::all()
    ));
});
```

---

## Theme-Specific Best Practices

### 1. No Models in Theme

**Never** ❌:
```php
// Themes/Zero/app/Models/CustomUser.php
class CustomUser extends Model { } // ❌ NEVER!
```

**Always** ✅:
```php
// Modules/User/app/Models/CustomUser.php
class CustomUser extends BaseModel { } // ✅ In module!
```

### 2. No Business Logic in Theme

**Never** ❌:
```php
// In Folio page
$invoice = Invoice::find($id);
$invoice->calculateTax(); // ❌ Business logic!
$invoice->save();
```

**Always** ✅:
```php
// Use service from module
app(\Modules\Invoice\Services\InvoiceService::class)->calculate($invoice);
```

### 3. Minimal PHP in Blade

**Limit PHP to**:
- Loops (`@foreach`, `@for`)
- Conditionals (`@if`, `@unless`)
- Includes (`@include`, `<x-component>`)
- Display (`{{ $var }}`)

**Avoid**:
- Complex calculations
- Database queries
- Object instantiation
- Business logic

---

## Checklist for Theme Code

When writing code in themes:

### Folio Pages
- [ ] Use type hints in `render()` function
- [ ] Pass all data through `render()`, not in Blade
- [ ] Use `route()` helper for URLs, not hardcoded
- [ ] Import models from modules at top of file
- [ ] No database queries in Blade templates
- [ ] No business logic in Folio pages (use services)

### Blade Views
- [ ] Use components for reusable elements
- [ ] No `@php` blocks with logic
- [ ] No database queries (`Model::all()`, etc.)
- [ ] No object instantiation (`new MyClass()`)
- [ ] Use provided data only, don't fetch more

### Components
- [ ] Document props with `@props()`
- [ ] Use `$attributes->merge()` for extensibility
- [ ] Keep components focused (single responsibility)
- [ ] No business logic, only presentation

### General
- [ ] Run PHPStan on PHP code in theme
- [ ] Follow DRY - extract duplicates
- [ ] Follow KISS - keep views simple
- [ ] Use module services for logic
- [ ] Models always from modules, never in theme

---

## Example: Good Theme Structure

```
Themes/Zero/
├── resources/views/
│   ├── components/          # Reusable UI components
│   │   ├── button.blade.php
│   │   ├── card.blade.php
│   │   └── navigation.blade.php
│   │
│   ├── layouts/             # Page layouts
│   │   ├── main.blade.php   # Main layout
│   │   └── auth.blade.php   # Auth layout
│   │
│   └── pages/               # Folio pages
│       ├── index.blade.php  # Homepage
│       ├── users/
│       │   ├── index.blade.php     # ✅ Type-safe
│       │   └── [User].blade.php   # ✅ Route binding
│       └── products/
│           └── index.blade.php
│
└── app/
    └── Providers/
        └── ThemeServiceProvider.php  # ✅ View composers here
```

---

## PHPStan Validation for Themes

### Run Validation

```bash
# Check theme service providers
./vendor/bin/phpstan analyse Themes/Zero/app/Providers --level=10

# Check any custom classes in theme
./vendor/bin/phpstan analyse Themes/Zero/app --level=10
```

### Expected Result

✅ **0 errors** - Themes should have minimal PHP code, all should be type-safe.

---

## Migration from Non-Compliant Code

### Before (❌ Non-compliant)

```blade
<?php
// resources/views/pages/dashboard.blade.php

@php
    $user = Auth::user();
    $stats = \Modules\Analytics\Models\Stat::where('user_id', $user->id)->get();
    $total = $stats->sum('value');
@endphp
?>

<div>
    <h1>Dashboard for {{ ucfirst($user->name) }}</h1>
    <p>Total: {{ $total }}</p>
</div>
```

**Problems**:
- ❌ Business logic in view
- ❌ Database query in view
- ❌ String manipulation in view
- ❌ No type safety

### After (✅ Compliant)

```php
<?php
// resources/views/pages/dashboard.blade.php

use Modules\User\Models\User;
use Modules\Analytics\Services\StatsService;
use function Laravel\Folio\{name, render};

name('dashboard');

render(function (StatsService $statsService): array {
    /** @var User $user */
    $user = auth()->user();

    return [
        'user' => $user,
        'stats' => $statsService->getUserStats($user),
        'total' => $statsService->calculateTotal($user),
    ];
});

?>

<x-layouts.main>
    <div>
        <h1>Dashboard for {{ $user->display_name }}</h1>
        <p>Total: {{ $total }}</p>
    </div>
</x-layouts.main>
```

**Improvements**:
- ✅ Logic in service
- ✅ No queries in view
- ✅ Type-safe (PHPStan Level 10)
- ✅ Testable
- ✅ Follows KISS & DRY

---

## Related Documentation

- [Model Usage in Themes](./model-usage-in-themes.md)
- [Theme Architecture](./architecture.md)
- [PHPStan Level 10 Full Analysis (Xot)](../../Modules/Xot/docs/phpstan-level-10-dry-kiss-analysis-2025-10-17.md)
- [DRY/KISS Best Practices](./dry-kiss-best-practices-2025-10-15.md)

---

*Last Updated: 17 October 2025*
*Applies to: All themes (Zero, One, etc.)*
*Standard: PHPStan Level 10, DRY, KISS*
