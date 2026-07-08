# Redundancy Report — Modulo Notify

> Generato: 2026-05-21 | Analisi automatica deep-scan

## Problemi Trovati

### 1. 🔴 BaseModel NON estende XotBaseModel

**File**: `app/Models/BaseModel.php`

```php
// ATTUALE (NON conforme)
abstract class BaseModel extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use Updater;
}

// CORRETTO — richiede verifica su XotBaseModel + HasMedia
abstract class BaseModel extends XotBaseModel implements HasMedia
{
    use InteractsWithMedia;
}
```

**Nota**: `XotBaseModel` include già `HasFactory` e `Updater`. L'unica aggiunta necessaria è `HasMedia` + `InteractsWithMedia`. Verificare che `XotBaseModel` non confligga con l'interfaccia `HasMedia`.

### 2. 🔴 BasePivot NON estende XotBasePivot

**File**: `app/Models/BasePivot.php`

```php
// ATTUALE (NON conforme)
abstract class BasePivot extends Pivot
{
    use Updater;
}

// CORRETTO
abstract class BasePivot extends XotBasePivot {}
```

### 3. 🟠 BaseMorphPivot NON estende XotBaseMorphPivot

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

### 4. 🟡 EventServiceProvider — Non usa XotBaseEventServiceProvider

**File**: `app/Providers/EventServiceProvider.php`

Estende `BaseEventServiceProvider` (Laravel) invece di `XotBaseEventServiceProvider`.

## Riepilogo

| Priorità | Problema | Stato |
|----------|----------|-------|
| 🔴 | BaseModel non conforme (+ HasMedia) | Da risolvere con attenzione |
| 🔴 | BasePivot non conforme | Da risolvere |
| 🟠 | BaseMorphPivot non conforme | Da risolvere |
| 🟡 | EventServiceProvider inconsistente | Da standardizzare |
