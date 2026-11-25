---
description:
globs:
alwaysApply: false
---
# Linee guida per l'uso di Spatie Activitylog

## Introduzione
Utilizzare sempre [spatie/laravel-activitylog](mdc:https:/spatie.be/docs/laravel-activitylog/v4/introduction) per tracciare eventi, audit trail e cambi di stato nei moduli. Non creare mai tabelle custom come ModerationLog.

## Vantaggi
- Standardizzazione dell'audit trail
- Query avanzate e filtraggio
- Integrazione con dashboard, notifiche, Filament
- Supporto a metadati, causer, soggetto, ecc.

## Esempio base
```php
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Model
{
    use LogsActivity;
    protected static $logAttributes = ['state', 'type'];
    protected static $logName = 'user_moderation';
}

// Log manuale
activity()
    ->performedOn($user)
    ->causedBy(auth()->user())
    ->withProperties(['reason' => 'approved by admin'])
    ->log('User approved');
```

## Checklist di implementazione
- [ ] Usare SEMPRE il trait LogsActivity nei modelli che richiedono audit
- [ ] Definire $logAttributes e $logName
- [ ] Loggare manualmente eventi custom rilevanti
- [ ] Integrare la visualizzazione log in Filament o dashboard
- [ ] Non creare mai tabelle custom per l'audit

## Query utili
```php
// Recupera tutte le attività di moderazione di un utente
$logs = $user->activities()->where('log_name', 'user_moderation')->get();
```

## Collegamenti correlati
- [README User](mdc:README.md)
- [Best Practices](mdc:best-practices.md)
- [Filament Best Practices](mdc:filament-best-practices.md)
- [Testing](mdc:testing.md)
- [Documentazione centrale](mdc:../../../../docs/INDEX.md)

