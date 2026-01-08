# Standard di Sviluppo

## 1. Principi Generali

### 1.1 Type Safety
- Utilizzare `declare(strict_types=1)` in tutti i file PHP
- Definire tipi di ritorno per tutti i metodi
- Utilizzare type hints per tutti i parametri
- Evitare `mixed` quando possibile

### 1.2 Design Patterns
- Preferire composizione su ereditarietà
- Utilizzare DTO per il trasferimento dati
- Implementare QueueableActions per operazioni asincrone
- Seguire il principio di responsabilità singola

### 1.3 Clean Code
- Nomi descrittivi per classi, metodi e variabili
- Funzioni piccole e focalizzate
- Commenti solo quando necessario
- Codice auto-documentante

## 2. Struttura del Codice

### 2.1 Namespace
```php
namespace Modules\ModuleName\App\Actions;

class CreateUserAction
{
    // ...
}
```

### 2.2 Classi
```php
declare(strict_types=1);

namespace Modules\ModuleName\App\Data;

use Spatie\LaravelData\Data;

final class UserData extends Data
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly ?string $phone = null,
    ) {}
}
```

### 2.3 Metodi
```php
public function execute(UserData $data): User
{
    return User::create([
        'name' => $data->name,
        'email' => $data->email,
        'phone' => $data->phone,
    ]);
}
```

## 3. Data Objects

### 3.1 Definizione
```php
declare(strict_types=1);

namespace Modules\ModuleName\App\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation;

final class UserData extends Data
{
    public function __construct(
        #[Validation\Required]
        #[Validation\StringType]
        public readonly string $name,
        
        #[Validation\Required]
        #[Validation\Email]
        public readonly string $email,
        
        #[Validation\Nullable]
        #[Validation\StringType]
        public readonly ?string $phone = null,
    ) {}
}
```

### 3.2 Utilizzo
```php
$userData = UserData::from([
    'name' => 'John Doe',
    'email' => 'john@example.com',
]);

$user = CreateUserAction::execute($userData);
```

## 4. Queueable Actions

### 4.1 Definizione
```php
declare(strict_types=1);

namespace Modules\ModuleName\App\Actions;

use Spatie\QueueableAction\QueueableAction;
use Modules\ModuleName\App\Data\UserData;
use App\Models\User;

class CreateUserAction
{
    use QueueableAction;
    
    public function execute(UserData $data): User
    {
        return User::create([
            'name' => $data->name,
            'email' => $data->email,
            'phone' => $data->phone,
        ]);
    }
}
```

### 4.2 Utilizzo
```php
CreateUserAction::dispatch($userData);
```

## 5. Testing

### 5.1 Unit Tests
```php
declare(strict_types=1);

namespace Tests\Modules\ModuleName\Actions;

use Tests\TestCase;
use Modules\ModuleName\App\Actions\CreateUserAction;
use Modules\ModuleName\App\Data\UserData;

class CreateUserActionTest extends TestCase
{
    public function test_it_creates_a_user(): void
    {
        $userData = UserData::from([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
        
        $user = CreateUserAction::execute($userData);
        
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('john@example.com', $user->email);
    }
}
```

### 5.2 Feature Tests
```php
declare(strict_types=1);

namespace Tests\Modules\ModuleName\Features;

use Tests\TestCase;
use Modules\ModuleName\App\Data\UserData;

class UserManagementTest extends TestCase
{
    public function test_user_can_be_created(): void
    {
        $response = $this->postJson('/api/users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
        
        $response->assertCreated();
        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
    }
}
```

## 6. Documentazione

### 6.1 PHPDoc
```php
/**
 * Crea un nuovo utente nel sistema.
 *
 * @param UserData $data Dati dell'utente da creare
 * @return User L'utente appena creato
 * @throws \Exception Se la creazione fallisce
 */
public function execute(UserData $data): User
{
    // ...
}
```

### 6.2 README
```markdown
# Modulo ModuleName

## Descrizione
Breve descrizione del modulo e delle sue funzionalità.

## Installazione
1. Aggiungere il modulo al composer.json
2. Eseguire composer update
3. Registrare il service provider

## Utilizzo
Esempi di utilizzo del modulo.

## Testing
Istruzioni per eseguire i test.
```

## 7. Performance

### 7.1 Query
```php
// Male
$users = User::all();
foreach ($users as $user) {
    $posts = $user->posts;
}

// Bene
$users = User::with('posts')->get();
```

### 7.2 Caching
```php
// Male
$users = User::all();

// Bene
$users = Cache::remember('users', 3600, function () {
    return User::all();
});
```

## 8. Sicurezza

### 8.1 Validazione
```php
// Male
$data = $request->all();

// Bene
$data = $request->validated();
```

### 8.2 Autorizzazione
```php
// Male
if ($user->isAdmin()) {
    // ...
}

// Bene
$this->authorize('create', User::class);
```

## 9. Error Handling

### 9.1 Eccezioni
```php
// Male
try {
    // ...
} catch (\Exception $e) {
    return false;
}

// Bene
try {
    // ...
} catch (UserNotFoundException $e) {
    throw new UserNotFoundHttpException('User not found');
}
```

### 9.2 Logging
```php
// Male
Log::error('Error');

// Bene
Log::error('User creation failed', [
    'user_id' => $userId,
    'error' => $e->getMessage(),
]);
```

## 10. Best Practices

### 10.1 Naming
- Classi: PascalCase
- Metodi: camelCase
- Variabili: camelCase
- Costanti: UPPER_SNAKE_CASE

### 10.2 Formattazione
- Indentazione: 4 spazi
- Lunghezza riga: max 120 caratteri
- Spazi dopo virgole
- Parentesi su nuova riga per metodi

### 10.3 Commenti
- Documentare solo codice complesso
- Mantenere commenti aggiornati
- Evitare commenti ovvi
- Utilizzare PHPDoc per API pubbliche 