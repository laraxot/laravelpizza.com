---
title: "Naming delle migrazioni dal modello"
type: rule
module: Xot
status: active
created: 2026-11-05
updated: 2026-11-05
tags: [migration, naming, model, database]
qmd: "migration filename timestamp model plural snake case table XotBaseMigration model_class additive"
related:
  - ../../migration-standards.md
  - ../../../../Lang/docs/migrations.md
  - ../../bmad/decision-log.md
---
# Naming delle migrazioni dal modello

## Regola

Il timestamp è seguito da un'azione descrittiva e dal nome **plurale** del
modello in `snake_case`, terminando con `_table.php`:

```text
YYYY_MM_DD_HHMMSS_<azione>_<modello_plurale>_table.php
```

Esempi:

- `2026_08_06_190100_create_translations_table.php`
- `2026_11_05_100001_update_translations_table.php`

`create_<modello_plurale>_table` consente a `XotBaseMigration` di derivare il
modello e il modulo dal filename. Le azioni additive come `update` non sono
auto-derivabili: dichiarare `protected ?string $model_class = Translation::class;`.

Il suffisso descrittivo deve restare legato alla tabella owner; non codificare
nel filename i dettagli delle singole colonne (`user_id_uuid`). Il codice
migration e la story descrivono lo scopo specifico dell'aggiornamento.

## Forward-only

Il ledger Laravel identifica una migrazione per filename: una rinomina può
renderla pendente e causare una nuova esecuzione. Prima di rinominare un file già
distribuito verificare il ledger e dimostrare che il corpo è idempotente; in caso
contrario conservare il file storico e aggiungere una migrazione forward-only con
nuovo timestamp. Le migrazioni UUID Lang sono state rinominate mantenendo il
timestamp perché l'helper salta lo schema già convertito e blocca valori legacy
senza mapping verificabile.

Ogni modello ha un solo owner per la creazione della propria tabella. Le
migrazioni additive sono evoluzioni successive dello stesso schema e devono
usare `tableUpdate()` con guardie, senza una seconda creazione concorrente.

## Verifica

1. Ricavare il nome plurale dalla convenzione di tabella del modello (`getTable()`),
   non inventare un plurale a mano.
2. Per un `create_*_table`, controllare che `XotBaseMigration::getModelClass()`
   derivi la classe attesa. Per le altre azioni dichiarare `$model_class`.
3. Cercare collisioni dello stesso timestamp e duplicazioni `create_*` owner.
4. Non modificare migrazioni già distribuite senza prima verificare il ledger;
   preferire una migrazione forward-only idempotente.

## Inventario verificato

L'audit dei percorsi canonici minuscoli `Modules/*/database/migrations/` ha
contato 252 file: 245 rispettano il formato `YYYY_MM_DD_HHMMSS_azione_tabella_table.php`.
Le sette eccezioni trovate sono:

- `Activity/2026_02_13_171410_fix_causer_id_to_uuid.php`
- `Sigma/2026_09_30_create_import_logs_table.php`
- `Sigma/2026_09_30_create_import_trackers_table.php`
- `User/2026_02_13_172135_add_lang_column.php`
- `User/2026_10_16_000001_fix_profiles_id_autoincrement.php`
- `User/2026_10_22_000001_repair_users_type_state_columns.php`
- `User/2026_11_04_220000_add_query_supporting_indexes.php`

Questi filename sono già presenti nello storico: non rinominarli senza controllo
del ledger di tutti gli ambienti e prova di idempotenza. I file Sigma usano la
data senza la componente `HHMMSS`. Il file Activity è riconducibile a
`activities`; i quattro file User a `users`/`profiles`;
quello sugli indici interessa tre tabelle e non ha un unico modello owner. Anche il percorso
legacy maiuscolo `Lang/database/Migrations/2024_03_20_000001_create_language_lines_table.php`
va verificato rispetto al loader prima di spostarlo o rimuoverlo. Queste eccezioni
sono debito storico censito, non esempi da replicare per nuove migrazioni.
