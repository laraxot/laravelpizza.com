---
title: "Xot - index.md"
module: Xot
bmad: true
status: active
---
# Xot Module - concepts Index

## Purpose
Index for Xot module concepts.

## On-Demand Loading

```bash
qmd search "Xot concepts" --limit 5
```

## Moduli & skeleton (2026-07-27)

- [module-theme-root-hygiene.md](./module-theme-root-hygiene.md) _(target mancante, verificato 2026-10-14)_: root lowercase, workspace, IDE folders vietate
- [module-providers-dual-registration-mandatory.md](./module-providers-dual-registration-mandatory.md) _(target mancante, verificato 2026-10-14)_: **min 2 provider** in `module.json` + `composer.json`
- [module-filament-panel-triad.md](./module-filament-panel-triad.md) _(target mancante, verificato 2026-10-14)_: **SSoT** trinità panel
- [module-config-php-religion.md](./module-config-php-religion.md) _(target mancante, verificato 2026-10-14)_: **obbligatorio** `Modules/{M}/config/config.php`
- [module-config-icon-svg.md](./module-config-icon-svg.md) _(target mancante, verificato 2026-10-14)_: `resources/svg/icon.svg` → `{alias}-icon`
- [module-admin-panel-provider-mandatory.md](./module-admin-panel-provider-mandatory.md) _(target mancante, verificato 2026-10-14)_: `AdminPanelProvider` + doppia registrazione
- [module-dashboard-page-mandatory.md](./module-dashboard-page-mandatory.md) _(target mancante, verificato 2026-10-14)_: **obbligatorio** `app/Filament/Pages/Dashboard.php`
- [module-providers-dual-registration-mandatory.md](./module-providers-dual-registration-mandatory.md) _(target mancante, verificato 2026-10-14)_: `module.json` + `composer.json`
- [module-model-artifact-parity.md](./module-model-artifact-parity.md) _(target mancante, verificato 2026-10-14)_: N modelli = N migrate + factory + seeder
- [composer-root-skeleton-modular.md](./composer-root-skeleton-modular.md) _(target mancante, verificato 2026-10-14)_: Root Composer minimo
- [module-testcase-xotbase-hierarchy.md](./module-testcase-xotbase-hierarchy.md) _(target mancante, verificato 2026-10-14)_: TestCase → XotBaseTestCase

## Migrazioni & Filament

- [migration-foreign-id-for.md](./migration-foreign-id-for.md) _(target mancante, verificato 2026-10-14)_: FK via modello
- [xotbase-filament-widget-hierarchy.md](./xotbase-filament-widget-hierarchy.md) _(target mancante, verificato 2026-10-14)_
- [no-app-support-queueable-actions.md](./no-app-support-queueable-actions.md) _(target mancante, verificato 2026-10-14)_: Actions, non Services

## PHPStan & qualità

- [xotbasemodel-get-class-name.md](./xotbasemodel-get-class-name.md) _(target mancante, verificato 2026-10-14)_: sibling model nel namespace leaf (`static::getClassName`)
- [phpstan-trait-probes.md](./phpstan-trait-probes.md) _(target mancante, verificato 2026-10-14)_: trait `unused` → probe host
- [trend-action-delegation.md](./trend-action-delegation.md) _(target mancante, verificato 2026-10-14)_: Action come confine
- [Ridondanze cross-cutting (hub)](./ridondanze-cross-cutting-codebase.md) _(target mancante, verificato 2026-10-14)_

## Composer

- [composer-merge-plugin-modules-only.md](./composer-merge-plugin-modules-only.md) _(target mancante, verificato 2026-10-14)_: merge solo moduli, mai temi

## See Also

- [Root Trigger Map](../../../../../../docs/wiki/rules/00-TRIGGER_MAP.md)
- Hub temi: [runtime-config-religion-hub](../../../../Themes/docs/shared-components/runtime-config-religion-hub.md) _(target mancante, verificato 2026-10-14)_
- Audit: `bash bashscripts/tools/audit-module-config-php.sh`

---
*Updated: 2026-07-27*