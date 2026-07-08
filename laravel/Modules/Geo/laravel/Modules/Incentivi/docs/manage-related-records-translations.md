# Traduzioni per XotBaseManageRelatedRecords

## Panoramica

Questo documento descrive come configurare le traduzioni per le pagine che estendono `XotBaseManageRelatedRecords` nel modulo Incentivi, seguendo la filosofia Laraxot.

## Sistema di Traduzione Automatica

Il sistema di traduzione Laraxot genera automaticamente le chiavi di traduzione basandosi sul nome della classe. Per una classe come `Modules\Incentivi\Filament\Resources\ProjectResource\Pages\ManageProjectEmployees`, la chiave di traduzione è:

```
incentivi::manage_project_employees
```

## Struttura dei File di Traduzione

I file di traduzione devono essere posizionati in:

```
Modules/Incentivi/lang/{locale}/{class_name_snake}.php
```

### Esempio: ManageProjectEmployees

#### Italiano (it)
```php
<?php

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

#### Inglese (en)
```php
<?php

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

> **IMPORTANTE**: La chiave `navigation.label` (con punto) è obbligatoria per il metodo `getNavigationLabel()` in `XotBaseManageRelatedRecords` che usa `static::trans('navigation.label')`.

## Pagine Implementate

### 1. ManageProjectEmployees
- **Classe**: `Modules\Incentivi\Filament\Resources\ProjectResource\Pages\ManageProjectEmployees`
- **Chiave**: `incentivi::manage_project_employees`
- **File**: `lang/it/manage_project_employees.php`, `lang/en/manage_project_employees.php`
- **Etichetta**: Dipendenti / Employees

### 2. ManageProjectActivities
- **Classe**: `Modules\Incentivi\Filament\Resources\ProjectResource\Pages\ManageProjectActivities`
- **Chiave**: `incentivi::manage_project_activities`
- **File**: `lang/it/manage_project_activities.php`, `lang/en/manage_project_activities.php`
- **Etichetta**: Attività / Activities

### 3. ManageProjectPhases
- **Classe**: `Modules\Incentivi\Filament\Resources\ProjectResource\Pages\ManageProjectPhases`
- **Chiave**: `incentivi::manage_project_phases`
- **File**: `lang/it/manage_project_phases.php`, `lang/en/manage_project_phases`
- **Etichetta**: Fasi / Phases

## Come Funziona

### Generazione delle Chiavi

Il sistema di traduzione utilizza l'azione `GetTransKeyAction` per generare automaticamente le chiavi di traduzione:

```php
// Per: Modules\Incentivi\Filament\Resources\ProjectResource\Pages\ManageProjectEmployees
// Chiave generata: incentivi::manage_project_employees
```

### Traduzione Automatica

Le classi che estendono `XotBaseManageRelatedRecords` utilizzano il trait `NavigationLabelTrait` e `TransFuncTrait` per tradurre automaticamente:

- `getTitle()` → Restituisce `incentivi::manage_project_employees.title`
- `getNavigationLabel()` → Restituisce `incentivi::manage_project_employees.navigation_label`
- `getHeading()` → Restituisce `incentivi::manage_project_employees.heading`
- `getBreadcrumb()` → Restituisce `incentivi::manage_project_employees.breadcrumb`

## Creazione di Nuove Pagine

Per creare una nuova pagina che estende `XotBaseManageRelatedRecords` con traduzioni:

1. **Creare la classe**:
```php
namespace Modules\Incentivi\Filament\Resources\ProjectResource\Pages;

use Modules\Xot\Filament\Resources\Pages\XotBaseManageRelatedRecords;
use Modules\Incentivi\Filament\Resources\ProjectResource;

class ManageProjectCustom extends XotBaseManageRelatedRecords
{
    protected static string $resource = ProjectResource::class;
    protected static string $relationship = 'custom';
}
```

2. **Creare il file di traduzione italiano**:
```php
// Modules/Incentivi/lang/it/manage_project_custom.php
<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Personalizzato',
    ],
    'title' => 'Personalizzato',
    'navigation_label' => 'Personalizzato',
    'heading' => 'Personalizzato',
    'breadcrumb' => 'Personalizzato',
    'label' => 'Personalizzato',
    'plural_label' => 'Personalizzati',
];
```

3. **Creare il file di traduzione inglese**:
```php
// Modules/Incentivi/lang/en/manage_project_custom.php
<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Custom',
    ],
    'title' => 'Custom',
    'navigation_label' => 'Custom',
    'heading' => 'Custom',
    'breadcrumb' => 'Custom',
    'label' => 'Custom',
    'plural_label' => 'Customs',
];
```

## Best Practices

1. **MAI usare hardcoded strings** per le etichette
2. **Sempre creare file di traduzione** per tutte le lingue supportate (it, en, de)
3. **Usare termini italiani appropriati** per le etichette italiane
4. **Mantenere consistenza** tra le traduzioni delle diverse lingue
5. **Seguire la convenzione di naming**: `{class_name_snake}.php`

## Troubleshooting

### Etichetta non appare o mostra la chiave di traduzione

1. **Verificare il nome del file**: Deve corrispondere al nome della classe in snake_case
2. **Verificare il path**: Deve essere `Modules/Incentivi/lang/{locale}/{file}.php`
3. **Pulire la cache**: `php artisan cache:clear` e `php artisan view:clear`
4. **Verificare le chiavi**: Assicurarsi che tutte le chiavi necessarie siano presenti

### Etichetta sbagliata

1. **Verificare la chiave generata**: Usare `GetTransKeyAction::class` per verificare
2. **Verificare il fallback**: Il sistema usa automaticamente il fallback appropriato
3. **Verificare le priorità**: Le traduzioni del modulo hanno priorità su quelle globali

## Riferimenti

- [Laraxot Translation Philosophy](../../Xot/docs/translation-philosophy.md)
- [Translation System](../../Xot/docs/translation-system-1.md)
- [XotBaseManageRelatedRecords](../../Xot/docs/xot-base-resource-page.md)
- [TransFuncTrait](../../Xot/app/Filament/Traits/TransFuncTrait.php)
- [GetTransKeyAction](../../Xot/app/Actions/GetTransKeyAction.php)

---

**Aggiornato**: 2026-02-18
**Autore**: Laraxot Development Team