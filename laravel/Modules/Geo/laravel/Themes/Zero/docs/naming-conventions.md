---
title: Naming Conventions — Zero Theme
module: Zero
type: reference
status: approved
tags: [naming, conventions, style-guide, components, blade]
updated: "2026-06-18"
related:
  - component-guide.md
  - customization.md
---

# Naming Conventions — Zero Theme

Convenzioni di naming per mantenere coerenza e leggibilità del tema Zero in Laraxot PTVX.

## File Naming

### Blade Components
- **Format**: `kebab-case.blade.php`
- **Example**: `nav-link.blade.php`, `hero-section.blade.php`, `responsive-nav-link.blade.php`
- **Reason**: Matches Blade component naming (`<x-nav-link>`, `<x-hero-section>`)
- **No plurals**: Use singular form (e.g., `nav-link` not `nav-links`)

### Directories
```
resources/views/
├── layouts/              # Global layout templates
│   ├── app.blade.php
│   └── guest.blade.php
├── pages/                # Page templates
│   ├── index.blade.php
│   ├── home.blade.php
│   └── auth/
│       └── login.blade.php
├── components/           # Reusable Blade components
│   ├── layouts/          # Layout wrapper components
│   │   ├── app.blade.php
│   │   └── main.blade.php
│   ├── navigation/       # Navigation components
│   │   ├── navigation.blade.php
│   │   ├── nav-link.blade.php
│   │   └── responsive-nav-link.blade.php
│   ├── blocks/           # Page section blocks
│   │   ├── hero/
│   │   ├── features/
│   │   ├── testimonials/
│   │   ├── stats/
│   │   ├── sidebar/
│   │   └── cta/
│   └── ui/               # Basic UI components
│       └── logo.blade.php
└── mail/                 # Email templates (if applicable)
```

### CSS/Asset Files
- **Tailwind config**: `tailwind.config.js` (root)
- **Vite config**: `vite.config.js` (root)
- **PostCSS config**: `postcss.config.js` (root)
- **CSS imports**: `resources/css/app.css`

## PHP Naming

### Component Class Names
- **Format**: `PascalCase`
- **Example**: `class NavigationComponent`
- **Namespace**: `App\View\Components` (managed by Laravel)
- **No suffix "Component"**: Naming is implicit

### Props & Slots
- **Format**: `camelCase`
- **Example**: `$isActive`, `$menuItems`, `$title`
- **Typed**: Always use typed props (PHP 8.0+)

```php
// ✓ GOOD
class NavLink extends Component
{
    public function __construct(
        public string $href,
        public bool $active = false,
        public string $label = '',
    ) {}
}

// ✗ BAD
class NavLink extends Component
{
    public $href;
    public $active;
}
```

### Slot Names
- **Format**: `camelCase`
- **Example**: `<x-slot name="headerContent">`
- **Semantic**: Name describes content, not position
- **Always document**: In component class or Blade comment

```blade
{{-- ✓ GOOD --}}
<x-slot name="headerContent">
    <!-- Header content here -->
</x-slot>

{{-- ✗ BAD --}}
<x-slot name="top">
    <!-- Content here -->
</x-slot>
```

## CSS & Tailwind

### Custom CSS Classes
- **Format**: `kebab-case`
- **Prefix**: `theme-` for custom utilities
- **Example**: `theme-nav-active`, `theme-card-shadow`, `theme-brand-color`
- **Location**: `resources/css/app.css` or Tailwind `@apply`

```css
/* resources/css/app.css */
@layer components {
    .theme-nav-active {
        @apply font-bold border-b-2 border-primary;
    }
    
    .theme-card-shadow {
        @apply shadow-md hover:shadow-lg transition-shadow;
    }
}
```

### Tailwind Color Usage
- **Primary**: `primary-*` (via Tailwind config)
- **Secondary**: `secondary-*`
- **Neutral**: Use Tailwind defaults (`gray-*`)
- **Semantic**: Use `text-red-500` for errors, `text-green-500` for success

### Custom Tailwind Variables (if used)
- **Format**: CSS custom properties in root
- **Example**: `--color-primary-500`, `--spacing-unit`
- **Usage**: `var(--color-primary-500)`

```css
:root {
    --color-primary-500: #6366f1;
    --color-secondary-500: #0891b2;
    --spacing-unit: 0.25rem;
}
```

## JavaScript/Alpine.js

### Event Handlers
- **Format**: `camelCase`
- **Pattern**: `@eventName="handler()"`
- **Example**: `@click="toggleMenu()"`, `@input="updateField()"`

```blade
<button @click="toggleMenu()">Toggle</button>
```

### State Variables
- **Format**: `camelCase`
- **Boolean prefix**: `is` (`isOpen`, `isActive`, `isLoading`)
- **Counter prefix**: `count` (`countItems`)
- **Other**: descriptive name (`selectedOption`)

```html
<div x-data="{ 
    isMenuOpen: false, 
    isLoading: false,
    selectedOption: null 
}">
</div>
```

### Alpine Component Naming
- **Global components**: `x-*` pattern (Blade convention)
- **File location**: `resources/views/components/`
- **JavaScript logic**: Keep minimal in HTML, use Alpine syntax

```blade
<!-- ✓ GOOD: Component-driven -->
<x-navigation :menu="$menuItems" />

<!-- ✗ BAD: Too much logic in HTML -->
<div x-data="{ items: @json($menuItems), ... }">
</div>
```

## Filament Integration

### Resource Classes
- **Format**: `PascalCase.php`
- **Example**: `UserResource.php`, `PostResource.php`
- **Location**: `app/Filament/Resources/`
- **Namespace**: `App\Filament\Resources`

### Action Classes
- **Format**: `PascalCase` + `Action`
- **Example**: `PublishAction`, `DeleteAction`
- **Location**: Same directory or `app/Filament/Actions/`

### Theme Config Classes
- **Format**: `PascalCase` + `Theme`
- **Example**: `ZeroTheme.php`
- **Location**: `app/Themes/` or `app/Filament/Themes/`

## Git & Commit Conventions

### Branch Naming
- **Feature**: `feature/component-name` or `feat/component-name`
- **Fix**: `fix/issue-description`
- **Docs**: `docs/filename`
- **Example**: `feature/hero-section-block`, `fix/nav-link-active-state`

### Commit Messages
```
[type]([scope]): [description]

Types: feat, fix, docs, style, refactor, test, chore, perf
Scope: components, customization, layout, styling, docs
Example: [feat](components): add hero-section block with image support
```

### File Organization in Commits
- **Atomic commits**: One feature per commit
- **Related files together**: Component + docs + tests
- **No unrelated changes**: Separate concerns

## Import Organization in Blade

```blade
{{-- 1. Layout/Framework imports --}}
@extends('layouts.app')

{{-- 2. Section declarations --}}
@section('title', 'Page Title')

{{-- 3. Component includes --}}
<x-navigation :menu="$menu" />

{{-- 4. Content sections --}}
@section('content')
    {{-- Page content --}}
@endsection

{{-- 5. Script sections (if needed) --}}
@push('scripts')
    {{-- Inline scripts --}}
@endpush
```

## Documentation Naming

### Doc Files
- **Format**: `kebab-case.md`
- **Example**: `component-guide.md`, `customization.md`, `naming-conventions.md`
- **Frontmatter**: Always include YAML header with metadata

### Documentation Titles
- **Format**: `Title — Zero Theme` (em-dash separator)
- **Language**: Italian for main docs
- **Consistency**: Same format across all themes

## Best Practices

### 1. Consistency First
Una volta scelto uno standard, mantienilo rigidamente:
- Un modo di nominare i file: `kebab-case` per Blade
- Un modo di nominare le classi: `PascalCase` per PHP
- Un modo di ordinare le imports

### 2. Self-Documenting Code
Il nome deve dire cosa fa, senza bisogno di commenti:
```blade
<!-- ✓ GOOD -->
<x-responsive-nav-link href="/dashboard">Dashboard</x-responsive-nav-link>

<!-- ✗ BAD -->
<x-link href="/d" type="nav">Link</x-link>
```

### 3. Avoid Abbreviations
Prefer readability over brevity:
- ✓ `navigation`, `header`, `sidebar`
- ✗ `nav`, `hdr`, `sb`

### 4. Namespace Discipline
Always qualify components:
```blade
<!-- ✓ GOOD -->
<x-blocks.hero.main :image="$heroImage" />

<!-- Unclear scope -->
<x-main :image="$heroImage" />
```

### 5. No Magic Numbers or Strings
Use constants or configuration:
```php
// ✓ GOOD
const HERO_SECTION_HEIGHT = 'h-96';

// ✗ BAD
'h-96' scattered throughout code
```

## Legacy/Deprecated Naming

Se modifichi uno standard, documenta il cambio:
- **Old**: `nav_link.blade.php` (snake_case)
- **New**: `nav-link.blade.php` (kebab-case)
- **Deprecation date**: 2026-06-18
- **Migration path**: Provide search-replace command

## PHP dominio (cross-repo)

Convenzioni backend condivise mono-repo (non Blade): vietato `persist*` su model dominio; action scheda su `SchedaContract`; getter `get*ByYear`. Vedi [domain-method-naming-no-persist](../../../../docs/wiki/patterns/domain-method-naming-no-persist.md) e [check-criteri-esclusione](../../../Modules/Ptv/docs/wiki/concepts/check-criteri-esclusione.md).

## References

- [Laravel Blade Documentation](https://laravel.com/docs/blade)
- [Tailwind CSS Naming](https://tailwindcss.com/docs)
- [PHP Naming Standards (PSR-12)](https://www.php-fig.org/psr/psr-12/)
- [Atomic Git Commits](https://www.conventionalcommits.org/)
