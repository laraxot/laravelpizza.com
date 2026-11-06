---
title: "Notify Module: Document"
type: docs/bmad
status: active
module: Notify
scope: documentation
bmad_version: 1.0
updated: 2026-10-06
tags: [docs, notify, bmad]
qmd: "epics e user stories - modulo notify notify"
---

# Epics e User Stories - Modulo Notify

## Epics

### Epic 1: Gestione canali notifica (SMS, WhatsApp, Telegram)
**Descrizione:** Consolidare l'invio di notifiche testuali su SMS, WhatsApp e Telegram tramite un'architettura factory-driven con driver configurabili. Ogni canale deve supportare più provider (es. SMS: Twilio, Netfun, SmsFactor, Nexmo, Plivo, Gammu, Agiletelecom) selezionabili via config o override per-notifica.
**Storia utente associate:**
- US-1: Come sviluppatore deve poter aggiungere un nuovo provider SMS registrándolo nella factory senza toccare il canale
- US-2: Come utente deve poter configurare il driver di default via `SMS_DRIVER` / `config('sms.default')`
- US-3: Come sviluppatore devo poter forzare un provider specifico a livello di notifica implementando `getProvider()`

### Epic 2: Push notification multi-piattaforma (FCM, APNs, WebPush)
**Descrizione:** Implementare l'invio di notifiche push a dispositivi, topic e broadcast su tre piattaforme (FCM via HTTP legacy API, APNs, WebPush), con rilevamento automatico della piattaforma dal formato del token e supporto a notifiche programmate.
**Storia utente associate:**
- US-4: Come frontend dev devo poter inviare una push a un singolo token via `SendPushNotificationAction`
- US-5: Come product owner devo poter programmare un push per un momento futuro e vedere il job in coda
- US-6: Come sviluppatore devo poter raggruppare token per piattaforma e inviare in batch
- US-7: Come product owner devo poter inviare una push a tutti gli utenti attivi

### Epic 3: Gestione template e notifiche email
**Descrizione:** Fornire motori di template multipli (Spatie DB per `MailTemplate`, Blade inline per `NotificationTemplate`, Mustache per `NotifyTheme`) con supporto a traduzione, anteprima e allegati PDF generati da HTML.
**Storia utente associate:**
- US-8: Come content editor devo poter creare un template email con soggetto, HTML e testo, gestendo traduzioni
- US-9: Come sviluppatore devo poter compilare un template con dati e inviare via `RecordNotification` (SpatieEmail)
- US-10: Come utente devo poter generare un PDF dall'anteprima di un template e alleggerlo all'email
- US-11: Come product owner devo poter visualizzare un'anteprima del template compilato prima dell'invio

### Epic 4: Log di consegna e statistiche
**Descrizione:** Registrare ogni notifica inviata in `NotificationLog` con stato di consegna (PENDING, SENT, DELIVERED, FAILED, OPENED, CLICKED) e fornire statistiche per template e destinatari.
**Storia utente associate:**
- US-12: Come admin devo poter vedere nella lista log gli stati colorati (verde=consegnata, rosso=failed)
- US-13: Come product owner devo poter filtrare i log per canale e stato
- US-14: Come sviluppatore devo poter recuperare le statistiche di invio per un template
- US-15: Come admin devo poter pulire i log vecchi tramite comando console

### Epic 5: Notifiche database e bulk
**Descrizione:** Supportare la consegna su canale database (notifiche interne all'applicazione) e l'invio bulk a più record contemporaneamente con risultato aggregato.
**Storia utente associate:**
- US-16: Come utente devo poter ricevere notifiche interne nell'interfaccia Filament
- US-17: Come admin devo poter inviare una notifica a tutti i record selezionati da una tabella Filament
- US-18: Come sviluppatore devo poter inviare notifiche via `NotificationManager::sendMultiple()` con risultato di successi/fallimenti

### Epic 6: Integrazione Filament Admin
**Descrizione:** Fornire risorse Filament complete per la gestione di template, log, contatti, temi e notifiche, estendendo sempre `XotBaseResource` o `LangBaseResource`.
**Storia utente associate:**
- US-19: Come admin devo poter gestire i `NotificationTemplate` con form di editing e preview
- US-20: Come admin devo poter consultare i `NotificationLog` con filtri e visualizzatore dettaglio
- US-21: Come admin devo poter gestire i `Contact` con i tipi di contatto (`ContactTypeEnum`)

## User Stories dettagliate

### US-1: Aggiungere un nuovo provider SMS
**Come** sviluppatore
**Voglio** registrare un nuovo driver SMS nella `SmsActionFactory` mappa
**Per** poter supportare provider aggiuntivi senza modificare i canali

**Criteri di accettazione:**
- [ ] Il provider implementa `SmsActionContract`
- [ ] La factory mappa `driver_name => ClassName`
- [ ] Il canale `SmsChannel` invia correttamente al nuovo driver
- [ ] PHPStan L10 verde

**Task:**
- [ ] Creare `Actions/SMS/Send{Provider}SMSAction` implementante `SmsActionContract`
- [ ] Registrare il driver in `SmsActionFactory::$driverActions`
- [ ] Aggiungere mappa driver in `config/sms.php`
- [ ] Aggiungere test Pest per il nuovo driver

### US-4: Invio push a un singolo token
**Come** frontend dev
**Voglio** inviare una push a un singolo device token
**Per** notificare l'utente su azioni in tempo reale

**Criteri di accettazione:**
- [ ] `SendPushNotificationAction::sendToDevice()` accetta un token e `PushNotificationData`
- [ ] Il payload FCM include titolo, body, icon, sound, badge, priority, ttl
- [ ] APNs e WebPush sono simulati (ritornano `success: true`)
- [ ] Il risultato include stato per ogni piattaforma

**Task:**
- [ ] Verificare `SendPushToPlatformAction` gestisce i 3 payload correttamente
- [ ] Testare con token FCM dummy
- [ ] Documentare il payload atteso

### US-5: Notifica push programmata
**Come** product owner
**Voglio** programmare un push per un momento futuro
**Per** inviare promemori o notifiche temporizzate

**Criteri di accettazione:**
- [ ] `SchedulePushNotificationAction` salva in cache con scadenza
- [ ] Il job `SendScheduledPushNotification` è dispatchato con delay
- [ ] Il job legge dalla cache, invia, e pulisce la cache
- [ ] In caso di errore, il job fallisce e mantiene i dati in cache

**Task:**
- [ ] Testare flusso cache → job → delivery
- [ ] Gestire caso di cache vuota (job fantasma)

### US-8: Creare template email
**Come** content editor
**Voglio** creare un template con soggetto, HTML, testo e traduzioni
**Per** personalizzare le email di notifica

**Criteri di accettazione:**
- [ ] `NotificationTemplate` supporta campi traducibili (subject, body_html, body_text)
- [ ] I template usano `Blade::render()` per la compilazione
- [ ] Il form Filament permette editing WYSIWYG via GrapesJS
- [ ] Esiste una preview page

**Task:**
- [ ] Verificare `NotificationTemplateResource` con pagina `preview`
- [ ] Testare compilazione con `compile()` e `shouldSend()`
- [ ] Verificare scope `active()`, `forChannel()`, `forCategory()`

### US-12: Visualizzazione log notifiche
**Come** admin
**Voglio** vedere i log con stati colorati e filtrabili
**Per** monitorare la consegna e risolvere problemi

**Criteri di accettazione:**
- [ ] `NotificationLogResource` estende `XotBaseResource`
- [ ] Lo status usa `NotificationLogStatusEnum` con colori/icone via `EnumTrait`
- [ ] Filtri per canale (`forChannel`) e stato (`withStatus`)
- [ ] Colonna `channel` mostra `ChannelEnum` label

**Task:**
- [ ] Verificare `NotificationLogForm`, `NotificationLogInfolist`, `NotificationLogsTable`
- [ ] Testare scope query

### US-14: Statistiche di invio per template
**Come** sviluppatore
**Voglio** recuperare le statistiche di consegna per un template
**Per** monitorare l'efficacia dei template

**Criteri di accettazione:**
- [ ] `NotificationManager::getTemplateStats()` restituisce total, sent, delivered, failed, opened, clicked
- [ ] I dati provengono da `NotificationLog` (o `NotificationTemplateVersion` se implementato)
- [ ] [DA COMPLETARE] attualmente il metodo è commentato: implementare il collegamento al log

**Task:**
- [ ] [DA COMPLETARE] Implementare query reale su `NotificationLog`
- [ ] Testare con log di esempio

### US-15: Pulizia log vecchi
**Come** admin
**Voglio** rimuovere i log di notifica più vecchi di X giorni
**Per** evitare che la tabella cresca indefinitamente

**Criteri di accettazione:**
- [ ] Esiste `CleanupNotificationLogsCommand`
- [ ] Il comando accetta un parametro di durata (giorni)
- [ ] Usa `NotificationLogStatusEnum` per identificare stati non rilevanti

**Task:**
- [ ] Verificare comando esiste (visto in `Console/Commands`)
- [ ] Documentare uso

### US-16: Notifiche database in Filament
**Come** utente
**Voglio** vedere notifiche interne nell'interfaccia Filament
**Per** essere aggiornato su eventi senza lasciare l'applicazione

**Criteri di accettazione:**
- [ ] `AdminPanelProvider` registra `DatabaseNotifications` Livewire
- [ ] Polling ogni 60 secondi
- [ ] Il trigger è `notify::livewire.database-notifications-trigger`
- [ ] Il display è nel `panels::user-menu.before` hook

**Task:**
- [ ] Verificare configurazione in `AdminPanelProvider::panel()`
- [ ] Testare con `NotifyManager::send()` canale `database`
