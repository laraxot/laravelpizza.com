---
title: "Filament 5 table filters: schema() → form()"
status: active
type: note
tags: [filament, phpstan, filters, xot]
qmd: "filament 5 BaseFilter schema deprecated use form table filters phpstan method.deprecated"
---

# Filament 5 — filtri tabella: `schema()` → `form()`

## Perché
In Filament ≥ 5.11.2 (verificato su `filament/tables` **v5.12.0**) i campi di un
filtro tabella si dichiarano con `BaseFilter::form()`
(`Filament\Tables\Filters\Concerns\HasForm`).
`schema()` è alias deprecato (`@deprecated Use form()`).
PHPStan `method.deprecated` segnala i call-site ancora su `schema()`.

Sotto 5.11.0/5.11.1 la deprecazione era invertita. Report PHPStan che dicono
«`form()` deprecato → usa `schema()`» su `BaseFilter` sono **stale o invertiti**:
non seguirli. Source-first sul trait vendor batte il messaggio del report.

Attenzione: su **Actions** (`Filament\Actions\Concerns\HasSchema`) vale l'opposto
(`form()` deprecato → `schema()`). Non confondere le due API.

## Cosa fare / non fare
- **Sì:** `Filter::make(...)->form([...])` / `$this->form([...])` su classi filtro.
- **No:** sostituire `->schema(` su Form Resource/Page, GroupColumn, Action modal, Infolist — API diverse.
- **No:** cambiare `FilterBuilder` / `UsersRelationManager` da `form()` a `schema()`.

## Scope verificato
Call-site filtro già su `form()` in:

- `FilterBuilder::dateRange`
- `User/.../UsersRelationManager::getTableFilters`
- `Modules/Ptv/.../Tables/Filters/*`
- `IndividualePesisTable`, `Asz00fsTable`, `ProgressionisTable`, `RatingsTable` (Progressioni / Indennita*)
- `CondizioniLavoroAdmsTable`

Residuo rimosso: blocco commentato `$this->schema(` in `XotBaseTernaryFilter`.

Gate: `phpstan analyse` mirato sui file → `method.deprecated` = 0 se vendor ≥ 5.11.2.

## Related
- [phpstan-filterbuilder-schema.story.md](stories/phpstan-filterbuilder-schema.story.md)
- [filament-5-11-2-filter-form-naming.story.md](../stories/filament-5-11-2-filter-form-naming.story.md) — storia ping-pong vendor
- [phpstan-modules-swarm-random.story.md](stories/phpstan-modules-swarm-random.story.md)
- [phpstan-modules-remediation.story.md](stories/phpstan-modules-remediation.story.md)
