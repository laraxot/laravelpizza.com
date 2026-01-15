# Registrazione dei Componenti nei Moduli

## Regola Fondamentale

> **IMPORTANTE**: Non registrare manualmente i componenti Blade nei ServiceProvider che estendono XotBaseServiceProvider.

## Funzionamento Corretto

XotBaseServiceProvider implementa già un metodo `registerBladeComponents()` che:

1. Registra automaticamente il namespace dei componenti con `Blade::componentNamespace()`
2. Utilizza `RegisterBladeComponentsAction` per registrare tutti i componenti nel percorso standard

## Errore Comune

Un errore comune è aggiungere manualmente registrazioni di componenti nei ServiceProvider dei moduli:

```php
// ERRATO ❌
class UserServiceProvider extends XotBaseServiceProvider
{
    public function boot(): void
    {
        parent::boot(); // Già chiama registerBladeComponents()

        // Registrazione ridondante ed errata
        Blade::component('user-profile-dropdown', \Modules\User\View\Components\Profile\Dropdown::class);
    }
}
```

## Implementazione Corretta

La registrazione avviene automaticamente se si segue la struttura corretta:

```php
// CORRETTO ✅
class UserServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'User';

    public function boot(): void
    {
        parent::boot(); // Questo è sufficiente!

        // Eventuale codice aggiuntivo specifico...
    }
}
```

## Struttura Corretta dei Componenti

I componenti devono essere organizzati nel percorso standard del modulo:

```
Modules/
└── ModuleName/
    └── View/
        └── Components/
            └── ComponentName.php
```

Il componente sarà registrato automaticamente come `module-name::component-name`.

## Richiesta di Modifiche Personalizzate

Se hai bisogno di personalizzazioni nella registrazione dei componenti:

1. Crea un trait specifico per il tuo modulo
2. Estendi `RegisterBladeComponentsAction` con una versione specifica per il tuo modulo
3. Sovrascrivi il metodo `registerBladeComponents()` nel tuo ServiceProvider **solo se assolutamente necessario**

## Riferimenti

- [XotBaseServiceProvider](Modules/Xot/app/Providers/XotBaseServiceProvider.php)
- [RegisterBladeComponentsAction](Modules/Xot/Actions/Blade/RegisterBladeComponentsAction.php)
