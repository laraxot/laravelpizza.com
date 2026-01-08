# GetAllModelsByModuleNameAction

## Descrizione
Questa azione recupera tutti i modelli presenti in un modulo specifico. È implementata come QueueableAction utilizzando Spatie QueueableAction.

## Utilizzo
```php
$action = new GetAllModelsByModuleNameAction();
$models = $action->execute('NomeModulo');
```

## Parametri
- `string $moduleName`: Nome del modulo da cui recuperare i modelli

## Valore di ritorno
- `array`: Array associativo dove le chiavi sono i nomi dei modelli in formato snake_case e i valori sono i nomi completi delle classi

## Esempio di output
```php
[
    'user' => 'Modules\User\Models\User',
    'role' => 'Modules\User\Models\Role',
    'permission' => 'Modules\User\Models\Permission'
]
```

## Dettagli di implementazione
- Utilizza il facade `Module` di Nwidart per trovare il modulo
- Scansiona la directory `Models` del modulo
- Filtra i file PHP non astratti
- Gestisce correttamente i namespace
- Implementa la gestione degli errori per classi non valide

## Best Practices
- Utilizza `strict_types=1`
- Implementa la coda con Spatie QueueableAction
- Gestisce correttamente i path del filesystem
- Utilizza reflection per verificare le classi
- Implementa una gestione robusta degli errori

## Note sulla sicurezza
- Verifica l'esistenza del modulo prima di procedere
- Utilizza `File::files()` per una scansione sicura della directory
- Implementa controlli di tipo per i namespace
- Gestisce correttamente i separatori di directory cross-platform

## Collegamenti correlati
- [Documentazione Spatie QueueableAction](https://github.com/spatie/laravel-queueable-action)
- [Documentazione Nwidart Modules](https://nwidart.com/laravel-modules/v6/introduction)
- [PHP Reflection](https://www.php.net/manual/en/book.reflection.php) 