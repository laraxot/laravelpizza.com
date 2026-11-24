---
qmd: "README"
issues: []
discussions: []
title: "Cms Module Documentation"
type: documentation
tags: [module, documentation, cms, content-management]
created: 2026-07-14
updated: 2026-07-14
---

# Modulo Cms

## Overview

Il modulo **Cms** gestisce il sistema di content management per la piattaforma Laraxot. Fornisce un sistema flessibile basato su Filament Builder Blocks per creare, modificare e pubblicare contenuti dinamici, incluse pagine, sezioni e blocchi di contenuto.

## Scopo

- Gestione completa di pagine e contenuti dinamici
- Sistema modulare di blocchi (Builder Blocks) per composizione pagine
- Storage JSON ottimizzato per persistenza contenuti
- Interfaccia amministrativa Filament completamente integrata
- Supporto multi-lingua per tutti i contenuti

## Funzionalità Principali

- **Page Management**: Creazione, modifica e pubblicazione pagine
- **Block System**: Sistema modulare blocchi per composizione dinamica
- **Content Builder**: Interfaccia Filament per composizione pagine
- **Folio Integration**: File-based routing per pagine pubbliche
- **Blade Components**: Componenti riutilizzabili per rendering frontend
- **JSON Storage**: Persistenza efficiente contenuti strutturati
- **Multi-language**: Supporto i18n completo per tutti i contenuti

## Struttura del Modulo

```
Modules/Cms/
├── app/
│   ├── Models/
│   │   ├── Page.php              # Page model
│   │   ├── Section.php           # Page section
│   │   └── Block.php             # Content block
│   ├── Services/
│   │   ├── PageService.php
│   │   ├── BlockService.php
│   │   └── ContentService.php
│   ├── Actions/
│   │   ├── PublishPageAction.php
│   │   └── BuildPageAction.php
│   ├── Filament/
│   │   ├── Resources/
│   │   │   └── PageResource.php
│   │   └── Fields/
│   │       └── PageContentBuilder.php
│   ├── Http/
│   │   └── Controllers/
│   └── Traits/
├── database/
│   ├── migrations/
│   ├── factories/
│   └── seeders/
├── resources/
│   ├── views/
│   │   └── components/
│   └── lang/
├── tests/
├── docs/
│   ├── README.md
│   ├── architecture.md
│   └── block-system.md
├── module.json
└── composer.json
```

## Componenti Principali

| Classe | Scopo | Extends |
|--------|-------|---------|
| `Page` | Modello pagina principale | `XotBaseModel` |
| `Section` | Sezione dentro pagina | `XotBaseModel` |
| `Block` | Blocco contenuto singolo | `XotBaseModel` |
| `PageResource` | Amministrazione Filament | `XotBaseResource` |
| `PageContentBuilder` | Builder Filament per composizione | - |
| `PageService` | Logica gestione pagine | - |
| `ContentService` | Logica gestione contenuti | - |

## Utilizzo Comune

### Scenario 1: Creare una Pagina

```php
use Modules\Cms\Actions\CreatePageAction;

$page = CreatePageAction::execute([
    'title' => 'Homepage',
    'slug' => 'home',
    'status' => 'published',
    'content' => [
        'blocks' => [
            ['type' => 'hero', 'data' => [...] ],
            ['type' => 'text', 'data' => [...] ],
        ]
    ],
]);
```

### Scenario 2: Aggiungere Blocchi

```php
use Modules\Cms\Models\Page;

$page = Page::find(1);
$page->addBlock([
    'type' => 'gallery',
    'data' => ['images' => [...] ],
]);
```

### Scenario 3: Renderizzare Pagina Frontend

```blade
@foreach ($page->blocks as $block)
    @switch($block->type)
        @case('hero')
            <x-cms::blocks.hero :data="$block->data" />
            @break
        @case('text')
            <x-cms::blocks.text :data="$block->data" />
            @break
    @endswitch
@endforeach
```

## Configuration

### Block Types

Definire tipi di blocchi supportati in `laravel/config/local/cms/blocks.php`:

```php
return [
    'types' => [
        'hero' => [
            'label' => 'Hero Section',
            'fields' => ['title', 'subtitle', 'image'],
        ],
        'text' => [
            'label' => 'Text Block',
            'fields' => ['content'],
        ],
        'gallery' => [
            'label' => 'Gallery',
            'fields' => ['images'],
        ],
    ],
];
```

### Content Storage

Contenuti immagazzinati come JSON strutturato:

```json
{
  "id": 1,
  "title": "Homepage",
  "slug": "home",
  "status": "published",
  "blocks": [
    {
      "type": "hero",
      "data": {
        "title": "Welcome",
        "subtitle": "Laraxot CMS"
      }
    }
  ]
}
```

## Testing

```bash
# Run Cms module tests
./vendor/bin/pest Modules/Cms/tests

# Run specific test category
./vendor/bin/pest Modules/Cms/tests/Feature/PageCreationTest.php

# With coverage
./vendor/bin/pest Modules/Cms/tests --coverage
```

## Quality Standards

- **PHPStan**: Level 10 (zero baseline)
- **Test Coverage**: Minimum 80%
- **Code Style**: PSR-12 via Pint

Run locally:
```bash
php -d memory_limit=-1 ./vendor/bin/phpstan analyse --level=max Modules/Cms
./vendor/bin/pest Modules/Cms/tests --coverage
./vendor/bin/pint Modules/Cms
```

## Documentation Index

- [Architecture Details](./architecture.md) — System design and patterns
- [Block System](./block-system.md) — Creating and using blocks
- [Frontend Rendering](./frontend-rendering.md) — Display components
- [Folio Integration](./folio-integration.md) — File-based routing
- [Troubleshooting](./troubleshooting.md) — Common issues and solutions

### Head SEO condiviso

- [Architettura Seo Head](./seo-head-architecture.md)
- [Piano Cms Head per Sixteen](./bmad/head-component-adoption-plan.md)
- [Story di migrazione](./stories/head-sixteen-layout-migration.story.md)
- [Story di chiusura parita' e D-7](./stories/head-sixteen-parity-closeout.story.md)
- [Discussion di coordinamento #93](https://github.com/laraxot/theme_sixteen_fila5/discussions/93)

## Dipendenze / Moduli Correlati

- [Xot - Framework Base](../../Xot/docs/README.md) — Always dependency
- [UI - Components](../../UI/docs/README.md) — For UI components library
- [Lang - Translations](../../Lang/docs/README.md) — For i18n support
- [Media - File Management](../../Media/docs/README.md) — For image/file handling

## Documenti Correlati

- [PHPStan Configuration](../../../phpstan.neon)

## Regole Critiche

1. **Always extend Xot base classes** — Never extend Laravel/Filament directly
2. **Use namespace `Modules\Cms`** — Never `app\Cms`
3. **Strict typing** — `declare(strict_types=1);` in all files
4. **Relative links only** — All doc links must be relative paths
5. **No placeholder text** — Remove PROJECT_NAME, [CHANGE_ME], etc
6. **JSON validation** — Validate block data structure before storage
7. **No merge conflict markers** — Ensure clean commits

## Standard Rules & Workflow

- [[BMAD Method](../../../../docs/wiki/concepts/bmad-method.md)]
- [[Context Engineering](../../../../docs/wiki/concepts/context-engineering.md)]
- [[LLM Wiki Governance](../../../../docs/wiki/concepts/llm-wiki-governance.md)]

---

**Status**: ✅ Production  
**Last Updated**: 2026-07-14  
**Requirements**: PHP 8.3+, Laravel 12, Filament 5  
**PHPStan Level**: 10 (Target)

**Note**: Documentation previously had duplications and merge conflicts. This version consolidates to single source of truth.
