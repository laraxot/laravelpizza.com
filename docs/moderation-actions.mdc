---
description:
globs:
alwaysApply: false
---
# Azioni di Moderazione (Action class)

## Introduzione
Tutte le operazioni di business logic relative alla moderazione sono implementate tramite Action class secondo [spatie/laravel-queueable-action](mdc:https:/github.com/spatie/laravel-queueable-action), mai tramite Service class.

## Pattern Consigliati
- Ogni azione (approvazione, rifiuto, richiesta integrazione, ecc.) deve essere una Action class
- Le action devono essere queueable per gestire carichi elevati
- Ogni action deve loggare l'attività tramite activitylog
- Le action devono accettare come parametro ModeratableUser

## Esempio di Action
```php
use Spatie\QueueableAction\QueueableAction;
use Spatie\Activitylog\Traits\LogsActivity;

class ApproveUserAction
{
    use QueueableAction;
    use LogsActivity;

    public function execute(ModeratableUser $user): void
    {
        $user->setState('approved');
        $user->save();
        activity()
            ->performedOn($user)
            ->causedBy(auth()->user())
            ->withProperties(['reason' => 'approved by moderator'])
            ->log('User approved');
        // notifica...
    }
}
```

## Errori Comuni da Evitare
- Usare Service class invece di Action class
- Non loggare l'attività
- Non accettare ModeratableUser come parametro

## Collegamenti correlati
- [Best Practice: ActivityLog per la Moderazione Utenti](mdc:ACTIVITYLOG_MODERATION_BEST_PRACTICES.mdc)
- [Contratti e Interfacce Moderazione](mdc:MODERATION_CONTRACTS.mdc)
- [Moderazione e Wizard Generici](mdc:MODERATION_WIZARD_GENERIC.mdc)
- [Configurazione Stati Utente](mdc:USER_STATES.mdc)
- [Notifiche Moderazione](mdc:MODERATION_NOTIFICATIONS.mdc)
