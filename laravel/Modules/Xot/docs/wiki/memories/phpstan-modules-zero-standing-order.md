---
title: "PHPStan Modules Zero Standing Order"
type: memory
module: Xot
tags: [phpstan, standing-order, flock, conflict-markers, bmad, second-brain]
created: 2026-11-23
updated: 2026-11-23
qmd: "phpstan modules zero standing order flock cache parse prima dei tipi mixed ultima spiaggia"
related:
  - ../../../../../../bashscripts/docs/prompts/00-master-prompt.md
  - ../../../../../../bashscripts/docs/prompts/11-phpstan.md
  - ../../../../../../bashscripts/docs/prompts/INDEX.md
  - ../../stories/phpstan-merge-bootstrap.story.md
  - ../../stories/module-sync-stale-snapshot-and-phpstan-zero.story.md
  - ./merge-marker-spazzatura-worktree.md
---

# PHPStan Modules: ordine permanente

## Scopo

Tenere `cd laravel && ./vendor/bin/phpstan analyse Modules` a **zero** errori reali, senza scorciatoie, e continuare dopo lo zero (boy scout + Services→Actions).

## Vittoria verificata

Tutti nello stesso run:

1. `totals.errors = 0` e `totals.file_errors = 0` (JSON)
2. Banner `[OK] No errors`
3. Exit code `0`
4. Nessun messaggio «Result is incomplete because of severe errors»

Artifact: `laravel/storage/phpstan-runs/` (mai `/tmp`). Cache: `laravel/storage/phpstan` (`tmpDir` in neon).

## Ordine fisso prima di credere a un numero

1. **Parse** — `php -l`; zero marker `<<<<<<<` / `=======` / `>>>>>>>` in `*.php` (e idealmente anche in `*.md` / Blade: i md avvelenano il second brain).
2. **Bootstrap** — `GeneratedConfig.php` con estensioni > 0; vendor coerente con lock.
3. **Esclusione** — `flock` su `laravel/storage/phpstan-runs/gate.lock`; `clear-result-cache` prima della chiusura wave. Concorrenza sulla cache condivisa produce falsi `class.notFound`.
4. **Tipi** — solo dopo 1–3. `mixed` ultima spiaggia; mai `@phpstan-ignore*`; mai editare `laravel/phpstan.neon`.

## Decisioni gia' prese (non ri-litigare)

- Debito `tests/Arch/debt.php` `services => []` quando i Service sono migrati ad Actions (#247).
- Test AI con skip se `TestCase::moduleTablesMissing()` (#243).
- `Job/lang/it/status.php` con sezione `values` italiana per EnumTrait (#245).
- Cms FO: `@filamentStyles` / `@filamentScripts` sempre emessi (niente guard `panelAssets`).

## Dopo lo zero

Non fermarsi: boy scout, Services→Actions, docs moduli/temi, prompt canonici aggiornati se un fatto li smentisce.
