# Agent Teams Workflow - PTVX Project

## Overview

Sistema di agent teams per la gestione collaborativa del progetto **PTVX (Fila5 Mono)** basato su Laravel 12 e Filament 5.

## Struttura Agent Teams

### Team 1: Core Architecture Agent

**Responsabilità**:
- Gestione classi base (XotBasePage, XotBaseEditRecord)
- Namespace e struttura moduli
- Upgrade framework (Laravel, Filament)
- PHPStan Level 10 compliance

**Competenze**:
- PHP 8.3+ typing
- Laravel 12.x internals
- Filament 5.x architecture
- Modular monolith patterns

**Files chiave**:
- `Modules/Xot/app/Filament/Pages/XotBasePage.php`
- `Modules/Xot/app/Filament/Resources/Pages/XotBaseEditRecord.php`

---

### Team 2: Custom Pages Agent

**Responsabilità**:
- Sviluppo pagine Filament custom
- Form Schema (Filament 5)
- View Blade components
- Integrazione con XotBasePage

**Competenze**:
- Filament Forms/Schemas
- Livewire components
- Blade templating
- Validation rules

**Moduli**:
- Pdnd (servizi ANPR)
- Notify (email, telegram, push)
- UI (componenti condivisi)

**Files di riferimento**:
- `Modules/Pdnd/docs/filament-custom-pages.md`
- `Modules/Notify/docs/filament-custom-pages.md`

---

### Team 3: Documentation Agent

**Responsabilità**:
- Manutenzione docs moduli
- Collegamenti bidirezionali
- README e CHANGELOG
- Standard di documentazione

**Competenze**:
- Markdown
- Diagrammi ASCII
- PHPDoc standards
- Best practices documentation

**Regole**:
- Short array syntax `[]` in tutti i file PHP
- Namespace corretto (senza segmento `app`)
- Backlinks tra docs modulo e root

---

### Team 4: Quality Assurance Agent

**Responsabilità**:
- PHPStan Level 10
- Laravel Pint
- Rector refactoring
- Test coverage

**Comandi**:
```bash
./vendor/bin/phpstan analyse --level=10
./vendor/bin/pint
./vendor/bin/rector process --dry-run
./vendor/bin/pest --coverage
```

---

## Workflow Collaborativo

### 1. Request Routing

```
Utente Request
    ↓
┌─────────────────┐
│  Router Agent   │  ← Determina quale team è necessario
└────────┬────────┘
         ↓
┌─────────────────┬─────────────────┬─────────────────┐
│  Core Agent     │  Pages Agent    │  Docs Agent     │
│  (Architettura) │  (Form/View)    │  (Documentazione)│
└────────┬────────┴────────┬────────┴────────┬────────┘
         ↓               ↓               ↓
    ┌─────────────────────────────────────────────┐
    │        Quality Assurance Agent            │
    │   (Validazione finale prima del commit)   │
    └─────────────────────────────────────────────┘
```

### 2. Communication Protocol

Ogni agent deve:
1. **Leggere** la documentazione del modulo prima di modificare
2. **Verificare** i collegamenti bidirezionali esistono
3. **Aggiornare** la documentazione dopo modifiche
4. **Seguire** le regole del progetto (short array syntax, etc.)

### 3. Handoff Rules

Quando un agent completa un task:
- Aggiorna il TODO list
- Documenta le modifiche nel file appropriato
- Crea backlink se necessario
- Notifica l'agent successivo se workflow multi-step

---

## Standard Condivisi

### Array Syntax (CRITICO)

```php
// ✅ SEMPRE USARE SHORT SYNTAX
$data = [
    'key' => 'value',
    'nested' => [
        'item' => 1,
    ],
];

// ❌ MAI USARE LONG SYNTAX nei file .php
$data = array(
    'key' => 'value',
    'nested' => array(
        'item' => 1,
    ),
);
```

Eccezione: Quando si spiega come NON usare qualcosa, può essere usato `array()` per chiarezza didattica.

### Namespace

```php
// ✅ CORRETTO
namespace Modules\NomeModulo\Filament\Pages;

// ❌ ERRATO
namespace Modules\NomeModulo\App\Filament\Pages;
```

### Type Declarations

```php
protected static string $resource = Resource::class;
protected string $view = 'module::filament.pages.name';
public array $data = [];
public ?array $formData = null;
```

---

## Documentazione Moduli

Ogni modulo deve avere:

```
Modules/Name/
├── docs/
│   ├── filament-custom-pages.md
│   ├── README.md
│   └── CHANGELOG.md
└── README.md
```

Collegamenti bidirezionali richiesti:
- Docs modulo → Root docs
- Root docs → Docs modulo

---

## Comandi Comuni

### Setup
```bash
composer go
```

### Quality Check
```bash
./vendor/bin/phpstan analyse Modules/ModuloName --level=10
```

### Formatting
```bash
./vendor/bin/pint
```

### Testing
```bash
./vendor/bin/pest
```

---

## Collegamenti

- [PTVX Root Documentation](../../docs/README.md)
- [Filament 5 Upgrade Guide](../../docs/filament-5-upgrade.md)
- [Coding Standards](../../docs/coding-standards.md)
- [Module Development](../../docs/module-development.md)
