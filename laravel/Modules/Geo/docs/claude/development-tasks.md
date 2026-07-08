# Development Tasks

## 🧪 Testing and Quality

### PHPStan (Level 10 Required)

```bash
# Execute from Laravel directory
cd /var/www/_bases/base_ptvx_fila5_mono/laravel

# Full analysis
./vendor/bin/phpstan analyse --level=10 --memory-limit=2G

# Module-specific analysis
./vendor/bin/phpstan analyse Modules/NomeModulo --level=10

# File-specific analysis
./vendor/bin/phpstan analyse Modules/NomeModulo/app/Models/User.php --level=10
```

### Pest Testing

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Tests\Feature;

use Tests\TestCase;
use Modules\NomeModulo\Models\User;
use Modules\NomeModulo\Data\UserData;
use Modules\NomeModulo\Actions\CreateUserAction;

class UserManagementTest extends TestCase
{
    /** @test */
    public function it_can_create_user_with_valid_data(): void
    {
        // Arrange
        $userData = new UserData(
            name: 'John Doe',
            email: 'john@example.com'
        );
        
        // Act
        $user = app(CreateUserAction::class)->execute($userData);
        
        // Assert
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('john@example.com', $user->email);
        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
    }
}
```

### Filament Testing

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Tests\Feature\Filament;

use Livewire\Livewire;
use Modules\NomeModulo\Filament\Resources\UserResource\Pages\CreateUser;
use Modules\NomeModulo\Filament\Resources\UserResource\Pages\ListUsers;
use Tests\TestCase;
use Modules\NomeModulo\Models\User;

class UserResourceTest extends TestCase
{
    /** @test */
    public function it_can_list_users(): void
    {
        $this->actingAs($this->user);
        
        $users = User::factory()->count(3)->create();
        
        Livewire::test(ListUsers::class)
            ->assertCanSeeTableRecords($users);
    }
}
```

## 🚀 Common Development Tasks

### Creating a New Module

```bash
php artisan module:make NomeModulo
```

### Module Commands

```bash
# Enable module
php artisan module:enable NomeModulo

# List modules
php artisan module:list

# Generate migration for module
php artisan make:migration create_table_name_table --module=NomeModulo
```

### Common Commands

```bash
# Run tests
php artisan test

# Run specific test
php artisan test --filter="test_name"

# Run module tests
php artisan test Modules/ModuleName/tests/

# Quality checks
vendor/bin/pint --dirty
vendor/bin/phpstan analyse
php artisan test --coverage
```

## 🧰 Bash Scripts Organization

- All bash scripts must live inside a dedicated subfolder under `bashscripts/`.
- Do not place executable scripts at the root of `bashscripts/`.
- Use lowercase, descriptive names (kebab-case) for folders and files.
- Group by domain, e.g. `bashscripts/docs/`, `bashscripts/db/`, `bashscripts/cache/`.
- Provide `--dry-run` for scripts that mutate files and ensure idempotency.

Examples:

```
bashscripts/
├── docs/
│   └── normalize_docs_case.sh
├── db/
│   └── seed_helpers.sh
└── cache/
    └── clear_all.sh
```

Checklist:
- [ ] Script in a subfolder of `bashscripts/`
- [ ] Lowercase, descriptive name
- [ ] Dry-run option for mutating operations
- [ ] Outputs a summary/mapping of changes

---

**Version**: 2.0 (Refactor DRY + KISS)  
**File**: development-tasks.md - Common development tasks