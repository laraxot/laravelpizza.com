---
description:
globs:
alwaysApply: false
---
# Notifiche Moderazione

## Introduzione
Tutte le notifiche relative alla moderazione (approvazione, rifiuto, richiesta integrazione, ecc.) devono essere implementate come Notification class Laravel, localizzate e prive di riferimenti hard-coded.

## Pattern Consigliati
- Ogni evento di moderazione deve generare una notifica specifica
- Le notifiche devono essere localizzate tramite i file lang
- Le notifiche devono essere inviate tramite action
- Le notifiche devono essere tracciate tramite activitylog

## Esempio di Notifica
```php
use Illuminate\Notifications\Notification;

class UserApprovedNotification extends Notification
{
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(__('user::notifications.approved.subject'))
            ->line(__('user::notifications.approved.body'));
    }
}
```

## Errori Comuni da Evitare
- Non localizzare i messaggi
- Inviare notifiche direttamente dal controller invece che tramite action
- Non tracciare l'invio tramite activitylog

## Collegamenti correlati
- [Best Practice: ActivityLog per la Moderazione Utenti](mdc:ACTIVITYLOG_MODERATION_BEST_PRACTICES.mdc)
- [Contratti e Interfacce Moderazione](mdc:MODERATION_CONTRACTS.mdc)
- [Azioni di Moderazione](mdc:MODERATION_ACTIONS.mdc)
- [Configurazione Stati Utente](mdc:USER_STATES.mdc)
- [Moderazione e Wizard Generici](mdc:MODERATION_WIZARD_GENERIC.mdc)
