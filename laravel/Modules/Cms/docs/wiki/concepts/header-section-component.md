---
title: "Header Section Component Architecture"
type: concept
sources: ["laravel/Modules/Cms/app/View/Components/Section.php", "laravel/config/local/fixcity/database/content/sections/header.json"]
confidence: high
created: 2026-05-04
updated: 2026-05-04
tags: [header, section-component, cms, blade, json-driven, design-comuni]
related:
  - ../../../docs/wiki/concepts/blade-component-extraction-governance.md
  - ../../../laravel/Themes/Sixteen/docs/wiki/concepts/sixteen-header-composition-rule.md
  - ../../../docs/wiki/concepts/design-comuni-header-auth-state.md
---

# Header Section Component Architecture

## Overview

The header is rendered via `<x-section slug="header" />` which resolves to:
- **Component**: `Modules\Cms\View\Components\Section`
- **Blade View**: `Themes\Sixteen\resources\views\components\sections\header\v1.blade.php`
- **Data Source**: `config/local/fixcity/database/content/sections/header.json`

## Section Component Flow

```php
// 1. Blade directive
<x-section slug="header" />

// 2. Section.php __construct()
$this->blocks = SectionModel::getBlocksBySlug($this->slug);

// 3. Section.php render()
$view = 'pub_theme::components.sections.'.$this->slug.'.'.$this->tpl;
// Resolves to: pub_theme::components.sections.header.v1

// 4. View receives $blocks and $section
return view($view, ['blocks' => $this->blocks, 'section' => $this]);
```

## JSON Configuration Structure

```json
{
  "sections": {
    "primary_nav": {
      "items": [
        {
          "id": "amministrazione",
          "label": "Amministrazione",
          "url": "/it/amministrazione",
          "nav_group": "primary",
          "order": 10,
          "enabled": true,
          "visible": true,
          "active_patterns": ["it/amministrazione*"]
        }
      ]
    }
  }
}
```

## Blade Integration

In `v1.blade.php`:
```php
$headerNavJsonPath = \Modules\Tenant\Services\TenantService::filePath('database/content/sections/header.json');
$headerNavConfig = \Illuminate\Support\Facades\File::json($headerNavJsonPath);
$headerNavItems = array_values(array_filter($headerNavConfig['sections']['primary_nav']['items'] ?? [], 
    fn ($i) => ($i['nav_group'] ?? 'primary') === 'primary' && ($i['enabled'] ?? true)
));
```

## Design Philosophy

1. **Single Source of Truth**: `header.json` owns navigation structure
2. **Admin-Managed**: Future Filament Builder interface will edit JSON
3. **No Hardcoding**: Navigation items NOT in Blade — only in JSON
4. **DRY/KISS**: `v1.blade.php` is orchestrator, partials under `partials/`
5. **Translation-Owned**: Labels in JSON, translation via LangServiceProvider

## Filament Admin Interface (Planned)

Using Filament v5 Builder: https://filamentphp.com/docs/5.x/forms/builder#builder

```php
Builder::make('nav_items')
    ->blocks([
        Block::make('nav_item')
            ->schema([
                TextInput::make('label')->translatable(),
                TextInput::make('url'),
                Select::make('nav_group')->options(['primary', 'secondary']),
                TextInput::make('order')->numeric(),
                Toggle::make('enabled'),
                Toggle::make('visible'),
            ])
    ])
```

## Related Files

- Component: `laravel/Modules/Cms/app/View/Components/Section.php`
- Blade SSoT: `laravel/Themes/Sixteen/resources/views/components/sections/header/v1.blade.php`
- Partials: `laravel/Themes/Sixteen/resources/views/components/sections/header/partials/`
- JSON Config: `laravel/config/local/fixcity/database/content/sections/header.json`
- Translations: `laravel/Themes/Sixteen/lang/{it,en}/header.php`
