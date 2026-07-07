---
title: "XotBaseMigration Timestamps Rule - Single Authority Pattern"
type: rule
tags: [xotbasemigration, timestamps, dry-kiss, idempotency, migrations]
created: 2026-06-05
updated: 2026-06-05
qmd: "xotbasemigration timestamps rule updateTimestamps single authority dry kiss"
related:
  - MIGRATION_PHILOSOPHY.md
  - ../wiki/rules/module-congruence-rule.md
---

# XotBaseMigration Timestamps Rule

## 🌟 Regola Fondamentale

**USA SOLO `updateTimestamps(table: $table, hasSoftDeletes: true|false)`**

*Non usare mai combinazioni di `$table->timestamps()`, `$table->softDeletes()` o dichiarazioni manuali di `created_by`/`updated_by`/`deleted_by`.*

## Perché Questa Regola Esiste

| Principio | Applicazione |
|-----------|--------------|
| **DRY** | Un'unica fonte di verità per timestamp, soft deletes e audit actors |
| **KISS** | Nessuna duplicazione di codice, leggibilità immediata |
| **Idempotenza** | `updateTimestamps()` verifica l'esistenza dei campi prima di aggiungerli |
| **Manutenibilità** | Tutti i cambiamenti vengono centralizzati in un unico posto |

## Pattern Corretto vs Errato

```php
// ✅ CORRETTO - Single authority
$this->tableCreate(static function (Blueprint $table): void {
    $table->id();
    $table->string('title');
    
    // Unica chiamata per timestamp + audit actors
    $this->updateTimestamps($table, hasSoftDeletes: true);
});

$this->tableUpdate(function (Blueprint $table): void {
    // updateTimestamps è idempotente, non serve guard aggiuntivo
    $this->updateTimestamps($table, hasSoftDeletes: true);
});
```

```php
// ❌ ERRATO - Ridondante
$this->tableCreate(static function (Blueprint $table): void {
    $table->id();
    $table->string('title');
    
    $table->timestamps();           // ❌ DOUBTOLO
    $table->softDeletes();          // ❌ DOUBTOLO
    $table->string('created_by');    // ❌ DOUBTOLO - formato sbagliato
    $table->string('updated_by');    // ❌ DOUBTOLO - formato sbagliato
});

$this->tableUpdate(function (Blueprint $table): void {
    $this->updateTimestamps($table, hasSoftDeletes: true);  // ❌ DUPLICAZIONE
});
```

## Cos'è Gestito da `updateTimestamps()`

| Campo | Tipo | Nullable | Descrizione |
|-------|------|----------|-------------|
| `created_at` | timestamp | Sì | Data/ora creazione record |
| `updated_at` | timestamp | Sì | Data/ora ultima modifica |
| `created_by` | foreignId | Sì | Riferimento all'utente creatore |
| `updated_by` | foreignId | Sì | Riferimento all'utente modificatore |
| `deleted_at` | timestamp | Sì | Soft delete (se `hasSoftDeletes: true`) |
| `deleted_by` | foreignId | Sì | Riferimento all'utente cancellatore |

## Metodi Disponibili

### `updateTimestamps(Blueprint $table, bool $hasSoftDeletes = false)`

Aggiunge i campi solo se non esistono già:

- ✅ Idempotente - sicuro da chiamare più volte
- ✅ Verifica l'esistenza di ogni colonna con `hasColumn()`
- ✅ Aggiunge soft delete solo se richiesto
- ✅ Gestisce automaticamente `deleted_by` se `deleted_at` esiste

### `timestamps(Blueprint $table, bool $hasSoftDeletes = false)` - **RIMOSSO**

Questo metodo è stato **rimosso** da `XotBaseMigration` il 2026-06-05 perché:

1. Non è idempotente - aggiunge colonne anche se già esistenti
2. Crea duplicazione con `updateTimestamps()`
3. È un anti-pattern DRY/KISS

## Lista di Controllo per Nuove Migrazioni

- [ ] Usare SOLO `$this->updateTimestamps(table: $table, hasSoftDeletes: ...)`?
- [ ] Non includere `$table->timestamps()` né `$table->softDeletes()`?
- [ ] Non dichiarare manualmente `created_by`, `updated_by`, `deleted_by`?
- [ ] Testare che la migrazione sia idempotente (`php artisan migrate` due volte)?

## Modulo Coinvolto

| Modulo | Numero migrazioni da verificare |
|--------|--------------------------------|
| Blog | ~12 file |
| User | ~10 file |
| Activity | ~5 file |
| Comment | ~2 file |
| Notify | ~5 file |
| Geo | ~2 file |
| Lang | ~1 file |
| Fixcity | ~5 file |

## Riferimenti

- [Migrazione Philosophy](MIGRATION_PHILOSOPHY.md) - Single Source of Truth
- [Module Congruence Rule](docs/wiki/rules/module-congruence-rule.md) - 1:1:1:1
- [DRY KISS Refactoring](DRY_KISS_REFACTORING.md) - Principi generali

---

*Claude (`claude-opus-4-8`) - 2026-06-05*