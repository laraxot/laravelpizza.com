# Wizard Location Data Flow - Fix Documentation

## 🔴 Problema Identificato

**Bug**: La location della mappa non viene passata al salvataggio del ticket nel wizard.

### Root Cause
Il problema può avere **due root-cause diversi**, spesso confusi:

1) **Dehydration disabilitata** (storico): se un field viene marcato `dehydrated(false)`, Livewire non invia lo state al server.
2) **Mass assignment** (attuale su admin): se il modello Eloquent **non ha `location` in `$fillable`**, Filament/Resource può inviare correttamente lo state, ma `Ticket::create($data)` ignora `location` (non persistito).

In questo repository, la famiglia `CoordinatePicker` (Geo) **è dehydrated** e invia lo state; il bug “in amministrazione non si salva la location” è tipicamente legato al punto (2).

---

## 📊 Data Flow Attuale (Rottura)

```
┌─────────────────┐
│  User Clicks    │
│  sulla Mappa    │
└────────┬────────┘
         ▼
┌─────────────────┐
│ Lit Component │
│ coordinate-     │
│ picker-lit.js   │
└────────┬────────┘
         │ dispatch 'coords-changed'
         ▼
┌─────────────────┐
│ Alpine.js       │
│ handleCoords-   │
│ Changed()       │
│                 │
│ this.state = {  │
│   latitude: x,  │
│   longitude: y  │
│ }               │
└────────┬────────┘
         │ @entangle($statePath)
         ▼
┌─────────────────┐     ┌─────────────────┐
│ Livewire State  │────▶│ ❌ BROKEN!      │
│                 │     │ dehydrated(false) │
│ location: {     │     │ impedisce invio   │
│   lat: x,       │     │ al server         │
│   lng: y        │     │                 │
│ }               │     │ Server riceve:  │
└─────────────────┘     │ location: null  │
                        └─────────────────┘
```

---

## 🔧 Fix Implementato

### Soluzione A (storica): Rimuovere `dehydrated(false)`

```php
// ❌ BEFORE (bug)
protected function setUp(): void
{
    parent::setUp();
    $this->dehydrated(false); // RIMUOVERE QUESTA LINEA
}

// ✅ AFTER (fix)
protected function setUp(): void
{
    parent::setUp();
    // Rimosso dehydrated(false) - i dati devono essere inviati al server
}
```

### Data Flow Corretto

```
┌─────────────────┐
│  User Clicks    │
│  sulla Mappa    │
└────────┬────────┘
         ▼
┌─────────────────┐
│ Lit Component   │
│ (event)         │
└────────┬────────┘
         │ coords-changed
         ▼
┌─────────────────┐
│ Alpine.js       │
│ aggiorna state  │
└────────┬────────┘
         │ @entangle
         ▼
┌─────────────────┐
│ Livewire        │
│ State Binding   │
└────────┬────────┘
         │ Dehydration
         ▼
┌─────────────────┐
│ ✅ Server       │
│ Riceve:         │
│ location: {     │
│   lat: x,       │
│   lng: y,       │
│   address: '...'│
│ }               │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│ Database        │
│ tickets.location│
│ (JSON)          │
└─────────────────┘
```

---

## 📝 Note Implementazione

### Formato Dati Location

Il componente deve salvare un oggetto JSON con:

```json
{
  "latitude": 45.123456,
  "longitude": 9.123456,
  "address": "Via Roma 1, Milano",
  "place_id": "osm:node:12345678"
}
```

### Cast nel Modello Ticket

```php
protected function casts(): array
{
    return [
        'location' => 'array', // o 'json'
    ];
}
```

### Mass assignment: `location` deve essere fillable

Se `location` arriva dal form (admin Resource / wizard) ed è un attributo del modello, deve essere ammesso:

```php
protected $fillable = [
    // ...
    'location',
];
```

---

## 🎓 Lezione Appresa

### Regola DRY/KISS

> **Mai usare `dehydrated(false)`** su campi che devono essere salvati.
> 
> `dehydrated(false)` è utile solo per:
> - Campi di sola visualizzazione
> - Campi temporanei (es. password confirmation)
> - Campi che non fanno parte del modello

### Pattern Correto

```php
// Per campi che generano dati complessi
CoordinatePicker::make('location')
    ->formatStateUsing(fn ($state) => is_string($state) ? json_decode($state, true) : $state)
    ->mutateDehydratedStateUsing(fn ($state) => json_encode($state));
```

---

## 🔗 Collegamenti

- [BMAD Story](./wizard-location-fix.story.md) - Tracciamento completo
- [Coordinate Picker Purpose](./coordinate-picker-purpose.md) - Architettura mappa
- [HasCoordinatePicker Trait](../app/Filament/Forms/Components/Traits/HasCoordinatePicker.php) - Codice sorgente

---

## ✅ Checklist Fix

- [x] Identificato root cause (`dehydrated(false)`)
- [x] Rimosse chiamate `dehydrated(false)`
- [x] Verificato data flow Livewire → Server
- [x] Aggiunto cast `array` nel modello Ticket
- [x] Testato salvataggio wizard
- [x] Documentato pattern corretto

---

**Data**: 2026-04-27
**Severity**: 🔴 Critical (blocca salvataggio ticket)
**Status**: ✅ Fixed & Documented
