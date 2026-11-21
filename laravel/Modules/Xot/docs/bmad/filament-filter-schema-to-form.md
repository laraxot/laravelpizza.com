---
title: "Filament 5 table filters: schema() → form()"
status: active
type: note
tags: [filament, phpstan, filters, xot]
qmd: "filament 5 BaseFilter schema deprecated use form table filters phpstan method.deprecated"
---

# Filament 5 — filtri tabella: `schema()` → `form()`

## Perché
In Filament ≥ 5.11.2 i campi di un filtro tabella si dichiarano con `BaseFilter::form()`.
`schema()` è alias deprecato (`HasForm::schema` → `@deprecated Use form()`).
PHPStan `method.deprecated` segnala i call-site ancora su `schema()`.

Sotto 5.11.0/5.11.1 la deprecazione era invertita: vincolo progetto `filament/filament: ^5.11.2`
(vedi storia completa sotto).

## Cosa fare / non fare
- **Sì:** `Filter::make(...)->form([...])` / `$this->form([...])` su classi filtro.
- **No:** sostituire `->schema(` su Form Resource/Page, GroupColumn, Action modal, Infolist — API diverse.

## Scope verificato (2026-11-16)
Call-site filtro già su `form()` in:

- `FilterBuilder::dateRange`
- `Modules/Ptv/.../Tables/Filters/*`
- `IndividualePesisTable`, `Asz00fsTable`, `ProgressionisTable`, `RatingsTable` (Progressioni / Indennita*)
- `CondizioniLavoroAdmsTable`

Residuo rimosso: blocco commentato `$this->schema(` in `XotBaseTernaryFilter`.

Gate: `phpstan analyse Modules/<Mod>` → `method.deprecated` = 0 sui moduli sopra.

## Related
- [filament-5-11-2-filter-form-naming.story.md](../stories/filament-5-11-2-filter-form-naming.story.md) — storia ping-pong vendor
- [phpstan-modules-swarm-random.story.md](stories/phpstan-modules-swarm-random.story.md)
- [phpstan-modules-remediation.story.md](stories/phpstan-modules-remediation.story.md)
