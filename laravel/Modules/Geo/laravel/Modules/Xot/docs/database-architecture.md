# Database Architecture in Laraxot

## Modular Connection Isolation (Mandatory Rule)

**CRITICAL RULE**: It is strictly forbidden to add module-specific database connections to the root configuration file `/laravel/config/database.php`.

### Rationale
Laraxot follows a "Modular Monolith" architecture where each module must be self-contained and agnostic. Hardcoding module connections in the core:
1. **Breaks Agnosticism**: The core app becomes dependent on the modules.
2. **Impairs Portability**: Modules cannot be easily added or removed without modifying core files.
3. **Violates Separation of Concerns**: Database details for a specific domain (e.g., `DbForge`, `MobilitaVolontaria`) belong within that domain's scope.

### Correct Implementation
Modules that require a specific database connection must register it dynamically within their own Service Provider (extending `XotBaseServiceProvider`) during the `boot()` or `register()` phase.

#### Example Pattern
```php
public function boot(): void
{
    parent::boot();
    $this->registerDatabaseConnection();
}

protected function registerDatabaseConnection(): void
{
    $connectionName = 'my_module_connection';
    if (config("database.connections.{$connectionName}") === null) {
        config([
            "database.connections.{$connectionName}" => [
                'driver' => 'mysql',
                'host' => env('MY_MODULE_DB_HOST', env('DB_HOST', '127.0.0.1')),
                // ... other fields
            ]
        ]);
    }
}
```

Alternatively, the configuration can be placed in the module's `config/config.php` and merged, provided it doesn't leak into the global `database.connections` in a static way.

### Model Usage
Models within the module should explicitly state their connection:
```php
protected $connection = 'my_module_connection';
```
Or use a dynamic fallback in `getConnectionName()` if the connection is optional.
