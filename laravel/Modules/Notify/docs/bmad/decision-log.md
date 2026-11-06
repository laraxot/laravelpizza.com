---
title: "Notify Module: Document"
type: docs/bmad
status: active
module: Notify
scope: documentation
bmad_version: 1.0
updated: 2026-10-20
tags: [docs, notify, bmad]
qmd: "decision log - modulo notify notify"
related:
  - ./filament-blueprint.md
  - ../bmad-planning.md
---

# Decision Log - Modulo Notify

**Scopo:** consegnare messaggi multi-canale (mail, SMS, push, Telegram, WhatsApp) preference-aware con esiti osservabili, cosi' Fixcity e gli altri owner invocano Actions/canali invece di reinventare transport e template.

## Hub (solo link)

- Standing PHPStan: [phpstan-modules-zero-standing-order](../../../Xot/docs/wiki/memories/phpstan-modules-zero-standing-order.md)
- `graphify-out/`: [graphify-out-gitignore](../../../Xot/docs/bmad/graphify-out-gitignore.md)
- UI admin: [filament-blueprint.md](./filament-blueprint.md)

## Formato

- **Data:** YYYY-MM-DD
- **Decisione:** Breve descrizione della decisione presa
- **Stato:** PROPOSTA, APPROVATA, RIFIUTATA, OBSOLETA
- **Impatto:** Alto/Medio/Basso
- **Alternatives considerate:** Elenco delle alternative valutate
- **Conseguenze:** Implicazioni della decisione

## Registro delle decisioni

### 2026-10-20: Allineamento no-Services (census sera)

- **Stato:** `Modules/Notify/app/Services/` **assente** (0 file); invio/canali = Actions + Factory/Channel (decisione 2026-09-29 confermata). Campione `laraxot/dev` Notify = **0** sotto `app/Services/`. Merge che riesuma `SmsService` / `NotificationManager` → **delete-again**, ratchet Xot [NoServicesTest](../../../Xot/tests/Unit/Architecture/NoServicesTest.php).
- **Track:** [Xot census BMAD](../../../Xot/docs/bmad/services-to-queueable-actions-census.md), [services-to-queueable-actions-filament-blueprint](../../../Xot/docs/bmad/services-to-queueable-actions-filament-blueprint.md).

### 2026-10-20: Gate PHPStan Modules: rieseguito OK

- **Verifica:** `cd laravel && php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/Notify` (batch audit con User, Comment, Activity) → exit 0.
- **Docs:** `md-filenames.py check` su `docs/` → 0 date/suffissi; ~646 file legacy con maiuscole in radice/storico: solo segnalazione, no rinomina automatica.
- **Track:** [00-INDEX.md](../00-index.md), [phpstan-fixes.md](../phpstan-fixes.md), [phpstan-modules-zero-gate](../../../Xot/docs/stories/phpstan-modules-zero-gate.story.md), hub sopra.

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
- APNs e WebPush sono "simulated" (nessuna chiamata API reale): ritornano sempre `success: true`
- 2026-10-06: ogni consegna simulata viene tracciata da `Actions\Push\LogSimulatedPushDeliveryAction` (`Log::notice`, token abbreviato) e i risultati topic includono `topic`; resta aperta la decisione se implementare il transport o far fallire (vedi `stories/phpstan-cleanup-notify-dev.dev.md`)
- 2026-10-06: ogni consegna simulata viene tracciata da `Actions\Push\LogSimulatedPushDeliveryAction` (`Log::notice`, token abbreviato) e i risultati topic includono `topic`; resta aperta la decisione se implementare il transport o far fallire (vedi `stories/phpstan-cleanup-notify.dev.md`)

### 2026-09-29
**Decisione:** Notifiche programmate tramite Cache + Queueable Action (`SendScheduledPushNotificationAction`)
**Stato:** APPROVATA
**Impatto:** Medio
**Alternatives considerate:**
- Database per le notifiche programmate
- Laravel Scheduler con query
**Consegnenze:**
- `SchedulePushNotificationAction` scrive payload in `Cache::put` con chiave `scheduled_push:{jobId}` e scadenza
- `ActionJob::dispatch(new SendScheduledPushNotificationAction, [$jobId])->delay(...)`
- L'Action legge dalla cache, invia, poi `Cache::forget()`
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
- `NotificationTemplate::compile()` → `Blade::render($template, $data)`: supporta logica Blade nei template
- `SpatieEmail` usa `Mustache_Engine` per SMS template: solo sostituzione variabili, niente logica
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
- Duocircle è implementato come `SendDuocircleMailAction` ma lancia `RuntimeException('WIP')`: engine non funzionante
- `TryMailAction` parallelo per la lettura IMAP tramite Webklex

### [DA COMPLETARE]
**Decisione:** [DA COMPLETARE]
**Stato:** [DA COMPLETARE]
