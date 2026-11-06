---
title: "Migrazione SettingPage Notify alla base comune"
status: done
module: Notify (owner), Xot
created: 2026-11-04
updated: 2026-11-04
type: story
qmd: "Notify SettingPage BaseSettingPage EnvWidget configurazione tenant env segreti"
related:
  - ../../../Xot/docs/stories/base-setting-page.story.md
  - ../../../Xot/docs/stories/module-setting-pages.epic.md
---

# Migrazione SettingPage Notify alla base comune

## Contesto e decisione

Notify era l'unico modulo con una `SettingPage` autonoma basata su `XotBasePage`.
L'epic Xot aveva escluso il modulo dalla base perché la schermata gestisce `.env`
con `EnvWidget`, non configurazione tenant. La pagina può comunque estendere
`BaseSettingPage`: il form tenant rimane vuoto e il widget header mantiene la
funzione esistente. La base non salva dati fino all'invio esplicito del form; i
segreti restano nel flusso EnvData/.env e non entrano in `notify.php` tenant.

## Acceptance criteria

- [x] La pagina Notify estende `BaseSettingPage` e mantiene vista e icona.
- [x] `getFormSchema()` è vuoto: Notify non possiede `NotifyConfigData` né campi
      tenant amministrabili in questa schermata.
- [x] `EnvWidget` conserva la whitelist esistente e resta nell'header.
- [x] Epic Xot aggiornata per riflettere la distinzione tra configurazione tenant
      e configurazione `.env`.
- [x] Pest mirato verde in ambiente non produttivo (`SettingPageTest`: 1 test, 1
      assertion).

## File e verifica

- `app/Filament/Pages/SettingPage.php`
- `docs/bmad/stories/setting-page-base-migration.story.md`
- Verifica: `php -l` OK, Pint OK, PHPStan mirato OK (0 errori), Pest mirato OK.
