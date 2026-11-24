---
tags: [documentation]
created: 2026-09-26
issues: []
discussions: []
title: "Story — phpstan analyse Modules, fix fleet (2026-09-24)"
type: story
module: Xot
epic: quality
story_id: "phpstan-modules-2026-09-24"
status: done
track: quality/fleet
updated: 2026-09-24
qmd: "phpstan analyse Modules fix fleet swarm parallelo random RatingData AuditCoverage deep"
related:
  - ./phpstan-analyse-modules-2026-09-24.story.md
  - ../../../../Rating/docs/wiki/rules/no-trait-name-static-calls.md
  - ../../../../../../docs/wiki/memories/phpstan-merge-conflict-lock-coordination.md
  - ../concepts/tests-audit-coverage-forbidden.md
---
# phpstan-modules-2026-09-24

## Perche'

Richiesta: `cd laravel && ./vendor/bin/phpstan analyse Modules` e fix di tutti
gli errori, swarm in parallelo in ordine random, BMAD + second brain.

## Acceptance criteria

- [x] Run `phpstan analyse Modules` eseguito
- [x] Errori raggruppati per modulo, fix paralleli (Rating / IR / UI)
- [x] Root cause, no ignore/baseline/`phpstan.neon`
- [x] PHPStan finale `[OK] No errors`
- [x] Pest su test Rating toccati (o skip ambientale documentato)
- [x] Lock + story + memoria second brain

## Finding (inventario)

Prima run completa (post transient `audit-coverage` parse T_SL): **71 file_errors**

| Modulo | Errori | Root cause |
|--------|--------|------------|
| Rating | ~49 | API `RatingData::*` assente (corpo perso); `tests/AuditCoverage/` vietata; probe `RatingPhpstanTraitProbe` |
| IndennitaResponsabilita | ~21 | cascading su `RatingData` + typehint `RatingContract` |
| UI | 1 | `trait.unused` su `EnsuresUiDatabaseSchema` orfano |

## Fix (swarm random parallelo)

1. **Rating** — ripristinata API su `RatingData` (`ratingFieldName`, `formFieldLabel`, `ratingValuePath`, `ratingXlsValuePath`, `criteriaToXlsFields`, `getXlsFields`); rimossa `tests/AuditCoverage/`; rimosso probe vietato; gitignore già conforme.
2. **UI** — rimossa cartella `tests/Support` orfana / trait unused.
3. **IR** — errori cascading risolti dal ripristino RatingData; `clearEvaluation` vive su `HasRatingsTrait` via `BaseScheda`.

## Gate

```text
./vendor/bin/phpstan analyse Modules → [OK] No errors
phpstan clear-result-cache necessario dopo delete probe (phpstan.path stale)
```

## Follow-up race (Activity markers)

Dopo il verde PHPStan, sync concorrente ha reiniettato marker in
`Modules/Activity/app/**` (~20 file) → Pest falliva al boot. Swarm A/B/C ha
ripulito `app/`; `markers_app=0`. Marker residui possibili solo sotto
`tests/` (fuori path PHPStan tipico) — debito separato se emergono.

## Gate finale

```text
./vendor/bin/phpstan analyse Modules → [OK] No errors  (peer out + cache clear)
app markers <<<<<<< → 0
Pest Rating unit: skip ambientale — DB_HOST=10.100.200.53 DOWN (tcp 3306 timeout);
  host corrente 192.168.1.40 ≠ 10.100.200.15 quindi Pest ammessi ma DB irraggiungibile.
sprint-status.yaml: lock tenuto da opencode-phpstan — aggiornamento deferito a peer.
```

## Deep pass (richiesta «sistema le segnalazioni… a fondo»)

Second brain: `00-TRIGGER_MAP` → `tests-audit-coverage-forbidden`,
`merge-remote-repo-2-reinjects-conflict-markers`, `git-merge-marker-sweep`.

Inventario fresco: **16 errori** = solo `Rating/tests/AuditCoverage/001…016`
(`staticMethod.notFound` su `assertTrue`) — scaffold AI reiniettato alle 20:33
nonostante `.gitignore`. Class-load fatals: **0**. Marker `app/**/*.php`: **0**.

Fix root-cause:
1. `rm -rf Modules/Rating/tests/AuditCoverage` + `ensure-audit-coverage-gitignore.sh`
2. **Archeologia**: ripristinati verbatim da `8d7f3c1a` i 5 harness Xot
   (`ModuleBusinessCoverage`, `ModuleDeepCoverage`, `ModuleExecuteCoverage`,
   `ModuleRemainingCoverage`, `FilamentSchemaCoverage`) — cancellati → **394**
   `class.notFound` fleet-wide (canon `phpstan-status.md`)
3. Marker `app/**` a 0; class-load fatals 0

Gate deep: `phpstan analyse Modules` → **`[OK] No errors` EXIT 0** (certify post-harness).

## Esito

**done**. Pest skip: `DB_HOST=10.100.200.53` DOWN. Memoria:
`docs/wiki/memories/phpstan-modules-swarm-session.md`.
