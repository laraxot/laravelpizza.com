# Redundancy Report — Modulo UI

> Generato: 2026-05-21 | Analisi automatica deep-scan

## Problemi Trovati

### 1. 🟠 AddressField — Duplicato con Geo

**File**: `app/Filament/Forms/Components/AddressField.php`

Esiste anche in:
- `Modules/Geo/app/Filament/Forms/Components/AddressField.php`
- `Modules/Geo/app/Filament/Fields/AddressField.php`

La versione UI estende `XotBaseField` (conforme), mentre le versioni Geo estendono `Section`. Hanno logiche differenti:
- **UI**: usa `Select` con relazioni `HasOne`/`MorphOne`, campo generico per indirizzi
- **Geo**: usa `AddressResource` o `TextInput` direttamente, specializzata per dati geografici

**Azione suggerita**: Geo è il modulo canonico per i componenti geografici. Se UI ha bisogno di un AddressField, dovrebbe importare e wrappare quello di Geo, non duplicarlo.

### 2. 🟡 InteractiveMap — Dipendenze da servizi Geo inesistenti (RISOLTO)

**File**: `app/Livewire/Components/Map/InteractiveMap.php`

Referenziava `Modules\Geo\Services\MapService` e `Modules\Geo\Services\GeocodingService` che non esistevano. Creati come stubs nel modulo Geo in data 2026-05-21.

### 3. 🟡 Category model — Potenziale duplicazione

**File**: `app/Models/Category.php`

Esiste anche in:
- `Modules/Blog/app/Models/Category.php`
- `Modules/Fixcity/app/Models/Category.php`

Verificare se ciascun modulo ha la propria tabella `categories` o se dovrebbe usare un modello condiviso.

### 4. 🟡 PHPStan — 7 errori residui (dal precedente ciclo di fix)

Errori residui in:
- `InlineDatePicker.php` — `shortLocaleDayOfWeek` su `Carbon|string`
- `LocationSelector.php` — `is_array()` ridondante
- `UserCalendarWidget.php` — return type mismatch `fetchEvents()` e `getFormSchema()`
- `InteractiveMap.php` — parametro `array` vs `array<string, mixed>` su MapService

## Riepilogo

| Priorità | Problema | Stato |
|----------|----------|-------|
| 🟠 | AddressField duplicato con Geo | Da unificare |
| 🟡 | InteractiveMap dipendenze Geo | ✅ Risolto |
| 🟡 | Category model duplicato | Da verificare |
| 🟡 | PHPStan 7 errori residui | Da completare |
