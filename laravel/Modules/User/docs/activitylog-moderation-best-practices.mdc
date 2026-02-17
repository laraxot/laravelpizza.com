---
description:
globs:
alwaysApply: false
---
# Best Practice: ActivityLog per la Moderazione Utenti

## Introduzione
Per tracciare tutte le attività di moderazione (approvazione, rifiuto, richiesta integrazione, cambio stato, commenti, ecc.) si utilizza esclusivamente [spatie/laravel-activitylog](mdc:https:/spatie.be/docs/laravel-activitylog/v4/introduction). Questo garantisce audit trail, query avanzate, riuso cross-modulo e coerenza.

## Pattern Consigliati
- Usare sempre `activity()` per loggare ogni azione rilevante sulla moderazione.
- Associare sempre l'utente che causa l'azione (`causedBy`).
- Usare `performedOn` per collegare l'azione all'entità moderata.
- Aggiungere proprietà custom per motivazioni, note, dettagli.
- Loggare anche i tentativi falliti o le richieste di integrazione.

## Esempio di Action Moderazione
```php
use Spatie\QueueableAction\QueueableAction;
use Spatie\Activitylog\Traits\LogsActivity;

class ApproveUserAction
{
    use QueueableAction;
    use LogsActivity;

    public function execute(User $user): void
    {
        $user->state->transitionTo(Approved::class);
        $user->save();
        activity()
            ->performedOn($user)
            ->causedBy(auth()->user())
            ->withProperties(['reason' => 'approved by moderator'])
            ->log('User approved');
        $user->notify(new UserApprovedNotification());
    }
}
```

## Errori Comuni da Evitare
- Non loggare le azioni di moderazione (assenza di audit trail)
- Usare una tabella custom invece di activitylog
- Non associare l'utente che ha causato l'azione
- Non aggiungere dettagli nelle proprietà custom
- Non loggare i cambi di stato automatici

## Vantaggi
- **Audit trail completo**: tutte le attività sono tracciate in modo standard
- **Query avanzate**: ricerca, filtro, reportistica su tutte le attività
- **Riuso cross-modulo**: lo stesso sistema può essere usato per altri moduli
- **Manutenzione**: nessuna tabella custom da gestire
- **Sicurezza**: log centralizzato e consultabile

## Collegamenti correlati
- [Moderazione e Wizard Generici](mdc:MODERATION_WIZARD_GENERIC.mdc)
- [Contratti e Interfacce Moderazione](mdc:MODERATION_CONTRACTS.mdc)
- [Azioni di Moderazione](mdc:MODERATION_ACTIONS.mdc)
- [Configurazione Stati Utente](mdc:USER_STATES.mdc)
- [Notifiche Moderazione](mdc:MODERATION_NOTIFICATIONS.mdc)

## Collegamenti bidirezionali
- Aggiornare i file sopra elencati con link a questa best practice.

## Riferimenti
- [spatie/laravel-activitylog](mdc:https:/spatie.be/docs/laravel-activitylog/v4/introduction)
- [spatie/laravel-queueable-action](mdc:https:/github.com/spatie/laravel-queueable-action)
- [spatie/laravel-model-states](mdc:https:/spatie.be/docs/laravel-model-states/v2/working-with-states/01-configuring-states)

