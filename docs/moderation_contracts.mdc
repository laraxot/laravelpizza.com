---
description:
globs:
alwaysApply: false
---
# Contratti e Interfacce per la Moderazione Utenti

## Introduzione
Per garantire la riusabilità e la neutralità del modulo User, tutte le entità moderabili devono implementare un contract/interfaccia comune.

## Esempio di Interfaccia
```php
interface ModeratableUser
{
    public function getModerationData(): array;
    public function setState(string $state): void;
    public function getType(): string;
}
```

## Motivazione
- Permette di gestire la moderazione in modo generico e centralizzato
- Facilita l'estensione a nuovi tipi di utente
- Consente l'integrazione con action, policy, notifiche e activitylog

## Best Practice
- Ogni model che può essere moderato deve implementare questa interfaccia
- Le action di moderazione devono accettare come parametro ModeratableUser

## Collegamenti correlati
- [Best Practice: ActivityLog per la Moderazione Utenti](mdc:ACTIVITYLOG_MODERATION_BEST_PRACTICES.mdc)
- [Moderazione e Wizard Generici](mdc:MODERATION_WIZARD_GENERIC.mdc)
- [Azioni di Moderazione](mdc:MODERATION_ACTIONS.mdc)
- [Configurazione Stati Utente](mdc:USER_STATES.mdc)
- [Notifiche Moderazione](mdc:MODERATION_NOTIFICATIONS.mdc)
