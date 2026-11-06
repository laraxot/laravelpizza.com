---
title: "[STORY] EnvPage non funziona e non e' collegata: decisione del team se serve"
type: story
status: blocked
priority: low
created: 2026-10-22
updated: 2026-10-22
module: Xot
issue: https://github.com/laraxot/module_xot_fila5/issues/147
tags: [bmad, xot, filament, env, envwidget, codice-inutilizzato, decisione-team]
related:
  - ../../app/Filament/Pages/EnvPage.php
  - ../../app/Filament/Widgets/EnvWidget.php
  - ../../resources/views/filament/pages/env.blade.php
  - ../../resources/views/filament/pages/dashboard.blade.php
  - ../../../Notify/app/Filament/Pages/SettingPage.php
  - ../../../Quaeris/docs/stories/quaeris-envwidget-mail-config-fields.md
  - ../../../../../bashscripts/ai/wiki/rules/module-dashboard-page-mandatory.md
---

# [STORY] EnvPage non funziona e non e' collegata: serve ancora?

Fase BMAD: analisi. Nessun codice toccato. In attesa della decisione del team (stato `blocked`).

## Richiesta

Il 2026-10-22 l'utente ha aperto in locale `/xot/admin/env-page` cercando la pagina che mostra i valori del `.env`. Risultato: errore 500. Analisi chiesta; poi, visto che una pagina funzionante esiste gia', decisione dell'utente: non correggere `EnvPage`, chiedere al team se il codice serve.

## Sintomo

```text
BadMethodCallException
Method Modules\Xot\Filament\Pages\EnvPage::getColumns does not exist.
Modules/Xot/resources/views/filament/pages/dashboard.blade.php:10
```

La pagina compare nel menu del pannello Xot (scoperta automatica delle pagine, `$navigationIcon` impostata): chi ci clicca ottiene il 500.

## Causa

- `EnvPage` estende `XotBasePage` ma usa la vista `xot::filament.pages.dashboard`.
- Quella vista chiama `getColumns()`, `getWidgetData()` e `getVisibleWidgets()`: esistono solo nelle dashboard (`XotBaseDashboard`, che estende `Filament\Pages\Dashboard`). `XotBasePage` non li ha.
- `EnvWidget` (il form vero, gruppi General, SMS, Mail) non e' collegato a `EnvPage`: nessun riferimento a `EnvWidget` in Xot.
- `resources/views/filament/pages/env.blade.php` (form con `$this->form` e `submit`) non e' usata da nessuna classe.

## Da quando

Nella repo root `EnvPage` e' identica almeno dal 2026-03-10 (commit `269b05ee60`), anche su `origin/master`. In produzione la pagina e' quasi certamente rotta allo stesso modo (non verificato aprendola). Non e' un effetto del pull dei moduli del 2026-10-22.

## La pagina funzionante che esiste gia'

Notify → Impostazioni: `Modules\Notify\Filament\Pages\SettingPage`, URL `/notify/admin/setting-page`. Estende `XotBasePage`, monta `EnvWidget::make(['only' => [...]])` in `getHeaderWidgets()`, vista vuota. E' lo schema documentato e usato per SMS (2026-09-17) e mail (2026-09-20): story [quaeris-envwidget-mail-config-fields](../../../Quaeris/docs/stories/quaeris-envwidget-mail-config-fields.md), base_quaeris_fila5#200, discussion #201. Geo ha una sua `SettingPage` (`/geo/admin/setting-page`).

## Regole e documentazione trovate

- Schema delle pagine Impostazioni: `docs/wiki/concepts/env-widget-no-ssh-env-editor.md` del modulo Xot. **Eliminato il 2026-10-05** (commit `3d81ee3904`); si legge con `git -C laravel/Modules/Xot show 3d81ee3904^:docs/wiki/concepts/env-widget-no-ssh-env-editor.md`. La story Quaeris collegata lo cita ancora (link rotto).
- [module-dashboard-page-mandatory](../../../../../bashscripts/ai/wiki/rules/module-dashboard-page-mandatory.md): ogni modulo ha `Dashboard.php` che estende `XotBaseDashboard`, mai `XotBasePage`. Vale per la pagina iniziale del pannello, non per le pagine Impostazioni.
- Nessuna story, issue o discussion su `EnvPage`. Compare solo nell'elenco di [xot-architecture-overview](../architecture/xot-architecture-overview.md) ("`EnvPage`: Environment variables").

## Decisione richiesta al team

- **A.** `EnvPage` non serve: rimuovere `EnvPage` e la vista `env.blade.php`, e la riga in `xot-architecture-overview.md`.
- **B.** Serve: correggerla con lo schema di `SettingPage` (`XotBasePage` + `getHeaderWidgets()` con `EnvWidget::make(['only' => [...]])` + vista vuota) e decidere quali chiavi mostrare. Non trasformarla in dashboard: andrebbe contro lo schema documentato.
- In piu': l'eliminazione di `env-widget-no-ssh-env-editor.md` era voluta? Se no, va ripristinato.

Issue: [module_xot_fila5#147](https://github.com/laraxot/module_xot_fila5/issues/147), aperta il 2026-10-22.

## Criteri di accettazione

- [x] Issue aperta con il link a questa story: [module_xot_fila5#147](https://github.com/laraxot/module_xot_fila5/issues/147).
- [ ] Decisione del team registrata qui (A o B, e sul documento eliminato).
- [ ] Decisione applicata con il ciclo del quality gate (lock, PHPStan, PHPMD, PHPInsights).
