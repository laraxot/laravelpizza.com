---
title: "Services → QueueableAction — modulo Notify"
type: concept
tags: [notify, push, actions, migration]
created: 2026-07-13
updated: 2026-10-08
qmd: "Notify PushNotificationService removed SendPushNotificationAction scheduled job"
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

# Notify — `PushNotificationService` eliminato

`app/Services/PushNotificationService.php` rimosso. Logica migrata in `Actions/Push/`,
un'azione per responsabilità (una sola `execute()` pubblica ciascuna, come da
`queueable-action-trait-mandatory`):

- `Push/SendPushToDeviceAction` — invio a un singolo token multi-piattaforma
- `Push/SendPushToDevicesAction` — invio a più token, raggruppati per piattaforma
- `Push/SendPushToPlatformAction` — delivery su una piattaforma specifica (FCM reale via HTTP,
  APNS/WebPush simulati — limite già presente nel Service originale, non introdotto dalla
  migrazione)
- `Push/SendPushToTopicAction` — invio a un topic
- `Push/SendPushToAllUsersAction` — invio a tutti i token attivi
- `Push/SendPushWithTemplateAction` — invio da template
- `Push/SendPushWithTargetingAction` — invio con criteri di targeting
- `Push/SchedulePushNotificationAction` — schedulazione via cache + job

`Jobs/SendScheduledPushNotification::handle()` inietta `Push\SendPushToDevicesAction` e chiama:

```php
$pushService->execute($tokens, $notification, $data);
```

Due tentativi intermedi di migrazione — `Actions/PushNotificationAction` (duplicato 1:1 del
vecchio Service, multi-metodo pubblico) e `Actions/SendPushNotificationAction` +
`Actions/PushNotificationPlatformDelivery` (wrapper multi-metodo attorno alla stessa logica) —
sono stati rimossi il 2026-07-13 perché non referenziati altrove e superati dallo split in
`Actions/Push/`.

## Stato al 2026-10-08

La migrazione era stata annullata da un merge: `app/Services/*`, le due copie del recapito e i test che le importavano
erano tornati nel working tree. Rifatta e chiusa:

| Era in `app/Services` | Ora |
|---|---|
| `PushNotificationService` | `Actions/Push/*` (nessun facade con array); i test chiamano le Action con `PushNotificationData`/`PushCriteriaData` |
| `NotificationManager` | `Actions\NotificationManager` (esistente). Debito: multi-metodo senza `execute()` |
| `SmsService` | `Actions\SMS\SendSmsAction` (lancia sempre `RuntimeException`: il motore `SmsEngines` non e' mai esistito; l'SMS reale usa `SmsActionFactory`) |
| `MailEngines\MailtrapEngine` | `Actions\Mail\SendMailtrapMailAction` (nessun Contract ne' binding: non era una strategy scelta da config) |
| `MailService.to_action`, `MailEngines/*.test` | `Actions\Mail\{SendMailAction,TryMailAction}` e `Actions\Mail\Engines\Duocircle\*`; file non PHP, cancellati |

`app/Services` non esiste piu'. Il recapito APNs/Web Push resta simulato e ora traccia ogni consegna con
`Actions\Push\LogSimulatedPushDeliveryAction` (collegata a `SendPushToPlatformAction` e `SendPushToTopicAction`).
Le costanti `NotificationLog::STATUS_*` sono diventate `Enums\NotificationLogStatusEnum` (stessi literal nel DB).
Story: `../../stories/2026-10-08-services-to-actions-notify.story.md`.
