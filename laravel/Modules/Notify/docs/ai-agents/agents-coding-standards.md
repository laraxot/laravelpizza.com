# AGENTS Coding Standards

Standard di codifica PHP e naming conventions.

## PHP Standards

### Strict Types
- **Always** start files with `declare(strict_types=1);`

### Coding Standards
- Follow **PSR-12** coding standards
- Use **PHP 8.2+** features (constructor property promotion, union types, etc.)

### Type Hints
- **Type hints required** for all method parameters and return types

### PHPDoc
- Use **PHPDoc blocks** for class documentation (avoid inline comments)

---

## Naming Conventions

| Element | Convention | Example |
|---------|------------|---------|
| Classes/Interfaces | PascalCase | `UserController`, `BlogPost` |
| Methods/Properties | camelCase | `getUserById`, `createBlogPost` |
| Database | snake_case | `users`, `blog_posts`, `user_id` |
| Files | Follow PSR-4 | |
| Routes | kebab-case | `user.profile`, `blog.create` |

---

## Import Organization

```php
// External libraries
use Illuminate\Http\Request;
use Filament\Forms\Form;
use Livewire\Volt\Component;

// Internal app imports
use App\Models\User;
use Modules\Blog\Models\Post;
use Modules\Blog\Http\Controllers\BlogController;
```

---

## Module Architecture - Folio Routing

**Modules MUST NOT have Folio page files** (`resources/views/pages/`) per route coperte dal tema catch-all (`[container0]/[slug0]/index.blade.php`).

- Se una pagina modulo conflitta: rinominare a `.blade.php.old`
- I moduli forniscono: Models, Actions, Filament Widgets, CMS block JSON config
- Il tema fornisce: routing, layout, rendering

---

## Generic Page Blade Rule

**Il blade generico `Themes/TwentyOne/resources/views/pages/[container0]/[slug0]/index.blade.php` DEVE rimanere PULITO e GENERICO.**

- Dovrebbe solo gestire container routing e dispatch a pagine modulo-specifiche
- NON dovrebbe MAI contenere logica modulo-specifica (models, methods, business logic)

### ✅ CORRETTO

```php
// Only routing and dispatch
if ($container0 === 'predicts') {
    @include('predict::pages.predict-detail')
} elseif ($container0 === 'events') {
    @include('events::pages.event-detail')
} else {
    // generic CMS rendering
}
```

### ❌ SBAGLIATO

```php
// ❌ NEVER do this in the generic blade
private function getMarketData() { ... }  // Predict-specific
private function buildOrderBook() { ... } // Predict-specific
private function calculateQualityScore() { ... } // Predict-specific
```

---

## Common Patterns

### Repository Pattern

```php
interface UserRepositoryInterface {
    public function findById(int $id): ?User;
    public function create(array $data): User;
}

class EloquentUserRepository implements UserRepositoryInterface {
    public function findById(int $id): ?User {
        return User::find($id);
    }
}
```

### Action Pattern

```php
use Spatie\QueueableAction\QueueableAction;

class CreateUserAction
{
    use QueueableAction;

    public function __construct(
        private UserRepositoryInterface $repository,
        private EventDispatcher $events
    ) {}

    public function execute(array $data): User
    {
        $user = $this->repository->create($data);
        $this->events->dispatch(new UserCreated($user));

        return $user;
    }
}
```

**Nota**: Non introdurre classi `*Service` generiche per business logic.
Preferire Action classes esplicite, e quando serve reuse/async, usare `spatie/laravel-queueable-action`.

### Enum with Filament Integration

```php
enum Status: string implements HasLabel, HasColor {
    case Active = 'active';
    case Inactive = 'inactive';
    
    public function getLabel(): string {
        return match($this) {
            self::Active => __('Active'),
            self::Inactive => __('Inactive'),
        };
    }
    
    public function getColor(): string {
        return match($this) {
            self::Active => 'success',
            self::Inactive => 'danger',
        };
    }
}
```

---

## 🔗 Link

- [Indice AGENTS](./agents-split-index.md)
- [code-style.md](./code-style.md) - Più dettagliato
- [critical-rules.md](./critical-rules.md) - Regole critiche
- [AGENTS.md originale](../../AGENTS.md)
- [Index principale](./index.md)

## Miglioramenti vs Originale

- Esempi concreti per ogni pattern
- Tabella naming conventions
- Differenza chiaro tra CORRETTO e SBAGLIATO
