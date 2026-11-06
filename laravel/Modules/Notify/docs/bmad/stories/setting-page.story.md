---
title: NotifyConfigData, la SettingPage di Notify si apre
qmd: "Notify SettingPage configurazione tenant BaseSettingPage Filament"
status: superseded
module: Notify (owner)
created: 2026-11-04
related:
  - ./setting-page-access-and-name.story.md
  - ../../../Xot/docs/bmad/stories/setting-page-tutti-i-moduli.story.md
---

# NotifyConfigData, la SettingPage di Notify si apre

## Fase BMAD

Build. Bug trovato durante la decisione "SettingPage in tutti i moduli"
(`Xot/docs/stories/setting-page-tutti-i-moduli.story.md`).

## Problema

La `SettingPage` di Notify estende `BaseSettingPage`, che in `mount()` chiama
`getConfigDataClass()`. Notify non aveva `NotifyConfigData`: l'`Assert::notNull` falliva alla
prima apertura della pagina.

## Intervento

- `app/Datas/NotifyConfigData.php`: Data senza proprieta', legge `config/{tenant}/notify.php`.
- Nessun cambio alla pagina: resta con `EnvWidget` per le sole chiavi `.env` in whitelist. I
  segreti non entrano nella config tenant.

## Test

- `tests/Unit/Datas/NotifyConfigDataTest.php`: convenzione nome e file tenant.

## Superata

Superata da [setting-page-campi-reali](./setting-page-campi-reali.story.md): la pagina ora ha campi con lettore.
