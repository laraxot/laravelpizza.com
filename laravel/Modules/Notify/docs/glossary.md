<<<<<<< HEAD
=======
<<<<<<< HEAD
# Glossario di dominio Notify

<!-- Le parole del dominio e dove stanno nel codice. Topology di AGENTS.md punta qui.
     Un termine per riga; se glossario e codice non coincidono, vale il codice e si corregge il glossario. -->

| Termine | Significato | Nel codice |
|---|---|---|
| <!-- termine --> | <!-- cosa vuol dire per il business, con unità e stati se servono --> | <!-- classe, colonna, rotta --> |
=======
>>>>>>> laraxot/dev
---
title: "Glossario di dominio Notify"
type: glossary
owner: Notify
updated: 2026-11-24
qmd: "notify glossario dominio notifica template canale mail sms push whatsapp contatto pec inbound email tema log"
---

# Glossario di dominio Notify

Termini verificati nel codice con `rg`. Se glossario e codice divergono vale il codice.
Percorsi relativi a `laravel/Modules/Notify/`.

| Termine | Significato | Nel codice |
|---|---|---|
| Notifica | Record di una comunicazione a un destinatario (`notifiable_*`, `user_id`, `message`, `channels`, `status`, `sent_at`, `data`). | `app/Models/Notification.php` |
| Template di notifica | Modello di messaggio identificato da `code`, con `subject`, corpi, `channels`, `conditions`, `is_active`. | `app/Models/NotificationTemplate.php` (`shouldSend()`, `compile()`) |
| Codice template | Chiave con cui si richiede un template attivo; senza corrispondenza l'invio fallisce. | `NotificationTemplate::$code`, `NotificationTemplateNotFoundException::forCode()` |
| Condizioni di invio | Coppie percorso/valore sui dati: se non coincidono la notifica non parte. | `NotificationTemplate::shouldSend()` |
| Canale (invio) | Via di consegna usata da `SendNotificationAction`: `mail`, `database`, `sms`. | `app/Actions/SendNotificationAction.php` (`sendViaChannel()`) |
| Canale (enum) | `mail`, `sms`, `whatsapp`. | `app/Enums/ChannelEnum.php` |
| Canale configurato | Canale con `driver`, `config`, `is_enabled`, `priority`. | `app/Models/NotificationChannel.php` |
| Tipo di notifica | Categoria con `slug`, `category`, `channels`: modello `NotificationType`; enum `email`, `sms`, `push`. | `app/Models/NotificationType.php`, `app/Enums/NotificationTypeEnum.php` |
| Stato notifica | `pending`, `processing`, `sent`, `delivered`, `failed`, `opened`, `clicked`. | `app/Enums/NotificationStatusEnum.php`, `NotificationLogStatusEnum.php` (stessi valori) |
| Log di notifica | Traccia di invio legata a destinatario e template. | `app/Models/NotificationLog.php` |
| Notifica generica | Notification Laravel accodata (`ShouldQueue`) che porta soggetto, corpo e canali. | `app/Notifications/GenericNotification.php` |
| Orchestratore | Classe che chiama `SendNotificationAction` per l'invio di una notifica. | `app/Actions/NotificationManager.php` |
| Template mail | Template di email con `mailable`, `slug`, `variables`, traduzioni; con versioni e log. | `app/Models/MailTemplate.php`, `MailTemplateVersion.php`, `MailTemplateLog.php` |
| Email in ingresso | Messaggio ricevuto da un provider (`provider`, `message_id`, `from_email`, `to_email`, `subject`). | `app/Models/InboundEmail.php`, `app/Actions/Mail/ProcessInboundMailAction.php` |
| Contatto | Recapito polimorfico (`model_type`, `model_id`) di tipo `phone`, `mobile`, `email`, `pec`, `whatsapp`, `fax`. | `app/Models/Contact.php`, `app/Enums/ContactTypeEnum.php` |
| Tema di notifica | Tema grafico (con logo) applicabile alle notifiche. | `app/Models/NotifyTheme.php`, `app/Notifications/ThemeNotification.php` |
| Normalizzazione telefono | Porta un numero in formato internazionale prima dell'invio SMS. | `app/Actions/SMS/NormalizePhoneNumberAction.php` |
| Driver SMS | Fornitore SMS selezionabile: oggi `smsfactor` nell'enum; altre Action SMS esistono per singolo fornitore. | `app/Enums/SmsDriverEnum.php`, `app/Actions/SMS/SendSmsFactorSMSAction.php` |
| Push | Invio a dispositivo, piattaforma, topic o tutti gli utenti. | `app/Actions/Push/` (`SendPushToDeviceAction`, `SendPushToTopicAction`, `SendPushToAllUsersAction`), contratto `app/Contracts/CanReceivePushNotifications.php` |
<<<<<<< HEAD
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
