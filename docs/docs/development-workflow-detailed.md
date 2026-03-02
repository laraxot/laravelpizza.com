# Laraxot Development Workflow - Detailed Guide

## 🚀 Development Lifecycle

### Phase 1: Analysis & Planning

#### 1.1 Understanding the Domain
```bash
# Study existing module patterns
find Modules/ -name "*.php" -path "*/Models/*" | head -20
find Modules/ -name "module.json" -exec cat {} \;

# Analyze service providers
find Modules/ -name "*ServiceProvider.php" | grep -v vendor

# Review Filament resources
find Modules/ -name "*Resource.php" | grep -v vendor
```

#### 1.2 Architectural Compliance Check
```bash
# Check for Laraxot violations
grep -r "extends Model" Modules/*/app/Models/ | grep -v "BaseModel"
find Modules -name "*.php" | grep -E "(factories|seeders|tests)" | sort | uniq -c

# Check translation consistency
grep -r "\.navigation" Modules/*/lang/**/*.php

# Verify file structure consistency
find Modules -type d -name "Database" -o -name "Factories" -o -name "Seeders" | sort
```

#### 1.3 Dependency Analysis
```bash
# Check module dependencies
for module in Modules/*/module.json; do
    echo "=== $(basename $(dirname $module)) ==="
    cat $module | grep -E "(requires|dependencies)" || echo "No explicit dependencies"
    echo
```

### Phase 2: Implementation

#### 2.1 Creating New Modules

**Step-by-Step Module Creation**:

```bash
# 1. Create module structure
mkdir -p Modules/NewModule/{app/{Models,Filament/{Resources,Pages}},database/{migrations,factories,seeders},lang/{it,en,de},docs,Providers}

# 2. Create module.json
cat > Modules/NewModule/module.json << 'EOF'
{
    "name": "NewModule",
    "alias": "newmodule",
    "description": "Description of NewModule functionality",
    "keywords": ["keyword1", "keyword2"],
    "priority": 0,
    "providers": [
        "Modules\\NewModule\\Providers\\NewModuleServiceProvider",
        "Modules\\NewModule\\Providers\\Filament\\AdminPanelProvider"
    ],
    "files": []
}
EOF

# 3. Create BaseModel
cat > Modules/NewModule/app/Models/BaseModel.php << 'EOF'
<?php

declare(strict_types=1);

namespace Modules\NewModule\Models;

class BaseModel extends \Modules\Xot\Models\XotBaseModel
{
    // Connection auto-discovered as 'newmodule'
    // No need to set $connection unless different
}
EOF

# 4. Create Service Provider
cat > Modules/NewModule/app/Providers/NewModuleServiceProvider.php << 'EOF'
<?php

declare(strict_types=1);

namespace Modules\NewModule\Providers;

class NewModuleServiceProvider extends \Modules\Xot\Providers\XotBaseServiceProvider
{
    public string $name = 'NewModule';

    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;

    public function boot(): void
    {
        parent::boot();
        // Module-specific boot logic
    }

    public function register(): void
    {
        parent::register();
        // Module-specific registration logic
    }
}
EOF
```

#### 2.2 Creating Models

**Standard Model Creation**:
```php
<?php

declare(strict_types=1);

namespace Modules\NewModule\Models;

class Product extends BaseModel
{
    protected $fillable = ['name', 'description', 'price'];

    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'price' => 'decimal:2',
            'is_active' => 'boolean',
        ]);
    }

    // Relationships
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
```

**Pivot Model Creation**:
```php
<?php

declare(strict_types=1);

namespace Modules\NewModule\Models;

class ProductCategory extends BasePivot
{
    protected $table = 'product_category';

    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'assigned_at' => 'datetime',
        ]);
    }
}
```

#### 2.3 Creating Filament Resources

**Resource Creation**:
```php
<?php

declare(strict_types=1);

namespace Modules\NewModule\Filament\Resources;

class ProductResource extends XotBaseResource
{
    public static function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('name'),
            Forms\Components\Textarea::make('description'),
            Forms\Components\TextInput::make('price')
                ->numeric(),
            Forms\Components\Toggle::make('is_active'),
        ];
    }

    public static function getInfolistSchema(): array
    {
        return [
            Infolists\Components\TextEntry::make('name'),
            Infolists\Components\TextEntry::make('description'),
            Infolists\Components\TextEntry::make('price')
                ->money('EUR'),
            Infolists\Components\IconEntry::make('is_active')
                ->boolean(),
        ];
    }
}
```

#### 2.4 Creating Translations

**Italian Translation File**:
```php
<?php

declare(strict_types=1);

return [
    'singular' => 'Prodotto',
    'plural' => 'Prodotti',
    'navigation' => [
        'name' => 'Prodotto',
        'plural' => 'Prodotti',
        'group' => [
            'name' => 'Catalogo',
            'description' => 'Gestione prodotti e catalogo',
        ],
        'label' => 'Prodotti',
        'sort' => 10,
        'icon' => 'heroicon-o-shopping-bag',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome del prodotto',
        ],
        'description' => [
            'label' => 'Descrizione',
            'placeholder' => 'Inserisci la descrizione del prodotto',
        ],
        'price' => [
            'label' => 'Prezzo',
            'placeholder' => 'Inserisci il prezzo',
        ],
        'is_active' => [
            'label' => 'Attivo',
        ],
    ],
    'actions' => [
        'create' => 'Crea prodotto',
        'edit' => 'Modifica prodotto',
        'delete' => 'Elimina prodotto',
        'view' => 'Visualizza prodotto',
    ],
];
```

### Phase 3: Quality Assurance

#### 3.1 Code Quality Checks

**PHPStan Analysis**:
```bash
# Run PHPStan on specific module
./vendor/bin/phpstan analyse Modules/NewModule/app --level=10

# Run PHPStan on all modules
for module in Modules/*/; do
    echo "=== $(basename $module) ==="
    ./vendor/bin/phpstan analyse "$module/app" --level=10 --no-progress
```

**Code Formatting**:
```bash
# Format changed files
vendor/bin/pint --dirty

# Format specific module
vendor/bin/pint Modules/NewModule/

# Check formatting without fixing
vendor/bin/pint --test
```

**Translation Validation**:
```bash
# Check for .navigation placeholders
grep -r "\.navigation" Modules/NewModule/lang/

# Verify translation file structure
find Modules/NewModule/lang/ -name "*.php" | xargs -I {} basename {} .php
```

#### 3.2 Testing

**Creating Tests**:
```php
<?php

declare(strict_types=1);

namespace Modules\NewModule\Tests\Feature;

use Modules\NewModule\Models\Product;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function test_can_create_product(): void
    {
        $product = Product::factory()->create([
            'name' => 'Test Product',
            'price' => 19.99,
        ]);

        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'price' => 19.99,
        ]);
    }
}
```

**Running Tests**:
```bash
# Run tests for specific module
php artisan test Modules/NewModule/tests/

# Run specific test file
php artisan test Modules/NewModule/tests/Feature/ProductTest.php

# Run with coverage
php artisan test --coverage --min=80
```

### Phase 4: Deployment Preparation

#### 4.1 Database Migrations

**Creating Migrations**:
```php
<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
```

**Running Migrations**:
```bash
# Run migrations for specific module
php artisan module:migrate NewModule

# Run all migrations
php artisan migrate

# Check migration status
php artisan migrate:status
```

#### 4.2 Cache and Optimization

**Optimization Commands**:
```bash
# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Generate IDE helpers
php artisan ide-helper:generate
php artisan ide-helper:models --write
php artisan ide-helper:meta
```

## 🔧 Development Tools & Scripts

### Quality Improvement Scripts

**Module Analysis Script**:
```bash
#!/bin/bash
# analyze-module.sh

MODULE=$1

echo "=== Analyzing $MODULE ==="

# PHPStan
./vendor/bin/phpstan analyse "Modules/$MODULE/app" --level=10 --no-progress

# Code formatting check
vendor/bin/pint "Modules/$MODULE/" --test

# Translation checks
echo "=== Translation Analysis ==="
grep -r "\.navigation" "Modules/$MODULE/lang/" || echo "No .navigation placeholders found"

# File structure check
echo "=== File Structure ==="
find "Modules/$MODULE" -type d -name "Database" -o -name "Factories" -o -name "Seeders" | sort
```

**Documentation Cleanup Script**:
```bash
#!/bin/bash
# docs-cleanup.sh

# Analyze non-conformant files
./bashscripts/docs-cleanup/analyze-nonconformant-files.sh

# Preview renames (dry-run)
./bashscripts/docs-cleanup/rename-to-kebab-case.sh

# Actually rename files
DRY_RUN=0 ./bashscripts/docs-cleanup/rename-to-kebab-case.sh
```

### Development Automation

**Module Generator Script**:
```bash
#!/bin/bash
# generate-module.sh

MODULE_NAME=$1
MODULE_PATH="Modules/$MODULE_NAME"

# Create directory structure
mkdir -p "$MODULE_PATH/{app/{Models,Filament/{Resources,Pages}},database/{migrations,factories,seeders},lang/{it,en,de},docs,Providers}"

# Generate standard files
# ... (implementation of file generation)

echo "Module $MODULE_NAME created successfully"
echo "Next steps:"
echo "1. Update module.json with proper description"
echo "2. Create BaseModel and models"
echo "3. Create Filament resources"
echo "4. Add translations"
echo "5. Run quality checks"
```

## 🎯 Best Practices Checklist

### Pre-Commit Checklist
- [ ] PHPStan Level 10 passes
- [ ] Laravel Pint formatting applied
- [ ] No .navigation translation placeholders
- [ ] File structure follows Laraxot patterns
- [ ] All models extend appropriate base classes
- [ ] Filament resources extend XotBaseResource
- [ ] Translations exist for all supported languages
- [ ] Tests pass for new functionality
- [ ] Database migrations are idempotent

### Code Review Checklist
- [ ] Architecture compliance (Laraxot patterns)
- [ ] Code quality (PHPStan, Pint)
- [ ] Translation consistency
- [ ] Test coverage
- [ ] Performance considerations
- [ ] Security considerations
- [ ] Documentation completeness

### Deployment Checklist
- [ ] All migrations run successfully
- [ ] Caches cleared and optimized
- [ ] Environment configuration verified
- [ ] Database backups available
- [ ] Monitoring and logging configured
- [ ] Performance testing completed

## 🚨 Common Pitfalls & Solutions

### Pitfall 1: Direct Model Extension
**Problem**: `class User extends Model`
**Solution**: `class User extends BaseUser`

### Pitfall 2: Hardcoded Translations
**Problem**: `->label('User Name')`
**Solution**: `->label(__('user::fields.name.label'))`

### Pitfall 3: Mixed File Structure
**Problem**: Files in both `database/` and `app/Database/`
**Solution**: Consolidate to single location

### Pitfall 4: Missing Type Hints
**Problem**: Methods without return types
**Solution**: Add proper PHP 8.3 type hints

### Pitfall 5: Magic Property Misuse
**Problem**: `property_exists($model, 'email')`
**Solution**: `isset($model->email)` or `$model->getAttribute('email')`

---

**Workflow Version**: 1.0

**Maintained by**: Xot Module Development Team
