# Development Tasks and Workflows

## 🧪 Quality Assurance Pipeline

### Static Analysis (PHPStan Level 10)

**MANDATORY**: All code must pass PHPStan Level 10 analysis.

```bash
# Execute from Laravel root directory
cd /var/www/html/ptvx/laravel

# Full project analysis
./vendor/bin/phpstan analyse --level=10 --memory-limit=2G

# Module-specific analysis
./vendor/bin/phpstan analyse Modules/ModuleName --level=10

# Single file analysis
./vendor/bin/phpstan analyse Modules/ModuleName/app/Models/Model.php --level=10

# Generate baseline for legacy code
./vendor/bin/phpstan analyse --generate-baseline
```

### Code Quality Tools

```bash
# PHPMD (Mess Detection)
./vendor/bin/phpmd Modules/ModuleName text phpmd.xml

# PHP Insights (Code quality metrics)
./vendor/bin/phpinsights analyse Modules/ModuleName

# Rector (Automated refactoring)
./vendor/bin/rector process Modules/ModuleName
```

## 🧪 Testing Strategy

### Unit Tests Structure

```php
<?php
declare(strict_types=1);

namespace Modules\ModuleName\Tests\Unit\Actions;

use Tests\TestCase;
use Modules\ModuleName\Actions\CreateEntityAction;
use Modules\ModuleName\Data\EntityData;

class CreateEntityActionTest extends TestCase
{
    /** @test */
    public function it_creates_entity_with_valid_data(): void
    {
        // Arrange
        $data = new EntityData(name: 'Test Entity');

        // Act
        $result = app(CreateEntityAction::class)->execute($data);

        // Assert
        $this->assertInstanceOf(Entity::class, $result);
        $this->assertEquals('Test Entity', $result->name);
    }
}
```

### Feature Tests Structure

```php
<?php
declare(strict_types=1);

namespace Modules\ModuleName\Tests\Feature;

use Tests\TestCase;
use Modules\ModuleName\Models\Entity;
use Livewire\Livewire;

class EntityManagementTest extends TestCase
{
    /** @test */
    public function user_can_create_entity(): void
    {
        $this->actingAs($this->createUser());

        Livewire::test(CreateEntityForm::class)
            ->set('name', 'New Entity')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('entities', ['name' => 'New Entity']);
    }
}
```

### Running Tests

```bash
# All tests
./vendor/bin/pest

# Module-specific tests
./vendor/bin/pest Modules/ModuleName

# With coverage
./vendor/bin/pest --coverage

# Parallel execution
./vendor/bin/pest --parallel
```

## 🚀 Deployment Workflow

### Pre-Deployment Checklist

- [ ] **PHPStan Level 10**: `./vendor/bin/phpstan analyse --level=10`
- [ ] **Tests Passing**: `./vendor/bin/pest --parallel`
- [ ] **Code Quality**: `./vendor/bin/phpinsights analyse`
- [ ] **Migrations**: `php artisan migrate:status`
- [ ] **Translations**: Complete in all required languages
- [ ] **Documentation**: Updated in module and root docs

### Deployment Commands

```bash
# Production deployment
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force

# Rollback preparation
php artisan migrate:status
php artisan migrate:rollback --step=1
```

## 🔧 Common Development Tasks

### Creating a New Module

```bash
# 1. Create module structure
php artisan module:make ModuleName

# 2. Set up basic structure
cd Modules/ModuleName
mkdir -p app/{Actions,Data,Models,Filament/Resources}
mkdir -p database/{migrations,factories}
mkdir -p resources/lang/en

# 3. Create base files
# - ServiceProvider extending XotBaseServiceProvider
# - BaseModel extending XotBaseModel
# - Basic translation files
# - README.md documentation
```

### Adding a New Feature

```php
# 1. Create Action (business logic)
php artisan make:action CreateFeatureAction ModuleName

# 2. Create Data Object (DTO)
php artisan make:data FeatureData ModuleName

# 3. Create Model (if needed)
php artisan module:make-model Feature ModuleName

# 4. Create Filament Resource
php artisan module:make-resource FeatureResource ModuleName

# 5. Add translations
# Edit resources/lang/en/*.php files

# 6. Add tests
php artisan make:test FeatureTest ModuleName
```

### Database Changes

```php
# 1. Create migration
php artisan make:migration create_features_table --path=Modules/ModuleName/database/migrations

# 2. Write migration (extend XotBaseMigration)
<?php
return new class extends XotBaseMigration {
    public function up(): void {
        Schema::create('features', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }
};

# 3. Create factory
php artisan module:make-factory FeatureFactory ModuleName

# 4. Run migration
php artisan migrate
```

## 🔍 Debugging and Troubleshooting

### Common Issues

#### PHPStan Errors
```bash
# Get detailed error information
./vendor/bin/phpstan analyse --error-format=table Modules/ModuleName

# Focus on specific error types
./vendor/bin/phpstan analyse --error-format=compact Modules/ModuleName 2>&1 | grep "Method not found"
```

#### Database Issues
```bash
# Check migration status
php artisan migrate:status

# Reset and reseed
php artisan migrate:fresh --seed
```

#### Cache Issues
```bash
# Clear all caches
php artisan optimize:clear

# Rebuild caches
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 📊 Performance Monitoring

### Laravel Telescope (Development)
```php
# Install and configure Telescope
composer require laravel/telescope
php artisan telescope:install
php artisan migrate
```

### Query Optimization
```php
// Use eager loading
$users = User::with('posts.comments')->get();

// Use chunking for large datasets
User::chunk(100, function ($users) {
    foreach ($users as $user) {
        // Process user
    }
});
```

### Caching Strategy
```php
// Cache expensive operations
Cache::remember('expensive_data', 3600, function () {
    return ExpensiveOperation::calculate();
});

// Cache queries
$users = Cache::remember('active_users', 1800, function () {
    return User::active()->get();
});
```

---

**See Also**: [Code Conventions](conventions.md) | [Common Pitfalls](pitfalls.md) | [SOLID Principles](solid.md)
