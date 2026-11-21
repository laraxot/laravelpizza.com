---
title: "README"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "README"
issues: []
discussions: []
---

# Documentation

This directory contains documentation for the module.

## Structure

- **architecture.md** - Module architecture and design patterns
- **README.md** - This file

## Guidelines

- Gestione file traduzioni Laravel (.php e .json)
- Editor Filament per traduzioni multi-lingua
- Sincronizzazione traduzioni tra lingue
- Helper per traduzioni dinamiche
- Support per traduzioni modulo-specifiche
- Caching traduzioni per performance

## Funzionalità Principali

- **Translation File Management**: Leggi/scrivi file traduzioni PHP e JSON
- **Translation Editor**: Filament UI per edit traduzioni in real-time
- **Language Sync**: Sincronizza chiavi nuove tra lingue
- **Dynamic Translations**: Runtime translation lookup e fallback
- **Module Translations**: Traduzioni specifiche per ogni modulo
- **Translation Publishing**: Publish traduzioni da moduli a Laravel lang/
- **Translator Adapter**: Wrapper attorno translator di Laravel

## Struttura del Modulo

```
Modules/Lang/
├── app/
│   ├── Actions/
│   │   ├── ReadTranslationFileAction.php
│   │   ├── WriteTranslationFileAction.php
│   │   ├── SyncTranslationsAction.php
│   │   ├── PublishTranslationAction.php
│   │   └── GetAllTranslationAction.php
│   ├── Services/
│   │   └── TranslationService.php
│   ├── Adapters/
│   │   └── TranslatorAdapter.php
│   ├── Datas/
│   │   ├── TranslationData.php
│   │   └── LangData.php
│   ├── Casts/
│   │   └── LangField.php
│   ├── Filament/
│   │   └── Resources/
│   │       ├── TranslationFileResource.php
│   │       └── Pages/
│   └── Models/
│       └── BaseModelLang.php
├── database/
│   ├── migrations/
│   ├── factories/
│   └── seeders/
├── resources/
│   ├── lang/
│   │   ├── en/
│   │   ├── it/
│   │   └── ...
│   └── views/
├── tests/
├── docs/
│   └── README.md
├── module.json
└── composer.json
```

## Componenti Principali

| Classe | Scopo | Tipo |
|--------|-------|------|
| `ReadTranslationFileAction` | Leggi file traduzioni | Action |
| `WriteTranslationFileAction` | Scrivi file traduzioni | Action |
| `SyncTranslationsAction` | Sincronizza tra lingue | Action |
| `PublishTranslationAction` | Publish traduzioni | Action |
| `TranslationService` | Logica traduzioni | Service |
| `TranslatorAdapter` | Wrapper translator Laravel | Adapter |

## Trait Disponibili

| Trait | Scopo | Utilizzo |
|-------|-------|----------|
| `Modules\Lang\Traits\HasTranslator` | Helper translation lookup | Qualsiasi class |

**Utilizzo**:
```php
use Modules\Lang\Traits\HasTranslator;

class User extends Model
{
    use HasTranslator;
    
    public function greetingMessage(): string
    {
        return $this->trans('user.greeting', ['name' => $this->name]);
    }
}
```

## Utilizzo Comune

### Scenario 1: Leggere Traduzioni da File

```php
use Modules\Lang\Actions\ReadTranslationFileAction;

$translations = ReadTranslationFileAction::execute([
    'file' => 'user',
    'language' => 'en',
    'module' => 'User', // opzionale
]);

// Result: array associativo chiavi => traduzioni
echo $translations['welcome']; // "Welcome to the app"
```

### Scenario 2: Scrivere Traduzioni

```php
use Modules\Lang\Actions\WriteTranslationFileAction;

WriteTranslationFileAction::execute([
    'file' => 'user',
    'language' => 'it',
    'content' => [
        'welcome' => 'Benvenuto nell\'app',
        'goodbye' => 'Arrivederci',
    ],
    'module' => 'User', // opzionale
]);
```

### Scenario 3: Sincronizzare Traduzioni

```php
use Modules\Lang\Actions\SyncTranslationsAction;

SyncTranslationsAction::execute([
    'file' => 'user',
    'source_language' => 'en',
    'target_languages' => ['it', 'de', 'fr'],
    'missing_keys_only' => true, // solo chiavi nuove
]);
```

### Scenario 4: Usare Translator Helper

```php
$message = __('user.welcome', ['name' => 'Mario'], 'it');

// Result: "Benvenuto Mario" (se esiste traduzione it)
//         "Welcome Mario" (fallback a English)
```

### Scenario 5: Form Input Traduzioni

```php
use Modules\Lang\Filament\Resources\TranslationFileResource;

// Filament resource automatico per edit traduzioni
// UI: dropdown per lingua + form editor per valori
```

## Configuration

### Language Configuration

Configurare lingue in `laravel/config/local/lang/config.php`:

```php
return [
    'default_language' => 'en',
    
    'supported_languages' => [
        'en' => 'English',
        'it' => 'Italiano',
        'de' => 'Deutsch',
        'fr' => 'Français',
    ],
    
    'paths' => [
        'resources' => resource_path('lang'),
        'modules' => base_path('Modules/*/resources/lang'),
    ],
    
    'cache_translations' => true,
    'cache_ttl' => 3600, // 1 hour
];
```

### Translation File Structure

File traduzioni PHP (standard Laravel):

```php
// resources/lang/en/user.php
return [
    'welcome' => 'Welcome :name',
    'goodbye' => 'Goodbye',
    'role' => [
        'admin' => 'Administrator',
        'user' => 'Regular User',
    ],
];
```

File traduzioni JSON:

```json
{
    "Welcome": "Welcome",
    "Hello {name}": "Hello {name}",
    "user.profile": "User Profile"
}
```

## Filament Translation Editor

### Translation File Resource

Filament resource per edit traduzioni in UI:

```php
TranslationFileResource::class
// Features:
// - List traduzioni files
// - Edit traduzioni per lingua
// - Sincronizzazione missing keys
// - Preview in context
// - Bulk export/import
```

### Usage

```bash
# Accedere Filament admin
/admin/translations

# Edit file traduzioni
# - Seleziona lingua
# - Modifica stringhe
# - Save (auto-write file)
```

## Helper Functions

### trans() Helper Extended

```php
// Standard Laravel
$text = trans('user.welcome', ['name' => 'Mario']);

// With fallback language
$text = trans('user.greeting', ['lang' => 'it'], 'Hello');

// Check translation exists
if (trans_has('user.welcome')) { ... }
```

### Module Translations

```php
// Traduzioni specifiche modulo
$text = trans('User::messages.welcome');

// Load modulo namespace
trans()->addJsonPath(module_path('User/resources/lang'));
```

## Testing

```bash
# Run Lang module tests
./vendor/bin/pest Modules/Lang/tests

# Run translation tests
./vendor/bin/pest Modules/Lang/tests/Feature/TranslationSyncTest.php

# With coverage
./vendor/bin/pest Modules/Lang/tests --coverage
```

## Quality Standards

- **PHPStan**: Level 10 (zero baseline)
- **Test Coverage**: Minimum 80%
- **Code Style**: PSR-12 via Pint

Run locally:
```bash
php -d memory_limit=-1 ./vendor/bin/phpstan analyse --level=max Modules/Lang
./vendor/bin/pest Modules/Lang/tests --coverage
./vendor/bin/pint Modules/Lang
```

## Design Principles

### Single Source of Truth

- Translations stored in single canonical location
- Sync from source (English) to other languages
- Version control translation files

### Lazy Loading

- Cache translations in production
- Reload on-demand for admin changes
- Clear cache on translation publish

### Module Isolation

- Each module has its own translation files
- Lang module publishes to Laravel lang/
- No duplication across modules

## Dipendenze / Moduli Correlati

- [Xot - Framework Base](../../Xot/docs/README.md) — Always dependency
- [User - Authentication](../../User/docs/README.md) — For user-facing strings
- [Cms - Content](../../Cms/docs/README.md) — For content translations
- [Notify - Notifications](../../Notify/docs/README.md) — For email translations

## Documenti Correlati

- [PHPStan Configuration](../../../phpstan.neon)

## Regole Critiche

1. **Always extend Xot base classes** — Never extend Laravel/Filament directly
2. **Use namespace `Modules\Lang`** — Never `app\Lang`
3. **Strict typing** — `declare(strict_types=1);` in all files
4. **One source of truth** — Store translations centrally, not scattered
5. **Cache translations** — Use Laravel cache for performance
6. **Publish before deploy** — Publish translations to resources/lang/
7. **No Log statements** — Let Laravel handle exceptions

## Standard Rules & Workflow

- [[BMAD Method](../../../../docs/wiki/concepts/bmad-method.md)]
- [[Context Engineering](../../../../docs/wiki/concepts/context-engineering.md)]
- [[LLM Wiki Governance](../../../../docs/wiki/concepts/llm-wiki-governance.md)]

---

title: "README"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "README"
issues: []
discussions: []
**Status**: ✅ Production  
**Last Updated**: 2026-07-14  
**Requirements**: PHP 8.3+, Laravel 13  
**PHPStan Level**: 10 (Compliant)
---
Documentation should be:
- Clear and concise
- Example-driven
- Updated with code changes
- Use Markdown format (.md)
