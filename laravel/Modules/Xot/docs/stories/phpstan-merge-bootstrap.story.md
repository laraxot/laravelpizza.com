---
title: "[STORY] PHPStan merge bootstrap — conflitti PHP in Modules/Xot"
type: story
module: Xot
bmad: true
status: done
priority: high
tags: [phpstan, merge, conflict-markers, xot, bootstrap]
qmd: "phpstan merge bootstrap conflict markers xot modules resolve forward-only"
related:
  - ./fix-merge-conflicts.md
  - ./module-sync-stale-snapshot-and-phpstan-zero.story.md
---

# PHPStan merge bootstrap — conflitti PHP in `Modules/Xot`

## Scopo

Sbloccare il parse PHP (e quindi PHPStan/Larastan) rimuovendo **tutti** i marker di merge
(`<<<<<<<` / `=======` / `>>>>>>>`) dai file `*.php` sotto `laravel/Modules/Xot`, senza
checkout/restore/reset (forward-only), tenendo entrambe le funzionalità utili (DRY+KISS).

## Claim table

| Agent | Path | Claim | Esito |
|-------|------|-------|-------|
| agent-xot-swarm | `app/Actions/File/AssetAction.php` | phpstan-xot-merge | resolved |
| agent-xot-swarm | `app/Database/Migrations/XotBaseMigration.php` | phpstan-xot-merge | resolved |
| agent-xot-swarm | `app/Datas/XotData.php` | phpstan-xot-merge | resolved |
| agent-xot-swarm | `app/Models/Traits/HasCommonScopes.php` | phpstan-xot-merge | resolved |
| agent-xot-swarm | `app/Traits/HasCustomRelations.php` | phpstan-xot-merge | resolved |
| agent-xot-swarm | `app/Traits/HasSchemalessAttributes.php` | phpstan-xot-merge | resolved |
| agent-xot-swarm | `lang/it/health_overview.php` | phpstan-xot-merge | resolved |
| agent-xot-swarm | `tests/XotBaseTestCase.php` | phpstan-xot-merge | resolved |
| agent-xot-swarm | `tests/Unit/Actions/File/AssetActionsTest.php` | phpstan-xot-merge | resolved |

## Cosa è stato fixato e perché

| File | Decisione | Perché |
|------|-----------|--------|
| `AssetAction.php` | Early-exit se file in `public/`; fallback `resources/`; URL con `Str::lower($ns)`; doc symlink = deploy.sh **e** `xot:module-link` | Unisce symlink-first + URL case-safe Linux |
| `XotBaseMigration.php` | Firma con `preserveLegacyValues` + lista id in errore + path char(36) | Conserva guardia dati **e** path migrazione reversibile |
| `XotData.php` | `is_file` + fallback Notify se `$key !== ''` | Tema senza mail-layouts non rompe reset/modelli email |
| `HasCommonScopes` / `HasCustomRelations` / `HasSchemalessAttributes` | Docblock con riga vuota; rimossi `@phpstan-ignore` | Conflitto era solo spacing; ignore vietati dalle regole |
| `health_overview.php` | Tenuta chiave `sections.empty` | Serve al pattern Filament/lang espanso |
| `XotBaseTestCase.php` | `app(ResolveSharedSqlitePathAction::class)` via import | Stesso comportamento, DRY sull'FQCN |
| `AssetActionsTest.php` | Assert su `assets/xotassettest/...` | Allineato a `Str::lower` in AssetAction |

## Verifica

```bash
rg -l '^<<<<<<<' laravel/Modules/Xot --glob '*.php'   # atteso: vuoto
php -l <ciascun-file>                               # No syntax errors
```

## Collegamenti

- Story sync/stale: [module-sync-stale-snapshot-and-phpstan-zero.story.md](./module-sync-stale-snapshot-and-phpstan-zero.story.md)
- Nota storica conflitti: [fix-merge-conflicts.md](./fix-merge-conflicts.md)
