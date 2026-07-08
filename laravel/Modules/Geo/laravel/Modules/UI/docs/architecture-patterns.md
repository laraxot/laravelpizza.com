---
title: Architecture Patterns — UI Module
type: architecture
module: UI
status: approved
tags: [architecture, components, ui-library, design-system]
updated: "2026-06-18"
related:
  - ./README.md
  - ../app
  - ../../Xot/docs/architecture-patterns.md
---

# Architecture Patterns — UI Module

> **Component Library & Design System.** Reusable Blade components, design tokens, and frontend patterns for consistent UI across Laraxot applications.

## Overview

The UI module provides:
- **Blade Components** (5+ core components)
- **Design System** (Bootstrap Italia / Design Comuni integration)
- **Datas/DTOs** (Type-safe configuration objects)
- **Contracts** (Interface definitions for theming)
- **Services** (Component rendering and theming)
- **Livewire Integration** (Dynamic component updates)
- **Icons & Branding** (SVG icons, brand assets)

## Architettura Principale

### 1. Component Architecture

**Base Component Pattern** — All UI components extend a base class:
```php
namespace Modules\UI\App\View\Components;

abstract class BaseComponent extends Component
{
    // Lifecycle hooks
    public function render(): string | View
    
    // Data preparation
    protected function prepareData(): array
    
    // State management
    public function getState(): array
}
```

**Component Categories**:

#### Core Blade Components (5 models reference)
- **Alert Component** (`<x-ui::alert />`)
  - Configurable severity (info, warning, danger, success)
  - Icon support, dismissible option
  - Theme-aware styling
  
- **Button Component** (`<x-ui::button />`)
  - Variants (primary, secondary, outline, ghost)
  - Sizes (sm, md, lg)
  - Icon integration
  - Loading states
  
- **Badge Component** (`<x-ui::badge />`)
  - Color variants
  - Icon badges
  - Dismissible option
  
- **Card Component** (`<x-ui::card />`)
  - Header/footer slots
  - Hover effects
  - Image integration
  
- **Modal Component** (`<x-ui::modal />`)
  - Responsive sizing
  - Header/footer/body slots
  - Action buttons

#### Advanced Components
- **Table Component** — Sortable, filterable tables
- **Form Components** — Input, select, checkbox, radio wrappers
- **Navigation** — Breadcrumbs, tabs, sidebars
- **Media** — Image gallery, lightbox, video player
- **Notification** — Toast, alerts, popovers
- **DataDisplay** — Lists, grids, timelines
- **Charts** — Chart.js integration components
- **Disabled Components** (documented in `disabled-components.md`)

### 2. Data Transfer Objects (DTOs)

**Component Configuration Datas**:
```php
namespace Modules\UI\App\Data;

// Alert configuration
class AlertData extends Data
{
    public function __construct(
        public string $type,           // info, warning, danger, success
        public string $title,
        public string $message,
        public ?bool $dismissible = true,
        public ?string $icon = null,
    ) {}
}

// Button configuration
class ButtonData extends Data
{
    public function __construct(
        public string $label,
        public string $variant = 'primary',     // primary, secondary, outline, ghost
        public ?string $href = null,
        public string $size = 'md',             // sm, md, lg
        public ?string $icon = null,
        public bool $loading = false,
        public bool $disabled = false,
    ) {}
}

// Card configuration
class CardData extends Data
{
    public function __construct(
        public string $title,
        public ?string $subtitle = null,
        public ?string $imageUrl = null,
        public array $actions = [],
        public bool $hoverable = false,
    ) {}
}
```

**Theme Configuration**:
```php
class ThemeData extends Data
{
    public function __construct(
        public string $name,            // 'bootstrap', 'tailwind', 'design-comuni'
        public array $colors,           // Color palette
        public array $typography,       // Font config
        public array $spacing,          // Spacing scale
        public array $breakpoints,      // Responsive breakpoints
    ) {}
}
```

### 3. Filament Integration

**UI Module Resources**:
- Minimal Filament resources (1 primary)
- Mostly used as dependency by other modules
- Configuration management via service provider

### 4. Contracts & Interfaces

**Component Contract**:
```php
namespace Modules\UI\App\Contracts;

interface Component
{
    public function render(): string | View;
    public function getData(): array;
}
```

**Theme Provider Contract**:
```php
interface ThemeProvider
{
    public function getTheme(): ThemeData;
    public function apply(ThemeData $theme): void;
}
```

**Component Factory Contract**:
```php
interface ComponentFactory
{
    public function create(string $name, array $config): Component;
}
```

### 5. Services Layer

**ComponentRenderingService**:
```php
class ComponentRenderingService
{
    // Render component with data
    public function render(string $componentName, array $data): string
    
    // Register custom component
    public function register(string $name, string $class): void
    
    // Get available components
    public function getAvailable(): Collection
}
```

**ThemeService**:
```php
class ThemeService
{
    // Get current theme
    public function current(): ThemeData
    
    // Switch theme
    public function switch(string $themeName): void
    
    // Get color from palette
    public function color(string $name): string
}
```

**IconService**:
```php
class IconService
{
    // Get icon SVG
    public function get(string $name): string
    
    // List available icons
    public function list(): array
    
    // Register custom icon
    public function register(string $name, string $svgPath): void
}
```

### 6. Design System Integration

**Bootstrap Italia Integration**:
```
UI Module
├── resources/
│   ├── css/
│   │   ├── bootstrap-italia.css
│   │   ├── theme-overrides.css
│   │   └── components.css
│   ├── js/
│   │   ├── bootstrap-italia.js
│   │   └── components.js
│   └── views/
│       └── components/           (5+ components)
├── app/
│   ├── Data/                     (Component configuration)
│   ├── Services/                 (Rendering, theming)
│   └── Contracts/                (Interfaces)
```

**Design Comuni Compliance**:
- Color palette alignment with Design Comuni
- Responsive grid system
- Typography hierarchy
- Spacing/sizing scales consistent with guidelines

### 7. Enums for Component Configuration

**Component Types**:
```php
enum ComponentType: string
{
    case Alert = 'alert';
    case Button = 'button';
    case Badge = 'badge';
    case Card = 'card';
    case Modal = 'modal';
    case Form = 'form';
    case Table = 'table';
}
```

**Color/Variant Enums**:
```php
enum ButtonVariant: string
{
    case Primary = 'primary';
    case Secondary = 'secondary';
    case Outline = 'outline';
    case Ghost = 'ghost';
}

enum AlertType: string
{
    case Info = 'info';
    case Warning = 'warning';
    case Danger = 'danger';
    case Success = 'success';
}
```

### 8. Livewire Component Integration

**Livewire Components** (where needed):
```php
class DynamicSelectComponent extends Component
{
    #[Reactive]
    public string $searchQuery = '';
    
    public Collection $options;
    
    #[Computed]
    public function filteredOptions(): Collection
    {
        return $this->options->filter(fn($o) => 
            str_contains(strtolower($o->label), strtolower($this->searchQuery))
        );
    }
    
    public function render(): View
    {
        return view('ui::components.dynamic-select');
    }
}
```

### 9. Icons & Branding

**Icon Management**:
```
resources/
├── icons/
│   ├── solid/              (SVG files)
│   ├── outline/            (SVG files)
│   └── brands/             (Brand icons)
├── images/
│   ├── logos/
│   └── illustrations/
└── fonts/
    └── custom-icons/       (Icon fonts, if needed)
```

### 10. Disabled Components Documentation

**[disabled-components.md](./disabled-components.md)** documents:
- Components no longer in use
- Reason for deprecation
- Migration path for users
- Replacement components
- Timeline for removal

## Component Relationships

```
BaseComponent (abstract)
├── AlertComponent
├── ButtonComponent
├── BadgeComponent
├── CardComponent
├── ModalComponent
├── FormComponent
│   ├── InputComponent
│   ├── SelectComponent
│   └── CheckboxComponent
├── TableComponent
└── ... (advanced components)

ThemeService ↔ ComponentRenderingService
    ↓
ThemeProvider (interface)
    ├── BootstrapItaliaProvider
    ├── DesignComuniProvider
    └── CustomProvider

IconService
    ├── FontAwesome icons
    ├── Bootstrap icons
    └── Custom icons
```

## Best Practices

### 1. Component Design
- **Single Responsibility** — Each component does one thing well
- **Composition** — Use slots for content, avoid complex nesting
- **Accessibility** — ARIA labels, keyboard navigation, color contrast
- **Responsive** — Mobile-first design, test on all breakpoints

### 2. Component Usage
```blade
<!-- Basic usage -->
<x-ui::alert type="info" title="Information" message="This is an alert" />

<!-- With slots -->
<x-ui::card title="Card Title">
    <x-slot name="body">
        Card content here
    </x-slot>
    <x-slot name="footer">
        <x-ui::button label="Close" />
    </x-slot>
</x-ui::card>
```

### 3. Theme Implementation
- Use `ThemeService` for dynamic colors
- CSS variables for theming (not inline styles)
- Support dark mode via theme variants
- Document color palette in wiki

### 4. Styling Approach
- **CSS-first** for performance
- Minimal JavaScript (Livewire only when necessary)
- Utility classes over custom CSS (Bootstrap/Tailwind)
- BEM naming for custom styles

### 5. Icon Usage
- Use SVG icons (scalable, customizable)
- Register icons via `IconService`
- Provide fallback text for all icons
- Document icon naming conventions

## Development Workflow

### Adding New Component
1. Create component class extending `BaseComponent`
2. Create Blade view in `resources/views/components/`
3. Create corresponding `Data` class
4. Add to `ComponentFactory`
5. Document with examples
6. Test accessibility
7. Update `disabled-components.md` if replacing old component

### Updating Theme
1. Update `ThemeData` and related Datas
2. Update CSS/SCSS in `resources/css/`
3. Test across all components
4. Document changes in CHANGELOG
5. Update wiki/architecture docs

## Backlinks & References

- **Root README**: [UI Module](./README.md)
- **Framework Base**: [Xot Architecture Patterns](../../Xot/docs/architecture-patterns.md)
- **Disabled Components**: [disabled-components.md](./disabled-components.md)
- **Architecture Overview**: [ARCHITECTURE.md](./ARCHITECTURE.md)
- **Index**: [INDEX.md](./INDEX.md)
- **Design System**: [DESIGN_COMUNI_IMPLEMENTATION.md](./DESIGN_COMUNI_IMPLEMENTATION.md)
- **Icon Integration**: [BRANDS_ICONS_INTEGRATION.md](./BRANDS_ICONS_INTEGRATION.md)

---

**Document Type**: Architecture Reference  
**Module**: UI  
**Last Updated**: 2026-06-18  
**Maintainers**: Development Team  
**Status**: Approved
