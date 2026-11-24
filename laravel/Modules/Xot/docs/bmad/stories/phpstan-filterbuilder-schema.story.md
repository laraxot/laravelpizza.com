---
id: xot-phpstan-filterbuilder-schema-20261123
title: PHPStan residuali FilterBuilder form + CanonicalBladeViewPath
type: story
module: Xot
epic: quality/phpstan
status: done
qmd: "phpstan filterbuilder form schema BaseFilter CanonicalBladeViewPathTest"
related:
  - ../filament-filter-schema-to-form.md
  - ../../architecture/canonical-blade-view-path.md
  - ../../../../User/docs/bmad/stories/phpstan-filter-form-schema.story.md
---

# Scopo

Chiudere 3 segnalazioni PHPStan residuali su Xot(+User) senza ignore e senza
invertire l'API Filament corretta.

## Acceptance criteria

- [x] `FilterBuilder::dateRange` resta su `->form([...])` (Filament tables ≥ 5.11.2).
- [x] Nessuna conversione a `->schema()` sui table filter (sarebbe deprecata).
- [x] `CanonicalBladeViewPathTest` senza `assertIsString` tautologico; assertion
      sul path blade canonico/legacy mantenute e rafforzate.
- [x] Docs modulo aggiornati (nota filter + canonical blade path).
- [x] Riga sprint-status `Xot/phpstan-filterbuilder-schema-20261123`.

## Root cause

1. **Filter form vs schema** — report stale/invertito: su `HasForm` (tables)
   `schema()` è `@deprecated Use form()`. Reflection su vendor v5.12.0 conferma
   `form()` non deprecato. Confusione tipica con Actions (`HasSchema`: lì
   `form()` → `schema()`).
2. **CanonicalBladeViewPathTest** — `assertIsString($relative)` su valore già
   `string` → `staticMethod.alreadyNarrowedType`. Copertura riscritta su shape
   del path e freeze list legacy.

## Gate

- `php -l` sui file toccati: OK (FilterBuilder, UsersRelationManager, CanonicalBladeViewPathTest).
- PHPStan mirato (flock): **[OK] No errors** su FilterBuilder + UsersRelationManager +
  CanonicalBladeViewPathTest (dopo calo carico host).
- Pest mirato `CanonicalBladeViewPathTest`: **skip** — `TestDatabaseGuard` rifiuta
  host remoto `10.100.200.53` (`.env.testing`); 0 assertions, fail di bootstrap non
  di logica. Da rieseguire su host locale/`*_test` consentito.
