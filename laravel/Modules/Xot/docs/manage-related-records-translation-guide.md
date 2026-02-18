# Guida alle Traduzioni per XotBaseManageRelatedRecords

## Panoramica

Questa guida spiega come configurare le traduzioni per le pagine che estendono `XotBaseManageRelatedRecords`, seguendo la filosofia Laraxot di traduzioni automatiche e centralizzate.

## Come Funziona il Sistema di Traduzione

### Generazione Automatica delle Chiavi

Il sistema Laraxot genera automaticamente le chiavi di traduzione basandosi sul nome completo della classe usando l'azione `GetTransKeyAction`:

```php
// Classe: Modules\Incentivi\Filament\Resources\ProjectResource\Pages\ManageProjectEmployees
// Chiave generata: incentivi::manage_project_employees
```

### Processo di Generazione

1. **Estrazione del modulo**: `Incentivi` → `incentivi`
2. **Estrazione del tipo**: `Pages` → (rimosso)
3. **Estrazione della classe**: `ManageProjectEmployees`
4. **Conversione in snake_case**: `manage_project_employees`
5. **Rimozione prefissi comuni**: `manage_` → `project_employees`
6. **Combinazione**: `incentivi::manage_project_employees`

### Traduzione Automatica

Le classi che estendono `XotBaseManageRelatedRecords` utilizzano i trait `NavigationLabelTrait` e `TransFuncTrait` per tradurre automaticamente:

```php
public function getTitle(): string
{
    return static::transFunc(__FUNCTION__);
    // Restituisce: trans('incentivi::manage_project_employees.title')
}

public static function getNavigationLabel(): string
{
    return static::transFunc(__FUNCTION__);
    // Restituisce: trans('incentivi::manage_project_employees.navigation_label')
}
```

## Struttura dei File di Traduzione

### Posizione

```
Modules/{ModuleName}/lang/{locale}/{class_name_snake}.php
```

### Contenuto

```php
<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Etichetta Navigazione',
    ],
    'title' => 'Etichetta Titolo',
    'navigation_label' => 'Etichetta Navigazione',
    'heading' => 'Etichetta Heading',
    'breadcrumb' => 'Etichetta Breadcrumb',
    'label' => 'Etichetta',
    'plural_label' => 'Etichette Plurali',
];
```

> **IMPORTANTE**: La chiave `navigation.label` (con punto) è obbligatoria per il metodo `getNavigationLabel()` in `XotBaseManageRelatedRecords` che usa `static::trans('navigation.label')`.

## Esempio Pratico

### Classe

```php
<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\ProjectResource\Pages;

use Modules\Xot\Filament\Resources\Pages\XotBaseManageRelatedRecords;
use Modules\Incentivi\Filament\Resources\ProjectResource;

class ManageProjectEmployees extends XotBaseManageRelatedRecords
{
    protected static string $resource = ProjectResource::class;
    protected static string $relationship = 'employees';
}
```

### File di Traduzione Italiano

```php
<?php

// Modules/Incentivi/lang/it/manage_project_employees.php
declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Dipendenti',
    ],
    'title' => 'Dipendenti',
    'navigation_label' => 'Dipendenti',
    'heading' => 'Dipendenti',
    'breadcrumb' => 'Dipendenti',
    'label' => 'Dipendenti',
    'plural_label' => 'Dipendenti',
];
```

### File di Traduzione Inglese

```php
<?php

// Modules/Incentivi/lang/en/manage_project_employees.php
declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Employees',
    ],
    'title' => 'Employees',
    'navigation_label' => 'Employees',
    'heading' => 'Employees',
    'breadcrumb' => 'Employees',
    'label' => 'Employees',
    'plural_label' => 'Employees',
];
```

## Mappatura dei Metodi alle Chiavi

| Metodo Filament | Chiave di Traduzione | Esempio |
|-----------------|---------------------|---------|
| `getTitle()` | `{module}::{class}.title` | `incentivi::manage_project_employees.title` |
| `getNavigationLabel()` | `{module}::{class}.navigation_label` | `incentivi::manage_project_employees.navigation_label` |
| `getHeading()` | `{module}::{class}.heading` | `incentivi::manage_project_employees.heading` |
| `getBreadcrumb()` | `{module}::{class}.breadcrumb` | `incentivi::manage_project_employees.breadcrumb` |
| `getLabel()` | `{module}::{class}.label` | `incentivi::manage_project_employees.label` |
| `getPluralLabel()` | `{module}::{class}.plural_label` | `incentivi::manage_project_employees.plural_label` |

## Override del Comportamento di Default

### Metodo getTitle() in XotBaseManageRelatedRecords

La classe base `XotBaseManageRelatedRecords` ha un metodo `getTitle()` che genera il titolo usando il nome della relazione:

```php
public function getTitle(): string
{
    $resource = static::getResource();
    $recordTitle = $this->getRecordTitle();
    $relationship = static::getRelationshipName();

    $titleString = '';
    if ($recordTitle instanceof Htmlable) {
        $titleString = $recordTitle->toHtml();
    } else {
        $titleString = (string) $recordTitle;
    }

    return Str::of($relationship)
        ->title()
        ->prepend($titleString.' - ')
        ->toString();
}
```

### Sovrascrittura con Traduzione

Per usare le traduzioni invece del comportamento di default, il metodo `getTitle()` deve chiamare `transFunc()`:

```php
#[Override]
public function getTitle(): string
{
    return static::transFunc(__FUNCTION__);
}
```

Tuttavia, questo comportamento è già gestito automaticamente dal trait `NavigationLabelTrait` incluso in `XotBaseManageRelatedRecords`.

## Best Practices

### 1. MAI Hardcoded Strings

```php
// ❌ SBAGLIATO
public function getTitle(): string
{
    return 'Employees';
}

// ✅ CORRETTO
// Il metodo usa automaticamente transFunc() grazie a NavigationLabelTrait
// Basta creare il file di traduzione appropriato
```

### 2. File di Traduzione Completi

Creare sempre file di traduzione per tutte le lingue supportate:

```bash
Modules/Incentivi/lang/
├── it/
│   ├── manage_project_employees.php
│   ├── manage_project_activities.php
│   └── manage_project_phases.php
├── en/
│   ├── manage_project_employees.php
│   ├── manage_project_activities.php
│   └── manage_project_phases.php
└── de/
    ├── manage_project_employees.php
    ├── manage_project_activities.php
    └── manage_project_phases.php
```

### 3. Nomi dei File Consistenti

Il nome del file deve corrispondere al nome della classe in snake_case:

```php
// Classe: ManageProjectEmployees
// File: manage_project_employees.php

// Classe: ManageProjectActivities
// File: manage_project_activities.php

// Classe: ManageProjectPhases
// File: manage_project_phases.php
```

### 4. Chiavi di Traduzione Complete

Includere sempre tutte le chiavi necessarie con la struttura `navigation.label`:

```php
return [
    'navigation' => [
        'label' => '...',          // Usato da getNavigationLabel() - OBBLIGATORIO
    ],
    'title' => '...',              // Usato da getTitle()
    'navigation_label' => '...',    // Alternativo a navigation.label
    'heading' => '...',            // Usato da getHeading()
    'breadcrumb' => '...',         // Usato da getBreadcrumb()
    'label' => '...',              // Usato da getLabel()
    'plural_label' => '...',       // Usato da getPluralLabel()
];
```

## Troubleshooting

### Etichetta Non Appare

**Problema**: L'etichetta non viene visualizzata o mostra la chiave di traduzione

**Soluzione**:
1. Verificare il nome del file: deve corrispondere al nome della classe in snake_case
2. Verificare il path: `Modules/{ModuleName}/lang/{locale}/{file}.php`
3. Verificare le chiavi: tutte le chiavi devono essere presenti
4. Pulire la cache:
```bash
php artisan cache:clear
php artisan view:clear
php artisan config:clear
php artisan route:clear
```

### Etichetta Sbagliata

**Problema**: Viene mostrata l'etichetta sbagliata

**Soluzione**:
1. Verificare la chiave generata usando `GetTransKeyAction`
2. Verificare il fallback della lingua
3. Verificare le priorità delle traduzioni

### Titolo Generato Automaticamente

**Problema**: Il titolo viene generato automaticamente usando il nome della relazione invece delle traduzioni

**Soluzione**:
Assicurarsi che il file di traduzione esista e che il metodo `getTitle()` usi `transFunc()`. Questo è gestito automaticamente dal trait `NavigationLabelTrait`.

## Esempi di Implementazione

### Esempio 1: Pagina Semplice

```php
<?php

namespace Modules\Incentivi\Filament\Resources\ProjectResource\Pages;

use Modules\Xot\Filament\Resources\Pages\XotBaseManageRelatedRecords;
use Modules\Incentivi\Filament\Resources\ProjectResource;

class ManageProjectEmployees extends XotBaseManageRelatedRecords
{
    protected static string $resource = ProjectResource::class;
    protected static string $relationship = 'employees';
}
```

File di traduzione:
```php
<?php

// Modules/Incentivi/lang/it/manage_project_employees.php
declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Dipendenti',
    ],
    'title' => 'Dipendenti',
    'navigation_label' => 'Dipendenti',
    'heading' => 'Dipendenti',
    'breadcrumb' => 'Dipendenti',
    'label' => 'Dipendenti',
    'plural_label' => 'Dipendenti',
];
```

### Esempio 2: Pagina con Override

```php
<?php

namespace Modules\Incentivi\Filament\Resources\ProjectResource\Pages;

use Modules\Xot\Filament\Resources\Pages\XotBaseManageRelatedRecords;
use Modules\Incentivi\Filament\Resources\ProjectResource;
use Override;

class ManageProjectActivities extends XotBaseManageRelatedRecords
{
    protected static string $resource = ProjectResource::class;
    protected static string $relationship = 'activities';
    protected static ?string $title = 'Attività'; // Opzionale, viene sovrascritto dalle traduzioni

    #[Override]
    public function getTitle(): string
    {
        return static::transFunc(__FUNCTION__);
    }
}
```

## Riferimenti

- [Translation Philosophy](translation-philosophy.md)
- [Translation System](translation-system-1.md)
- [NavigationLabelTrait](../app/Filament/Traits/NavigationLabelTrait.php)
- [TransFuncTrait](../app/Filament/Traits/TransFuncTrait.php)
- [GetTransKeyAction](../app/Actions/GetTransKeyAction.php)
- [XotBaseManageRelatedRecords](../app/Filament/Resources/Pages/XotBaseManageRelatedRecords.php)

---

**Aggiornato**: 2026-02-18
**Autore**: Laraxot Development Team
**Versione**: 1.0