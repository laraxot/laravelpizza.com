# User Module - Third-Party Model Patterns

## Spatie Permission Package Integration

### Current Implementation

The User module integrates with `spatie/laravel-permission` package through direct model extension:

```php
// ✅ CORRECT - Direct Spatie model extension
class Permission extends SpatiePermission
{
    protected $connection = 'user';
    use RelationX;
}

class Role extends SpatieRole
{
    protected $connection = 'user';
    use RelationX;
}
```

### Why This Pattern is Correct

#### 1. **Package Architecture Respect**

Spatie's permission system is designed as a complete ecosystem:
- **Middleware**: `RoleMiddleware`, `PermissionMiddleware`
- **Gates**: Automatic Laravel Gate integration
- **Blade Directives**: `@role`, `@permission`, `@can`
- **Commands**: `php artisan permission:create-role`

#### 2. **Full Feature Access**

Direct extension provides access to:
- **Role Scoping**: Team-based permission scoping
- **Permission Caching**: Built-in performance optimization
- **Guard Integration**: Multiple authentication guard support
- **Model Binding**: Automatic model permission binding

#### 3. **Update Compatibility**

Package updates work seamlessly:
- **Security Patches**: Automatic security updates
- **New Features**: Access to new package features
- **Bug Fixes**: Package bug fixes apply automatically

## Implementation Details

### Permission Model

**File**: `Modules/User/app/Models/Permission.php`

```php
class Permission extends SpatiePermission
{
    use RelationX;

    protected $connection = 'user';

    protected $fillable = [
        'name',
        'guard_name',
        'display_name',    // Laraxot extension
        'description',     // Laraxot extension
    ];

    // Laraxot-specific relationships
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'model_has_permissions', 'permission_id', 'model_id')
            ->where('model_type', User::class);
    }
}
```

### Role Model

**File**: `Modules/User/app/Models/Role.php`

```php
class Role extends SpatieRole
{
    use HasFactory;
    use RelationX;

    protected $connection = 'user';
    protected $keyType = 'string';

    // Laraxot constants
    final public const ROLE_ADMINISTRATOR = 1;
    final public const ROLE_OWNER = 2;
    final public const ROLE_USER = 3;

    // Laraxot team integration
    public function team(): BelongsTo
    {
        $xotData = XotData::make();
        $teamClass = $xotData->getTeamClass();
        return $this->belongsTo($teamClass);
    }
}
```

## Laraxot Enhancements

### Added Functionality

#### 1. **Extended Fields**
- `display_name`: Human-readable permission name
- `description`: Detailed permission description

#### 2. **Team Integration**
- Team-based role assignment
- Multi-tenant permission scoping

#### 3. **Audit Trail**
- `created_by`, `updated_by` tracking
- RelationX trait for advanced relationships

#### 4. **Constants**
- Predefined role constants for consistency
- Type-safe role references

## Configuration

### Database Connection

```php
protected $connection = 'user';
```

This ensures:
- Module-specific database isolation
- Clear separation of concerns
- Performance optimization

### Table Configuration

```php
public function getTable(): string
{
    Assert::string($table = config('permission.table_names.roles'));
    return $table;
}
```

Uses Spatie's table configuration for compatibility.

## Testing Strategy

### Package Functionality Tests

```php
// Test Spatie package functionality
public function test_spatie_permission_functionality(): void
{
    $permission = Permission::create(['name' => 'test-permission']);
    $role = Role::create(['name' => 'test-role']);

    $role->givePermissionTo($permission);
    $this->assertTrue($role->hasPermissionTo('test-permission'));
}
```

### Laraxot Integration Tests

```php
// Test Laraxot enhancements
public function test_laraxot_enhancements(): void
{
    $permission = Permission::create([
        'name' => 'test',
        'display_name' => 'Test Permission',  // Laraxot field
        'description' => 'Test description',  // Laraxot field
    ]);

    $this->assertEquals('Test Permission', $permission->display_name);
}
```

## Migration Strategy

### Package-Compatible Migrations

Migrations follow Spatie's table structure with Laraxot extensions:

```php
// Extends Spatie's default migration
$this->tableCreate(function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('guard_name')->default('web');

    // Laraxot extensions
    $table->string('display_name')->nullable();
    $table->text('description')->nullable();

    $table->timestamps();
});
```

## Best Practices

### ✅ DO

- Extend Spatie models directly
- Use proper aliases (`SpatiePermission`, `SpatieRole`)
- Add Laraxot-specific fields and methods
- Maintain package compatibility
- Test both package and Laraxot functionality

### ❌ DON'T

- Create double inheritance chains
- Replicate Spatie functionality
- Break package update compatibility
- Ignore package architecture

## Documentation References

### Package Documentation
- [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission/v5/introduction)
- [Package Configuration](https://spatie.be/docs/laravel-permission/v5/installation-setup)

### Laraxot Philosophy
- [Third-Party Model Inheritance](../Xot/docs/third-party-model-inheritance-philosophy.md)
- [Model Architecture](../Xot/docs/models/MODEL_ARCHITECTURE.md)

---

**Integration Status**: ✅ Fully compatible with Spatie package architecture
**Maintenance**: Low - leverages package maintenance
**Security**: High - benefits from package security updates
