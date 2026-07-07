- Inventario [ridondanze cross-modulo](../docs/redundancy-report.md)
- Concetti [ridondanze cross-cutting](../Xot/docs/wiki/concepts/ridondanze-cross-cutting-codebase.md)

# Redundancy Report — Modulo Lang

> Generato: 2026-05-21 | Analisi automatica deep-scan

## Problemi Trovati

### 1. 🟠 BaseMorphPivot NON estende XotBaseMorphPivot

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

### 2. 🟠 BaseModelLang — Duplicato con Cms

| File | Modulo |
|------|--------|
| `app/Models/BaseModelLang.php` | Lang |
| `Modules/Cms/app/Models/BaseModelLang.php` | Cms |

Verificare quale è la versione canonica. Lang, essendo il modulo di traduzione, dovrebbe essere l'owner.

### 3. 🟡 AutoLabelAction — Versione canonica (Lang è owner)

**File**: `app/Actions/Filament/AutoLabelAction.php`

Questa è la versione completa con SVG, traduzioni, HtmlString. Esiste una copia ridotta in `Modules/Xot/app/Actions/Filament/AutoLabelAction.php` che dovrebbe essere eliminata.

**Nota**: Lang è il modulo canonico per `AutoLabelAction` perché gestisce traduzioni.

### 4. 🟡 EventServiceProvider — Non usa XotBaseEventServiceProvider

**File**: `app/Providers/EventServiceProvider.php`

Estende `BaseEventServiceProvider` (Laravel) invece di `XotBaseEventServiceProvider`.

## Riepilogo

| Priorità | Problema | Stato |
|----------|----------|-------|
| 🟠 | BaseMorphPivot non conforme | Da risolvere |
| 🟠 | BaseModelLang duplicato con Cms | Da verificare |
| 🟡 | AutoLabelAction è la versione canonica | OK — Xot va pulito |
| 🟡 | EventServiceProvider inconsistente | Da standardizzare |
