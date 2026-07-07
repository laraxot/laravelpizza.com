# 🔴 USE MODELS, NOT DB::TABLE() - CRITICAL RULE

**Path**: `.agents/docs/rules/use-models-not-db-table.md`  
**Last Updated**: 2026-03-26  
**Status**: ✅ CRITICAL RULE  
**Priority**: BLOCKER

---

## 🎯 The Rule

> **MAI** usare `DB::table()` quando esiste un **MODELLO**.
> **SEMPRE** usare i **MODelli Eloquent** per query database.

**Example**:
```php
// ❌ SBAGLIATO - DB::table() quando esiste il modello
$betHistories = DB::table('bet_histories')
    ->where('predict_id', $predict->id)
    ->get();

// ✅ CORRETTO - Usa il MODELLO
$betHistories = BetHistory::query()
    ->where('predict_id', $predict->id)
    ->get();
```

---

## 🧠 The WHY (5 Levels)

### Level 1: Type Safety ❌

```php
// ❌ DB::table() restituisce stdClass
$bet = DB::table('bet_histories')->first();
// $bet->created_at è STRINGA!
$bet->created_at->diffForHumans(); // ❌ ERROR!

// ✅ MODELLO restituisce oggetto tipizzato
$bet = BetHistory::query()->first();
// $bet->created_at è CARBON!
$bet->created_at->diffForHumans(); // ✅ WORKS!
```

**Benefit**: Type safety, autocomplete, refactoring.

---

### Level 2: Relationships ⚠️

```php
// ❌ DB::table() - NO relationships
$bet = DB::table('bet_histories')->first();
// Come prendo il rating? Query manuale...
$rating = DB::table('ratings')->find($bet->rating_id);

// ✅ MODELLO - Relationships built-in
$bet = BetHistory::with(['rating'])->first();
// $bet->rating è già caricato!
$outcome = $bet->rating->title;
```

**Benefit**: Eager loading, no N+1 queries.

---

### Level 3: Casts & Mutators ✅

```php
// ❌ DB::table() - NO casts
$bet = DB::table('bet_histories')->first();
$value = (float) $bet->value; // Cast manuale
$qty = (int) $bet->qty; // Cast manuale

// ✅ MODELLO - Casts automatici
$bet = BetHistory::query()->first();
// value è già float, qty è già int!
$value = $bet->value;
$qty = $bet->qty;
```

**Benefit**: Type casting automatico, meno bug.

---

### Level 4: Scopes & Reusability ✅✅

```php
// ❌ DB::table() - NO scopes
$activeBets = DB::table('bet_histories')
    ->where('status', 'active')
    ->where('created_at', '>', now()->subDay())
    ->get();

// ✅ MODELLO - Scopes riutilizzabili
$activeBets = BetHistory::query()
    ->active()
    ->today()
    ->get();
```

**Benefit**: DRY, query riutilizzabili, manutenibilità.

---

### Level 5: Zen Architecture ✅✅✅

> "I modelli non sono solo classi. Sono **CONTRATTI** di dominio."

```php
// ❌ DB::table() - Ignora il dominio
DB::table('bet_histories')->...

// ✅ MODELLO - Rispetta il dominio
BetHistory::query()->...
```

**Philosophy**:
- Ogni tabella ha un **MODELLO**
- Ogni modello ha **RELATIONSHIPS**
- Ogni relazione ha **SIGNIFICATO**
- Il **SIGNIFICATO** è il **DOMINIO**
- Il **DOMINIO** è la **VERITÀ**

---

## 📊 Comparison

| Feature | DB::table() | MODELLO |
|---------|-------------|---------|
| **Type Safety** | ❌ stdClass | ✅ Classe tipizzata |
| **Relationships** | ❌ Manuali | ✅ Built-in |
| **Casts** | ❌ Manuali | ✅ Automatici |
| **Scopes** | ❌ Nessuno | ✅ Riutilizzabili |
| **Mutators** | ❌ Nessuno | ✅ Built-in |
| **Events** | ❌ Nessuno | ✅ Dispatch |
| **Testing** | ❌ Difficile | ✅ Mockable |
| **IDE Support** | ❌ Limitato | ✅ Completo |

---

## 🔍 How to Spot the Violation

### Red Flag 🚩

```php
// 🚩 RED FLAG: DB::table() quando esiste il modello
DB::table('bet_histories')->...
DB::table('transactions')->...
DB::table('ratings')->...
```

**Immediate Fix**:
```php
// ✅ Usa il modello
BetHistory::query()->...
Transaction::query()->...
Rating::query()->...
```

---

## 📋 Checklist

**BEFORE** usare `DB::table()`:

- [ ] Esiste un modello per questa tabella?
- [ ] Posso usare `Model::query()` invece?
- [ ] Ho bisogno di relationships?
- [ ] Ho bisogno di casts/mutators?
- [ ] Sto violando il dominio?

**IF** esiste un modello → **USE IT!**

---

## 🔗 Related Documentation

### AI Agents Docs
- **[Rules Index](00-INDEX.md)** - All rules
- **[XotBase Extension Rule](xotbase-extension-rule.md)** - XotBase philosophy
- **[Reusable Components](../guidelines/reusable-components-philosophy.md)** - DRY+KISS

### Module Docs
- **[BetHistory Model](../../laravel/Modules/Predict/app/Models/BetHistory.php)** - Source
- **[Transaction Model](../../laravel/Modules/Predict/app/Models/Transaction.php)** - Source

---

## 📝 Changelog

### 2026-03-26 - CRITICAL RULE ADDED
- ✅ Added "USE MODELS, NOT DB::TABLE()" rule
- ✅ Documented 5 levels of understanding
- ✅ Added comparison table
- ✅ Added examples (CORRECT vs WRONG)

---

**Maintained By**: AI Agents Team  
**Review Cycle**: Per-release  
**Next Review**: 2026-04-02  
**Enforcement**: 🔴 CRITICAL (violation = code review failure)
