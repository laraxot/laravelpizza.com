---
title: "Widget del modulo User: il form sta su getFormSchema(), non su getFormSchemaOld()"
module: "User"
type: rule
status: approved
tags: [user, filament, widget, formschema, phpstan]
created: 2026-08-18
updated: 2026-08-18
qmd: "widget user getFormSchema getFormSchemaOld XotBaseWidget XotBaseSchemaWidget form vuoto"
related:
  - "../../../../docs/wiki/filament/xotbaseresource-formschema-old-pattern.md"
  - "../../../../docs/chat/formschema-widget-hierarchy-regression.md"
---

# Widget del modulo `User`: il form sta su `getFormSchema()`

> Il rename `getFormSchema` → `getFormSchemaOld` vale **solo** per chi estende
> `XotBaseResource`. Sui widget il metodo rinominato non viene mai invocato: il form si
> svuota in silenzio e nessun test di tipo se ne accorge.

## Chi chiama cosa

| Classe base | Metodo invocato | Dove |
|---|---|---|
| `XotBaseWidget` | `$this->getFormSchema()` | `XotBaseWidget.php:84` |
| `XotBaseSchemaWidget` | `$this->getFormSchema()` oppure `formClass()::{schemaMethod()}` | `XotBaseSchemaWidget.php:94` |
| `XotBaseRelationManager` | `$this->getFormSchema()` (`form()` è `final`) | `XotBaseRelationManager.php:96` |

Nessuna delle tre dichiara `getFormSchemaOld()`. Un widget che lo definisce sta scrivendo
un metodo morto. `#[Override]` su quel metodo è fatal PHP 8.3 all'autoload (Whoops) e
ferma `phpstan analyse Modules`. Chi lo usa: login `/it/auth/login` e widget profilo.

## Cosa è stato corretto

| File | Prima | Dopo |
|---|---|---|
| `Filament/Widgets/Auth/BaseAuthWidget.php:31` | `getViewData()` chiamava `$this->getFormSchemaOld()` — metodo inesistente, `method.notFound` | chiama `$this->getFormSchema()` |
| `Filament/Resources/ClientResource/Widgets/ClientHeader.php` | override `getFormSchemaOld(): array` che restituiva `[]` | rimosso: `XotBaseWidget::getFormSchema()` restituisce già `[]` per i widget senza form |
| `Filament/Resources/UserResource/Widgets/UserWidget.php` | idem | rimosso |
| `Filament/Widgets/UserDropdown.php` | idem, con commento «Required by XotBaseWidget» ormai falso | rimosso |

L'override vuoto non serve: `XotBaseWidget::getFormSchema()` documenta esplicitamente il
default vuoto «per i widget senza form».

## Chiusura debito widget/pagine

`getFormSchemaOld` sui widget non viene chiamato: login e correlati restavano vuoti. Chi lo usa: dipendente su `/it/auth/login`, admin team/tenant, permessi ruolo.

| Cosa | Azione |
|---|---|
| Widget con campi | `getFormSchema()` |
| Widget senza form | metodo vuoto rimosso |
| Pagine Filament (`EditProfile`, tenancy) | `form()` delega a `getFormSchema()` — Filament v5 chiama `form()` |
| `PasswordData` | `getFormSchema()` |
| Resource | restano su `getFormSchemaOld()` |

Niente `mixed` aggiunto. Censimento storico: [formschema-widget-hierarchy-regression.md](../../../../docs/chat/formschema-widget-hierarchy-regression.md).

## Riferimenti

- [Pattern getFormSchema / getFormSchemaOld](../../../../docs/wiki/filament/xotbaseresource-formschema-old-pattern.md)
- [Story 5.7 — PHPStan Modules green](../../Xot/docs/stories/5.7.phpstan-modules-green.story.md)
