# Standard di Sviluppo

## Best Practices Laravel

### Principi Generali
- Seguire il principio "fat models, skinny controllers"
- Utilizzare Spatie Laravel Data per la gestione dei dati
- Preferire Spatie QueueableActions invece dei Services
- Seguire le convenzioni di naming di Laravel

### Convenzioni di Codice
- Utilizzare la tipizzazione stretta (strict typing)
- Documentare tutte le classi e i metodi pubblici
- Seguire PSR-12 per lo stile del codice

### Data Objects
```php
use Spatie\LaravelData\Data;

class UserData extends Data
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly ?string $phone = null,
    ) {}
}
```

### Actions
```php
use Spatie\QueueableAction\QueueableAction;

class CreateUserAction
{
    use QueueableAction;

    public function execute(UserData $userData): User
    {
        return User::create([
            'name' => $userData->name,
            'email' => $userData->email,
            'phone' => $userData->phone,
        ]);
    }
}
```

### Validazione
- Utilizzare Form Requests per la validazione
- Definire regole di validazione chiare e riutilizzabili
- Utilizzare i messaggi di errore personalizzati in italiano

### Testing
- Scrivere test per tutte le Actions
- Utilizzare factories per i dati di test
- Seguire la convenzione AAA (Arrange, Act, Assert)

### Database
- Utilizzare le migrazioni per tutte le modifiche al database
- Definire indici appropriati
- Utilizzare le relazioni Eloquent correttamente

### Sicurezza
- Validare tutti gli input
- Utilizzare Gate e Policy per l'autorizzazione
- Seguire le best practices OWASP

### Performance
- Utilizzare il caching quando appropriato
- Ottimizzare le query N+1
- Utilizzare le code per operazioni pesanti

### Moduli
- Organizzare il codice in moduli logici
- Mantenere i moduli indipendenti
- Documentare le dipendenze tra moduli

### Versionamento
- Seguire Semantic Versioning
- Mantenere un changelog aggiornato
- Documentare breaking changes

### Documentazione
- Documentare tutte le API
- Mantenere README aggiornati
- Includere esempi di utilizzo

### Workflow
1. Sviluppo in feature branch
2. Code review obbligatoria
3. Testing automatizzato
4. Documentazione aggiornata
5. Merge in develop/main

### Errori Comuni da Evitare
- Non utilizzare query raw SQL
- Evitare logica di business nei controller
- Non saltare la validazione
- Non ignorare i type hints
