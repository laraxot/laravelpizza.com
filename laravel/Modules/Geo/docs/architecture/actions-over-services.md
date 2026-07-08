# Migrazione da Services ad Actions

## Architettura Precedente: Services

In precedenza, il sistema utilizzava un'architettura basata su Services per incapsulare la logica applicativa. Mentre questo approccio è comune in molti framework PHP, presenta alcune limitazioni:

1. **Accoppiamento elevato**: I Services tendono a crescere in dimensione e ad accumulare logica correlata ma distinta
2. **Difficoltà di test**: Services complessi sono difficili da testare in isolamento
3. **Nessun supporto integrato per code**: Eseguire operazioni in background richiedeva codice aggiuntivo
4. **Responsabilità meno definite**: I Services spesso finiscono per gestire troppe responsabilità

## Nuova Architettura: Spatie Laravel Queueable Action

Abbiamo deciso di migrare verso [spatie/laravel-queueable-action](https://github.com/spatie/laravel-queueable-action) per i seguenti vantaggi:

1. **Principio di Responsabilità Singola**: Ogni Action si concentra su un'unica operazione
2. **Facilità di Testing**: Le Actions sono facili da testare in isolamento
3. **Supporto per Code**: Le Actions possono essere eseguite in modo sincrono o in background senza modificare il codice chiamante
4. **Dipendency Injection**: Supporto completo per il container di Laravel
5. **Standardizzazione**: Approccio coerente in tutto il codebase

## Pattern di Migrazione

Quando si migra da un Service a una o più Actions:

1. Identificare le operazioni distinte all'interno del Service
2. Creare una Action separata per ciascuna operazione
3. Utilizzare Data Objects (Spatie Laravel Data) per il passaggio dei parametri
4. Aggiornare i chiamanti per utilizzare le nuove Actions
5. Rimuovere il Service obsoleto solo dopo aver migrato tutte le funzionalità

## Struttura delle Directories

```
Modules/
└── ModuleName/
    ├── app/
    │   ├── Actions/             # Queueable Actions
    │   │   ├── Domain1/         # Organizzazione opzionale per dominio
    │   │   │   └── ...
    │   │   └── Domain2/
    │   │       └── ...
    │   ├── Datas/               # Data Objects
    │   └── Services/            # Contiene solo Services legacy non ancora migrati
    └── ...
```

## Convenzioni di Naming

- **Action**: Nome del verbo + "Action" (es. `CreateUserAction`)
- **Data Object**: Nome dell'entità + "Data" (es. `UserData`)

## Esempio di Migrazione

### Service originale (da rimuovere)

```php
<?php

namespace Modules\User\Services;

class UserService
{
    public function createUser(array $data)
    {
        // Logica di creazione utente
    }
    
    public function updateUser($id, array $data)
    {
        // Logica di aggiornamento utente
    }
}
```

### Migrato a Actions

```php
<?php

namespace Modules\User\Actions;

use Modules\User\Datas\UserData;
use Modules\User\Models\User;
use Spatie\QueueableAction\QueueableAction;

class CreateUserAction
{
    use QueueableAction;
    
    public function execute(UserData $data): User
    {
        // Logica di creazione utente
    }
}

class UpdateUserAction
{
    use QueueableAction;
    
    public function execute(User $user, UserData $data): User
    {
        // Logica di aggiornamento utente
    }
}
```

## Uso delle Actions

```php
// In un controller o altrove
public function store(Request $request, CreateUserAction $action)
{
    $userData = UserData::from($request->validated());
    
    // Esecuzione sincrona
    $user = $action->execute($userData);
    
    // O in background
    $action->onQueue('users')->execute($userData);
}
```
