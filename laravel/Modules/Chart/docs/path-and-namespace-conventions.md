# Path and Namespace Conventions in <nome progetto>

## Path Structure vs Namespace Structure

In <nome progetto>, there's a critical distinction between physical paths and PHP namespaces that must be understood and followed:

### Physical Paths (Filesystem Structure)

- **Directory Names**: Always use lowercase for standard directory names
- **Module Structure**: `/var/www/html/<nome progetto>/laravel/Modules/[ModuleName]/app/...`
- **Important**: The `app` directory is always lowercase in the filesystem

✅ **CORRECT Physical Paths**:
- `/var/www/html/<nome progetto>/laravel/Modules/Notify/app/Actions/SMS`
- `/var/www/html/<nome progetto>/laravel/Modules/User/app/Http/Livewire/Profile`

❌ **INCORRECT Physical Paths**:
- `/var/www/html/<nome progetto>/laravel/Modules/Notify/App/Actions/SMS` (wrong capitalization)
- `/var/www/html/<nome progetto>/laravel/Modules/User/Http/Livewire/Profile` (missing app directory)

### PHP Namespaces

- **Standard Structure**: `Modules\[ModuleName]\[Segment]\[SubSegment]`
- **Important**: PHP namespaces DO NOT include the `app` segment

✅ **CORRECT Namespaces**:
- `namespace Modules\Notify\Actions\SMS;`
- `namespace Modules\User\Http\Livewire\Profile;`

❌ **INCORRECT Namespaces**:
- `namespace Modules\Notify\App\Actions\SMS;` (including App segment)
- `namespace Modules\User\app\Http\Livewire\Profile;` (lowercase app segment)

## PSR-4 Autoloading Configuration

This distinction is defined in each module's `composer.json` file:

```json
"autoload": {
    "psr-4": {
        "Modules\\Notify\\": "app/"
    }
}
```

This configuration maps the namespace `Modules\Notify\` to the directory `app/`, which explains why the `app` segment is present in the filesystem but absent in the namespace.

## Common Mistakes to Avoid

1. Using `App` (capitalized) in filesystem paths
2. Adding `app` or `App` segment in PHP namespaces
3. Omitting the `app` directory in filesystem paths
4. Assuming a direct 1:1 mapping between paths and namespaces

## Related Documentation

- [Namespace Structure](./namespace-structure.md)
- [Module Structure Standards](./modules/structure.md)
- [Path Conventions in Modules](./conventions/paths.md)
