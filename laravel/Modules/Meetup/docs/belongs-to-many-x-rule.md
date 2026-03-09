# Architectural Rule: Always Use `belongsToManyX()` Instead of `belongsToMany()`

## Why

The Laraxot framework provides a **`belongsToManyX()`** method via the `RelationX` trait (used by `XotBaseModel`). This method **must always be used** in place of Laravel's native `belongsToMany()`.

## What `belongsToManyX()` Does Automatically

1. **Auto-discovers the Pivot model** from naming conventions (e.g., `EventUser` for `Event ↔ User`).
2. **Handles cross-database pivot tables** (different DB connections, e.g., `meetup` vs `user`).
3. **Auto-adds `withPivot()` fields** from the pivot model's `$fillable`.
4. **Auto-adds `withTimestamps()`**.
5. **Auto-adds `using(PivotClass)`**.

## DRY / KISS Benefits

Instead of writing:

```php
// ❌ WRONG — verbose, fragile, manually coupling pivot details
return $this->belongsToMany(User::class, 'event_user', 'event_id', 'user_id')
    ->withTimestamps()
    ->using(EventUser::class);
```

You write:

```php
// ✅ CORRECT — one line, auto-discovers everything
return $this->belongsToManyX(User::class);
```

## Where It Lives

- **Trait**: `Modules\Xot\Models\Traits\RelationX`  
- **Used by**: `Modules\Xot\Models\XotBaseModel` (all models extend this)

## Also Available

- **`morphToManyX()`** — same principle for polymorphic many-to-many relationships.

## References

- [RelationX.php](../../Xot/app/Models/Traits/RelationX.php)
- [XotBaseModel.php](../../Xot/app/Models/XotBaseModel.php)
