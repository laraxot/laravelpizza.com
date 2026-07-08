# Model Usage in Themes - Best Practices

## Executive Summary

Themes in this application follow the **"Theme as Dress"** philosophy - they provide only visual presentation while business logic (including model access) remains in modules. This document explains how themes should interact with models from modules following DRY and KISS principles.

---

## Core Principle: Themes Don't Own Models

### ✅ CORRECT Architecture

```
┌──────────────────────────────────────────┐
│           THEME (Zero)                   │
│  • Views, layouts, styling               │
│  • NO direct model instantiation         │
│  • NO business logic                     │
└──────────────────────────────────────────┘
                  │
                  │ (Uses widgets from modules)
                  ▼
┌──────────────────────────────────────────┐
│           MODULES                        │
│  • Models (User, Tenant, Post, etc.)     │
│  • Widgets (contain logic + data)        │
│  • Business logic                        │
└──────────────────────────────────────────┘
```

### ❌ INCORRECT Architecture

```
Themes/Zero/app/Models/User.php  ← NEVER DO THIS!
```

**Why:** Models belong to modules because they contain domain-specific business logic and database connections.

---

## How Themes Access Data

### Pattern 1: Via Filament Widgets (Recommended)

Widgets encapsulate both logic and data access, passing only the necessary data to theme views.

**Module Widget (Modules/User/Filament/Widgets/Auth/LoginWidget.php):**
```php
<?php

namespace Modules\User\Filament\Widgets\Auth;

use Modules\User\Models\User;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

class LoginWidget extends XotBaseWidget
{
    protected static string $view = 'pub_theme::filament.widgets.auth.login';

    public function mount(): void
    {
        // Widget accesses models directly
        $this->form->fill([
            'email' => '',
            'password' => '',
        ]);
    }

    public function login(): void
    {
        // Widget handles business logic with models
        $credentials = $this->form->getState();
        $user = User::where('email', $credentials['email'])->first();

        // ... authentication logic
    }
}
```

**Theme View (Themes/Zero/resources/views/filament/widgets/auth/login.blade.php):**
```blade
{{-- Theme view only handles presentation --}}
<x-filament-widgets::widget>
    <div class="custom-login-styling">
        {{ $this->form }}  {{-- Data comes from widget --}}
    </div>
</x-filament-widgets::widget>
```

#### Runtime Guards (Webmozart Assert)

Se il widget prepara payload complessi (array `$data`, opzioni, configurazioni), la validazione deve avvenire nel widget (o action) con `Webmozart\Assert\Assert`.

- ✅ OK: `Assert` in widget/controller/action prima di passare dati alla view
- ❌ NO: `Assert` in Blade

### Pattern 2: Via Folio Pages with Controller Logic

For Folio pages that need data, use route model binding or controller-like logic within the Folio page.

**Folio Page (Themes/Zero/resources/views/pages/users/[User].blade.php):**
```php
<?php

use Modules\User\Models\User;
use function Laravel\Folio\{name, render};

name('users.show');

// Route model binding - User comes from module
render(fn (User $user) => view('pub_theme::pages.users.show', [
    'user' => $user,
]));

?>

<x-layouts.main>
    <h1>{{ $user->name }}</h1>
    <p>{{ $user->email }}</p>
</x-layouts.main>
```

**Key Points:**
- ✅ Import model from module: `use Modules\User\Models\User;`
- ✅ Use route model binding for automatic loading
- ✅ Pass data to view as variables
- ❌ Never instantiate models directly in Blade templates

### Pattern 3: Via View Composers (For Shared Data)

For data needed across multiple views (e.g., navigation, user info).

**Service Provider (Modules/User/Providers/UserServiceProvider.php):**
```php
use Illuminate\Support\Facades\View;
use Modules\User\Models\User;

public function boot(): void
{
    // Share data with all theme views
    View::composer('pub_theme::*', function ($view) {
        if (auth()->check()) {
            $view->with('currentUser', auth()->user());
        }
    });
}
```

**Theme Layout (Themes/Zero/resources/views/layouts/main.blade.php):**
```blade
<header>
    @auth
        <div>Welcome, {{ $currentUser->name }}</div>
    @endauth
</header>
```

---

## Model Inheritance Hierarchy (Reference)

Understanding the model hierarchy helps when working with data in themes.

### Regular Models
```
Illuminate\Database\Eloquent\Model
└── Modules\Xot\Models\XotBaseModel
    └── Modules\{Module}\Models\BaseModel
        └── Modules\{Module}\Models\{ConcreteModel}

Example:
Model → XotBaseModel → User\BaseModel → User\Models\User
```

### Pivot Models (Many-to-Many)
```
Illuminate\Database\Eloquent\Relations\Pivot
└── Modules\Xot\Models\XotBasePivot
    └── Modules\{Module}\Models\BasePivot
        └── Modules\{Module}\Models\{ConcretePivot}

Example:
Pivot → XotBasePivot → User\BasePivot → User\Models\TeamUser
```

### MorphPivot Models (Polymorphic Many-to-Many)
```
Illuminate\Database\Eloquent\Relations\MorphPivot
└── Modules\Xot\Models\XotBaseMorphPivot
    └── Modules\{Module}\Models\BaseMorphPivot
        └── Modules\{Module}\Models\{ConcreteMorphPivot}

Example:
MorphPivot → XotBaseMorphPivot → User\BaseMorphPivot → User\Models\ModelHasRole
```

**For Theme Developers:** You don't need to know these details! Widgets and controllers handle model access. This is just for reference.

---

## Common Patterns in Theme Views

### 1. Displaying User Data

**❌ WRONG:**
```blade
{{-- Never instantiate models in views --}}
@php
    $user = \Modules\User\Models\User::find(1);
@endphp
<h1>{{ $user->name }}</h1>
```

**✅ RIGHT:**
```blade
{{-- Data comes from widget, Folio render, or view composer --}}
<h1>{{ $user->name }}</h1>
```

### 2. Showing Related Data

**❌ WRONG:**
```blade
{{-- Never query relationships in views --}}
@php
    $posts = $user->posts()->get();
@endphp
@foreach($posts as $post)
    ...
@endforeach
```

**✅ RIGHT:**
```php
// In Folio page or widget
render(fn (User $user) => view('pub_theme::pages.users.show', [
    'user' => $user,
    'posts' => $user->posts()->latest()->limit(10)->get(),
]));
```

```blade
{{-- In theme view --}}
@foreach($posts as $post)
    <article>{{ $post->title }}</article>
@endforeach
```

### 3. Lists and Tables

**✅ Use Filament Widgets for Complex Tables:**
```blade
{{-- Theme view --}}
@livewire(\Modules\User\Filament\Widgets\UsersTableWidget::class)
```

**✅ Use Folio for Simple Lists:**
```php
// Folio page
use Modules\User\Models\User;

render(fn () => view('pub_theme::pages.users.index', [
    'users' => User::query()->latest()->paginate(20),
]));
```

```blade
{{-- Theme view --}}
<ul>
    @foreach($users as $user)
        <li>{{ $user->name }}</li>
    @endforeach
</ul>

{{ $users->links() }}
```

---

## Best Practices Summary

### DO ✅

1. **Import Models from Modules**
   ```php
   use Modules\User\Models\User;
   use Modules\Cms\Models\Post;
   ```

2. **Use Widgets for Complex Logic**
   ```blade
   @livewire(\Modules\User\Filament\Widgets\LoginWidget::class)
   ```

3. **Use Folio render() for Data Passing**
   ```php
   render(fn (User $user) => view('...', ['user' => $user]));
   ```

4. **Use Route Model Binding**
   ```php
   // Automatic in Folio: pages/users/[User].blade.php
   ```

5. **Use View Composers for Shared Data**
   ```php
   View::composer('pub_theme::*', fn($view) => ...);
   ```

### DON'T ❌

1. **Never Create Models in Theme**
   ```php
   // ❌ Themes/Zero/app/Models/User.php - NEVER!
   ```

2. **Never Query Models in Blade**
   ```blade
   {{-- ❌ WRONG --}}
   @php
       $users = \Modules\User\Models\User::all();
   @endphp
   ```

3. **Never Put Business Logic in Views**
   ```blade
   {{-- ❌ WRONG --}}
   @if($user->canAccessResource())
       ...
   @endif
   ```

   ```blade
   {{-- ✅ RIGHT - Logic in widget/controller, result in view --}}
   @if($canAccess)
       ...
   @endif
   ```

4. **Never Use @volt in Themes**
   ```blade
   {{-- ❌ WRONG - Volt components with logic in themes --}}
   @volt('users.list')
       // Logic here
   @endvolt
   ```

   Use Filament widgets from modules instead.

---

## Module-Specific Model References

When working with the Zero theme, you'll commonly encounter models from these modules:

### User Module
- `Modules\User\Models\User` - Application users
- `Modules\User\Models\Tenant` - Multi-tenancy
- `Modules\User\Models\Team` - Team management
- `Modules\User\Models\TeamUser` - Team membership (pivot)
- `Modules\User\Models\TenantUser` - Tenant membership (pivot)

### Cms Module
- `Modules\Cms\Models\Post` - Blog posts
- `Modules\Cms\Models\Page` - Static pages
- `Modules\Cms\Models\Article` - Articles

### healthcare_app Module
- `Modules\healthcare_app\Models\Survey` - Surveys
- `Modules\healthcare_app\Models\Question` - Survey questions
- `Modules\healthcare_app\Models\SurveyPdf` - PDF exports

### Other Modules
- `Modules\Geo\Models\Place` - Geographic data
- `Modules\Notify\Models\Notification` - Notifications
- `Modules\Rating\Models\Rating` - User ratings

**Remember:** Always import from the module, never copy or recreate these models in the theme!

---

## Testing Theme Model Integration

### Test 1: Verify Widget Provides Data

```php
use Livewire\Livewire;
use Modules\User\Filament\Widgets\Auth\LoginWidget;

test('login widget provides form to theme view', function () {
    Livewire::test(LoginWidget::class)
        ->assertViewIs('pub_theme::filament.widgets.auth.login')
        ->assertSee('email')
        ->assertSee('password');
});
```

### Test 2: Verify Folio Page Data Binding

```php
use Modules\User\Models\User;

test('user profile page displays user data', function () {
    $user = User::factory()->create(['name' => 'John Doe']);

    $this->get("/users/{$user->id}")
        ->assertOk()
        ->assertSee('John Doe');
});
```

### Test 3: Verify No Direct Model Access in Views

```php
test('theme views do not directly instantiate models', function () {
    $themeViewsPath = resource_path('views');

    $files = glob("{$themeViewsPath}/**/*.blade.php");

    foreach ($files as $file) {
        $content = file_get_contents($file);

        // Check for direct model instantiation
        expect($content)
            ->not->toContain('new \Modules\\')
            ->not->toContain('::find(')
            ->not->toContain('::all()')
            ->not->toContain('::get()');
    }
});
```

---

## Migration Guide: From Theme Models to Module Models

If you find models in the theme directory, here's how to migrate:

### Step 1: Identify the Model's Module

```php
// Found: Themes/Zero/app/Models/CustomUser.php
// Should be: Modules/User/app/Models/CustomUser.php (or extend User)
```

### Step 2: Move to Appropriate Module

```bash
# Move the file
mv Themes/Zero/app/Models/CustomUser.php \
   Modules/User/app/Models/CustomUser.php
```

### Step 3: Update Namespace

```php
<?php
// Change from:
namespace Themes\Zero\Models;

// To:
namespace Modules\User\Models;

// Ensure proper inheritance:
use Modules\User\Models\BaseModel;

class CustomUser extends BaseModel
{
    protected $connection = 'user'; // If not already in BaseModel
    // ...
}
```

### Step 4: Update All Imports in Theme

```php
// Change all theme files from:
use Themes\Zero\Models\CustomUser;

// To:
use Modules\User\Models\CustomUser;
```

### Step 5: Update Widget References

```php
// In widgets, update:
use Themes\Zero\Models\CustomUser;  // ❌ OLD

// To:
use Modules\User\Models\CustomUser;  // ✅ NEW
```

---

## Troubleshooting

### Problem: "Class not found" error in theme view

**Cause:** Trying to use a model not imported.

**Solution:** Import at top of Folio page or pass via widget:
```php
use Modules\User\Models\User;
```

### Problem: "Connection not found" error

**Cause:** Model not extending proper BaseModel with connection.

**Solution:** Check model extends `Modules\{Module}\Models\BaseModel`:
```php
// ✅ Correct
class User extends BaseModel  // BaseModel has $connection = 'user'
{
    // ...
}

// ❌ Wrong
class User extends Model  // No connection defined
{
    // ...
}
```

### Problem: N+1 query issues in theme views

**Cause:** Accessing relationships not eager-loaded.

**Solution:** Eager load in widget/controller:
```php
// In widget or Folio render()
$users = User::with('posts', 'teams')->get();

// Then pass to view
return view('...', ['users' => $users]);
```

### Problem: Data not showing in theme view

**Cause:** Widget view path incorrect.

**Solution:** Check widget's view path:
```php
class MyWidget extends XotBaseWidget
{
    // ✅ Correct - points to theme
    protected static string $view = 'pub_theme::filament.widgets.my-widget';

    // ❌ Wrong - hardcoded theme name
    protected static string $view = 'zero::filament.widgets.my-widget';
}
```

---

## Checklist for Theme Developers

When working with data in theme views:

- [ ] Models are imported from `Modules\{Module}\Models\`
- [ ] No models exist in `Themes/*/app/Models/`
- [ ] No direct model queries in Blade templates
- [ ] Complex logic uses Filament widgets
- [ ] Simple data passing uses Folio `render()`
- [ ] Shared data uses View Composers
- [ ] Route model binding used where appropriate
- [ ] Relationships are eager-loaded to prevent N+1
- [ ] Widget view paths use `pub_theme::` namespace
- [ ] Tests verify data flow from widget/controller to view

---

## Related Documentation

- [Model Inheritance Rules (User Module)](../../Modules/User/docs/model-inheritance-rules.md)
- [DRY/KISS Model Refactoring Analysis](../../Modules/Xot/docs/dry-kiss-model-refactoring-2025-10-15.md)
- [Theme Architecture](./architecture.md)
- [Widget Structure (User Module)](../../Modules/User/docs/widgets_structure.md)
- [Filament Authentication Best Practices](../../Modules/Cms/docs/frontoffice/filament-auth.md)

---

## Conclusion

The Zero theme follows a strict separation of concerns:

- **Themes = Presentation** (layouts, styling, UI components)
- **Modules = Logic + Data** (models, widgets, business rules)

By keeping models in modules and accessing them only through widgets, Folio pages, or view composers, we maintain:

- ✅ **DRY**: Models defined once in modules, used everywhere
- ✅ **KISS**: Theme views stay simple, focused on presentation
- ✅ **Maintainability**: Business logic changes don't break themes
- ✅ **Flexibility**: Themes can be swapped without touching models

**Golden Rule:** If you're writing `use Modules\...\Models\...` in a theme file, make sure it's only in:
1. Folio page `render()` functions
2. View composers (in module service providers, not theme)
3. Never in Blade templates themselves

---

*Last Updated: 15 October 2025*
*Refactoring Reference: DRY/KISS Model Refactoring 2025-10-15*
