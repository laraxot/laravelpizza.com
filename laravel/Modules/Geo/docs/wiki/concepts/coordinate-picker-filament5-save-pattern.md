---
title: "CoordinatePicker Filament 5 — Pattern salvataggio campo composito"
type: concept
confidence: high
created: 2026-04-28
updated: 2026-04-28
tags: [coordinate-picker, filament5, eloquent, mutator, composite-field, latitude, longitude, dehydrated, custom-field]
related:
  - ./coordinate-picker-architecture.md
  - ./coordinate-picker-best-practices.md
  - ../../../Fixcity/docs/wiki/troubleshooting/ticket-location-not-saved-mass-assignment.md
supersedes:
  - story 8-64 (root cause errata)
---

# CoordinatePicker Filament 5 — Pattern salvataggio campo composito

Reference ufficiale: `https://filamentphp.com/docs/5.x/forms/custom-fields`

## ROOT CAUSE CORRETTA: `dehydrated(false)`

### Il vero bug

In `HasCoordinatePicker::setUpCoordinatePicker()`, riga 44:

```php
$this->dehydrated(false);
```

**Effetto**: Filament **esclude completamente** il campo dal payload di `$form->getState()`.
Il dato `location` **non arriva mai** al model. Nessun mutator, nessun `$fillable`,
nessun `mutateFormDataBefore*` sarà mai invocato.

### Root cause precedentemente identificata (ERRATA)

La story 8-64 attribuiva il bug alla mancanza di un Eloquent mutator + `$fillable`.
Questi sono problemi **secondari** che da soli non bastano — anche con un mutator perfetto,
`dehydrated(false)` impedisce al dato di uscire dal form.

## Il problema: campo composito vs colonne DB separate

`CoordinatePicker::make('location')` gestisce il proprio stato come array composito:

```php
// Stato Livewire (entangle) — contiene dati UI + dati persistenza
[
    'latitude'    => 41.9028,
    'longitude'   => 12.4964,
    'address'     => 'Via Roma, Milano',       // UI-only
    'display_name'=> 'Via Roma 1, Milano, MI', // UI-only
    'street'      => 'Via Roma',               // UI-only
    'city'        => 'Milano',                 // UI-only
    // ... altri campi reverse geocoding
]
```

Il modello ha colonne **separate** `latitude` e `longitude` (e non una colonna `location`).

## Soluzione a 2 livelli

### Livello 1: `dehydrateStateUsing()` nel trait (contratto Filament custom field)

```php
// In HasCoordinatePicker::setUpCoordinatePicker()
$this->dehydrateStateUsing(static function (self $component, mixed $state): ?array {
    if (! is_array($state)) {
        return null;
    }
    return [
        'latitude'  => isset($state['latitude']) && is_numeric($state['latitude'])
            ? (string) $state['latitude']
            : null,
        'longitude' => isset($state['longitude']) && is_numeric($state['longitude'])
            ? (string) $state['longitude']
            : null,
    ];
});
```

**Perché**: filtra i campi UI-only (address, display_name, etc.) e normalizza i tipi.
Il campo partecipa a `$form->getState()` con solo le coordinate.

### Livello 2: Eloquent mutator sul model (mapping composito → colonne)

```php
// In Ticket.php (o qualsiasi model con colonne separate lat/lng)
use Illuminate\Database\Eloquent\Casts\Attribute;

protected function location(): Attribute
{
    return Attribute::make(
        get: fn (mixed $value, array $attributes): array => [
            'latitude'  => $attributes['latitude'] ?? null,
            'longitude' => $attributes['longitude'] ?? null,
        ],
        set: function (mixed $value): array {
            if (! is_array($value)) {
                return [];
            }
            return [
                'latitude'  => isset($value['latitude'])  ? (string) $value['latitude']  : null,
                'longitude' => isset($value['longitude']) ? (string) $value['longitude'] : null,
            ];
        },
    );
}
```

**Perché**: quando Filament chiama `$model->fill(['location' => [...]])`, Eloquent invoca il mutator
che smista i valori nelle colonne reali `latitude` e `longitude`.

## Lifecycle completo del flusso

```
CoordinatePicker::make('location')
  ├── HYDRATION (lettura dal DB):
  │     afterStateHydrated() → legge $record->latitude, $record->longitude
  │     → imposta state = ['latitude' => 41.9, 'longitude' => 12.4]
  │
  ├── UI (runtime Livewire/Alpine/Lit):
  │     Blade: $wire.$entangle('data.location') + wire:ignore
  │     Lit component: emette coords-changed → Alpine → aggiorna state
  │     reverse geocode: aggiunge address/display_name allo state (UI-only)
  │
  └── DEHYDRATION (salvataggio):
        dehydrateStateUsing() → filtra solo {latitude, longitude}
        Filament: $model->fill(['location' => ['latitude' => 41.9, 'longitude' => 12.4]])
        Eloquent mutator: smista nelle colonne latitude, longitude ✓
```

## Quando usare `dehydrated(false)` — e quando NO

| Scenario | `dehydrated(false)` | `dehydrateStateUsing` |
|----------|---------------------|------------------------|
| Campo display-only (info, preview) | ✅ OK | Non necessario |
| Campo composito → colonne separate | ❌ VIETATO | ✅ OBBLIGATORIO |
| Campo con singola colonna JSON | ❌ Non necessario | Opzionale |

## Regola operativa

> OBBLIGATORIO: per un CoordinatePicker che punta a colonne separate (latitude/longitude):
> 1. Il TRAIT deve usare `dehydrateStateUsing()` per normalizzare lo stato
> 2. Il MODELLO deve avere un Eloquent mutator `location()` per smistare le colonne
> 3. È VIETATO usare `dehydrated(false)` perché esclude il campo dal salvataggio

## Implementazione nel progetto

- Trait: `laravel/Modules/Geo/app/Filament/Forms/Components/Traits/HasCoordinatePicker.php` — `dehydrateStateUsing`
- Modello: `laravel/Modules/Fixcity/app/Models/Ticket.php` — mutator `location()`
- Form admin: `Modules/Fixcity/Filament/Resources/TicketResource/Schemas/TicketForm.php`
- Form frontoffice: `Modules/Fixcity/Filament/Widgets/CreateTicketWizardWidget.php`
  (ha anche `prepareTicketData()` che estrae lat/lng manualmente — layer ridondante ma compatibile)

## Story di riferimento

- **8-65** (corretta): `8-65-coordinatepicker-dehydrated-false-root-cause-and-filament5-contract-fix.md`
- ~~8-64~~ (superseded): root cause errata — attribuiva il bug solo al mutator mancante
