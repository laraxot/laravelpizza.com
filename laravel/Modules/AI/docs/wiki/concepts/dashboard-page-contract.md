---
qmd: "dashboard page contract"
issues: []
discussions: []
title: "AI Dashboard page contract"
type: concept
module: AI
status: approved
sources:
  - "../../../app/Filament/Pages/Dashboard.php"
  - "../../../../Xot/docs/wiki/concepts/module-dashboard-page-mandatory.md"
  - "../../../../../../docs/stories/2.4.module-theme-docs-hygiene.story.md"
confidence: high
created: 2026-09-25
updated: 2026-09-25
tags: [ai, filament, dashboard, xotbase, panel, contract]
related:
  - "../../../app/Filament/Pages/Dashboard.php"
  - "../../../../Xot/docs/wiki/concepts/module-dashboard-page-mandatory.md"
  - "../../../../../Themes/docs/shared-components/module-dashboard-page-religion.md"
  - "../../../../../../docs/stories/2.4.module-theme-docs-hygiene.story.md"
  - "../../../../../../docs/wiki/standards/module-theme-readme-dual.md"
---

# AI Dashboard page contract

## Decision

`Modules\AI\Filament\Pages\Dashboard` must extend
`Modules\Xot\Filament\Pages\XotBaseDashboard`:

```php
use Modules\Xot\Filament\Pages\XotBaseDashboard;

class Dashboard extends XotBaseDashboard
{
}
```

Un modulo può aggiungere una vista o contenuti specifici dopo aver dichiarato
il parent corretto; la view non sostituisce il contratto dashboard.

## Why

`XotBaseDashboard` is the module-panel landing contract. It extends Filament's
`Dashboard` page and supplies the shared widget/column defaults used by the
module panel. `XotBasePage` is a standalone page base with form and model
inference; it is not a drop-in replacement for a Filament dashboard.

The distinction is architectural, not cosmetic. Replacing the parent with
`XotBasePage` changes the page kind that Filament discovers for the module
`/admin` entry point, even if a view name is supplied. A view cannot restore
the missing dashboard contract.

A previous sync commit changed the parent from `XotBaseDashboard` to
`XotBasePage`; that was a regression against the repository contract recorded
in the Xot dashboard rule and in the module-panel triad. The current working
tree has been corrected to `XotBaseDashboard`. Keep the AI-specific view only
as content layered on top of that parent; do not add a compatibility page or a
second dashboard class.

## Ownership boundary

- **Modules** own the module `Dashboard.php`, its panel configuration, and its
  widgets.
- **Themes** document and consume the boundary; they do not register a module
  dashboard or replace `XotBaseDashboard`.
- **AI** owns only the AI-specific dashboard content and configuration layered
  on top of the shared Xot contract.

## Verification

1. Run `php -l Modules/AI/app/Filament/Pages/Dashboard.php` from `laravel/`.
2. Run the targeted PHPStan analysis for the AI module with the canonical
   `laravel/phpstan.neon` configuration.
3. Verify the class declaration and the panel discovery path before merging.

## References

- [Xot dashboard rule](../../../../Xot/docs/wiki/concepts/module-dashboard-page-mandatory.md)
- [Theme/module dashboard contract](../../../../../Themes/docs/shared-components/module-dashboard-page-religion.md)
- [BMAD docs hygiene story](../../../../../../docs/stories/2.4.module-theme-docs-hygiene.story.md)
- [Module/theme README standard](../../../../../../docs/wiki/standards/module-theme-readme-dual.md)
- [Dashboard source](../../../app/Filament/Pages/Dashboard.php)
