---
description:
globs:
alwaysApply: false
---
# Configurazione Stati Utente (state)

## Introduzione
La gestione dello stato degli utenti avviene tramite [spatie/laravel-model-states](mdc:https:/spatie.be/docs/laravel-model-states/v2/working-with-states/01-configuring-states), utilizzando la colonna `state`.

## Pattern Consigliati
- Definire una state class astratta (es. UserState) e le sue varianti (Pending, Approved, Active, Rejected, ecc.)
- Configurare le transizioni consentite tramite il metodo `config()`
- Usare sempre la colonna `state` (mai moderation_status)
- Le action devono usare le transizioni di stato

## Esempio di State
```php
use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class UserState extends State
{
    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Pending::class)
            ->allowTransition(Pending::class, Approved::class)
            ->allowTransition(Pending::class, Rejected::class)
            ->allowTransition(Approved::class, Active::class);
    }
}

class Pending extends UserState {}
class Approved extends UserState {}
class Active extends UserState {}
class Rejected extends UserState {}
```

## Errori Comuni da Evitare
- Usare nomi di colonna errati (es. moderation_status)
- Non configurare le transizioni
- Non usare le state class di Spatie

## Collegamenti correlati
- [Best Practice: ActivityLog per la Moderazione Utenti](mdc:ACTIVITYLOG_MODERATION_BEST_PRACTICES.mdc)
- [Contratti e Interfacce Moderazione](mdc:MODERATION_CONTRACTS.mdc)
- [Azioni di Moderazione](mdc:MODERATION_ACTIONS.mdc)
- [Moderazione e Wizard Generici](mdc:MODERATION_WIZARD_GENERIC.mdc)
- [Notifiche Moderazione](mdc:MODERATION_NOTIFICATIONS.mdc)
