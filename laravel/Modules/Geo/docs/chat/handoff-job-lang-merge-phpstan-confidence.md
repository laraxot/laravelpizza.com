---
title: handoff sessione Job Lang merge PHPStan
type: chat
tags: [handoff, job, lang, phpstan, merge-conflicts, confidence]
updated: 2026-05-26
related:
  - ../wiki/how-to/git-merge-marker-sweep.md
  - ../wiki/memories/phpstan-modules-inventory.md
  - phpstan-modules-coordination.md
  - ../../laravel/Modules/Job/docs/wiki/memories/session-confidence-checkpoint.md
---

# Handoff — ripartenza agente (livello confidenza 2026-05-26)

## Leggere per primo (ordine)

1. Questo file
2. [`laravel/Modules/Job/docs/wiki/memories/session-confidence-checkpoint.md`](../../laravel/Modules/Job/docs/wiki/memories/session-confidence-checkpoint.md)
3. [`docs/wiki/memories/module-github-remote-discipline.md`](../wiki/memories/module-github-remote-discipline.md)
4. [`laravel/Modules/Job/docs/merge-conflicts-list.md`](../../laravel/Modules/Job/docs/merge-conflicts-list.md)

## Cosa è provato (non ri-fare da zero)

| Verifica | Esito |
|----------|--------|
| `git grep '^<<<<<<< '` su mono (ultimo sweep) | **0** marker; ultimo fix **Notify** 2026-05-26 (svg + tabelle) |
| `phpstan analyse Modules/Job` da `laravel/` | **OK** (305 file) |
| `phpstan analyse Modules/Lang` | **8 errori** — chiavi duplicate in 2 file lang IT |
| `php -l` Job policies / tabelle toccate | OK |

## Fix applicati (mono, non ancora necessariamente su repo modulo)

- **Job:** 8 policy vuote su `JobBasePolicy`; Filament Tables/Forms (HEAD); `JobServiceProvider` (`}` spuria + `registerQueue()` commentato); PHPDoc `SchedulesTable`, `FailedImportRowsTable` con `Filament\Tables\Columns\Column`.
- **Lang:** `WriteTranslationFileAction.php` conflitto risolto (HEAD).
- **Doc Job wiki:** `index.md`, `log.md` senza URL org fissi — issue modulo via `git remote -v`.

## Aperto / prossima sessione

1. **Lang PHPStan:** `lang/it/locale_switcher_refresh.php`, `lang/it/translation_editor.php` — rimuovere chiavi duplicate (`label`, `plural_label`, `navigation`, `actions`).
2. **Job ridondanza:** `JobBatchesTable` vs `JobBatchsTable`; policy boilerplate — issue discussione sul repo da `git remote -v` in `Modules/Job` (#13 se già creata).
3. **Sweep residuo:** `git grep '^<<<<<<< '` su `*.md` / altri moduli (lista in `merge-conflicts-list.md` template).
4. **Sync modulo:** dopo fix, portare commit da mono al repo indicato da `git remote -v` nel modulo (mai `git checkout` di vecchie versioni per “ripristinare”).
5. **Notify bootstrap globale:** fatal storico `EditMailTemplate::$resource` protected vs `LangBaseEditRecord` — può bloccare `phpstan` su path ampi se non isolato per modulo.

## Comandi ripartenza

```bash
cd laravel
git grep -n '^<<<<<<< ' -- '*.php' '*.blade.php'
./vendor/bin/phpstan analyse Modules/Job --memory-limit=2G
./vendor/bin/phpstan analyse Modules/Lang --memory-limit=2G
cd Modules/Job && git remote -v   # issue / PR modulo
cd ../.. && git remote -v         # mono: provtv/base_ptv_fila5_mono
```

## Issue e tracciamento

- **Mono:** `git remote -v` in root → `gh issue list` (merge collision, PHPStan #136).
- **Moduli/temi:** `git remote -v` in `laravel/Modules/<Nome>` o `Themes/<Nome>` — meta + ridondanza batch 2026-05-26: [`module-theme-github-issues-manifest.md`](module-theme-github-issues-manifest.md), how-to [`../wiki/how-to/module-theme-github-issues.md`](../wiki/how-to/module-theme-github-issues.md).
- **Doc modulo:** solo `#numero` issue, no URL org fissi.

## Regole sessione

- Risoluzione collisioni: **HEAD/current** salvo analisi manuale (es. tabelle Filament).
- Post-edit PHP: PHPStan L10, `./tools/phpmd.sh`, `./tools/phpinsights.sh` da `laravel/`.
- Git: `git show` / `git log -p` per studiare; **mai** ripristinare file vecchi con checkout.

## Firma sessione

**Agente AI:** Auto (Cursor agent router) · **Modello:** Composer
