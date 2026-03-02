# Architectural Rule: Avoid `property_exists()` on Eloquent Models

## **CRITICAL LARAXOT PRINCIPLE**

**NEVER use `property_exists()` directly on Eloquent model instances.** This rule is fundamental to maintaining a robust, type-safe, and predictable codebase within the Laraxot architectural framework.

### **Motivation**

Eloquent models leverage PHP's magic methods (`__get`, `__set`) to provide dynamic access to attributes, relationships, and custom accessors/mutators. Using `property_exists()` with these models often leads to:

1.  **Inaccurate Results:** `property_exists()` only checks for declared class properties or public properties. It does not correctly account for magical attributes managed by Eloquent (e.g., database columns, relationships).
2.  **Loss of Type Safety:** Relying on `property_exists()` bypasses Eloquent's attribute casting and accessors, leading to `mixed` type issues in static analysis and potential runtime errors.
3.  **Violation of Eloquent's Design:** It works against the "Laravel Way" of interacting with models.
4.  **PHPStan/Psalm Errors:** Static analysis tools like PHPStan and Psalm will correctly flag `property_exists()` on dynamic/magic properties as unsafe or redundant.

### **The Rule**

For Eloquent model instances (`Illuminate\Database\Eloquent\Model` and its descendants):

*   **DO NOT** use `property_exists($model, 'attribute_name')`.
*   **DO NOT** use `isset($model->attribute_name)` for checking existence of magic Eloquent attributes. `isset()` *does* interact with `__isset`, but `hasAttribute()` is more explicit.
*   **DO** use `isset($model->declared_property)` for checking existence of *declared public or protected properties* on the model class.
*   **DO** use `array_key_exists('attribute_name', $model->getAttributes())` for raw database column existence (less common, use `hasAttribute` for type safety).

### **Recommended Approach: Centralized Cast Actions & Eloquent Methods**

Instead of `property_exists()`, always prefer:

1.  **`$model->hasAttribute('attribute_name')`:** The official Eloquent way to check if an attribute exists (including database columns and cast attributes).
2.  **`Modules\Xot\Actions\Cast\SafeEloquentCastAction`:** For robust, type-safe retrieval and validation of model attributes. This action handles the complexity of checking existence, casting, and providing default values.

    *   **Example (for magic attributes):**
        ```php
        use Modules\Xot\Actions\Cast\SafeEloquentCastAction;
        use Illuminate\Database\Eloquent\Model;

        function getEmail(Model $user): string
        {
            if (app(SafeEloquentCastAction::class)->hasAttribute($user, 'email')) {
                return app(SafeEloquentCastAction::class)->getStringAttribute($user, 'email', 'unknown@example.com');
            }
            return 'not-found@example.com';
        }
        ```
3.  **Direct property access with type narrowing/defaults:** If you are certain a property exists and is typed, access it directly. If it might be `null`, handle it with null coalescing (`??`).

    *   **Example:**
        ```php
        /** @var \App\Models\User $user */
        $name = $user->name ?? 'Guest';
        ```

### **Case Study: `HasDynamicFillable` Trait (`Modules\Xot\Models\Traits\HasDynamicFillable.php`)**

*   **Issue:** The `getFillable()` method in this trait previously used `property_exists($this, 'dynamicFillableEnums')`. While `$dynamicFillableEnums` is a *declared protected class property* (not a magic Eloquent attribute), the `property_exists` check was deemed redundant by PHPStan (`function.alreadyNarrowedType`) and violated the spirit of the Laraxot rule.
*   **Resolution:** The `property_exists` check was removed. The trait now directly checks `is_array($this->dynamicFillableEnums)`, relying on the implicit contract that models using this trait *will* define `protected array $dynamicFillableEnums`. If a model fails to define this property, it becomes a PHP runtime error (undefined property) which is a clearer signal of a missing contract than a silent `property_exists` returning `false`.

    *   **Before:**
        ```php
                if (! property_exists($this, 'dynamicFillableEnums') || ! is_array($this->dynamicFillableEnums)) {
                    return $fillable;
                }
        ```
    *   **After:**
        ```php
                if (! is_array($this->dynamicFillableEnums)) {
                    return $fillable;
                }
        ```

### **Compliance Check (`grep`)**

To verify adherence to this rule, regularly run:

```bash
grep -r "property_exists" laravel/Modules/ --include="*.php"
```

Any instances found (especially outside of `Safe*CastAction` implementations that use it for reflection) must be refactored.

## **Conclusion**

By strictly avoiding `property_exists()` on Eloquent models and instead utilizing `hasAttribute()`, direct property access with null coalescing, or specialized `SafeEloquentCastAction` methods, we ensure a more type-safe, robust, and architecturally consistent codebase. This practice aligns perfectly with the principles of DRY, KISS, and SOLID, reinforcing the foundational tenets of Laraxot.
