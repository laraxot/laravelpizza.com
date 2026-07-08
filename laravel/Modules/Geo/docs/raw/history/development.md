# Filosofia di Sviluppo

Principi, pratiche e workflow di sviluppo per il progetto PTVX.

## 🎯 Filosofia Core

### Forward-Only Development

**Principio**: Mai tornare indietro, solo avanzare con correzioni incrementali.

```php
// ❌ Migration con down()
public function down()
{
    Schema::dropIfExists('users');
}

// ✅ Migration forward-only
public function down()
{
    // Rollback not supported - create a new migration to fix
}

// ✅ Nuova migration per correggere
public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('email')->unique()->change();
    });
}
```

**Razionale**:
- Deployment più sicuri
- Storico completo modifiche
- Nessuna perdita dati accidentale
- Database sempre in avanti

### DRY (Don't Repeat Yourself)

```php
// ❌ Codice duplicato
class CreateUserAction
{
    public function handle(array $data): User
    {
        $user = new User();
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->email = $data['email'];
        $user->save();
        return $user;
    }
}

class UpdateUserAction
{
    public function handle(User $user, array $data): User
    {
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->email = $data['email'];
        $user->save();
        return $user;
    }
}

// ✅ Codice riutilizzabile
class SaveUserAction
{
    public function handle(UserData $data, ?User $user = null): User
    {
        return $user
            ? tap($user)->update($data->toArray())
            : User::create($data->toArray());
    }
}
```

### KISS (Keep It Simple, Stupid)

```php
// ❌ Over-engineered
class UserProcessor
{
    protected UserValidatorInterface $validator;
    protected UserTransformerInterface $transformer;
    protected UserPersistenceInterface $persistence;

    public function process(array $data): ProcessResult
    {
        $validated = $this->validator->validate($data);
        $transformed = $this->transformer->transform($validated);
        $persisted = $this->persistence->persist($transformed);
        return new ProcessResult($persisted);
    }
}

// ✅ Simple and clear
class CreateUserAction
{
    use AsAction;

    public function handle(UserData $data): User
    {
        return User::create($data->toArray());
    }
}
```

### SOLID Principles

#### Single Responsibility

```php
// ❌ Multiple responsibilities
class UserManager
{
    public function createUser(array $data): User { }
    public function sendWelcomeEmail(User $user): void { }
    public function logUserActivity(User $user): void { }
    public function generateReport(User $user): array { }
}

// ✅ Single responsibility per class
class CreateUserAction { }
class SendWelcomeEmailAction { }
class LogUserActivityAction { }
class GenerateUserReportAction { }
```

#### Open/Closed Principle

```php
// Aperto all'estensione, chiuso alla modifica
abstract class XotBaseModel extends Model
{
    // Comportamento base immutabile

    // Extension points per moduli
    protected function bootXotBase(): void { }
}

class User extends XotBaseModel
{
    // Estende senza modificare la base
    protected function bootXotBase(): void
    {
        // Custom behavior
    }
}
```

---

## 🛠️ Pratiche di Sviluppo

### Actions over Services

**Usa Spatie QueueableAction invece di Services tradizionali**

```php
use Lorisleiva\Actions\Concerns\AsAction;
use Spatie\QueueableAction\QueueableAction;

class CreateUserAction
{
    use AsAction;
    use QueueableAction;

    public function handle(UserData $data): User
    {
        $user = User::create($data->toArray());

        // Dispatch altri eventi/actions
        SendWelcomeEmailAction::dispatch($user);
        LogUserActivityAction::run($user, 'created');

        return $user;
    }

    // Può essere usato come controller
    public function asController(Request $request): JsonResponse
    {
        $data = UserData::from($request->validated());
        $user = $this->handle($data);

        return new JsonResponse($user, 201);
    }

    // Può essere usato come job
    public function asJob(UserData $data): void
    {
        $this->handle($data);
    }

    // Può essere usato come command
    public function asCommand(Command $command): void
    {
        $data = UserData::from($command->options());
        $user = $this->handle($data);

        $command->info("User {$user->email} created!");
    }
}
```

**Vantaggi**:
- Una classe = una operazione
- Riutilizzabile ovunque
- Facilmente testabile
- Queueable out of the box
- Type-safe con DTOs

### Data Transfer Objects (DTOs)

```php
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Required;

class UserData extends Data
{
    public function __construct(
        #[Required]
        public string $first_name,

        #[Required]
        public string $last_name,

        #[Required, Email]
        public string $email,

        #[Required]
        public string $password,

        public ?int $id = null,
        public ?CarbonImmutable $created_at = null,
    ) {}

    // From Eloquent Model
    public static function fromModel(User $user): self
    {
        return new self(
            first_name: $user->first_name,
            last_name: $user->last_name,
            email: $user->email,
            password: '', // Never expose password
            id: $user->id,
            created_at: $user->created_at,
        );
    }
}
```

### Event Sourcing (quando necessario)

```php
// Per modelli che richiedono audit trail completo
use Modules\Activity\Traits\HasEvents;

class Invoice extends XotBaseModel
{
    use HasEvents;

    // Gli eventi vengono registrati automaticamente
    protected $recordEvents = [
        'created',
        'updated',
        'deleted',
        'approved',
        'rejected',
    ];
}

// Query event stream
$events = $invoice->events()->get();

// Ricostruisci stato da eventi
$invoice = Invoice::reconstruct($events);
```

---

## 🔄 Git Workflow

### Branch Strategy

```
main (production-ready)
├── develop (development)
│   ├── feature/user-authentication
│   ├── feature/performance-module
│   ├── bugfix/user-login-error
│   └── refactor/optimize-queries
└── hotfix/critical-security-patch
```

### Commit Message Convention

```bash
# Format: <type>(<scope>): <subject>

# Types:
feat: New feature
fix: Bug fix
docs: Documentation only
style: Code style changes (formatting)
refactor: Code refactoring
perf: Performance improvement
test: Adding tests
chore: Maintenance tasks
ci: CI/CD changes

# Examples:
feat(user): add OAuth authentication
fix(performance): resolve N+1 query issue
docs(setup): update installation guide
refactor(user): convert service to action pattern
test(gdpr): add consent management tests
chore(deps): update Laravel to 11.x
```

### Commit Workflow

```bash
# 1. Create feature branch
git checkout -b feature/amazing-feature

# 2. Make changes
# (write code, tests, documentation)

# 3. Verify quality before commit
./vendor/bin/phpstan analyse
./vendor/bin/pint
./vendor/bin/pest

# 4. Stage changes
git add .

# 5. Commit with descriptive message
git commit -m "feat(user): add two-factor authentication"

# 6. Push to remote
git push origin feature/amazing-feature

# 7. Create Pull Request on GitHub
```

### Pull Request Guidelines

**PR Title**: Stesso formato dei commit messages

**PR Description Template**:
```markdown
## Description
Brief description of changes

## Type of Change
- [ ] Bug fix
- [ ] New feature
- [ ] Breaking change
- [ ] Documentation update

## Testing
- [ ] Unit tests added/updated
- [ ] Feature tests added/updated
- [ ] Manual testing completed

## Checklist
- [ ] Code follows style guidelines
- [ ] Self-review completed
- [ ] Documentation updated
- [ ] PHPStan Level 10 passes
- [ ] All tests pass
- [ ] No breaking changes (or documented)

## Related Issues
Closes #123
```

---

## 🧪 Test-Driven Development (TDD)

### Red-Green-Refactor Cycle

```php
// 1. RED: Write failing test first
it('can create a user', function () {
    $data = UserData::from([
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john@example.com',
        'password' => 'password123',
    ]);

    $user = CreateUserAction::run($data);

    expect($user->id)->not->toBeNull()
        ->and($user->email)->toBe('john@example.com');
});

// 2. GREEN: Write minimal code to pass
class CreateUserAction
{
    use AsAction;

    public function handle(UserData $data): User
    {
        return User::create($data->toArray());
    }
}

// 3. REFACTOR: Improve code quality
class CreateUserAction
{
    use AsAction;
    use QueueableAction;

    public function handle(UserData $data): User
    {
        $user = User::create($data->toArray());

        SendWelcomeEmailAction::dispatch($user);
        event(new UserCreated($user));

        return $user;
    }
}
```

### Test Pyramid

```
         /\
        /  \  E2E Tests (5%)
       /____\
      /      \  Integration Tests (15%)
     /________\
    /          \  Unit Tests (80%)
   /____________\
```

**Focus**: Più unit tests, meno E2E tests

---

## 📝 Documentazione

### Self-Documenting Code

```php
// ❌ Needs comments to understand
// Check if user is active and has permission
if ($u->s == 1 && in_array($p, $u->p)) {
    // do something
}

// ✅ Code explains itself
if ($user->isActive() && $user->hasPermission($permission)) {
    // do something
}
```

### When to Write Comments

```php
// ❌ Obvious comment
// Get the user by ID
$user = User::find($id);

// ✅ Explains "why", not "what"
// We need to bypass the global scope here because
// soft-deleted users can still have active sessions
$user = User::withTrashed()->find($id);

// ✅ Documents complex business logic
/**
 * Calculate incentive based on performance score.
 *
 * Uses progressive percentage:
 * - 90-100%: 15% incentive
 * - 80-89%: 10% incentive
 * - 70-79%: 5% incentive
 *
 * As per ministerial decree 123/2023 art. 45
 */
public function calculateIncentive(float $score): float
{
    return match(true) {
        $score >= 90 => 0.15,
        $score >= 80 => 0.10,
        $score >= 70 => 0.05,
        default => 0,
    };
}
```

### Module Documentation

Ogni modulo deve avere:

```
Modules/{ModuleName}/docs/
├── README.md              # Overview
├── architecture.md        # Technical details
├── api.md                # API documentation
├── examples.md           # Usage examples
└── changelog.md          # Version history
```

---

## ⚡ Performance Best Practices

### Database Queries

```php
// ❌ N+1 Query Problem
$users = User::all();
foreach ($users as $user) {
    echo $user->profile->name; // Query per ogni user!
}

// ✅ Eager Loading
$users = User::with('profile')->get();
foreach ($users as $user) {
    echo $user->profile->name; // No extra queries
}

// ✅ Lazy Eager Loading (quando necessario)
$users = User::all();
$users->load('profile');
```

### Caching Strategy

```php
// Cache per query costose
$statistics = Cache::remember(
    'user-statistics',
    now()->addHour(),
    fn () => User::calculateStatistics()
);

// Cache tags per invalidazione selettiva
Cache::tags(['users', 'statistics'])->put(
    'user-statistics',
    $statistics,
    now()->addHour()
);

// Invalidate cache quando necessario
Cache::tags(['users', 'statistics'])->flush();
```

### Queue for Heavy Operations

```php
// ❌ Operazione sincrona pesante
public function store(Request $request)
{
    $user = User::create($request->validated());

    // Blocca la response!
    $this->sendWelcomeEmail($user);
    $this->generateReport($user);
    $this->notifyAdmins($user);

    return redirect()->route('users.show', $user);
}

// ✅ Operazioni pesanti in coda
public function store(Request $request)
{
    $user = User::create($request->validated());

    // Response immediata, elaborazione asincrona
    SendWelcomeEmailAction::dispatch($user);
    GenerateUserReportAction::dispatch($user);
    NotifyAdminsAction::dispatch($user);

    return redirect()->route('users.show', $user);
}
```

---

## 🔒 Security Best Practices

### Input Validation

```php
// Sempre validare input con Form Requests o DTOs
class UserData extends Data
{
    public function __construct(
        #[Required, Min(2), Max(50)]
        public string $first_name,

        #[Required, Email, Unique(table: 'users', column: 'email')]
        public string $email,

        #[Required, Min(8), Password]
        public string $password,
    ) {}
}
```

### SQL Injection Prevention

```php
// ❌ SQL Injection vulnerability
$users = DB::select("SELECT * FROM users WHERE email = '{$email}'");

// ✅ Parameter binding
$users = DB::select('SELECT * FROM users WHERE email = ?', [$email]);

// ✅ Query Builder (sempre usare questo)
$users = User::where('email', $email)->get();
```

### XSS Prevention

```php
// Blade automatically escapes
{{ $user->name }} // Safe

// Raw output (use carefully)
{!! $user->name !!} // Dangerous

// Purify HTML input
use Mews\Purifier\Facades\Purifier;
$clean = Purifier::clean($dirtyHtml);
```

---

## 📊 Code Review Checklist

### Reviewer Checklist

- [ ] Codice segue style guide (Pint passa)
- [ ] PHPStan Level 10 passa
- [ ] Test coverage adeguato
- [ ] Test tutti passanti
- [ ] No hardcoded values (usa config/env)
- [ ] No credenziali/secrets nel codice
- [ ] Documentazione aggiornata
- [ ] No console.log/dd()/dump() nel codice
- [ ] Performance considerata
- [ ] Security vulnerabilities check
- [ ] Breaking changes documentati

### Author Checklist

Prima di creare PR:

- [ ] Self-review completato
- [ ] Commit message seguono convention
- [ ] Branch aggiornato con develop
- [ ] Conflitti risolti
- [ ] CHANGELOG.md aggiornato
- [ ] Migration testate (up e down)
- [ ] Verifica su ambiente staging

---

## 🎓 Learning Resources

### Internal
- [Architettura](architecture.md)
- [Regole Laraxot](laraxot-rules.md)
- [Qualità Codice](code-quality.md)

### External
- [Laravel Best Practices](https://github.com/alexeymezenin/laravel-best-practices)
- [Spatie Guidelines](https://guidelines.spatie.be/)
- [PHP The Right Way](https://phptherightway.com/)
- [Clean Code PHP](https://github.com/piotrplenik/clean-code-php)

---

## 💡 Tips for New Developers

1. **Leggi il codice esistente** prima di scrivere nuovo codice
2. **Segui i pattern stabiliti** nel progetto
3. **Chiedi quando non sei sicuro** - meglio chiedere che indovinare
4. **Scrivi test** - ti salveranno da molti problemi
5. **Commit frequenti** con messaggi descrittivi
6. **Code review attivo** - impara dai feedback
7. **Documentazione always** - aiuta te futuro e il team
8. **Performance later** - prima fa funzionare, poi ottimizza
9. **Security first** - pensa alla sicurezza sin dall'inizio
10. **Have fun!** - programmare deve essere piacevole

---

## 🚀 Zen of PTVX

- **Forward Only**: Mai tornare indietro, solo avanzare
- **Simple Profound**: Semplice è meglio di complesso
- **Document Why**: Spiega il "perché", non il "cosa"
- **Test First**: Test non sono opzionali
- **Type Safe**: Type hints salvano vite
- **DRY Always**: Non ripeterti mai
- **XotBase Sacred**: Le classi base sono sacre
- **Quality First**: Qualità prima di velocità
- **Security Always**: Sicurezza non è opzionale
- **Team Effort**: Codice è scritto per essere letto
