---
title: "Struttura dei metodi dei modelli Notify"
type: architecture
module: Notify
status: active
created: 2026-11-05
updated: 2026-11-05
tags: [notify, eloquent, model, traits, architecture]
qmd: "Notify model mutator accessor template notification log polymorphic relations traits"
related:
  - ../index.md
---

# Struttura dei metodi dei modelli Notify

Le classi Notify delegano i metodi di dominio dei modelli a trait dedicati,
mantenendo i metodi pubblici chiamati da Eloquent e dai consumer.

| Trait | Modello e metodi |
|---|---|
| [NotifyThemeMutators](../../../app/Models/Traits/NotifyThemeMutators.php) | `NotifyTheme`: `getLogoAttribute`/`getLogo` |
| [NotifyThemeRelations](../../../app/Models/Traits/NotifyThemeRelations.php) | `NotifyTheme`: `linkable` |
| [NotificationTemplateMutators](../../../app/Models/Traits/NotificationTemplateMutators.php) | `NotificationTemplate`: `getChannelsLabelAttribute`/`getChannelsLabel` |
| [NotificationLogRelations](../../../app/Models/Traits/NotificationLogRelations.php) | `NotificationLog`: `notifiable`, `template` |
| [MailTemplateLogRelations](../../../app/Models/Traits/MailTemplateLogRelations.php) | `MailTemplateLog`: `template`, `mailable` |
| [MailTemplateVersionRelations](../../../app/Models/Traits/MailTemplateVersionRelations.php) | `MailTemplateVersion`: `template` |
| [NotificationTemplateVersionRelations](../../../app/Models/Traits/NotificationTemplateVersionRelations.php) | `NotificationTemplateVersion`: `template` |

Le associazioni polimorfiche mantengono i nomi e i campi usati da `morphTo()`;
le relazioni ai template conservano le chiavi esplicite.
