# 🔴 XotBase Extension Rule - PHILOSOPHY

**Path**: `.agents/docs/rules/xotbase-extension-rule.md`  
**Last Updated**: 2026-03-26  
**Status**: ✅ PHILOSOPHY DEFINED  
**Priority**: BLOCKER

---

## 🎯 The Rule

> **TUTTI** i widget FILAMENT devono estendere `XotBaseWidget`
> **TUTTI** i table widget devono estendere `XotBaseTableWidget`

**Example**:
```php
// ✅ CORRETTO
class OutcomesTableWidget extends XotBaseTableWidget

// ❌ SBAGLIATO
class OutcomesTableWidget extends FilamentTableWidget
```

---

## 🧠 The WHY (5 Levels of Understanding)

### Level 1: Blind Obedience ❌

```php
// ❌ SBAGLIATO: Solo per obbedienza
class OutcomesTableWidget extends XotBaseTableWidget
// "Lo faccio perché è una regola"
```

**Problem**: Non capisci il perché, prima o poi violerai la regola.

---

### Level 2: Technical Understanding ⚠️

```php
// ✅ CORRETTO: Capisci i benefici tecnici
class OutcomesTableWidget extends XotBaseTableWidget
// "XotBaseTableWidget ha già configuration, permissions, styling"
```

**Benefits**:
- ✅ Configuration già impostata
- ✅ Permissions già definite
- ✅ Styling già coerente
- ✅ Methods già implementati

**Still Missing**: La visione d'insieme.

---

### Level 3: Architectural Understanding ✅

```php
// ✅✅ CORRETTO: Capisci l'ecosistema
class OutcomesTableWidget extends XotBaseTableWidget
// "Fa parte di un ECOSISTEMA: XotBaseResource → XotBaseTableWidget → XotBaseAction"
```

**Ecosystem**:
```
XotBaseResource (CRUD)
    ↓
XotBaseTableWidget (Display)
    ↓
XotBaseAction (Business Logic)
```

**Benefits**:
- ✅ Tutti i widget comunicano tramite contratti
- ✅ Tutti seguono le stesse convenzioni
- ✅ Cambi un posto, cambi tutti

**Still Missing**: La filosofia profonda.

---

### Level 4: DRY+KISS Philosophy ✅✅

```php
// ✅✅✅ CORRETTO: Incarni DRY+KISS
class OutcomesTableWidget extends XotBaseTableWidget
// "DRY: Non riscrivo configuration, permissions, styling"
// "KISS: Un solo posto dove cambiare il comportamento di TUTTI i widget"
```

**DRY (Don't Repeat Yourself)**:
- ❌ **PRIMA**: 10 widget, 10 configuration, 10 permissions, 10 styling
- ✅ **ADESSO**: 1 XotBaseWidget, 10 widget ereditano

**KISS (Keep It Simple, Stupid)**:
- ❌ **PRIMA**: Cambi 10 file per cambiare un comportamento
- ✅ **ADESSO**: Cambi 1 file (XotBaseWidget), cambi 10 widget

**Still Missing**: Lo Zen.

---

### Level 5: Zen Architecture ✅✅✅

```php
// ✅✅✅✅ CORRETTO: Realizzi lo Zen
class OutcomesTableWidget extends XotBaseTableWidget
// "XotBaseTableWidget è VUOTO. La sua forza è la sua VUOTEZZA."
```

**Zen Philosophy**:
> "XotBaseTableWidget non sa di Predict, non sa di Blog, non sa di Events.
> È AGNOSTICO, come il container blade.
> La sua forza è la sua VUOTEZZA.
> Può contenere QUALSIASI cosa."

**The Void**:
```php
abstract class XotBaseTableWidget extends FilamentTableWidget
{
    // È VUOTO di dipendenze specifiche
    // Non ha conoscenza del dominio
    // È PURA forma, pronto a ricevere QUALSIASI contenuto
}
```

**Why This is Powerful**:
- ✅ **Agnostico**: Funziona per Predict, Blog, Events, Profiles
- ✅ **Estensibile**: Puoi aggiungere features a TUTTI i widget cambiando 1 file
- ✅ **Coerente**: Tutti i widget hanno lo stesso comportamento base
- ✅ **Manutenibile**: Fix in 1 posto, fix everywhere

---

## 📜 The Constitution of Laraxot

```
📜 COSTITUZIONE LARAXOT - Articolo 1

"Tutti i widget FILAMENT devono estendere XotBaseWidget.
Tutti i table widget devono estendere XotBaseTableWidget.

La ragione è DRY+KISS+Zen.

Non estendiamo per obbedienza.
Estendiamo per COMPRENSIONE.

Ogni widget che estende XotBaseWidget
è un mattone nel nostro castello di cristallo.
Fragile se singolo, indistruttibile se unito."
```

---

## 🔍 Real Example: OutcomesTableWidget

### Before (Wrong) ❌

```php
// ❌ SBAGLIATO: Estende FilamentTableWidget direttamente
class OutcomesTableWidget extends FilamentTableWidget
{
    // Devi riscrivere TUTTO
    protected static ?string $pollingInterval = '5s';
    protected static int $perPage = 12;
    
    // Configuration duplicata
    // Permissions duplicate
    // Styling duplicato
}
```

**Problems**:
- ❌ Duplica configuration in 10 widget
- ❌ Cambi polling interval in 10 file
- ❌ Cambi permissions in 10 file
- ❌ Styling incoerente

### After (Correct) ✅

```php
// ✅ CORRETTO: Estende XotBaseTableWidget
class OutcomesTableWidget extends XotBaseTableWidget
{
    // Eredita configuration, permissions, styling
    // Scrivi SOLO ciò che è specifico di Outcomes
    
    public function table(Table $table): Table
    {
        return $table
            ->columns([
                // Colonne specifiche di Outcomes
            ]);
    }
}
```

**Benefits**:
- ✅ Configuration centralizzata in XotBaseTableWidget
- ✅ Permissions centralizzate
- ✅ Styling coerente
- ✅ Cambi 1 file, cambi 10 widget

---

## 🎯 When to Override

### Override ✅ CORRETTO

```php
class OutcomesTableWidget extends XotBaseTableWidget
{
    // ✅ Override SOLO se necessario
    protected static ?string $pollingInterval = '10s'; // Diverso dal default
    
    public function table(Table $table): Table
    {
        return $table
            ->columns([
                // Colonne specifiche di Outcomes
            ]);
    }
}
```

### Override ❌ SBAGLIATO

```php
class OutcomesTableWidget extends XotBaseTableWidget
{
    // ❌ Override INUTILE (duplica il default)
    protected static ?string $pollingInterval = '5s'; // Già default in XotBaseTableWidget
    
    protected static int $perPage = 12; // Già default in XotBaseTableWidget
}
```

**Rule**: Override SOLO se diverso dal default.

---

## 📊 Impact Analysis

### Before XotBase (Chaos)

```
10 Widget → 10 Configuration → 10 Permissions → 10 Styling
                ↓
        100 righe duplicate
        10 file da cambiare per 1 modifica
        Incoerenza garantita
```

### After XotBase (Order)

```
10 Widget → 1 XotBaseWidget → 0 duplicazioni
                ↓
        1 file da cambiare per 1 modifica
        Coerenza garantita
```

---

## 🔗 Related Documentation

### Module Docs
- **[OutcomesTableWidget](../../laravel/Modules/Predict/Filament/Widgets/OutcomesTableWidget.php)** - Actual implementation
- **[XotBaseTableWidget](../../laravel/Modules/Xot/app/Filament/Widgets/XotBaseTableWidget.php)** - Base class

### AI Agents Docs
- **[Rules Index](00-INDEX.md)** - All rules
- **[Reusable Components](../guidelines/reusable-components-philosophy.md)** - DRY+KISS philosophy

---

## 📝 Changelog

### 2026-03-26 - Philosophy Defined
- ✅ Documented 5 levels of understanding
- ✅ Added Constitution of Laraxot
- ✅ Real example: OutcomesTableWidget
- ✅ Impact analysis (Before/After)

---

**Maintained By**: AI Agents Team  
**Review Cycle**: Per-release  
**Next Review**: 2026-04-02  
**Status**: ✅ Production Ready
