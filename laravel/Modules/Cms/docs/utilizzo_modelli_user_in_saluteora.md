# Utilizzo Corretto dei Modelli User in il progetto

## Introduzione

il progetto utilizza un'architettura modulare con Laravel Modules, dove ogni modulo ha la propria struttura e namespace. Questo documento descrive le best practices per l'utilizzo corretto dei modelli User all'interno dell'applicazione.

## Errori Comuni da Evitare

### Errore #1: Utilizzo di App\Models\User

Un errore comune è utilizzare il modello User predefinito di Laravel:

```php
use App\Models\User; // ERRATO
```

Questo approccio è errato perché il progetto utilizza una struttura modulare dove il modello User è definito all'interno del modulo User.

### Errore #2: Utilizzo Diretto del Modello User del Modulo

Un altro errore, seppur meno grave, è utilizzare direttamente il modello User del modulo:

```php
use Modules\User\App\Models\User; // MENO OTTIMALE
```

Questo approccio funziona ma non è ottimale perché crea un accoppiamento stretto tra i componenti e il modello User specifico.

## Approccio Corretto: Utilizzare UserContract

L'approccio corretto è utilizzare l'interfaccia UserContract:

```php
use Modules\Xot\Contracts\UserContract; // CORRETTO
```

Questo approccio offre numerosi vantaggi:

1. **Disaccoppiamento**: I componenti non dipendono dall'implementazione specifica del modello User.
2. **Flessibilità**: L'implementazione di UserContract può cambiare senza influenzare i componenti che la utilizzano.
3. **Testabilità**: È più facile creare mock per i test.
4. **Coerenza**: Garantisce che tutti i componenti utilizzino lo stesso contratto.

## Utilizzo di UserContract nei Componenti

### Esempio di Iniezione di Dipendenze

```php
use Modules\Xot\Contracts\UserContract;

class MioServizio
{
    public function __construct(
        protected UserContract $user
    ) {
    }
    
    public function eseguiOperazione(): void
    {
        // Utilizzo dell'interfaccia UserContract
        $this->user->assignRole('utente');
    }
}
```

### Esempio di Risoluzione dal Container

```php
use Modules\Xot\Contracts\UserContract;

$user = app(UserContract::class);
```

### Esempio di Creazione di un Nuovo Utente

```php
use Modules\Xot\Contracts\UserContract;
use Illuminate\Support\Facades\Hash;

public function register(array $data): UserContract
{
    $user = app(UserContract::class);
    
    $user->name = $data['name'];
    $user->email = $data['email'];
    $user->password = Hash::make($data['password']);
    $user->save();
    
    return $user;
}
```

## Autenticazione in il progetto

### Utilizzo di Passport invece di Sanctum

il progetto utilizza Laravel Passport per l'autenticazione API invece di Sanctum. Questo è importante da ricordare quando si implementano funzionalità di autenticazione:

```php
// ERRATO
use Laravel\Sanctum\HasApiTokens;

// CORRETTO
use Laravel\Passport\HasApiTokens;
```

Passport è preferito in il progetto perché offre:

1. Supporto completo per OAuth 2.0
2. Gestione dei client e dei token più avanzata
3. Scadenza dei token configurabile
4. Supporto per i refresh token

## Best Practices

1. **Utilizzare Sempre UserContract**: Quando possibile, utilizzare sempre l'interfaccia UserContract invece del modello concreto.

2. **Iniettare le Dipendenze**: Utilizzare l'iniezione delle dipendenze per ottenere istanze di UserContract.

3. **Rispettare la Struttura Modulare**: Ricordare che ogni modulo ha la propria struttura e namespace.

4. **Utilizzare Passport per l'Autenticazione**: Ricordare che il progetto utilizza Passport per l'autenticazione API.

5. **Verificare i Namespace**: Controllare sempre che i namespace utilizzati siano corretti e rispettino la struttura modulare di il progetto.

## Conclusione

L'utilizzo corretto dei modelli User in il progetto è fondamentale per mantenere un'architettura pulita e modulare. Seguendo le best practices descritte in questo documento, è possibile evitare errori comuni e garantire che il codice sia manutenibile e scalabile.
