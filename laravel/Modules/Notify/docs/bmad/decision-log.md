---
title: "Notify Module — Document"
type: docs/bmad
status: active
module: Notify
scope: documentation
bmad_version: 1.0
<<<<<<< HEAD
<<<<<<< .merge_file_c0KZnP
<<<<<<< .merge_file_zsx6dx
updated: 2026-11-23
=======
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> .merge_file_2OTXwN
=======
>>>>>>> .merge_file_BGQ1ZD
updated: 2026-11-16
=======
<<<<<<< HEAD
updated: 2026-11-23
=======
<<<<<<< .merge_file_0uH3zr
<<<<<<< .merge_file_c0KZnP
<<<<<<< .merge_file_zsx6dx
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_2OTXwN
=======
>>>>>>> .merge_file_BGQ1ZD
tags: [docs, notify, bmad]
related:
  - ./filament-blueprint.md
  - ../bmad-planning.md
<<<<<<< .merge_file_c0KZnP
<<<<<<< .merge_file_zsx6dx
<<<<<<< HEAD
qmd: "Notify decision log ADR NotificationLog policy webhook canali"
created: 2026-11-23
=======
=======
>>>>>>> .merge_file_2OTXwN
=======
>>>>>>> .merge_file_BGQ1ZD
updated: 2026-11-16
qmd: "Notify decision log ADR NotificationLog policy webhook canali"
=======
updated: 2026-11-16
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_c0KZnP
<<<<<<< .merge_file_zsx6dx
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_2OTXwN
=======
>>>>>>> .merge_file_BGQ1ZD
tags: [docs, notify, bmad]
qmd: "Notify decision log ADR NotificationLog policy webhook canali"
related:
  - ./filament-blueprint.md
<<<<<<< HEAD
<<<<<<< .merge_file_c0KZnP
<<<<<<< .merge_file_zsx6dx
<<<<<<< HEAD
=======
created: 2026-11-23
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_2OTXwN
=======
>>>>>>> .merge_file_BGQ1ZD
=======
created: 2026-11-23
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
---

# Decision Log - Modulo Notify

## Formato

- **Data:** YYYY-MM-DD
- **Decisione:** Breve descrizione della decisione presa
- **Stato:** PROPOSTA, APPROVATA, RIFIUTATA, OBSOLETA
- **Impatto:** Alto/Medio/Basso
- **Alternatives considerate:** Elenco delle alternative valutate
- **Conseguenze:** Implicazioni della decisione

## Registro delle decisioni

### 2026-09-29
**Decisione:** Usare Spatie Queueable Actions (`QueueableAction`) come pattern per tutta la logica di invio, migrando i precedenti Service
**Stato:** APPROVATA
**Impatto:** Alto
**Alternatives considerate:**
- Mantenere Service class con metodo statico facade
- Usare Laravel Jobs direttamente
**Conseguenze:**
- Un'action per canale/driver, invocabile anche in coda via `->onQueue()`
- Codice più testabile (mockabile via container)
- Coerenza con il resto dei moduli Laraxot
- Necessità di migrare `SendSmsAction` che referenzia namespace `SmsEngines` inesistente (vedi brainstorming)

### 2026-09-29
**Decisione:** Usare Factory pattern (`SmsActionFactory`, `WhatsAppActionFactory`, `TelegramActionFactory`) per la selezione del driver via config
**Stato:** APPROVATA
**Impatto:** Alto
**Alternatives considerate:**
- Risoluzione via convenzione di naming (string interpolation del nome driver nella classe)
- Match statement statico per ogni provider
**Consegnenze:**
- `SmsActionFactory` usa mappa esplicita (necessaria perché `ucfirst('smsfactor')` → `Smsfactor` ≠ `SmsFactor`)
- `WhatsAppActionFactory` usa convenzione di naming con `preg_replace` per caratteri non alfanumerici (es. `360dialog` → `360dialog`)
- Driver nuovi aggiunti solo registrandoli nella factory + config
- `WhatsAppActionFactory` e `TelegramActionFactory` usano convenzione di naming, `SmsActionFactory` usa mappa esplicita

### 2026-09-29
**Decisione:** Canali personalizzati (`SmsChannel`, `WhatsAppChannel`, `TelegramChannel`, `NetfunChannel`) implementano `Illuminate\Notifications\Notification::send()` 
**Stato:** APPROVATA
**Impatto:** Alto
**Alternatives considerate:**
- Usare i canali built-in di Laravel (mail, database)
- Usare il pacchetto `laravel-notification-channels/fcm` per push
**Conseguenze:**
- Interfaccia uniforme con Laravel Notifications: ogni canale converte `Notification → Data → Action → API call`
- `SmsChannel` delega a `SmsActionFactory` con override per-notifica via `getProvider()`
- `NetfunChannel` usa `SendSmsFactorSMSAction` direttamente (bypass `SmsActionFactory`)
- `FirebaseAndroidNotification` usa `FcmChannel` del pacchetto esterno (percorso diverso rispetto al push HTTP puro)

### 2026-09-29
**Decisione:** Notifiche push multi-piattaforma (FCM, APNs, WebPush) con rilevamento automatico della piattaforma dal formato del token
**Stato:** APPROVATA
**Impatto:** Medio
**Alternatives considerate:**
- Token esplicitamente etichettati con piattaforma
- Un unico provider (solo FCM)
**Conseguenze:**
- APNs: token lungo 64 hex character
- FCM: token lungo >100 con `:`
- WebPush: fallback per tutto il resto
- APNs e WebPush sono "simulated" (nessuna chiamata API reale) — ritornano sempre `success: true`
- 2026-10-06: ogni consegna simulata viene tracciata da `Actions\Push\LogSimulatedPushDeliveryAction` (`Log::notice`, token abbreviato) e i risultati topic includono `topic`; resta aperta la decisione se implementare il transport o far fallire (vedi `stories/2026-10-06-phpstan-cleanup-notify.dev.md`)

### 2026-09-29
**Decisione:** Notifiche programmate tramite Cache + Job (`SendScheduledPushNotification`)
**Stato:** APPROVATA
**Impatto:** Medio
**Alternatives considerate:**
- Database per le notifiche programmate
- Laravel Scheduler con query
**Consegnenze:**
- `SchedulePushNotificationAction` scrive payload in `Cache::put` con chiave `scheduled_push:{jobId}` e scadenza
- `SendScheduledPushNotification::dispatch($jobId)->delay(...)`
- Il Job legge dalla cache, invia, poi `Cache::forget()`
- Richiede sistema di cache configurato (non funziona con `array` driver in produzione)

### 2026-09-29
**Decisione:** Estendere `XotBaseResource` per tutte le risorse Filament, mai le classi Filament direttamente
**Stato:** APPROVATA
**Impatto:** Alto
**Alternatives considerate:**
- Estendere `Filament\Resources\Resource` direttamente
**Consegnenze:**
- `MailTemplateResource` estende `LangBaseResource` (modulo Lang) per gestione traduzioni
- Tutte le altre risorse estendono `XotBaseResource`
- Coerenza con architettura Laraxot
- Meno controllo su form/schema, più su conventions condivise

### 2026-09-29
**Decisione:** `NotificationTemplate` usa `Blade::render()` per compilare template inline, `MailTemplate` usa Spatie Mustache (`{{ var }}`)
**Stato:** APPROVATA
**Impatto:** Medio
**Alternatives considerate:**
- Un motore di template unico (solo Blade o solo Mustache)
**Consegnenze:**
- `NotificationTemplate::compile()` → `Blade::render($template, $data)` — supporta logica Blade nei template
- `SpatieEmail` usa `Mustache_Engine` per SMS template — solo sostituzione variabili, niente logica
- Doppio motore mantiene compatibilità con Spatie package esistente
- [DA COMPLETARE] valutare unificazione del motore di template (vedi brainstorming DOMANDA 4)

### 2026-09-29
**Decisione:** `SendMailAction` delega all'engine via naming convention `Engines/{Driver}/Send{Driver}MailAction`
**Stato:** APPROVATA
**Impatto:** Basso
**Alternatives considerate:**
- Factory simile a `SmsActionFactory` con mappa esplicita
**Consegnenze:**
- Driver nuovi aggiunti creando la cartella `Actions/Mail/Engines/{Driver}/`
- Duocircle è implementato come `SendDuocircleMailAction` ma lancia `RuntimeException('WIP')` — engine non funzionante
- `TryMailAction` parallelo per la lettura IMAP tramite Webklex

### [DA COMPLETARE]
**Decisione:** [DA COMPLETARE]
**Stato:** [DA COMPLETARE]

## Decisioni da audit 2026-11-16

### ADR-N1 — Ogni Resource Notify ha una Policy
**Stato:** PROPOSTA · **Impatto:** alto
**Contesto:** `Gate::getPolicyFor(NotificationLog::class)` è `NONE`; Filament senza policy consente tutto.
**Decisione:** `NotificationLogPolicy extends NotifyBasePolicy`, sola lettura; test `assertForbidden`.
**Alternative scartate:** `canViewAny()` sulla Resource (duplica la logica, bypassa il Gate).

### ADR-N2 — Webhook inbound: segreto fuori dal path
**Stato:** PROPOSTA · **Impatto:** medio
**Decisione:** firma/header del provider + `throttle` + whitelist `provider`; il token nel path resta solo come compatibilità transitoria.

### ADR-N3 — Un canale non implementato fallisce in modo esplicito
**Stato:** PROPOSTA · **Impatto:** medio
**Decisione:** gli stub lanciano eccezione tracciata; nessun `return` silenzioso.
