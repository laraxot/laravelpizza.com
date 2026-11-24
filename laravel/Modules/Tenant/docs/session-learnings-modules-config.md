---
qmd: "session learnings modules config"
issues: []
discussions: []
title: session learnings modules and tenant config
type: concept
module: Tenant
tags: [tenant, modules, config, permission, learnings]
created: 2026-07-27
updated: 2026-07-27
related:
  - ./tenant-module-status-registry.md
  - ./it/config/modules-statuses.md
  - ../WorkOrder/docs/modules-statuses-workorder.md
  - ../User/docs/wiki/concepts/spatie-permission-table-names.md
  - ../Xot/docs/wiki/concepts/module-admin-panel-provider-mandatory.md
  - ../Xot/docs/wiki/concepts/module-filament-panel-triad.md
  - ../Xot/docs/wiki/concepts/basemodel-connection-religion.md
  - ../WorkOrder/docs/profile-schema-ownership.md
---

# Lezioni 2026-07-27 — moduli, tenant, config

Hub sintetico per agenti: cosa è successo, perché, dove documentare.

## 1. `modules_statuses.json` tenant workorder

**Problema:** `config/local/workorder/modules_statuses.json` stale (altro progetto) + `modules.php` non puntava al file tenant.

**Fix:** 38 moduli con `module.json` → tutti `true`; rimossi fantasma (`DbForge`, `FormBuilder`, nomi legacy multi-verticale).

**SSoT fisico:** solo directory con `Modules/{Name}/module.json`.

**Doc:** [tenant-module-status-registry.md](./tenant-module-status-registry.md) · [it/config/modules-statuses.md](./it/config/modules-statuses.md) · [WorkOrder/modules-statuses-workorder.md](../WorkOrder/docs/modules-statuses-workorder.md)

## 2. `config/config.php` per modulo

**Problema:** 21 moduli senza metadati panel (`name`, `icon`, `navigation`).

**Fix:** audit 38/38 con `config/config.php` completo.

**Doc:** [Xot/module-config-php-religion.md](../Xot/docs/wiki/concepts/module-config-php-religion.md)

## 3. `permission.php` — `table_names` intoccabile

**Problema:** agente ha rinominato tabelle / hardcodato `model_has_roles` invece di leggere config.

**Regola:** `laravel/config/permission.php` → pivot **singolari** (`model_has_role`, …). Codice e migrazioni **seguono** config. Overlay tenant: solo `models`, mai `table_names`.

**Doc:** [User/spatie-permission-table-names.md](../User/docs/wiki/concepts/spatie-permission-table-names.md)

## 4. `profiles` — owner schema WorkOrder

**Problema:** `Field 'id' doesn't have a default value` — legacy UUID PK senza default.

**Fix:** migrazione canonica in **WorkOrder** (`main_module`); duplicati User in `_bak`.

**Doc:** [WorkOrder/profile-schema-ownership.md](../WorkOrder/docs/profile-schema-ownership.md)

## 5. `BaseModel::$connection` obbligatorio

Ogni modulo dichiara `protected $connection = '{snake}'` nel proprio `BaseModel` — mai `null`.

**Doc:** [Xot/basemodel-connection-religion.md](../Xot/docs/wiki/concepts/basemodel-connection-religion.md)

## 6. `app/Filament/Pages/Dashboard.php` per ogni modulo

**Problema:** panel `{modulo}/admin` senza landing — `discoverPages()` non trova `Dashboard`.

**Regola:** classe vuota `extends XotBaseDashboard`.

**Doc:** [Xot/module-dashboard-page-mandatory.md](../Xot/docs/wiki/concepts/module-dashboard-page-mandatory.md)

## 7. `AdminPanelProvider` + doppia registrazione

**Problema:** nessun panel `{modulo}/admin` — file assente, non in `module.json`, o mancante in `composer.json`.

**Regola:** `extends XotBasePanelProvider` + `protected string $module` + **stessi provider** in `module.json` e `composer.json`.

**Doc:** [module-admin-panel-provider-mandatory.md](../Xot/docs/wiki/concepts/module-admin-panel-provider-mandatory.md) · [trinità panel](../Xot/docs/wiki/concepts/module-filament-panel-triad.md) · [doppia registrazione](../../Themes/docs/shared-components/module-providers-dual-registration-religion.md)

## Perché gli audit precedenti non bastavano

| Audit fatto | Cosa NON copriva |
|-------------|------------------|
| `Modules/*/config/config.php` | JSON tenant in `config/local/workorder/` |
| PHPStan / migrate runtime | Navigazione Filament (`GetTenantModulesAction`) |
| `laravel/modules_statuses.json` root | Override `config/local/workorder/modules.php` |

**Regola:** nuovo modulo → 2 provider allineati in `module.json` + `composer.json` + trinità Filament + **entrambi** i `modules_statuses.json` + migrazione owner se ha modelli.

**Audit:**

```bash
bash bashscripts/tools/audit-module-providers-dual-registration.sh
bash bashscripts/tools/audit-module-config-php.sh
bash bashscripts/tools/audit-module-admin-panel-provider.sh
bash bashscripts/tools/audit-module-dashboard-page.sh
```

**Sync tenant:** `bash bashscripts/tools/sync-tenant-modules-statuses.sh local/workorder`

## Themes

I temi non gestiscono il registro, ma subiscono menu incompleto:

- [Themes/tenant-modules-navigation-discipline.md](../../Themes/docs/tenant-modules-navigation-discipline.md)
- [Themes/runtime-config-religion-hub.md](../../Themes/docs/shared-components/runtime-config-religion-hub.md)
