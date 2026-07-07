# PHPStan (Claude)

## Rules

- Do not modify `laravel/phpstan.neon`.
- No baseline.
- No ignores except known PHPStan bugs with a referenced issue.
- Use level 10 approach: fix errors instead of ignoring them.
- Complete one module before moving to the next.
- Use Safe functions for file operations, JSON, etc.
- Use Webmozart Assert for input validation.

## Commands (run from `laravel/`)

- Single file analysis:
  - `./vendor/bin/phpstan analyse path/to/file.php --memory-limit=-1`

- Module analysis (save outputs):
  - `./vendor/bin/phpstan analyse Modules/{Module} --memory-limit=-1 --error-format=json > Modules/{Module}/docs/phpstan/phpstan_errors.json`
  - `./vendor/bin/phpstan analyse Modules/{Module} --memory-limit=-1 --error-format=table > Modules/{Module}/docs/phpstan/phpstan_errors.txt`

## Critical rule

- Never use `property_exists()` on Eloquent models / magic attributes. Use `isset()`, `hasAttribute()`, `isFillable()`, or `Schema::hasColumn()` instead.

## Common fixes

### 1. Eloquent models

```php
// ❌ Wrong
if (property_exists($model, 'attribute')) { ... }

// ✅ Correct
if ($model->hasAttribute('attribute')) { ... }
// or
if ($model->isFillable('attribute')) { ... }
// or
Schema::hasColumn('table_name', 'attribute')
```

### 2. Filament components

```php
// ❌ Wrong
TextInput::make('name')->label('Name')

// ✅ Correct (labels handled automatically by LangServiceProvider)
TextInput::make('name')
```

### 3. String type safety

```php
// Add type checks before passing to HtmlString
use Webmozart\Assert\Assert;
use Illuminate\Support\HtmlString;

Assert::string($value, 'Expected string, got: %s');
return new HtmlString($value);
```

### 4. Factory doesn't exist

```php
// ❌ Wrong - factory class doesn't exist
use Modules\User\Database\Factories\UserFactory;
class MyModel extends BaseModel
{
    use HasXotFactory; // Error if factory doesn't exist
}

// ✅ Correct - remove factory references entirely
class MyModel extends BaseModel
{
    // No trait needed
}
```

### 5. Array type casting for JSON

```php
// ❌ PHPStan error: expects array<array<string, mixed>>, array<mixed> given
return $this->processEvents($events, $locale);

// ✅ Add proper type casting
/** @var array<array<string, mixed>> $events */
return $this->processEvents($events, $locale);
```

### 6. DatePicker filter in Filament

```php
// ❌ Arrow function causes mixed type errors
->query(fn ($query, array $data) => $query
    ->when($data['from'], fn ($q, $date) => $q->whereDate('start_date', '>=', $date)))

// ✅ Explicit function body with empty check
->query(function (Builder $query, array $data) {
    if (! empty($data['from'])) {
        $query->whereDate('start_date', '>=', (string) $data['from']);
    }
    return $query;
})
```

### 7. Model constructor fallback

```php
// ❌ Direct assignment causes type error
$this->attributes = $attributes;

// ✅ Use setAttribute() method
foreach ($attributes as $key => $value) {
    $this->setAttribute($key, $value);
}
```

### 8. TablColumn typo

```php
// ❌ Wrong class name
Tables\Columns\Tablecolumn::make('location')

// ✅ Correct
Tables\Columns\TextColumn::make('location')
```

### 9. Nullsafe with ?? operator

```php
// ❌ PHPStan: unnecessary nullsafe on left side of ??
'name' => $user?->name ?? 'User'

// ✅ Remove nullsafe when using ??
'name' => $user->name ?? 'User'
// or keep nullsafe but remove ??
'name' => $user?->name ?: 'User'
```

### 10. Collection mapping (selectRaw)

```php
// ❌ $item->month fails when item is array
$labels = $data->map(fn ($item) => Carbon::parse($item->month))

// ✅ Handle both array and stdClass
$labels = $data->map(function ($item) {
    $itemArray = is_array($item) ? $item : (array) $item;
    $monthValue = $itemArray['month'] ?? '';
    return $monthValue ? Carbon::parse($monthValue) : null;
})
```

### 11. Enum return types mismatch

```php
// ❌ Mismatch with EnumTrait::getFormSchema() return type
/**
 * @return array<string, TextInput>
 */
protected function getFormSchema(): array
{
    return ContactTypeEnum::getFormSchema(); // Returns array<int|string, TextInput>
}

// ✅ Match the trait return type
/**
 * @return array<int|string, TextInput>
 */
protected function getFormSchema(): array
{
    return ContactTypeEnum::getFormSchema();
}
```

## MCP Integration

When PHPStan access is limited:
1. Use MCP tools to access protected files
2. Reference `laravel/.mcp.json` for configuration
3. Apply PHPStan fixes using MCP commands
4. Verify MCP-specific changes

## Links

- [Claude docs index](./context.md)
- [General PHPStan guide](../../bashscripts/tools/prompts/phpstan.txt)
- [General docs](../../docs/README.md)
