---
title: SettingPage di Tenant, pagina impostazioni senza campi
qmd: "Tenant SettingPage configurazione tenant BaseSettingPage Filament"
status: superseded
module: Tenant (owner)
created: 2026-11-04
related:
  - ./setting-page-campi-reali.story.md
  - ../../../Xot/docs/bmad/stories/setting-page-tutti-i-moduli.story.md
---

# SettingPage di Tenant

> Superata da [setting-page-campi-reali](./setting-page-campi-reali.story.md): il form vuoto e i tre campi senza lettore
> (`enabled`, `domain_routing`, `default_locale`) sono stati sostituiti da `title` e `logo_height` del file `metatag`.

## Fase BMAD

Build. Decisione dell'utente (2026-11-04): la pagina Impostazioni va in tutti i moduli. Storia
di decisione in Xot: `Modules/Xot/docs/bmad/stories/setting-page-tutti-i-moduli.story.md`.

## Intento

Il super-admin trova la voce Impostazioni in `Tenant`, su `/tenant/admin/setting`. Il form e' vuoto:
il modulo non ha ancora valori da cambiare senza deploy.

## File

- `app/Datas/TenantConfigData.php`: Data di configurazione, senza proprieta', legge `config/{tenant}/tenant.php`.
- `app/Filament/Pages/SettingPage.php`: estende `BaseSettingPage`, `getFormSchema()` vuoto.
- `lang/it/setting.php`, `lang/en/setting.php`: navigazione, titolo, azioni.
- `tests/Unit/Datas/TenantConfigDataTest.php`: convenzione nome e file tenant.

## Verifica

- Test: vedi il riepilogo di Xot (`setting-page-tutti-i-moduli.story.md`).
