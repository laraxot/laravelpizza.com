# Database patterns

> Source: [AGENT_MEMORY.md](../../AGENT_MEMORY.md)
> Back: [index](index.md) | [migration-patterns.md](migration-patterns.md)

## Schemaless attributes

Use Spatie Schemaless Attributes for dynamic/flexible data fields.

### Model setup

```php
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;

protected function casts(): array
{
    return array_merge(parent::casts(), [
        'extra_attributes' => SchemalessAttributes::class,
    ]);
}
```

### Migration setup

```php
$table->schemalessAttributes('extra_attributes');
// NOT: $table->json('extra_attributes');
```

### Querying

```php
// Single attribute filter
Rating::withExtraAttributes('anno', 2024)->get();

// Multiple attribute filters
Rating::withExtraAttributes(['anno' => 2024, 'type' => 'performance'])->get();
```

### Setting values

```php
$rating->extra_attributes->set('anno', 2024);
$rating->save();
// OR
$rating->extra_attributes->anno = 2024;
$rating->save();
```

## Rating module (agnostic pattern)

The Rating module is agnostic — it serves multiple modules (IndennitaResponsabilita, Performance, Progressioni).

- Each module has its own Rating model extending `BaseRating` with only `$connection` override
- `rule` column (singular) is cast to `RuleEnum` — access via `$rating->rule?->value`
- `$rating->rules` (plural) does NOT exist — common bug to avoid
- `extra_attributes->anno` stores year, NOT pivot column

### RuleEnum pattern

```php
enum RuleEnum: string implements HasLabel
{
    case ZeroFive = 'numeric|min:0|max:5';
    case NullableNumericMin0Max25 = 'nullable|numeric|min:0|max:25';
}
```

### Dynamic validation from ratings

```php
public function getRules(): array
{
    $rulesFromRatings = $record->getRatingsRules('form_data.ratings.', '.pivot.value');

    $convertedRules = [];
    foreach ($rulesFromRatings as $key => $ruleString) {
        $convertedRules[$key] = explode('|', $ruleString);
    }

    return $convertedRules;
}
```

Note: readonly computed fields (tot, importo) should NOT have validation rules.

## Action pattern for DB operations

```php
// CORRECT - use app() resolution, not constructor DI
app(CreateRatingAction::class)->execute($data);

// WRONG - constructor DI is forbidden
public function __construct(private DatabaseManager $db) {}
```

Action method MUST be named `execute()`.

## Testing DB safety

NEVER use in tests:
- `RefreshDatabase`
- `php artisan migrate:fresh`
- `php artisan migrate --force`

Use `DatabaseTransactions` trait for rollback between tests.
Include the module's connection in `$connectionsToTransact`:
```php
protected $connectionsToTransact = ['mysql', 'activity']; // module connection required
```
