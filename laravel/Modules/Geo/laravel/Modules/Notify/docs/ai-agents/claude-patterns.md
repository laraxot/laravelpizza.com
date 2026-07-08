# CLAUDE Patterns

Pattern architetturali comuni.

## 1. Action Pattern (Business Logic)

Use Spatie QueueableAction per toda la business logic:

```php
// Modules/Meetup/app/Actions/Event/CreateEventAction.php
use Spatie\QueueableAction\QueueableAction;

class CreateEventAction
{
    use QueueableAction;

    public function execute(EventData $data): Event
    {
        return DB::transaction(function () use ($data) {
            $event = Event::create($data->toArray());

            activity('event')
                ->performedOn($event)
                ->causedBy(auth()->user())
                ->log('Event created');

            return $event;
        });
    }
}
```

---

## 2. Data Transfer Objects

Use Spatie Laravel Data per DTOs:

```php
use Spatie\LaravelData\Data;

class EventData extends Data
{
    public function __construct(
        public string $title,
        public string $description,
        public ?Carbon $start_datetime = null,
    ) {}
}
```

---

## 3. Strict Typing

**ALWAYS** declare strict types:

```php
<?php
declare(strict_types=1);

namespace Modules\YourModule\...;
```

---

## 4. Model Conventions

```php
use HasUuids, SoftDeletes, HasFactory;

protected $fillable = [...];
protected $casts = [
    'start_datetime' => 'datetime',
    'is_active' => 'boolean',
];
protected $hidden = ['password'];
```

---

## 5. Translation Pattern

```php
// Use module-prefixed translation keys
trans('meetup::events.title')

// In Filament components
->label(trans('meetup::fields.title'))
```

---

## 6. Core Principles

### DRY
- Use Actions, Services, Traits for shared logic
- No code duplication

### KISS
- Simple solutions over complex
- Avoid over-engineering

### SOLID
- Single Responsibility
- Open/Closed
- Liskov Substitution
- Interface Segregation
- Dependency Inversion

### ROBUST
- Strict type safety (PHP 8.2+)
- PHPStan level 10
- Error handling
- Input validation

### Laraxot
- Modular architecture
- XotBase inheritance
- CMS-driven content
- One table, one migration

---

## 🔗 Link

- [Indice CLAUDE](./claude-split-index.md)
- [queueable-actions.md](./queueable-actions.md)
- [CLAUDE.md originale](../../CLAUDE.md)
- [Index principale](./index.md)
