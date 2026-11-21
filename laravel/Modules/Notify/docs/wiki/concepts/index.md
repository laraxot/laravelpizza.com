---
qmd: "index"
issues: []
discussions: []
title: "concepts index — Notify"
type: index
tags: [concepts, Notify]
created: 2026-05-11
updated: 2026-09-10
---

# concepts Index — Notify

Concetti specifici del modulo Notify. Carica on-demand via `qmd search` o consulta il [trigger map root](/docs/wiki/rules/00-TRIGGER_MAP.md).

## Schema notifications (2026-06-10)

- [notifications-database-contract.md](notifications-database-contract.md) — owner migrazione, `XotBaseMigration`, conn `user` via `User\Models\Notification`
- [../migrations/notifications_table.md](../migrations/notifications_table.md) — file `2026_06_10_133000_create_notifications_table.php`
## Database notifications (boundary Notify/User)

- [notifications-database-contract](notifications-database-contract.md) — schema owner Notify
- [notifications-migration-owner](notifications-migration-owner.md) — migrazione unica, runtime model User
- UI Folio: [User notifications-folio-page](../../User/docs/wiki/concepts/notifications-folio-page.md)
- Audit rotte FO: [Cms folio-list-vs-route-list](../../Cms/docs/wiki/concepts/folio-list-vs-route-list.md)

## SMS — canale e selezione driver

- [sms-channel-driver-selection.md](sms-channel-driver-selection.md) — `SmsChannel` sceglie il driver da `config('sms.default')` (env `SMS_DRIVER`) via `SmsActionFactory` (mappa esplicita `driver => Send{Provider}SMSAction`). Con `SMS_DRIVER=netfun` + `NETFUN_TOKEN` gli SMS (inviti inclusi) passano da Netfun. Storia: regressione `b8321c567` che aveva cablato SMSFactor.

## Mail templates

- [one-migration-consolidamento-wave2.md](one-migration-consolidamento-wave2.md) — owner-file `mail_templates` (`2026_09_10_150101`), procedura bump-timestamp, colonna `sms_from`
- [mail-template-slug-prevent-overwrite.md](mail-template-slug-prevent-overwrite.md) — `getSlugOptions()->preventOverwrite()` obbligatorio: senza, `SpatieEmail::__construct()` (che fa `update(counter++)`) rigenera lo slug da `subject` e `findForMailable()` non trova più il template

