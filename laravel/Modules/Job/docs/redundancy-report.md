- Inventario [ridondanze cross-modulo](../docs/redundancy-report.md)
- Concetti [ridondanze cross-cutting](../Xot/docs/wiki/concepts/ridondanze-cross-cutting-codebase.md)

# Redundancy Report — Modulo Job

> Generato: 2026-05-21 | Analisi automatica deep-scan

## Problemi Trovati

### 1. 🔴 BaseModel NON estende XotBaseModel

**File**: `app/Models/BaseModel.php`

```php
// ATTUALE (NON conforme)
abstract class BaseModel extends Model
{
    use HasFactory;
    use Updater;
}

// CORRETTO (conforme Laraxot)
abstract class BaseModel extends XotBaseModel {}
```

`XotBaseModel` include già `HasFactory`, `Updater` e la logica factory tramite `GetFactoryAction`.

### 2. 🟠 BaseMorphPivot NON estende XotBaseMorphPivot

**File**: `app/Models/BaseMorphPivot.php`

```php
// ATTUALE (NON conforme)
abstract class BaseMorphPivot extends MorphPivot
{
    use Updater;
}

// CORRETTO
abstract class BaseMorphPivot extends XotBaseMorphPivot {}
```

### 3. 🟡 EventServiceProvider — Non usa XotBaseEventServiceProvider

**File**: `app/Providers/EventServiceProvider.php`

Estende `BaseEventServiceProvider` (Laravel) invece di `XotBaseEventServiceProvider`.

## Riepilogo

| Priorità | Problema | Stato |
|----------|----------|-------|
| 🔴 | BaseModel non conforme | Da risolvere |
| 🟠 | BaseMorphPivot non conforme | Da risolvere |
| 🟡 | EventServiceProvider inconsistente | Da standardizzare |
