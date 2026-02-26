# Implementare Actions

## Perché usare le Actions?

Le Actions sono il cuore della nostra logica di business per diversi motivi:

1. **Atomicità**: Ogni action fa una cosa sola e la fa bene
2. **Testabilità**: Facili da testare in isolamento
3. **Riusabilità**: Possono essere utilizzate in diversi contesti
4. **Manutenibilità**: Codice più facile da mantenere e modificare
5. **Queue-ability**: Possono essere eseguite in modo asincrono quando necessario

## Cosa sono le Actions?

Le Actions sono classi che implementano una singola operazione di business logic. Utilizziamo `Spatie\QueueableAction\QueueableAction` invece dei tradizionali Services perché:

- Sono più facili da testare
- Possono essere messe in coda
- Hanno una responsabilità singola
- Sono più facili da comporre

## Come Implementare un'Action

### 1. Struttura Base

```php
namespace Modules\YourModule\Actions;

use Spatie\QueueableAction\QueueableAction;
use Modules\YourModule\DataObjects\YourData;

class CreateSomethingAction
{
    use QueueableAction;

    public function __construct(
        private readonly DependencyInterface $dependency
    ) {}

    public function execute(YourData $data): Result
    {
        // Logica dell'action
    }
}
```

### 2. Dipendenze

- Inietta le dipendenze nel costruttore
- Usa interfacce per il disaccoppiamento
- Mantieni le dipendenze al minimo

### 3. Input/Output

- Usa sempre Data Objects per input/output
- Definisci tipi di ritorno espliciti
- Documenta le eccezioni

## Best Practices

### ✅ Da Fare

- Nomina le actions con verbi (Create, Update, Delete)
- Una action = una operazione
- Usa type hints ovunque
- Documenta il comportamento
- Scrivi test unitari

### ❌ Da Evitare

- Logic complessa nel costruttore
- Dipendenze non necessarie
- Side effects non documentati
- Return types dinamici

## Esempi Pratici

### 1. Create Action

```php
namespace Modules\Blog\Actions;

use Spatie\QueueableAction\QueueableAction;
use Modules\Blog\DataObjects\PostData;
use Modules\Blog\Models\Post;

class CreatePostAction
{
    use QueueableAction;

    public function execute(PostData $data): Post
    {
        return Post::create($data->toArray());
    }
}
```

### 2. Action con Validazione

```php
namespace Modules\User\Actions;

use Spatie\QueueableAction\QueueableAction;
use Modules\User\DataObjects\UserData;
use Modules\User\Exceptions\InvalidUserDataException;

class ValidateUserDataAction
{
    use QueueableAction;

    public function execute(UserData $data): bool
    {
        if (!$this->isValid($data)) {
            throw new InvalidUserDataException();
        }
        
        return true;
    }
}
```

## Testing

```php
namespace Tests\Unit\Modules\Blog\Actions;

use Tests\TestCase;
use Modules\Blog\Actions\CreatePostAction;
use Modules\Blog\DataObjects\PostData;

class CreatePostActionTest extends TestCase
{
    /** @test */
    public function it_creates_a_post(): void
    {
        $action = app(CreatePostAction::class);
        $data = PostData::from([/* ... */]);
        
        $result = $action->execute($data);
        
        $this->assertDatabaseHas('posts', $data->toArray());
    }
}
```

## Composizione di Actions

Le actions possono essere composte per operazioni più complesse:

```php
namespace Modules\Blog\Actions;

use Spatie\QueueableAction\QueueableAction;
use Modules\Blog\DataObjects\PostData;

class PublishPostAction
{
    use QueueableAction;

    public function __construct(
        private readonly ValidatePostAction $validatePost,
        private readonly CreatePostAction $createPost,
        private readonly NotifySubscribersAction $notifySubscribers
    ) {}

    public function execute(PostData $data): void
    {
        $this->validatePost->execute($data);
        $post = $this->createPost->execute($data);
        $this->notifySubscribers->execute($post);
    }
}
```

## Debugging

Per facilitare il debugging:

1. Usa logging appropriato
2. Cattura e gestisci le eccezioni
3. Implementa try/catch solo dove necessario
4. Usa transaction DB quando appropriato

## Links Utili

- [[../architecture/actions.md|Architettura Actions]]
- [[../testing/unit-tests.md|Unit Testing]]
- [[../performance/optimization.md|Ottimizzazioni]] 