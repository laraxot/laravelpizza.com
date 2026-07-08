# Gestione dei Repository

## Repository Pattern
Il Repository Pattern è un pattern di progettazione che astrae la persistenza dei dati e centralizza la logica comune di accesso ai dati.

### Implementazione Base
```php
interface RepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
```

### Repository con Spatie Query Builder
```php
use Spatie\QueryBuilder\QueryBuilder;

class UserRepository implements RepositoryInterface
{
    public function all()
    {
        return QueryBuilder::for(User::class)
            ->allowedFilters(['name', 'email'])
            ->allowedSorts(['created_at'])
            ->paginate();
    }
}
```

## Best Practices

### 1. Interfacce
- Definire interfacce per tutti i repository
- Utilizzare l'injection delle dipendenze
- Implementare i contratti in modo coerente

### 2. Query Builder
- Utilizzare Spatie Query Builder per filtri e ordinamento
- Implementare scope query per logica complessa
- Utilizzare eager loading per ottimizzare le query

### 3. Caching
- Implementare il caching a livello repository
- Utilizzare tag per invalidazione selettiva
- Implementare TTL appropriati

### 4. Transazioni
- Utilizzare le transazioni per operazioni multiple
- Implementare rollback automatico
- Gestire le eccezioni appropriatamente

### 5. Validazione
- Validare i dati prima dell'inserimento
- Utilizzare i DTO per la validazione
- Implementare regole di business

## Esempi di Utilizzo

### Repository Base
```php
class BaseRepository implements RepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }
}
```

### Repository Specifico
```php
class UserRepository extends BaseRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function findByEmail(string $email)
    {
        return $this->model->where('email', $email)->first();
    }
}
```

### Utilizzo nel Controller
```php
class UserController extends Controller
{
    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return $this->repository->all();
    }
}
```

Tracker gathers a lot of information from your requests to identify and store:
- Sessions
- Page Views (hits on routes)
- Users (logged users)
- Devices (computer, smartphone, tablet...)
- Languages (preference, language range)
- User Devices (by, yeah, storing a cookie on each device)
- Browsers (Chrome, Mozilla Firefox, Safari, Internet Explorer...)
- Operating Systems (iOS, Mac OS, Linux, Windows...)
- Geo Location Data (Latitute, Longitude, Country and City)
- Routes and all its parameters
- Events
- Referers (url, medium, source, search term...)
- Exceptions/Errors
- Sql queries and all its bindings
- Url queries and all its arguments
- Database connections

https://github.com/antonioribeiro/tracker

---
