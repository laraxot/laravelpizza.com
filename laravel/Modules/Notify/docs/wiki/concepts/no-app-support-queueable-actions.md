---
title: "no app/Support — business logic in QueueableAction"
type: concept
tags: [notify, actions, queueable-action, support, refactor, push, mail]
created: 2026-07-12
updated: 2026-10-08
qmd: "Notify module no app Support QueueableAction push mail Mailtrap"
issues:
discussions:
related:
  - "./claude-audit-static.md"
  - "./code-redundancy-notify.md"
  - "./composer-root-minimal-nwidart.md"
  - "./context-overflow-prevention.md"
  - "./enum-standards.md"
  - "./llm-wiki-governance.md"
  - "./method-name-homonyms.md"
  - "./module-root-uppercase-folders-archive.md"
---

# no `app/Support/` — business logic in QueueableAction

## Scopo

Nel modulo Notify **non** esiste più `app/Support/`. Ogni helper con comportamento di dominio è sotto `app/Actions/`.

## Migrazione (2026-07-12)

| Legacy `app/Support/` | Destinazione |
|----------------------|--------------|
| `PushNotificationPlatformDelivery.php` (path errato, namespace già `Actions`) | ~~`app/Actions/PushNotificationPlatformDelivery.php`~~ rimossa; superata da `Actions/Push/*` (vedi sotto) |
| `MailEngines/MailtrapEngine` | `Actions/Mail/SendMailtrapMailAction` |

## Perché

- **Path = namespace:** `PushNotificationPlatformDelivery` era in `Support/` ma namespace `Modules\Notify\Actions` — incoerenza PSR-4
- **Single-purpose:** invio mail Mailtrap → `SendMailtrapMailAction::execute()`
- **Orchestrazione push (stato 2026-10-08):** non esiste piu' `SendPushNotificationAction` -> `PushNotificationPlatformDelivery`.
  Sia l'orchestrazione sia il recapito per piattaforma vivono in `Actions/Push/*`, una Action per caso d'uso con un solo
  `execute()` (elenco e mapping in [services-to-actions-migration.md](services-to-actions-migration.md)).

## Push — token vs topic (oggi in `Actions/Push/*`)

| Action | Uso | Piattaforme |
|--------|-----|-------------|
| `SendPushToPlatformAction` | singolo device su una piattaforma | fcm (HTTP reale), apns/webpush (simulati) |
| `SendPushToTopicAction` | broadcast su topic FCM `/topics/{name}` | fcm (HTTP reale), apns/webpush (simulati) |
| `SendPushToDevicesAction` | loop token raggruppati per piattaforma + aggregazione success/fail | tutte |

I recapiti simulati (APNs, Web Push) ritornano `success: true` e tracciano la consegna con
`LogSimulatedPushDeliveryAction`; il transport reale e' una decisione di prodotto ancora aperta.

**Regola multi-agente:** una sola definizione per metodo privato (`class.duplicateMethod` PHPStan) e una sola copia della
logica di recapito. Prima di "correggere" una classe gemella, cercare nella wiki del modulo `rimosso|eliminato|superato` con
il nome della classe: le copie `Actions/PushNotificationPlatformDelivery`, `Support/PushNotificationPlatformDelivery` e
`Services/PushNotificationService` sono tornate nel working tree piu' volte dopo la migrazione del 2026-07-13.

## Collegamenti

- [claude-audit-static.md](claude-audit-static.md)
- [queueable-action-trait-mandatory](../../../../docs/wiki/rules/queueable-action-trait-mandatory.md)
