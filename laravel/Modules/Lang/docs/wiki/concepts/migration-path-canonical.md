---
qmd: "migration path canonical"
issues: []
discussions: []
title: Path canonico migrazioni Lang
type: concept
module: Lang
tags: [migrations, nwidart, database, path, anti-pattern]
created: 2026-07-01
updated: 2026-11-05
related:
  - ../../redundancy-audit.md
  - ../../case-sensitivity-rules.md
  - ../../../../../../docs/wiki/index/llm-wiki.md
  - ../../../Xot/docs/wiki/rules/migration-filename-from-model-name.md
status: draft
---

# Path canonico migrazioni Lang

## Regola

| Vietato | Canonico |
|---------|----------|
| `database/Migrations/` | `database/migrations/` |
| `database/migrations/Migrations/` | `database/migrations/*.php` (file flat, nessuna sottocartella) |

nwidart e Laravel scoprono le migrazioni solo sotto **`database/migrations`** (minuscolo). Su Linux `Migrations` e `migrations` sono directory diverse: duplicati case-only rompono `php artisan migrate` e i submoduli.

La sottocartella **`migrations/Migrations/`** è un anti-pattern peggiore del solo CamelCase: sembra “corretto” ma Laravel **non** la carica; duplica file già presenti nel path canonico.

## Incidente 2026-07-01 (non ripetere)

1. `962d9fab2`: rimossa correttamente `Lang/database/migrations/Migrations/`.
2. `f840e0cc0`: **reintrodotta per errore** (`.gitkeep` + copia di `create_language_lines_table`); stesso pattern su `Cms/database/migrations/Migrations/`.
3. Causa probabile: agente che “sistema” il case spostando file nella cartella sbagliata invece di lasciare solo `database/migrations/`.

**Mai creare** `Migrations/` sotto `database/` a qualsiasi profondità. Spostare/rinominare solo verso `database/migrations/`; duplicati → `.bak` o `git rm`, non nuove cartelle.

## Stato modulo Lang

- Canonico: `laravel/Modules/Lang/database/migrations/` (file `.php` + `.gitkeep`)
- Vietato: qualsiasi `*/Migrations/` sotto `Lang/database/`
- Audit 2026-11-05: trovata una cartella legacy `database/Migrations/` con una
  variante `language_lines` e un backup `.old3`. Non è il path caricato dal
  provider Xot; la sua rimozione resta da pianificare dopo la verifica dei
  repository e dei deploy.

## Migrazioni canoniche per modello

| Modello | File migrazione |
|---------|-----------------|
| `Post` | `2026_01_21_211814_create_posts_table.php` |
| `Translation` | `2026_01_21_211815_create_translations_table.php` |
| `TranslationFile` | Sushi: nessuna tabella DB |
| `language_lines` | `2024_03_20_000001_create_language_lines_table.php`: tabella Spatie translation-loader (modello vendor, non modulo) |

Migrazioni additive per `Post` e `Translation`:

| Modello | File migrazione |
|---------|-----------------|
| `Post` | `2026_11_05_100000_update_posts_table.php` |
| `Translation` | `2026_11_05_100001_update_translations_table.php` |

Anche gli aggiornamenti usano la tabella plurale nel filename; l'azione è
esplicita e `$model_class` identifica il modello owner.

## Verifica

```bash
# Nessuna directory Migrations sotto database/ del modulo
find laravel/Modules/Lang/database -type d -name 'Migrations' | wc -l
# atteso: 0

ls laravel/Modules/Lang/database/migrations/

bash bashscripts/tools/audit-database-folder-lowercase.sh Lang
```

## Audit cross-modulo

```bash
find laravel/Modules -path '*/database/*' -type d -name 'Migrations' 2>/dev/null
# deve essere vuoto (esclude vendor e XotBaseMigration in app/Database/Migrations)
```
