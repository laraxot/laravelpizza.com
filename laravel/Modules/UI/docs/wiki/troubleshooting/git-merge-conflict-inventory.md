---
title: "Git Conflict Inventory"
qmd: "ui wiki troubleshooting git merge conflict inventory md"
type: note
tags: [documentation]
---

# Git Conflict Inventory

- Owner: Modules/UI
- Ultimo sweep app+routes: 2026-11-24 (PHPStan boot lane)

## App PHP + routes risolti (prefer `laraxot/dev` se HEAD vuoto; stub routes senza `empty.php`)

- `routes/web.php` — stub vuoto (no `require` Xot/routes/empty.php)
- `routes/api.php` — stub vuoto (no `require` Xot/routes/empty.php)
- `app/Actions/GetUserDataAction.php` — docblock `@contract`
- `app/Actions/Icon/GetAllIconsAction.php` — docblock `@contract`
- `app/Actions/Datetime/GetDaysMappingAction.php` — docblock `@contract`
- `app/Actions/Panel/ApplyCalendarToPanelAction.php` — docblock `@contract`
- `app/Actions/Block/GetAllBlocksAction.php` — docblock `@contract`
- `app/Actions/Block/ResolveLocalizedBlockDataAction.php` — `@contract` + guard `class_exists` (Cms opzionale)
- `app/Services/ComponentService.php` — stub SUPERSEDED
- `app/Services/ThemeService.php` — stub SUPERSEDED
- `app/Services/UIService.php` — stub SUPERSEDED (AssetAction diretto)
- `app/Services/Map/NullGeocodingService.php` — stub SUPERSEDED (canonico: Adapter)
- `app/Services/Map/NullMapService.php` — stub SUPERSEDED (canonico: Adapter)
- `app/Traits/TableLayoutTrait.php` — senza `@phpstan-ignore`

## Notes

- Nessun `require empty.php`. Nessun `@phpstan-ignore` aggiunto.
- Guard intenzionali in `ResolveLocalizedBlockDataAction` (Cms opzionale) e Null*Adapter.
- Blade/tests/docs con marker: fuori da questo sweep app+routes (PHPStan boot).

## Backlinks

- [services-to-actions-ui](../../stories/services-to-actions-ui.story.md)
- [conflict-resolution](../../conflict-resolution.md)
- [ui-module-bmad-setup](../../stories/ui-module-bmad-setup.story.md)
