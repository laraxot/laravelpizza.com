---
title: "CoordinatePicker Best Practices"
type: concept
sources: ["../../Modules/Geo/app/Filament/Forms/Components/CoordinatePicker.php"]
confidence: high
created: 2026-04-28
updated: 2026-04-28
tags: [coordinate-picker, best-practices, filament-5, custom-field]
related:
  - concepts/coordinate-picker-state-binding-rule.md
  - concepts/coordinate-picker-field.md
  - concepts/filament5-custom-field-entangle-contract.md
---

# CoordinatePicker Best Practices

## Overview

Best practices per l'uso del componente `CoordinatePicker` in Filament 5.x.

## ✅ Best Practices

### 1. Usare sempre `applyStateBindingModifiers()`
```blade
state: $wire.{{ $applyStateBindingModifiers("\$entangle('{$statePath}')") }},
```
**Perché**: Rispetta i modificatori `live()` e `defer()` configurati sul field.

### 2. Non dichiarare `$view` statica
```php
// ❌ NO
protected static string $view = '...';

// ✅ SI - lasciare che GetViewByClassAction risolva
class CoordinatePicker extends XotBaseField { }
```
**Perché**: `XotBaseField` usa `GetViewByClassAction` per risolvere la vista automaticamente.

### 3. Mai usare `dehydrated(false)` nel trait
```php
// ❌ NO in HasCoordinatePicker
dehydrated(false);

// ✅ SI - il campo deve essere incluso nei dati
```
**Perché**: Il campo deve essere incluso nei dati del form affinché la location venga salvata.

### 4. Estendere sempre `XotBaseField`
```php
// ✅ SI
class CoordinatePicker extends XotBaseField { }

// ❌ NO
class CoordinatePicker extends Field { }
```

### 5. Usare mutator Eloquent per la persistenza
```php
// In Ticket.php
public function location(): Attribute {
    return Attribute::make(
        get: fn ($value) => json_decode($value, true),
        set: fn ($value) => json_encode($value)
    );
}
```

## ❌ Bad Practices

### 1. Hardcodare percorsi SVG
```php
// ❌ NO
$icon = '<svg>...</svg>';

// ✅ SI
echo GeoIcon::make('map-pin');
```

### 2. Usare CDN per asset Leaflet
```php
// ❌ NO
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

// ✅ SI - Vite build locale
@vite('resources/css/leaflet.css')
```

### 3. Dichiarare `$view` in XotBaseField
Vedi Best Practice #2.

### 4. Ignorare `applyStateBindingModifiers()`
Vedi Best Practice #1.

## 🔗 False Friends

### `dehydrated(false)` vs `dehydrateStateUsing()`
- **False Friend**: Pensare che `dehydrated(false)` preservi i dati
- **Realtà**: `dehydrated(false)` ESCLUDE il campo dai dati del form
- **Soluzione**: Usare `dehydrateStateUsing()` per personalizzare la serializzazione

### `$wire.$entangle` vs `$applyStateBindingModifiers()`
- **False Friend**: Pensare che `$wire.$entangle(...)` sia sufficiente
- **Realtà**: Senza `applyStateBindingModifiers()`, i modificatori `live()`/`defer()` vengono ignorati
- **Soluzione**: Usare sempre `{{ $applyStateBindingModifiers("\$entangle('...')") }}`

### `Field` vs `XotBaseField`
- **False Friend**: Pensare che `Field` di Filament sia sufficiente
- **Realtà**: `XotBaseField` aggiunge logiche specifiche Laraxot (casts, translations, etc.)
- **Soluzione**: Estendere sempre `XotBaseField`

## Related

- [[coordinate-picker-state-binding-rule]]
- [[coordinate-picker-field]]
- [[filament5-custom-field-entangle-contract]]
- [[map-picker-family-architecture]]
