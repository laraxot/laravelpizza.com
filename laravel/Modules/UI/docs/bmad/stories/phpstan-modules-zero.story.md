---
title: "UI: PHPStan Modules/UI → 0"
type: story
module: UI
status: done
epic: code-quality
created: 2026-11-16
updated: 2026-11-16
tags: [phpstan, ui, geo-boundary, auditcoverage, filament, bmad]
qmd: "UI phpstan modules zero LocationSelector Geo AuditCoverage ThemeMetadataData GroupColumn"
lock: phpstan-ui
owned_scope:
  - laravel/Modules/UI/app/Filament/Forms/Components/LocationSelector.php
  - laravel/Modules/UI/tests/AuditCoverage/
  - laravel/Modules/UI/app/Datas/ThemeMetadataData.php
  - laravel/Modules/UI/tests/Feature/GroupColumnTest.php
  - laravel/Modules/UI/docs/geo-boundary.md
references:
  - ../../geo-boundary.md
  - ../../wiki/concepts/ui-geo-boundary-contracts.md
  - ../../wiki/troubleshooting/phpstan-fixes.md
  - ../../stories/7.14.phpstan-locationselector-geo-boundary-cleanup.story.md
  - ./phpstan-conflict-markers-bootstrap.story.md
supersedes:
  - ./phpstan-ui-geo-auditcoverage-zero.story.md
---

# Story: PHPStan Modules/UI → 0

## Scopo / perché

`Modules/UI` è il design system Filament (form/table components, blocchi, theme
helpers). PHPStan a zero serve a:

1. Non far passare di nuovo dipendenze verso un dominio assente (`Modules\Geo`).
2. Non tenere stub di coverage morti che sporcano il gate.
3. Tipizzare i DTO tema e i test Feature senza `mixed` / ignore.

Inventario di partenza: `/tmp/phpstan_ptvx_fila5/modules/UI.json` → **112**
`file_errors` (77 file).

## Inventario iniziale (112)

| Famiglia | N | Root cause |
|---|---:|---|
| `staticMethod.notFound` | 74 | `tests/AuditCoverage/*` chiama `assertTrue` senza `TestCase` |
| `class.notFound` + `method.nonObject` + `return.type` | 36 | `LocationSelector` → `Modules\Geo\Models\Comune` (Geo assente) |
| `throws.notThrowable` | 1 | `ThemeMetadataData` `@throws InvalidArgumentException` nel namespace UI\Datas |
| `variable.unused` | 1 | `$fields` non letto in `GroupColumnTest` |

## Decisioni (KISS, no ignore, no mixed)

1. **LocationSelector** — non è un componente UI: cascading regione/provincia/CAP
   è dominio Geo. `Modules/Geo` non esiste. **`git rm`**, non stub/`class_exists`.
   Canone: [geo-boundary.md](../../geo-boundary.md), story 7.14 (reimport dopo
   cleanup → re-rimozione).
2. **AuditCoverage** — 74 stub anti-pattern (già vietati). **Rimossi**, non
   convertiti in TestCase.
3. **ThemeMetadataData** — `@throws \InvalidArgumentException` (FQCN globale).
4. **GroupColumnTest** — eliminata variabile `$fields` inutilizzata; il test
   resta sul comportamento `data_get` del record.

## Verifica

```bash
cd laravel && php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/UI
# [OK] No errors — file_errors: 0
```

Misura: **112 → 0**.

## Pest

Host non produzione (`192.168.1.40`). Gate mirato: `GroupColumnTest` (unico test
toccato). Nessuna logica runtime aggiunta: rimozione file fuori confine +
docblock FQCN.

## Criteri di accettazione

- [x] PHPStan `Modules/UI` = 0
- [x] Nessun `@phpstan-ignore` / baseline nuova
- [x] Nessun `mixed` introdotto
- [x] Docs confine Geo aggiornati
- [x] Lock `phpstan-ui` rilasciato a fine lavoro
