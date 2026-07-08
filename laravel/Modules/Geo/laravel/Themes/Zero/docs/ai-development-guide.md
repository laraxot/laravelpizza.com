# AI-Assisted Development Guide - Zero Theme

## Overview

This guide explains how to leverage AI assistants (Claude Code, Cursor, Windsurf) when developing with the **Zero Theme** in the healthcare_app Fila4 Mono project.

Zero is a flexible, modern Laravel theme system built on Filament 5, Livewire 4, and Volt. Understanding how to configure AI assistants for theme development ensures faster, more consistent development.

## Why AI Configuration Matters for Theme Development

### Theme-Specific Patterns

The Zero theme has unique conventions that differ from standard Laravel/Filament:

1. **Blade Component Organization**: Components in `Resources/views/components/`
2. **Livewire Volt Pages**: Functional Livewire pages in `Resources/views/pages/`
3. **Layout System**: Multi-purpose layouts (guest, app, admin, email)
4. **Theme Configuration**: Via `theme.json` and config files
5. **Asset Management**: Vite integration for theme-specific assets

**Without proper AI configuration**, assistants will:
- Create components in wrong directories ❌
- Use incorrect namespace patterns ❌
- Not follow theme naming conventions ❌
- Miss theme configuration requirements ❌

**With proper AI configuration**, assistants will:
- Generate components in correct locations ✅
- Follow Zero theme patterns ✅
- Use proper Blade/Livewire syntax ✅
- Respect theme architecture ✅

## AI Configuration Files for Zero Theme

### Project-Level Instructions

The project root contains shared instructions that include Zero theme patterns:

**Location**: `CLAUDE.md`

**Zero Theme Section**: Documents theme structure, best practices, and integration patterns.

### Cursor Rules for Themes

Recommended Cursor rules for Zero theme development:

**Location**: `.cursor/rules/theme-zero.md` (to be created)

```markdown
# Zero Theme Development Rules

## Component Creation

When creating Blade components for Zero theme:
- Location: `Themes/Zero/Resources/views/components/`
- Namespace: `<x-theme::component-name />`
- Follow atomic design: atoms, molecules, organisms

## Livewire Volt Pages

Per Volt pages class-based (default):
- Location: `Themes/Zero/Resources/views/pages/`
- Use `<?php use Livewire\Volt\Component; new class extends Component { /* stati e metodi */ }; ?>`
- Keep logic minimal, delegate to actions

## Layouts

Available layouts:
- `theme::layouts.guest` - Public pages
- `theme::layouts.app` - Authenticated users
- `theme::layouts.admin` - Admin panel
- `theme::layouts.mail` - Email templates

## Asset Organization

Theme assets in `Resources/`:
- CSS: `Resources/css/`
- JS: `Resources/js/`
- Images: `Resources/images/`
- Fonts: `Resources/fonts/`
```

### Windsurf Rules for Themes

**Location**: `.windsurf/rules/theme-zero.mdc` (to be created)

```markdown
---
title: Zero Theme Development
globs: ["Themes/Zero/**"]
---

# Zero Theme Development

## File Structure

```
Themes/Zero/
├── Resources/
│   ├── views/
│   │   ├── components/  # Blade components
│   │   ├── pages/       # Volt pages
│   │   └── layouts/     # Layouts
│   ├── css/             # Stylesheets
│   └── js/              # JavaScript
└── Config/
    └── theme.json       # Theme configuration
```

## Component Naming

- Use kebab-case: `button-primary.blade.php`
- Prefix custom components: `theme::components.button-primary`
- Follow atomic design principles

## Best Practices

- Keep Volt pages focused and simple
- Use Tailwind CSS utility classes
- Leverage Filament components where possible
- Follow WCAG 2.1 AA accessibility standards
```

### Claude Code Memories

Add theme-specific patterns to `.claude/` configuration:

**Location**: `.claude/instructions.md` (add section)

```markdown
## Zero Theme Development

### Directory Structure
- Blade Components: `Themes/Zero/Resources/views/components/`
- Volt Pages: `Themes/Zero/Resources/views/pages/`
- Layouts: `Themes/Zero/Resources/views/layouts/`
- Assets: `Themes/Zero/Resources/{css,js,images,fonts}/`

### Component Usage
```blade
{{-- Standard Blade component --}}
<x-theme::components.button-primary>
    Click Me
</x-theme::components.button-primary>

{{-- Livewire Volt component --}}
@volt('pages.dashboard')
<div>
    <!-- Component logic -->
</div>
@endvolt
```

### Asset Compilation
```bash
npm run build  # Compiles to ../public_html/themes/Zero/
```
```

## Theme Development Workflows with AI

### Creating a New Blade Component

**AI-Assisted Workflow**:

**Step 1**: Prompt AI with context
```
Create a notification badge Blade component for the Zero theme.
Location: Themes/Zero/Resources/views/components/atoms/
Follow atomic design principles.
Use Tailwind CSS for styling.
```

**Step 2**: AI generates component
```blade
{{-- Themes/Zero/Resources/views/components/atoms/notification-badge.blade.php --}}
@props(['count' => 0, 'variant' => 'primary'])

@php
$classes = match($variant) {
    'primary' => 'bg-primary-500 text-white',
    'success' => 'bg-green-500 text-white',
    'warning' => 'bg-yellow-500 text-white',
    'danger' => 'bg-red-500 text-white',
    default => 'bg-gray-500 text-white',
};
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none rounded-full {$classes}"]) }}>
    {{ $count }}
</span>
```

**Step 3**: Verify AI output
- ✅ Correct location
- ✅ Atomic design (atoms folder)
- ✅ Tailwind CSS usage
- ✅ Props documentation
- ✅ Variant support

### Creating a Volt Page

**AI-Assisted Workflow**:

**Prompt**:
```
Create a Volt page for user profile in the Zero theme.
Use functional API with state() and computed().
Include form for name, email, and avatar upload.
Location: Themes/Zero/Resources/views/pages/profile.blade.php
```

**AI Output**:
```php
<?php

use function Livewire\Volt\{state, computed, mount};
use Livewire\WithFileUploads;
use Livewire\Volt\Component;

new class extends Component {
    use WithFileUploads;

    public string $name = '';
    public string $email = '';
    public $avatar;

    public function mount(): void
    {
        $user = auth()->user();
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function save(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.auth()->id(),
            'avatar' => 'nullable|image|max:1024',
        ]);

        // Update user via action
        // UpdateUserProfileAction::execute(...)
    }
}; ?>

<x-theme::layouts.app>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form wire:submit="save">
                <!-- Form fields -->
            </form>
        </div>
    </div>
</x-theme::layouts.app>
```

### Extending Layouts

**Prompt**:
```
Add a sidebar section to the app layout in Zero theme.
Sidebar should be collapsible on mobile.
Use Alpine.js for toggle functionality.
```

**AI generates updated layout with**:
- Responsive sidebar
- Alpine.js toggle
- Proper slot management
- Mobile-first design

## Critical Rules for Theme Development

### Rule 1: Component Location

**Rule**: All theme components MUST be in `Themes/Zero/Resources/views/components/`

```php
// ❌ WRONG - In module
Modules/UI/Resources/views/components/button.blade.php

// ✅ CORRECT - In theme
Themes/Zero/Resources/views/components/button.blade.php
```

**AI Configuration**:
```markdown
# .cursor/rules/component-location.md

CRITICAL: Theme components must be in Themes/Zero/Resources/views/components/

Never create components in Modules for theme-specific UI.
```

### Rule 2: Volt Functional API

**Rule**: Use Volt functional API for simple pages, class-based for complex logic.

```php
// ✅ CORRECT - Functional for simple page
<?php
use function Livewire\Volt\{state};

state(['count' => 0]);
?>

<div>
    <span>{{ $count }}</span>
    <button wire:click="$set('count', $count + 1)">+</button>
</div>

// ✅ CORRECT - Class for complex logic
<?php
use Livewire\Volt\Component;

new class extends Component {
    // Complex state management
    // Multiple methods
    // Lifecycle hooks
}; ?>
```

### Rule 3: Layout Selection

**Rule**: Choose appropriate layout based on context.

| Context | Layout | Usage |
|---------|--------|-------|
| Public pages (login, register) | `theme::layouts.guest` | Marketing, auth |
| Authenticated users | `theme::layouts.app` | User dashboard, profile |
| Admin panel | `theme::layouts.admin` | Admin interface (uses Filament) |
| Emails | `theme::layouts.mail` | Email templates |

**AI Configuration**:
```markdown
# .cursor/memories/theme-layouts.md

Remember layout selection rules:
- guest layout: unauthenticated users
- app layout: authenticated users
- admin layout: admin panel (Filament integrated)
- mail layout: email templates
```

### Rule 4: Asset Compilation

**Rule**: Theme assets compile to `public_html/themes/Zero/`

```bash
# ✅ CORRECT workflow
cd laravel
npm run build  # or npm run dev

# Assets compiled to:
# ../public_html/themes/Zero/css/
# ../public_html/themes/Zero/js/
```

**AI Configuration**:
```markdown
# .windsurf/rules/theme-assets.mdc

Theme assets compile to ../public_html/themes/Zero/

When referencing assets in views:
- Use asset() helper
- Path: themes/Zero/css/app.css
- Never hardcode absolute paths
```

### Rule 5: Accessibility Standards

**Rule**: All theme components must meet WCAG 2.1 AA standards.

**AI Configuration**:
```markdown
# .cursor/rules/accessibility.md

All Zero theme components must be accessible:

- Proper semantic HTML (nav, main, aside, article)
- ARIA labels where needed
- Keyboard navigation support
- Sufficient color contrast (4.5:1 minimum)
- Focus indicators visible
- Alt text for images
- Form labels associated with inputs
```

## Testing AI Configuration for Themes

### Verification Prompts

After configuring AI assistants, test with these prompts:

**Test 1: Component Creation**
```
Prompt: "Create a modal component for Zero theme"
Expected: Component in Themes/Zero/Resources/views/components/
Expected: Uses Tailwind CSS
Expected: Includes Alpine.js for toggle
Expected: Accessible (ARIA attributes)
```

**Test 2: Volt Page**
```
Prompt: "Create a settings page using Volt in Zero theme"
Expected: File in Themes/Zero/Resources/views/pages/
Expected: Uses Volt functional API
Expected: Extends theme::layouts.app
Expected: Includes form validation
```

**Test 3: Layout Modification**
```
Prompt: "Add a notification dropdown to the app layout"
Expected: Modifies Themes/Zero/Resources/views/layouts/app.blade.php
Expected: Uses theme components
Expected: Livewire integration
Expected: Mobile responsive
```

**Test 4: Asset Reference**
```
Prompt: "Add custom CSS for dark mode toggle"
Expected: Creates file in Themes/Zero/Resources/css/
Expected: References in vite.config.js
Expected: Uses asset() helper in views
Expected: Compiles to ../public_html/themes/Zero/
```

## Common AI Mistakes and Fixes

### Mistake 1: Wrong Component Location

**AI Generates**:
```php
// ❌ WRONG
Modules/UI/Resources/views/components/theme-button.blade.php
```

**Fix Configuration**:

`.cursor/rules/strict-theme-location.md`:
```markdown
# CRITICAL: Component Location Rule

BEFORE creating ANY component:
1. Ask: Is this theme-specific or module-specific?
2. If theme-specific → Themes/Zero/Resources/views/components/
3. If module-specific → Modules/{Module}/Resources/views/components/

NEVER mix theme and module components.
```

### Mistake 2: Incorrect Layout Extension

**AI Generates**:
```blade
{{-- ❌ WRONG --}}
@extends('layouts.app')
```

**Fix Configuration**:

`.cursor/memories/theme-layout-syntax.md`:
```markdown
# Zero Theme Layout Syntax

NEVER use @extends('layouts.app')

ALWAYS use component syntax:
<x-theme::layouts.app>
    <!-- Content -->
</x-theme::layouts.app>

Available layouts:
- theme::layouts.guest
- theme::layouts.app
- theme::layouts.admin
- theme::layouts.mail
```

### Mistake 3: Hardcoded Asset Paths

**AI Generates**:
```blade
{{-- ❌ WRONG --}}
<link href="/public_html/themes/Zero/css/app.css" rel="stylesheet">
```

**Fix Configuration**:

`.windsurf/rules/asset-helpers.mdc`:
```markdown
# Asset Path Helpers

NEVER hardcode asset paths.

ALWAYS use asset() helper:
```blade
<link href="{{ asset('themes/Zero/css/app.css') }}" rel="stylesheet">
<img src="{{ asset('themes/Zero/images/logo.png') }}" alt="Logo">
<script src="{{ asset('themes/Zero/js/app.js') }}"></script>
```

Assets compile to ../public_html/themes/Zero/ (not public/)
```

## Advanced: Theme-Specific MCP Tools

### Custom MCP Server for Themes

Consider creating a custom MCP server for Zero theme operations:

**Capabilities**:
- List all theme components
- Analyze component dependencies
- Generate component documentation
- Validate accessibility compliance
- Check asset compilation

**Configuration**: `.claude/mcp.json`, `.cursor/mcp.json`, `.windsurf/mcp.json`

```json
{
  "mcpServers": {
    "zero-theme": {
      "command": "npx",
      "args": ["-y", "zero-theme-mcp-server"],
      "env": {
        "THEME_PATH": "Themes/Zero"
      }
    }
  }
}
```

## Best Practices Summary

### Do's ✅

1. **Place components in correct directories**
   - Theme-specific → `Themes/Zero/Resources/views/components/`
   - Shared → Consider creating module instead

2. **Use appropriate layouts**
   - Choose based on authentication and context
   - Component syntax, not @extends

3. **Follow atomic design**
   - atoms/molecules/organisms/templates
   - Keeps components focused and reusable

4. **Leverage Filament components**
   - Don't reinvent the wheel
   - Extend Filament where possible

5. **Write accessible code**
   - Semantic HTML
   - ARIA attributes
   - Keyboard navigation
   - Color contrast

6. **Use Volt appropriately**
   - Functional for simple pages
   - Class-based for complex logic

### Don'ts ❌

1. **Don't mix theme and module components**
   - Keep separation clear
   - Theme = presentation
   - Module = business logic

2. **Don't hardcode asset paths**
   - Always use asset() helper
   - Relative to public_html/

3. **Don't skip accessibility**
   - Every component must be accessible
   - Use automated testing tools

4. **Don't create giant components**
   - Break down into smaller pieces
   - Follow single responsibility

5. **Don't duplicate Filament components**
   - Use Filament where possible
   - Only customize when necessary

## Resources

### Documentation

- **Main AI/IDE Guide**: `/docs/ai-ide-configurations.md`
- **Theme Documentation**: `laravel/Themes/Zero/docs/README.md`
- **Zero Architecture**: `laravel/Themes/Zero/docs/architecture.md`
- **Zero Components**: `laravel/Themes/Zero/docs/components.md`

### External Resources

- [Livewire Volt](https://livewire.laravel.com/docs/volt)
- [Filament v5 Themes](https://filamentphp.com/docs/5.x/themes)
- [Tailwind CSS](https://tailwindcss.com/docs)
- [Alpine.js](https://alpinejs.dev/)
- [WCAG 2.1 Guidelines](https://www.w3.org/WAI/WCAG21/quickref/)

### Project-Specific

- **CLAUDE.md**: Root instructions
- **Cursor Rules**: `.cursor/rules/theme-*.md`
- **Windsurf Rules**: `.windsurf/rules/theme-*.mdc`
- **Claude Memories**: `.claude/` folder

## Maintenance

### When Theme Structure Changes

**Checklist**:
1. [ ] Update `CLAUDE.md` with new patterns
2. [ ] Update `.cursor/rules/theme-*.md` files
3. [ ] Update `.windsurf/rules/theme-*.mdc` files
4. [ ] Add memories to `.cursor/memories/`
5. [ ] Update this documentation
6. [ ] Test AI assistants with new patterns

### When Adding New Layout

**Steps**:
1. Create layout in `Themes/Zero/Resources/views/layouts/`
2. Document in `Themes/Zero/docs/layouts.md`
3. Add to AI configuration files
4. Update layout selection rules
5. Create example usage
6. Test with AI assistants

### When Creating New Component Type

**Steps**:
1. Document atomic design level (atom/molecule/organism)
2. Create in appropriate directory
3. Add examples to `Themes/Zero/docs/components.md`
4. Update AI rules with new pattern
5. Create test cases
6. Verify AI assistant generates correctly

---

**Version**: 1.0
**Last Updated**: December 23, 2025
**Theme**: Zero
**Maintainer**: healthcare_app Team

*This guide is part of the healthcare_app documentation standard for AI-assisted development.*
