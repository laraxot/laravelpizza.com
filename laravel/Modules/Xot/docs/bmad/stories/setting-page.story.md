---
title: SettingPage di Xot, pagina impostazioni senza campi
qmd: "Xot SettingPage configurazione tenant BaseSettingPage Filament"
status: in-progress
module: Xot (owner)
created: 2026-11-04
related:
  - ./setting-page-tutti-i-moduli.story.md
---

# SettingPage di Xot

## Fase BMAD

Build. Decisione dell'utente (2026-11-04): la pagina Impostazioni va in tutti i moduli. Storia
di decisione in Xot: `Modules/Xot/docs/bmad/stories/setting-page-tutti-i-moduli.story.md`.

## Intento

Il super-admin trova la voce Impostazioni in `Xot`, su `/xot/admin/setting`. Il form e' vuoto:
il modulo non ha ancora valori da cambiare senza deploy.

## File

- `app/Datas/XotConfigData.php`: Data di configurazione, senza proprieta', legge `config/{tenant}/xot.php`.
- `app/Filament/Pages/SettingPage.php`: estende `BaseSettingPage`, `getFormSchema()` vuoto.
- `lang/it/setting.php`, `lang/en/setting.php`: navigazione, titolo, azioni.
- `tests/Unit/Datas/XotConfigDataTest.php`: convenzione nome e file tenant.

## Verifica

- Test: vedi il riepilogo di Xot (`setting-page-tutti-i-moduli.story.md`).
