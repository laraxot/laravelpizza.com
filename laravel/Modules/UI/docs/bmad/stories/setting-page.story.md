---
title: SettingPage di UI, pagina impostazioni senza campi
qmd: "UI SettingPage configurazione tenant BaseSettingPage Filament"
status: superseded
module: UI (owner)
created: 2026-11-04
related:
  - ../../../Xot/docs/bmad/stories/setting-page-tutti-i-moduli.story.md
---

# SettingPage di UI

## Fase BMAD

Build. Decisione dell'utente (2026-11-04): la pagina Impostazioni va in tutti i moduli. Storia
di decisione in Xot: `Modules/Xot/docs/bmad/stories/setting-page-tutti-i-moduli.story.md`.

> Superata da [setting-page-campi-reali](./setting-page-campi-reali.story.md): la pagina ora ha un campo con lettore.

## Intento

Il super-admin trova la voce Impostazioni in `UI`, su `/ui/admin/setting`. Il form e' vuoto:
il modulo non ha ancora valori da cambiare senza deploy.

## File

- `app/Datas/UIConfigData.php`: Data di configurazione, senza proprieta', legge `config/{tenant}/ui.php`.
- `app/Filament/Pages/SettingPage.php`: estende `BaseSettingPage`, `getFormSchema()` vuoto.
- `lang/it/setting.php`, `lang/en/setting.php`: navigazione, titolo, azioni.
- `tests/Unit/Datas/UIConfigDataTest.php`: convenzione nome e file tenant.

## Verifica

- Test: vedi il riepilogo di Xot (`setting-page-tutti-i-moduli.story.md`).
