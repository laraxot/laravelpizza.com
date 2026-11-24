---
title: "Git Conflict Inventory"
qmd: "ui wiki troubleshooting git merge conflict inventory md"
type: note
tags: [documentation]
---

# Git Conflict Inventory

<<<<<<< HEAD
- Owner: Modules/UI
- Ultimo sweep app PHP: 2026-11-24

## App PHP risolti (prefer `laraxot/dev` se HEAD vuoto)

- `app/Services/ComponentService.php` — stub SUPERSEDED
- `app/Services/ThemeService.php` — stub SUPERSEDED
- `app/Services/UIService.php` — stub SUPERSEDED (AssetAction diretto)
- `app/Services/Map/NullGeocodingService.php` — stub SUPERSEDED (canonico: Adapter)
- `app/Services/Map/NullMapService.php` — stub SUPERSEDED (canonico: Adapter)
- `app/Actions/GetUserDataAction.php` — docblock `@contract`
- `app/Actions/Block/GetAllBlocksAction.php` — docblock `@contract`
- `app/Actions/Block/ResolveLocalizedBlockDataAction.php` — `@contract` + guard `class_exists`
- `app/Traits/TableLayoutTrait.php` — senza `@phpstan-ignore`

## Notes

- Nessun `require empty.php`. Nessun `@phpstan-ignore` aggiunto.
- Guard intenzionali in `ResolveLocalizedBlockDataAction` (Cms opzionale) e Null*Adapter.
- Blade/tests con marker: fuori da questo sweep app.

## Backlinks

- [services-to-actions-ui](../../stories/services-to-actions-ui.story.md)
- [conflict-resolution](../../conflict-resolution.md)
=======
- Date: 2026-04-28
- Owner: Modules/UI
- Files with conflict markers: 2

## Files

- docs/strategy.md
- docs/studio_card_selector_implementation.md

## Notes

- Inventory generated from `rg -l "^(<<<<<<<|=======|>>>>>>>)"`.
- Use this list as a volatile coordination map; re-open each file before editing because other agents may resolve items in parallel.
>>>>>>> laraxot/dev
