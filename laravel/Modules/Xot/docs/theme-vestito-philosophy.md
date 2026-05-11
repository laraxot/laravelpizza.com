# Theme System: The "Vestito" (Clothing) Philosophy

## Core Concept: Theme as "Vestito"

The Laraxot theme system follows the **"Vestito"** (Italian for "clothing") philosophy:

> *Themes are like clothes - they cover the application and provide visual presentation, but they do not change the core functionality or structure of the underlying system.*

This philosophy ensures clear separation between:
- **Business Logic** (in modules)
- **Presentation Layer** (in themes)
- **Application Structure** (in Xot engine)

## The Sacred Separation Principle

### 1. Themes ≠ Business Logic
- Themes provide only visual presentation
- No business logic in themes
- No data processing in themes
- Themes are "dumb" presentation layers

### 2. Modules = Business Logic
- All business logic in modules
- All data processing in modules
- All security in modules
- Modules are "smart" business logic containers

### 3. Xot = Engine
- Core functionality in Xot module
- Foundation for modules and themes
- Provides shared services and patterns

## Theme Architecture

### Theme Structure
```
Themes/[ThemeName]/
├── app/
│   ├── Http/
│   └── View/
├── docs/               # Theme documentation
├── extras/            # Theme-specific extras
├── lang/              # Theme translations
├── public/            # Theme assets
│   ├── css/
│   ├── js/
│   └── images/
├── resources/
│   ├── css/
│   ├── js/
│   ├── views/
│   │   ├── components/
│   │   ├── layouts/
│   │   └── pages/
├── _healthcare_app_fila5_mono.code-workspace
├── package.json
├── postcss.config.js
├── tailwind.config.js
├── theme.json
└── vite.config.js
```

### Example: Zero Theme
The `Zero` theme serves as the baseline theme with minimal styling:

```json
// theme.json
{
    "name": "Zero",
    "description": "Baseline theme with minimal styling",
    "version": "1.0.0",
    "author": "Laraxot Team"
}
```

## The Vestito Philosophy in Practice

### 1. Theme Switching
You can change themes without affecting business logic:

```php
// Business logic remains the same regardless of theme
$users = User::active()->get();
// Presentation layer changes based on active theme
return view('users.index', compact('users'));
```

### 2. View Resolution Priority
Laraxot follows this view resolution order:

```
1. Current Theme Views → Themes/[ThemeName]/resources/views/
2. Module Views → Modules/[ModuleName]/resources/views/
3. Laravel Defaults → resources/views/
```

### 3. Component Isolation
Themes provide visual components, but modules provide functional components:

```blade
{{-- Theme provides visual wrapper --}}
<x-theme::layout>
    {{-- Module provides functional content --}}
    <x-module::user-card :user="$user" />
</x-theme::layout>
```

## Theme Integration Patterns

### 1. Layout System
Themes provide layout structures:

```blade
{{-- Themes/Zero/resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Laraxot')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header>
        @include('partials.header')
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        @include('partials.footer')
    </footer>
</body>
</html>
```

### 2. Component System
Themes can provide visual components that wrap module functionality:

```blade
{{-- Themes/Zero/resources/views/components/card.blade.php --}}
<div class="bg-white rounded-lg shadow-md p-6">
    {{ $slot }}
</div>
```

### 3. Asset Management
Themes manage their own assets independently:

```javascript
// vite.config.js in theme
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
```

## Multi-Theme Architecture

### 1. Theme Discovery
Themes are automatically discovered and can be switched:

```php
// Configuration-based theme switching
'active_theme' => env('ACTIVE_THEME', 'Zero'),
```

### 2. Module-Theme Communication
Modules remain theme-agnostic:

```php
// Module code remains unchanged
class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        // View resolution handles theme selection
        return view('users.index', compact('users'));
    }
}
```

## The Sacred Rules of the Vestito Philosophy

### Rule 1: Themes Are Presentation Only
❌ **WRONG:**
```blade
{{-- themes should not contain business logic --}}
@if($user->hasPermission('admin') && $user->isActive() && now()->gte($user->subscription_start))
    <div class="admin-panel">
        {{-- presentation --}}
    </div>
@endif
```

✅ **CORRECT:**
```blade
{{-- business logic in controller --}}
@if($canViewAdminPanel)
    <div class="admin-panel">
        {{-- only presentation --}}
    </div>
@endif
```

### Rule 2: Modules Are Theme-Agnostic
Modules should work with any theme:

```php
// Controller should not reference theme-specific elements
class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        // Module defines what data is needed
        // Theme defines how it's presented
        return view('users.index', compact('users'));
    }
}
```

### Rule 3: Clear Interface Contracts
Themes and modules communicate through well-defined interfaces:

```php
// Contracts define what data themes need
interface UserPresenterContract
{
    public function presentForTheme(User $user): array;
}
```

## Advanced Theme Patterns

### 1. Theme-Specific Assets
Themes can load their own CSS/JS while maintaining compatibility:

```php
// Theme service provider can register theme-specific assets
public function boot()
{
    $this->publishes([
        __DIR__.'/../resources/css' => public_path('themes/zero/css'),
    ], 'theme-assets');
}
```

### 2. Responsive Design
Themes implement responsive design while modules provide structured data:

```blade
{{-- Theme handles responsive layout --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    @foreach($users as $user)
        <x-theme::user-card :user="$user" />
    @endforeach
</div>
```

### 3. Accessibility
Themes implement accessibility features while maintaining module functionality:

```blade
{{-- Semantic HTML provided by theme --}}
<article role="article" class="user-card">
    <header>
        <h2>{{ $user->name }}</h2>
    </header>
    <main>
        {{-- Module data presented accessibly --}}
        <p>{{ $user->email }}</p>
    </main>
</article>
```

## The DRY/KISS Implementation

### DRY (Don't Repeat Yourself)
- Common layouts in theme
- Shared components in theme
- Consistent styling patterns
- Reusable visual elements

### KISS (Keep It Simple, Stupid)
- Simple theme switching
- <nome progetto>able view resolution
- Clear separation of concerns
- Minimal configuration needed

## The Philosophy Behind the Vestito Pattern

The "Vestito" philosophy embodies several core values:

### 1. Flexibility
- Change appearance without changing functionality
- Multiple themes for different audiences
- Easy theme customization

### 2. Maintainability
- Clear separation reduces complexity
- Themes can be developed independently
- Module code remains stable

### 3. Scalability
- New themes don't affect existing modules
- Themes can be developed by different teams
- Consistent module interface across themes

### 4. User Experience
- Professional appearance through themes
- Consistent functionality across themes
- Customizable user experience

## Best Practices

### 1. Theme Structure
- Keep themes lightweight
- Use semantic class names
- Maintain accessibility standards
- Provide fallbacks for missing assets

### 2. Module-Them Integration
- Define clear data contracts
- Use consistent view names
- Provide theme-agnostic data
- Maintain backward compatibility

### 3. Performance
- Optimize theme assets
- Use efficient CSS selectors
- Implement asset caching
- Minimize theme-specific logic

This architecture ensures that themes can be changed, updated, or replaced without affecting the core business logic, while maintaining a consistent and professional user experience across the application.
