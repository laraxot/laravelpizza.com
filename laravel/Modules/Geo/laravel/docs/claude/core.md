# 🎯 Core Rules - Regole Fondamentali PTVX

> **⚠️ CRITICO**: Queste regole sono FONDAMENTALI per il progetto PTVX. Violarle causa bug critici e instabilità.

## 🔥 Regole Assolute (MAI Violare)

### 1. **XotBase Classes - OBBLIGATORIO**
```php
// ❌ MAI Fare
class MyResource extends Resource { }

// ✅ SEMPRE Fare
class MyResource extends XotBaseResource { }
```

**Classi XotBase obbligatorie:**
- `Resource` → `XotBaseResource`
- `CreateRecord` → `XotBaseCreateRecord`
- `EditRecord` → `XotBaseEditRecord`
- `ListRecords` → `XotBaseListRecords`
- `Page` → `XotBasePage`

### 2. **MAI Labels Hardcoded**
```php
// ❌ MAI Fare
TextInput::make('name')->label('Nome Utente')

// ✅ SEMPRE Fare
TextInput::make('name') // Il framework gestisce le traduzioni
```

### 3. **getTableColumns() SOLO in List Pages**
```php
// ❌ MAI Fare - Nelle Resource
class MyResource extends XotBaseResource {
    public static function getTableColumns(): array { } // VIOLAZIONE!
}

// ✅ SEMPRE Fare - Nelle List Pages
class ListMyRecords extends XotBaseListRecords {
    protected function getTableColumns(): array { } // CORRETTO!
}
```

### 4. **MAI BadgeColumn (deprecated)**
```php
// ❌ MAI Fare
BadgeColumn::make('status')

// ✅ SEMPRE Fare
TextColumn::make('status')->badge()
```

### 5. **MAI Services - USA Actions**
```php
// ❌ MAI Fare
class MyService { }

// ✅ SEMPRE Fare
class MyAction {
    use QueueableAction;
}
```

---

## 🚨 Proprietà XotBasePage - VIETATE

Le classi che estendono `XotBasePage` NON possono avere:

```php
// ❌ MAI Fare in XotBasePage
protected static ?string $navigationIcon = 'heroicon-o-users';
protected static ?string $title = 'My Page';
protected static ?string $navigationLabel = 'My Page';
```

**Usa invece i metodi:**
```php
// ✅ SEMPRE Fare
public static function getNavigationIcon(): string { return 'heroicon-o-users'; }
protected function getTitle(): string { return 'My Page'; }
```

---

## 📋 Checklist Pre-Commit (OBBLIGATORIA)

Prima di ogni commit, verifica:

### Code Quality
- [ ] PHPStan Level 10 passa: `./vendor/bin/phpstan analyze`
- [ ] PHPMD passa: `./vendor/bin/phpmd`
- [ ] PHPInsights passa: `./vendor/bin/phpinsights`
- [ ] Pint formatta: `./vendor/bin/pint`

### Architecture Rules
- [ ] Nessuna `Resource` class estende classi Filament dirette
- [ ] `getTableColumns()` solo in List pages
- [ ] Nessun label hardcoded
- [ ] Nessun BadgeColumn
- [ ] Actions usano Spatie QueueableAction

### Testing
- [ ] Test passano: `php artisan test`
- [ ] Code coverage adeguato
- [ ] Test integrativi per funzionalità critiche

---

## ⚡ Quick Reference Pattern

### Resource Pattern
```php
<?php

declare(strict_types=1);

namespace Modules\MyModule\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;
// ... altri use

class MyResource extends XotBaseResource
{
    // ❌ MAI getTableColumns() qui
    
    protected static ?string $model = MyModel::class;
    
    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name') // Nessun label()
        ]);
    }
}
```

### List Page Pattern
```php
<?php

declare(strict_types=1);

namespace Modules\MyModule\Filament\Resources\MyResource\Pages;

use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListMyRecords extends XotBaseListRecords
{
    // ✅ getTableColumns() SOLO qui
    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('name'),
            TextColumn::make('status')->badge(), // Non BadgeColumn
        ];
    }
}
```

### Action Pattern
```php
<?php

declare(strict_types=1);

namespace Modules\MyModule\Actions;

use Spatie\QueueableAction\QueueableAction;

class MyAction
{
    use QueueableAction;
    
    public function execute(array $data): Model
    {
        // Logica business
        return $model;
    }
}
```

---

## 🔧 Comandi Utili

### Code Quality (runna SEMPRE)
```bash
# PHPStan Level 10
./vendor/bin/phpstan analyze

# Formattazione
./vendor/bin/pint

# Testing
php artisan test

# Tutti insieme
composer quality-check
```

### Debug
```bash
# Verifica struttura moduli
php artisan module:list

# Cache clear
php artisan optimize:clear

# Filament optimize
php artisan filament:optimize
```

---

## 📚 Riferimenti

- [Architecture Rules Complete](architecture-rules.md) - Pattern e architettura dettagliata
- [Common Pitfalls](common-pitfalls.md) - Errori comuni da evitare
- [Code Quality](code-quality.md) - PHPStan, testing, e quality tools
- [Eloquent Properties](eloquent-properties.md) - Gestione proprietà magiche

---

**Versione**: 3.0 (Refactor DRY + KISS)  
**Priorità**: 🔥 URGENTE - Leggi PRIMA di scrivere codice  
**Aggiornamento**: Dicembre 2025

> **⚠️ AVVISO**: Violare queste regole causa instabilità critica nel sistema PTVX.