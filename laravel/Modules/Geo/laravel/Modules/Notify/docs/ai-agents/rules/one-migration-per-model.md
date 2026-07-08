# 🔴 ONE MIGRATION PER MODEL - CRITICAL RULE

**Path**: `.agents/docs/rules/one-migration-per-model.md`  
**Last Updated**: 2026-03-26  
**Status**: ✅ CRITICAL RULE  
**Priority**: BLOCKER

---

## 🎯 The Rule

> **SEMPRE** 1 MIGRAZIONE PER 1 MODELLO.
> **MAI** creare migrazioni separate per aggiungere colonne.
> **TUTTE** le colonne devono essere nella migrazione **ORIGINALE** del modello.

**Example**:
```php
// ❌ SBAGLIATO - Migrazione separata per aggiungere colonna
// File: 2026_03_26_000000_add_value_to_ratings_table.php
return new class extends XotBaseMigration {
    public function up(): void
    {
        $this->tableUpdate(function (Blueprint $table): void {
            $table->decimal('value', 10, 2)->nullable();
        });
    }
};

// ✅ CORRETTO - Colonna nella migrazione originale
// File: 2026_03_12_180000_create_ratings_table.php
return new class extends XotBaseMigration {
    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->decimal('value', 10, 2)->nullable(); // ✅ Qui!
        });
    }
};
```

---

## 🧠 The WHY (Philosophy)

### Level 1: DRY Principle ❌

```
❌ SBAGLIATO:
- Migrazione originale: 10 colonne
- Migrazione #2: aggiungo 1 colonna
- Migrazione #3: aggiungo 1 colonna
- ...
- 10 migrazioni per 1 modello!

✅ CORRETTO:
- 1 migrazione originale
- TUTTE le colonne lì
- 0 migrazioni separate
```

**Benefit**: DRY - Don't Repeat Yourself.

---

### Level 2: KISS Principle ⚠️

```
❌ SBAGLIATO:
- 10 file di migrazione
- Devi leggerli tutti per capire lo schema
- Difficile capire quali colonne esistono

✅ CORRETTO:
- 1 file di migrazione
- Tutte le colonne visibili
- Facile capire lo schema
```

**Benefit**: KISS - Keep It Simple, Stupid.

---

### Level 3: Version Control ✅

```
❌ SBAGLIATO:
- 10 migrazioni = 10 commit
- Git history confuso
- Difficile fare rollback

✅ CORRETTO:
- 1 migrazione = 1 commit
- Git history chiaro
- Facile fare rollback
```

**Benefit**: Clean Git history.

---

### Level 4: Database Schema ✅✅

```
❌ SBAGLIATO:
- Schema frammentato
- Devi eseguire 10 migrazioni
- Rischio di errori

✅ CORRETTO:
- Schema completo
- 1 migrazione
- Zero rischi
```

**Benefit**: Reliable database schema.

---

### Level 5: Zen Architecture ✅✅✅

> "La migrazione è il **CONTRATTO** del modello."

```
1 migrazione = 1 modello = 1 contratto

Se il contratto cambia, aggiorni il contratto.
Non crei 10 contratti separati.

La migrazione originale è la **VERITÀ**.
Tutto il resto è **RUMORE**.
```

**Philosophy**: One Model, One Migration, One Truth.

---

## 📊 Comparison

| Aspect | Multiple Migrations | One Migration |
|--------|-------------------|---------------|
| **Files** | ❌ 10+ files | ✅ 1 file |
| **Readability** | ❌ Low | ✅ High |
| **Maintainability** | ❌ Low | ✅ High |
| **Git History** | ❌ Confused | ✅ Clear |
| **Rollback** | ❌ Difficult | ✅ Easy |
| **DRY** | ❌ Violated | ✅ Followed |
| **KISS** | ❌ Complex | ✅ Simple |

---

## 🔍 How to Spot the Violation

### Red Flag 🚩

```php
// 🚩 RED FLAG: Nome del file
2026_03_26_000000_add_value_to_ratings_table.php
2026_03_27_000000_add_color_to_users_table.php
2026_03_28_000000_add_status_to_posts_table.php

// ✅ CORRETTO: Nome del file
2026_03_12_180000_create_ratings_table.php
2026_03_12_180000_create_users_table.php
2026_03_12_180000_create_posts_table.php
```

**Rule**: Se il nome contiene `add_*_to_*_table`, è **SBAGLIATO**!

---

## 📋 Checklist

**BEFORE** committing migrations:

- [ ] **1 modello** = **1 migrazione**?
- [ ] **TUTTE** le colonne nella migrazione originale?
- [ ] **ZERO** migrazioni `add_*_to_*_table`?
- [ ] Nome file: `create_*_table.php`?
- [ ] **DRY** (nessuna ripetizione)?
- [ ] **KISS** (semplice e chiaro)?

**IF** migrazione separata → **ELIMINARE** e aggiornare originale!

---

## 🔗 Related Documentation

### AI Agents Docs
- **[Rules Index](00-INDEX.md)** - All rules
- **[DRY Principle](../guidelines/dry-kiss.md)** - DRY + KISS
- **[Translation Structure](translation-structure-5-levels.md)** - 5 levels rule

### Module Docs
- **[Rating Model](../../laravel/Modules/Rating/app/Models/Rating.php)** - Model source
- **[Rating Migration](../../laravel/Modules/Rating/database/migrations/2026_03_12_180000_create_ratings_table.php)** - Migration source

---

## 📝 Changelog

### 2026-03-26 - CRITICAL RULE ADDED
- ✅ Added "ONE MIGRATION PER MODEL" rule
- ✅ Documented 5 levels of philosophy
- ✅ Comparison table
- ✅ Checklist
- ✅ Examples (CORRECT vs WRONG)

**NOTE**: Questa regola è stata violata **UNA VOLTA**.
**ORA È PERMANENTE**. **MAI PIÙ** violazioni!

---

**Maintained By**: AI Agents Team  
**Review Cycle**: Per-release  
**Next Review**: 2026-04-02  
**Enforcement**: 🔴 CRITICAL (violation = code review failure)
