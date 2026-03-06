# Meetup Migration Rule: No Outer `tableExists()` Guard

## Rule

When a migration extends `Modules\Xot\Database\Migrations\XotBaseMigration`, do not wrap `tableCreate()` with an additional outer guard like:

```php
if (! $this->tableExists()) {
    $this->tableCreate(...);
}
```

## Why

- `tableCreate()` already checks table existence internally.
- Double-checks add noise and increase cognitive load.
- Keeping only helper-level guard keeps migrations shorter and consistent.

## Correct Pattern

```php
$tableAlreadyExisted = $this->tableExists();

$this->tableCreate(function (Blueprint $table) {
    // create columns
});

if ($tableAlreadyExisted && $this->hasColumn('title')) {
    $this->tableUpdate(function (Blueprint $table) {
        // additive / compatibility updates
    });
}
```

