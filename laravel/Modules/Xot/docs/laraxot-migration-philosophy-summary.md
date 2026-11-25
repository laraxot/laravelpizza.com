---
title: "Filosofia delle migrazioni Laraxot"
type: rule
status: active
module: Xot
qmd: "migrazioni XotBaseMigration una tabella una migrazione tableCreate tableUpdate idempotente dati sacri updateTimestamps"
updated: 2026-11-25
---

# Filosofia delle migrazioni Laraxot

**Un modello, una tabella, una migrazione owner, un modulo.** Ogni modello Eloquent persistente ha una sola migrazione di creazione, nel modulo che possiede
il modello; l'evoluzione dello schema sono migrazioni additive successive. Mai due `create_<tabella>_table.php` per la stessa tabella.

## Perche'

- una sola fonte per lo schema: nessuna ambiguita' su quale migrazione definisce la tabella "vera", ordine di esecuzione identico in ogni ambiente;
- il modello si deduce dal nome del file: `XotBaseMigration::getModelClass()` ricava la classe da `{timestamp}_create_{modello_snake_plurale}_table.php`
  (namespace `Modules\<Modulo>\Models\<Modello>`), quindi il nome file segue il **modello**, non la tabella fisica;
- connessione e nome tabella arrivano dal modello (`getTable()`, `getConnectionName()`), mai hardcoded nella migrazione.

## Struttura di una migrazione

Classe anonima che estende `Modules\Xot\Database\Migrations\XotBaseMigration`:

```php
return new class extends XotBaseMigration
{
    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {   // crea solo se la tabella non esiste
            $table->id();
            $table->string('email')->nullable()->index();
        });

        $this->tableUpdate(function (Blueprint $table): void {   // aggiunte idempotenti
            if (! $this->hasColumn('extra')) {
                $table->schemalessAttributes('extra');
            }
            $this->updateTimestamps(table: $table, hasSoftDeletes: true);
        });
    }
};
```

| Helper della base | Uso |
|---|---|
| `tableCreate(Closure, ?string $table)` | `Schema::create` solo se la tabella manca |
| `tableUpdate(Closure, ?string $table)` | crea se manca, altrimenti `Schema::table`; e' qui che vanno le colonne nuove |
| `hasColumn()`, `hasTable()`, `tableExists()`, `hasIndex()`, `getColumnType()`, `isColumnType()` | guardie per rendere ri-eseguibile ogni passo |
| `updateTimestamps($table, $hasSoftDeletes)` | aggiunge solo i campi mancanti: `created_at`, `updated_at`, `created_by`, `updated_by` (e `deleted_at`, `deleted_by`) |
| `foreignIdFor($table, Model::class, ?string $column)` | FK costruita dal modello, non da un nome di tabella a mano |
| `ensureIndexes()` | crea solo gli indici che mancano, mai li toglie |
| `shouldRun()` | hook per l'esecuzione condizionale (default `true`) |

## Regole

1. **Solo aggiunte**: nuove colonne in `tableUpdate()` dietro `hasColumn()`; mai rimuovere colonne ne' tabelle, mai cambiare tipo in modo distruttivo.
   Per una modifica di schema su una tabella esistente: nuova migrazione `add_{colonna}_to_{tabella}` o un nuovo ramo idempotente nella migrazione owner.
2. **Niente `down()` distruttivo**: le migrazioni del progetto non definiscono `down()`; il `down()` ereditato dalla base fa `dropTableIfExists`, quindi
   rollback, `migrate:fresh` e `migrate:refresh` non si usano sui dati reali.
3. **Dati sacri**: l'agente non decide mai `migrate:fresh`, `migrate:refresh` o `--force`, e i test non usano `RefreshDatabase` (vedi [testing.md](testing.md)).
4. **N modelli = N migrazioni**, con factory e seeder paralleli; un pivot e' un modello (estende `XotBasePivot`) e ha la sua migrazione.
5. Legacy: `adoptPluralLegacyTableNameIfNeeded()` rinomina una tabella plurale storica verso il nome del modello, solo se la tabella target non esiste.

## Guardie

- `tests/Unit/XotMigrationDeepBranchesTest.php`, `tests/Unit/XotMigrationUuidModelClassCoverageTest.php` (rami di `XotBaseMigration`).
- Audit statico del progetto: un solo `create_*_table` per modello (ADR 0004).

## Decisioni collegate

- [adr/0004-one-model-one-migration.md](adr/0004-one-model-one-migration.md)
- [adr/0013-dati-sacri-migrazioni-e-test.md](adr/0013-dati-sacri-migrazioni-e-test.md)
