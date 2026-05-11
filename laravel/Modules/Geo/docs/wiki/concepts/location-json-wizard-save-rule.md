---
name: location-json-wizard-save-rule
description: Ensure location JSON is correctly passed to wizard save; mutateFormData should not drop location if DB expects JSON.
---

# Location JSON in Wizard Save — Rule

**Scope:** Ticket creation wizard, `CoordinatePicker` field, `CreateTicketWizardWidget`.

## Problema

Quando si salva il wizard in `fixcity/admin/tickets/create?step=form.summary`, la `location` (JSON con `latitude`/`longitude`) non viene salvata.

## Root Cause

In `CreateTicketWizardWidget::mutateFormDataBeforeCreate()`:
```php
if (isset($state['location']) && is_array($state['location'])) {
    // estrae lat/lng in campi separati
    unset($state['location']); // <-- SE DB ASPETTA JSON, QUESTO ELIMINA I DATI
}
```

Se la colonna `location` nel DB è di tipo JSON (cast `array` o `json` nel model), l'`unset` previene il salvataggio.

## Decisione

Il model `Ticket` (o il model sottostante) deve dichiarare:
```php
protected $casts = [
    'location' => 'array', // o 'json'
];
```

Il `mutateFormDataBeforeCreate` **NON deve** fare `unset($state['location'])`. La `location` deve rimanere nell'array `$state` come array associativo.

## Fix

```php
// In CreateTicketWizardWidget::mutateFormDataBeforeCreate()
if (isset($state['location']) && is_array($state['location'])) {
    // Assicurarsi che i campi siano numerici
    if (isset($state['location']['latitude'])) {
        $state['location']['latitude'] = (float) $state['location']['latitude'];
    }
    if (isset($state['location']['longitude'])) {
        $state['location']['longitude'] = (float) $state['location']['longitude'];
    }
    // NON fare unset($state['location']) — il model casta come JSON
}
```

## Verifica

1. Controllare `Modules/Fixcity/app/Models/Ticket.php` per il cast `location`.
2. Se non c'è, aggiungere il cast.
3. Rimuovere l'`unset($state['location'])` in `mutateFormDataBeforeCreate`.
4. Testare il salvataggio nel browser.

## Collegamenti

- `Modules/Geo/docs/wiki/concepts/coordinate-picker-purpose.md`
- `Modules/Fixcity/docs/wiki/concepts/wizard-map-visibility-fix.md`
- `Modules/Geo/app/Filament/Forms/Components/CoordinatePicker.php`

*Last updated: 2026-04-27*