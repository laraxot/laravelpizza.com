# Componenti Form Riutilizzabili - Notify Module

**Data**: 19 Dicembre 2025
**Stato**: ✅ Implementato
**Motivazione**: DRY, Riutilizzabilità, Manutenibilità

## 🎯 Obiettivo

Creare componenti form Filament riutilizzabili per evitare duplicazione di logica tra diverse Actions e Forms nel modulo Notify.

## ✅ Componenti Implementati

### MailTemplateSelect

**File**: `Modules/Notify/app/Filament/Forms/Components/MailTemplateSelect.php`

Componente `Select` pre-configurato per la selezione di template email da `MailTemplate`.

**Configurazione Predefinita**:
- Label da traduzione: `notify::form.mail_template`
- Options da query `MailTemplate::query()->orderBy('name')->pluck('name', 'slug')`
- Campo required
- Nome campo di default: `mail_template_slug`

**Utilizzo**:
```php
use Modules\Notify\Filament\Forms\Components\MailTemplateSelect;

->schema([
    MailTemplateSelect::make(), // Usa nome di default 'mail_template_slug'
    // Oppure
    MailTemplateSelect::make('custom_field_name')
        ->searchable() // Opzionale: aggiunge ricerca
        ->preload(),   // Opzionale: precarica opzioni
])
```

**Estende**: `Filament\Forms\Components\Select`

**Pattern**: Estende direttamente `Select` e configura in `setUp()`, seguendo il pattern degli altri componenti custom (es. `SingleRoleSelect`, `NationalFlagSelect`).

### ChannelCheckboxList

**File**: `Modules/Notify/app/Filament/Forms/Components/ChannelCheckboxList.php`

Componente `CheckboxList` pre-configurato per la selezione di canali notifica da `ChannelEnum`.

**Configurazione Predefinita**:
- Label da traduzione: `notify::form.channels`
- Options da `ChannelEnum::cases()` usando `getLabel()` per traduzioni
- Layout a 3 colonne (`columns(3)`)
- Campo required
- Nome campo di default: `channels`

**Utilizzo**:
```php
use Modules\Notify\Filament\Forms\Components\ChannelCheckboxList;

->schema([
    ChannelCheckboxList::make(), // Usa nome di default 'channels'
    // Oppure
    ChannelCheckboxList::make('custom_channels')
        ->minItems(1), // Opzionale: richiede almeno un canale selezionato
])
```

**Estende**: `Filament\Forms\Components\CheckboxList`

**Pattern**: Estende direttamente `CheckboxList` e configura in `setUp()`, usando `ChannelEnum` come Single Source of Truth per i canali disponibili.

## 📚 Pattern di Implementazione

### Struttura Componente

Tutti i componenti seguono questo pattern:

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Forms\Components;

use Filament\Forms\Components\{Select|CheckboxList};
use Modules\Notify\{Models\MailTemplate|Enums\ChannelEnum};

class ComponentName extends {Select|CheckboxList}
{
    /**
     * Set up the component configuration.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Configurazione predefinita (label, options, validazione, ecc.)
        $this->label(__('notify::form.field_name'))
            ->options(/* ... */)
            ->required();
    }

    /**
     * Create a new ComponentName instance.
     *
     * @param string|null $name Field name (default: 'field_name')
     * @return static
     */
    public static function make(?string $name = null): static
    {
        $name = $name ?? 'default_field_name';
        return parent::make($name);
    }
}
```

### Principi Seguiti

1. **DRY**: Logica di configurazione centralizzata in un solo componente
2. **KISS**: Configurazione semplice e diretta nel `setUp()`
3. **Riutilizzabilità**: Usabile in Actions, Forms, Widgets
4. **Type Safety**: PHPStan Level 10 compliant
5. **Traduzioni**: Labels sempre da file di traduzione del modulo

## 🔄 Refactoring Effettuato

### Prima (Duplicazione)

**SendRecordsNotificationBulkAction**:
```php
->schema([
    Select::make('mail_template_slug')
        ->label(__('notify::form.mail_template'))
        ->options(fn (): array => MailTemplate::query()
            ->orderBy('name')
            ->pluck('name', 'slug')
            ->all())
        ->required(),
    CheckboxList::make('channels')
        ->label(__('notify::form.channels'))
        ->options(fn (): array => collect(ChannelEnum::cases())
            ->mapWithKeys(function (ChannelEnum $enum): array {
                $label = $enum->getLabel();
                return [$enum->value => is_string($label) ? $label : $enum->value];
            })
            ->all())
        ->columns(3)
        ->required(),
])
```

**SendNotificationBulkAction**: Stessa logica duplicata con opzioni hardcoded invece di `ChannelEnum`.

### Dopo (Riutilizzabilità)

**SendRecordsNotificationBulkAction**:
```php
->schema([
    'mail_template_slug' => MailTemplateSelect::make('mail_template_slug'),
    'channels' => ChannelCheckboxList::make('channels'),
])
```

**SendNotificationBulkAction**:
```php
->schema([
    'template_slug' => MailTemplateSelect::make('template_slug')
        ->searchable()
        ->preload(),
    'channels' => ChannelCheckboxList::make('channels')
        ->minItems(1),
])
```

## 🧘 Filosofia e Principi

### DRY (Don't Repeat Yourself)

> "La configurazione di Select/CheckboxList per MailTemplate e ChannelEnum è cross-cutting. Definisci una volta, riusa ovunque."

**Benefici**:
- **Single Source of Truth**: Logica centralizzata in un componente
- **Manutenibilità**: Modifiche in un solo punto
- **Consistency**: Comportamento uniforme in tutto il modulo

### KISS (Keep It Simple, Stupid)

> "Componente semplice con configurazione predefinita. Opzioni customizzabili quando necessario."

**Caratteristiche**:
- Configurazione essenziale nel `setUp()`
- Metodi fluenti per personalizzazione (searchable, preload, minItems)
- Default sensati che coprono 90% dei casi d'uso

### Single Responsibility Principle (SRP)

- **MailTemplateSelect**: Responsabilità = Selezione template email
- **ChannelCheckboxList**: Responsabilità = Selezione canali notifica
- **Action/Form**: Responsabilità = Orchestrazione business logic

## 📊 Impatto

### File Modificati/Creati

1. **MailTemplateSelect.php**: ✅ Migliorato con PHPDoc completo e pattern corretto
2. **ChannelCheckboxList.php**: ✅ Creato nuovo componente riutilizzabile
3. **SendRecordsNotificationBulkAction.php**: ✅ Refactored per usare componenti
4. **SendNotificationBulkAction.php**: ✅ Refactored per usare componenti (DRY!)
5. **NotificationChannelsCheckboxList.php**: ❌ Eliminato (duplicato di ChannelCheckboxList)

### Benefici Misurabili

- **Riduzione Codice**: ~30 righe di codice duplicato eliminate per Action
- **Manutenibilità**: Modifiche a options/validazione in un solo punto
- **Consistency**: Comportamento uniforme tra Actions
- **Testabilità**: Componenti testabili indipendentemente

## ✅ Verifica Qualità

- ✅ PHPStan Level 10: **0 errori**
- ✅ Pattern Consistency: Allineato con altri componenti custom (SingleRoleSelect, NationalFlagSelect)
- ✅ DRY: Zero duplicazione di logica Select/CheckboxList
- ✅ Type Safety: Tipizzazione completa con PHPDoc
- ✅ Schema Keys: Array associativi con chiavi string per conformità Filament

## 🔗 Utilizzo nei File Esistenti

### SendRecordsNotificationBulkAction

```php
use Modules\Notify\Filament\Forms\Components\MailTemplateSelect;
use Modules\Notify\Filament\Forms\Components\ChannelCheckboxList;

->schema([
    'mail_template_slug' => MailTemplateSelect::make('mail_template_slug'),
    'channels' => ChannelCheckboxList::make('channels'),
])
```

### SendNotificationBulkAction

```php
use Modules\Notify\Filament\Forms\Components\MailTemplateSelect;
use Modules\Notify\Filament\Forms\Components\ChannelCheckboxList;

->schema([
    'template_slug' => MailTemplateSelect::make('template_slug')
        ->searchable()
        ->preload(),
    'channels' => ChannelCheckboxList::make('channels')
        ->minItems(1),
])
```

## 📝 Note Tecniche

### Pattern `make()` Method

Il metodo `make()` accetta `?string $name = null` per essere contravariante con il parent `Field::make()`:

```php
public static function make(?string $name = null): static
{
    $name = $name ?? 'default_field_name'; // Default se null
    return parent::make($name);
}
```

**Motivazione**: PHPStan Level 10 richiede contravarienza corretta con metodi parent.

### Schema Array Keys

Lo schema deve sempre avere chiavi string per conformità Filament:

```php
// ✅ CORRETTO
->schema([
    'mail_template_slug' => MailTemplateSelect::make('mail_template_slug'),
    'channels' => ChannelCheckboxList::make('channels'),
])

// ❌ ERRATO
->schema([
    MailTemplateSelect::make('mail_template_slug'), // Chiave numerica implicita
    ChannelCheckboxList::make('channels'),
])
```

## 🔗 Riferimenti

- [Filament Form Components](https://filamentphp.com/docs/forms/fields) - Documentazione ufficiale Filament
- [SendRecordsNotificationBulkAction](./../refactoring/send-notification-bulk-action.md) - Refactoring completo
- [ChannelEnum](./enums/channel-enum.md) - Smart Enum per canali notifica
- [MailTemplate Model](./../models.md) - Modello template email

## 🎯 Best Practice per Futuri Componenti

1. **Estendere direttamente** `Select`, `CheckboxList`, o altri componenti Filament
2. **Configurare in `setUp()`** tutte le proprietà predefinite
3. **Metodo `make()`** con `?string $name = null` e default interno
4. **PHPDoc completo** con esempi d'uso
5. **Traduzioni** sempre da file di traduzione del modulo
6. **Type Safety** PHPStan Level 10 compliant

---

**Ultimo aggiornamento**: 19 Dicembre 2025
**Filosofia**: *"Define once, reuse everywhere - DRY over duplication, simplicity over complexity"*
