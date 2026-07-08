---
title: Naming Conventions — One Theme
module: One
type: reference
status: approved
tags: [naming, conventions, style-guide, components, blade]
updated: "2026-06-18"
related:
  - component-guide.md
  - customization.md
  - ../../../Zero/docs/naming-conventions.md
sync-rule: "Shared with Zero theme — keep in sync"
---

# Naming Conventions — One Theme

Convenzioni di naming per mantenere coerenza e leggibilità del tema One in Laraxot PTVX.

**Note**: One theme shares naming conventions with Zero theme for consistency. This is an intentional design choice to allow easy migration between themes.

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
│   └── guest.blade.php (if applicable)
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
│   │   ├── cta/
│   │   └── sidebar/
│   └── ui/               # Basic UI components (optional)
└── mail/                 # Email templates (if applicable)
```

### CSS/Asset Files
**Note**: One theme intentionally has NO `package.json` or asset build. Projects extending One must wire their own Tailwind and CSS toolchain.

- **No Vite config**: Projects add their own
- **No PostCSS config**: Projects configure
- **No Tailwind config**: Scaffold from Zero or create custom

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
- **Prefix**: `theme-` for custom utilities (if using custom CSS)
- **Example**: `theme-nav-active`, `theme-card-shadow`, `theme-brand-color`
- **Location**: Project-provided CSS file or Tailwind config

```css
/* Your project's CSS file */
@layer components {
    .theme-nav-active {
        @apply font-bold border-b-2 border-primary;
    }
}
```

### Tailwind Color Usage
- **Primary**: `primary-*` (via Tailwind config in your project)
- **Secondary**: `secondary-*`
- **Neutral**: Use Tailwind defaults (`gray-*`)
- **Semantic**: Use `text-red-500` for errors, `text-green-500` for success

### No Built-in CSS Variables
One theme does NOT include custom CSS variables. Projects extend this pattern as needed:

```css
/* Project-level CSS (if needed) */
:root {
    --color-primary-500: #6366f1;
    --color-secondary-500: #0891b2;
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

## Filament Integration (Optional)

One theme does NOT include Filament resources. If you're integrating Filament:

### Resource Classes
- **Format**: `PascalCase.php`
- **Example**: `UserResource.php`, `PostResource.php`
- **Location**: `app/Filament/Resources/`
- **Namespace**: `App\Filament\Resources`

### Action Classes
- **Format**: `PascalCase` + `Action`
- **Example**: `PublishAction`, `DeleteAction`
- **Location**: Same directory or `app/Filament/Actions/`

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
- **Format**: `Title — One Theme` (em-dash separator)
- **Language**: Italian for main docs
- **Consistency**: Same format as Zero theme

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

## Integration with Zero Theme

One theme is a **skeleton** of Zero. If you're integrating Zero's naming conventions:

1. Copy naming patterns directly
2. Keep component names identical across themes
3. Adjust CSS prefixes only if needed
4. Maintain slot names consistently

This allows easy migration:
```blade
<!-- Works in both Zero and One -->
<x-navigation :menu="$menuItems" />
<x-nav-link href="/home" :active="request()->is('/')">Home</x-nav-link>
```

## PHP dominio (cross-repo)

Convenzioni backend condivise mono-repo (non Blade): vietato `persist*` su model dominio; action scheda su `SchedaContract`; getter `get*ByYear`. Vedi [domain-method-naming-no-persist](../../../../docs/wiki/patterns/domain-method-naming-no-persist.md) e [check-criteri-esclusione](../../../Modules/Ptv/docs/wiki/concepts/check-criteri-esclusione.md).

## References

- [Laravel Blade Documentation](https://laravel.com/docs/blade)
- [Tailwind CSS Naming](https://tailwindcss.com/docs)
- [PHP Naming Standards (PSR-12)](https://www.php-fig.org/psr/psr-12/)
- [Atomic Git Commits](https://www.conventionalcommits.org/)
- [Zero Theme Conventions](../../../Zero/docs/naming-conventions.md) (reference)
