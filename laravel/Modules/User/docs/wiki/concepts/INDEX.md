---
title: "concepts index — User"
type: index
tags: [concepts, User]
created: 2026-05-11
updated: 2026-06-04
---

# concepts Index — User

Concetti specifici del modulo User. Carica on-demand via `qmd search` o consulta il [trigger map root](/docs/wiki/rules/00-TRIGGER_MAP.md).

## Filament auth FO

- [filament-widget-no-validate-form](filament-widget-no-validate-form.md) — validazione solo in `UserForm`; submit = `getState()`, no `validateForm()`
- [filament-widget-linear-crud-model-create](filament-widget-linear-crud-model-create.md) — `getUserClass()::create($data)`, no Action banale
- [filament-widget-resource-form-delegation](filament-widget-resource-form-delegation.md) — widget → `UserForm::get*FormSchema()`

## Altro
- [notifications-folio-page](notifications-folio-page.md) — pagina `/notifications`, owner User
- [notifications-folio-route](notifications-folio-route.md) — quick ref `route('notifications')`

- [legacy-docs-duplication-pattern](legacy-docs-duplication-pattern.md) — debito nominativo `docs/legacy/` (dry)

## Notifiche e profili (2026-06-10)

- [notifications-runtime-model.md](notifications-runtime-model.md) — runtime + `NotificationSchema`
- [notifications-folio-page.md](notifications-folio-page.md) — `route('notifications')`
- [profiles-ownership-boundary-rule.md](profiles-ownership-boundary-rule.md) — owner Fixcity
- [no-notifications-migration-in-user-module](../rules/no-notifications-migration-in-user-module.md)

## Folio FO

- [notifications-folio-page](notifications-folio-page.md)
- [notifications-folio-route](notifications-folio-route.md)
- [folio-pages-owner-pattern](folio-pages-owner-pattern.md) — User owner pagine, zero web.php


## Folio FO (User = owner pagine)

- [folio-pages-owner-pattern](folio-pages-owner-pattern.md) — `pages/` nel modulo, mount Cms, zero `web.php`
- [notifications-folio-page](notifications-folio-page.md) — centro notifiche in-app
- [notifications-folio-route](notifications-folio-route.md) — `route('notifications')` quick ref
- [notifications-runtime-model](notifications-runtime-model.md) — model + `NotificationSchema`
- Cms: [folio-list-vs-route-list](../../Cms/docs/wiki/concepts/folio-list-vs-route-list.md) — `folio:list` audit
- Cms: [folio-filesystem-routing-no-web-php](../../Cms/docs/wiki/concepts/folio-filesystem-routing-no-web-php.md) — religione routing

