# Quick Reference

## Essential Commands

### Development Workflow
```bash
# Complete setup (install, migrate, optimize, serve)
composer go

# Optimize for production
composer optimize

# Run all tests
php artisan test

# Run tests with coverage
php artisan test --coverage

# Static analysis (PHPStan Level 10)
./vendor/bin/phpstan analyze

# Code formatting
./vendor/bin/pint

# Code upgrades
./vendor/bin/rector process
```

### Module Management
```bash
# List all modules
php artisan module:list

# Create new module
php artisan module:make ModuleName

# Enable/disable modules
php artisan module:enable ModuleName
php artisan module:disable ModuleName
```

### Cache Management
```bash
# Clear all caches
php artisan optimize:clear

# Clear specific caches
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Rebuild caches
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Common Code Patterns

### Resource Structure
```php
<?php
declare(strict_types=1);

namespace Modules\ModuleName\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;

class MyResource extends XotBaseResource
{
    protected static ?string $model = MyModel::class;
    
    public static function getFormSchema(): array
    {
        return [
            'name' => TextInput::make('name')->required(),
            'email' => TextInput::make('email')->email()->required(),
        ];
    }
}
```

### Action Pattern
```php
<?php
declare(strict_types=1);

namespace Modules\ModuleName\Actions;

use Spatie\QueueableAction\QueueableAction;

class MyAction
{
    use QueueableAction;
    
    public function execute(MyData $data): MyModel
    {
        // Implementation
        return $model;
    }
}
```

### DTO Pattern
```php
<?php
declare(strict_types=1);

namespace Modules\ModuleName\Datas;

use Spatie\LaravelData\Data;

class MyData extends Data
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $email = null,
    ) {}
}
```

## Quick Fixes for Common Issues

### PHPStan Level 10 Type Issues
```php
// Mixed type to string
$value = is_string($mixed) ? $mixed : '';

// Check array key exists safely
$value = is_array($arr) ? $arr['key'] ?? null : null;

// Cast numeric safely
$num = is_numeric($value) ? (float)$value : 0.0;

// Handle nullable model property
$email = $model?->email ?? 'default@example.com';
```

### Filament v4 Migration Issues
```php
// Grid/Section need columnSpanFull() for full width
Section::make()->columnSpanFull()->schema([...]);

// unique() has ignoreRecord=true by default
TextInput::make('email')->unique(ignoreRecord: true);

// Radio::inline() only affects radio buttons, not labels
Radio::make('option')->inline();
```

## Common Error Solutions

| Error | Solution |
|-------|----------|
| `Cannot override final method` | Don't override final methods from XotBaseResource |
| `property_exists() doesn't work` | Use `isset($model->property)` instead |
| `Mixed type cannot be cast` | Check type before casting |
| `Class not found` | Check namespace doesn't include 'app' segment |
| `Table or view not found` | Use correct database connection for cross-database queries |

## File Templates

### New Module Structure
```
Modules/ModuleName/
├── app/
│   ├── Models/BaseModel.php
│   ├── Providers/ModuleServiceProvider.php
│   └── Filament/Resources/
├── database/migrations/
├── resources/lang/
└── tests/
```

### Migration Template
```php
<?php
return new class extends XotBaseMigration
{
    public function up(): void
    {
        if ($this->hasTable('table_name')) {
            return;
        }
        
        Schema::create('table_name', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->timestamps();
        });
        
        $this->tableComment('table_name', 'Description');
    }
};
```

### Resource Template
```php
<?php
declare(strict_types=1);

namespace Modules\ModuleName\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;
use Filament\Forms\Components\TextInput;

class MyResource extends XotBaseResource
{
    protected static ?string $model = MyModel::class;

    public static function getFormSchema(): array
    {
        return [
            'name' => TextInput::make('name')->required(),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRecords::route('/'),
            'create' => CreateRecord::route('/create'),
            'edit' => EditRecord::route('/{record}/edit'),
        ];
    }
}
```