---
id: cms-phpstan-swarm-bucket-grandi
title: PHPStan swarm bucket grandi — Cms
status: done
module: Cms
start_errors: 78
end_errors: 0
updated: 2026-10-20
qmd: "cms phpstan variable.unused alreadyNarrowedType GetStyleClass BlockData swarm"
# Facts GateGuard: (1) Non duplica multiple-records-cms né STORY-CMS-FOLIO-*; è la story lane PHPStan bucket grandi. (2) Link da docs/bmad/decision-log.md e README modulo. (3) Nuova perché lo scope TSV/wave è distinto dalle story Folio/records. (4) User: «Aggiorna/crea UNA story per modulo in docs/bmad/stories/».
type: story
tags: [docs, cms, bmad]
---

# Cms — PHPStan swarm (bucket grandi)

## Scopo del modulo
CMS pagine/blocchi Folio+Volt, Appearance (footer/headernav), Actions di tema/vista, DTO Wireable.

## Inventario TSV (start)
| identifier | count |
|---|---|
| variable.unused | 72 |
| staticMethod.impossibleType | 4 |
| staticMethod.alreadyNarrowedType | 2 |
| **totale** | **78** |

## Famiglie → scopo → causa → fix

1. **variable.unused** — smoke su Action/Page/Policy/Component con assegnazione non letta.  
   Fix (file freddi): assert proprietà (`FooterData::$view`, `BlockData` collection count, `toLivewire`), rimozione assert tautologici `::class`.

2. **alreadyNarrowedType** (`GetStyleClassActionTest`) — `assertSame(FQCN, $action::class)` sempre vero; sostituito con `new` / `method_exists('execute')` coerenti con lo scopo del test.

3. **impossibleType** (Volt Password/Verify) — path TSV; alcuni file HOT o già toccati da altre lane: SKIP se mtime &lt; 120s.

## Verifica
Chunk ≤10 file dai path TSV, `flock -w 1800 /tmp/phpstan-gate.lock`, solo `laravel/phpstan.neon`.

## Note
- Mai ignore/baseline.
- HOT skip: ResolvePageDataTest, BaseModelTest (e altri se concurrent).
- Link: [testing](../../testing.md), [bmad-variable-unused](../../bmad-variable-unused.md)
