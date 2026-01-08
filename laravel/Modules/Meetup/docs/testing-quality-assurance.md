# Laravel Pizza Testing Strategy & Quality Assurance

## Testing Philosophy

The Laravel Pizza project follows a comprehensive testing strategy based on the testing pyramid approach with emphasis on quality, reliability, and maintainability. The testing strategy ensures code quality across all modules and maintains the integrity of the modular architecture.

## Testing Types & Levels

### 1. Unit Tests
Unit tests focus on individual components and functions within the application.

#### Location
```
tests/Unit/
Modules/{Module}/tests/Unit/
```

#### Coverage Areas
- **Actions**: Test business logic in isolation
- **Models**: Verify relationships, accessors, mutators
- **Helpers**: Test utility functions
- **Data Objects**: Validate data transformation and validation
- **Services**: Test service class functionality

#### Example Unit Test
```php
<?php

namespace Tests\Unit\Modules\User;

use PHPUnit\Framework\TestCase;
use Modules\User\Actions\CreateUserAction;
use Modules\User\Models\User;

class CreateUserActionTest extends TestCase
{
    /** @test */
    public function it_creates_user_with_valid_data()
    {
        $action = new CreateUserAction();
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
        ];
        
        $user = $action->execute($userData);
        
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('john@example.com', $user->email);
    }
    
    /** @test */
    public function it_hashes_password_before_saving()
    {
        $action = new CreateUserAction();
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
        ];
        
        $user = $action->execute($userData);
        
        $this->assertNotEquals('password123', $user->password);
        $this->assertTrue(password_verify('password123', $user->password));
    }
}
```

### 2. Feature Tests
Feature tests cover user stories and business workflows across multiple layers.

#### Location
```
tests/Feature/
Modules/{Module}/tests/Feature/
```

#### Coverage Areas
- **API Endpoints**: Test REST API functionality
- **Web Routes**: Test web interface interactions
- **User Workflows**: Test complete business processes
- **Module Interactions**: Test cross-module functionality
- **Authentication Flows**: Test login, registration, etc.

#### Example Feature Test
```php
<?php

namespace Tests\Feature\Modules\Cms;

use Tests\TestCase;
use Modules\User\Models\User;
use Modules\Cms\Models\Page;

class PageManagementTest extends TestCase
{
    /** @test */
    public function authenticated_user_can_create_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        
        $response = $this->post('/api/cms/pages', [
            'title' => 'Test Page',
            'content' => 'Page content',
            'slug' => 'test-page',
        ]);
        
        $response->assertStatus(201);
        $this->assertDatabaseHas('pages', [
            'title' => 'Test Page',
            'slug' => 'test-page',
            'user_id' => $user->id,
        ]);
    }
    
    /** @test */
    public function unauthenticated_user_cannot_create_page()
    {
        $response = $this->post('/api/cms/pages', [
            'title' => 'Test Page',
            'content' => 'Page content',
        ]);
        
        $response->assertStatus(401);
    }
}
```

### 3. Integration Tests
Integration tests verify how different components work together.

#### Coverage Areas
- **Database Interactions**: Test Eloquent queries and relationships
- **Service Integrations**: Test external API integrations
- **Module Communications**: Test inter-module data flow
- **Event Handling**: Test event dispatching and listeners
- **Queue Processing**: Test queued jobs

### 4. End-to-End Tests
E2E tests validate complete user journeys.

#### Tools Used
- **Pest**: Primary testing framework
- **Laravel Dusk**: Browser testing (if configured)
- **Puppeteer**: For advanced browser automation

## Testing Framework Configuration

### Pest PHP Configuration
The project uses Pest PHP as the primary testing framework with Laravel-specific extensions.

```php
// tests/Pest.php
<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

uses(TestCase::class, RefreshDatabase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function createTestUser()
{
    return \Modules\User\Models\User::factory()->create();
}
```

### Test Configuration File (phpunit.xml)
```xml
<?xml version="1.0" encoding="UTF-8"?>
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="./vendor/phpunit/phpunit/phpunit.xsd"
         bootstrap="vendor/autoload.php"
         colors="true"
>
    <testsuites>
        <testsuite name="Unit">
            <directory suffix="Test.php">./tests/Unit</directory>
        </testsuite>
        <testsuite name="Feature">
            <directory suffix="Test.php">./tests/Feature</directory>
        </testsuite>
    </testsuites>
    <coverage processUncoveredFiles="true">
        <include>
            <directory suffix=".php">./app</directory>
        </include>
    </coverage>
    <php>
        <server name="APP_ENV" value="testing"/>
        <server name="BCRYPT_ROUNDS" value="4"/>
        <server name="CACHE_DRIVER" value="array"/>
        <server name="DB_CONNECTION" value="sqlite"/>
        <server name="DB_DATABASE" value=":memory:"/>
        <server name="MAIL_MAILER" value="array"/>
        <server name="QUEUE_CONNECTION" value="sync"/>
        <server name="SESSION_DRIVER" value="array"/>
        <server name="TELESCOPE_ENABLED" value="false"/>
    </php>
</phpunit>
```

## Module-Specific Testing Patterns

### Testing Actions
```php
// Example: Testing an Action class
namespace Tests\Unit\Modules\Geo;

use Tests\TestCase;
use Modules\Geo\Actions\GeocodeAction;
use Illuminate\Support\Facades\Http;

class GeocodeActionTest extends TestCase
{
    /** @test */
    public function it_geocodes_address_successfully()
    {
        Http::fake([
            'https://api.example.com/geocode*' => Http::response([
                'results' => [
                    ['lat' => 40.7128, 'lng' => -74.0060]
                ]
            ])
        ]);
        
        $action = new GeocodeAction();
        $result = $action->execute('New York, NY');
        
        $this->assertEquals(40.7128, $result['lat']);
        $this->assertEquals(-74.0060, $result['lng']);
    }
}
```

### Testing Data Objects
```php
// Example: Testing a Data object
namespace Tests\Unit\Modules\Xot\Datas;

use Tests\TestCase;
use Modules\Xot\Datas\XotData;

class XotDataTest extends TestCase
{
    /** @test */
    public function it_creates_data_object_with_defaults()
    {
        $data = XotData::from([]);
        
        $this->assertEquals('user', $data->main_module);
        $this->assertEquals('noset', $data->param_name);
    }
    
    /** @test */
    public function it_overrides_defaults_with_provided_data()
    {
        $data = XotData::from(['main_module' => 'cms']);
        
        $this->assertEquals('cms', $data->main_module);
    }
}
```

### Testing with Filament Components
```php
// Example: Testing Filament resources
namespace Tests\Feature\Modules\User\Filament;

use Tests\TestCase;
use Livewire\Livewire;
use Modules\User\Filament\Resources\UserResource;

class UserResourceTest extends TestCase
{
    /** @test */
    public function it_displays_users_in_table()
    {
        $user = \Modules\User\Models\User::factory()->create();
        
        Livewire::test(UserResource\Pages\ListUsers::class)
            ->assertSuccessful()
            ->assertSee($user->name);
    }
}
```

## Quality Assurance Tools

### 1. PHPStan (Static Analysis)
```bash
# Run PHPStan analysis
./vendor/bin/phpstan analyse --level=8

# Configuration in phpstan.neon
includes:
    - ./vendor/larastan/larastan/extension.neon
    - ./vendor/nesbot/carbon/extension.neon
    - ./vendor/phpstan/phpstan/conf/bleedingEdge.neon

parameters:
    level: 8
    paths:
        - ./app/
        - ./Modules/
```

### 2. PHP-CS-Fixer (Code Style)
```bash
# Fix code style issues
./vendor/bin/php-cs-fixer fix

# Configuration in .php_cs.dist
<?php
use PhpCsFixer\Config;
use PhpCsFixer\Finder;

return (new Config())
    ->setFinder(Finder::create()
        ->in(__DIR__.'/app')
        ->in(__DIR__.'/Modules')
        ->in(__DIR__.'/tests')
    )
    ->setRules([
        '@PSR12' => true,
        'array_syntax' => ['syntax' => 'short'],
        // Additional rules...
    ]);
```

### 3. PHPMD (Mess Detection)
```bash
# Run PHPMD analysis
./vendor/bin/phpmd app,Modules text cleancode,codesize,controversial,design,naming,unusedcode
```

### 4. PHP Insights
```bash
# Run PHP Insights
./vendor/bin/phpinsights

# Configuration in phpinsights.php
<?php

return [
    'preset' => 'laravel',
    'ide' => 'phpstorm',
    'exclude' => [
        // Directories to exclude
    ],
    'add' => [
        // Additional analyzers
    ],
];
```

## Testing Best Practices

### 1. Test Naming Conventions
```php
// Good: Descriptive test names
public function it_creates_user_with_valid_data()
public function it_fails_to_create_user_with_invalid_email()
public function it_redirects_unauthenticated_users()

// Avoid: Generic names
public function test1()
public function testSomething()
```

### 2. Test Data Management
```php
// Use factories for test data
public function test_user_can_view_profile()
{
    $user = User::factory()->create();
    $this->actingAs($user);
    
    $response = $this->get('/profile');
    $response->assertStatus(200);
}

// Use traits for common test setups
trait CreatesTestUsers
{
    protected function createTestUser(): User
    {
        return User::factory()->create();
    }
}
```

### 3. Mocking and Faking
```php
// Mock external services
public function test_email_notification_sent()
{
    Mail::fake();
    
    $user = User::factory()->create();
    $this->post('/register', [
        'name' => 'John',
        'email' => 'john@example.com',
        'password' => 'password',
    ]);
    
    Mail::assertSent(WelcomeEmail::class);
}

// Fake HTTP requests
public function test_geocoding_service()
{
    Http::fake([
        'https://api.geocoding.com/*' => Http::response(['lat' => 40.7128, 'lng' => -74.0060])
    ]);
    
    $result = $this->geocodeAction->execute('New York');
    $this->assertEquals(40.7128, $result['lat']);
}
```

## Continuous Integration Configuration

### GitHub Actions Workflow
```yaml
# .github/workflows/tests.yml
name: Tests

on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    
    services:
      mysql:
        image: mysql:8.0
        env:
          MYSQL_ROOT_PASSWORD: password
          MYSQL_DATABASE: test
        ports:
          - 3306:3306
        options: --health-cmd="mysqladmin ping" --health-interval=10s --health-timeout=5s --health-retries=3
    
    steps:
      - name: Checkout code
        uses: actions/checkout@v2
      
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.2'
          extensions: dom, curl, libxml, mbstring, zip, pcntl, pdo, sqlite, pdo_sqlite, bcmath, soap, intl, gd, exif, iconv, imagick
          coverage: xdebug
      
      - name: Install dependencies
        run: |
          composer install --no-interaction --no-progress --no-suggest --optimize-autoloader
          npm ci
      
      - name: Run tests
        run: |
          php artisan config:clear
          php artisan migrate --env=testing
          php artisan test
          ./vendor/bin/phpstan analyse --level=8
```

### Code Coverage
```bash
# Generate code coverage
php artisan test --coverage

# Generate HTML coverage report
php artisan test --coverage-html=coverage
```

## Performance Testing

### Load Testing
```php
// Example load testing with Artillery
/*
{
  "config": {
    "target": "http://localhost:8000",
    "phases": [
      {
        "duration": 60,
        "arrivalRate": 10
      }
    ]
  },
  "scenarios": [
    {
      "name": "User registration load test",
      "flow": [
        {
          "post": {
            "url": "/register",
            "json": {
              "name": "{{ $random.fullName }}",
              "email": "{{ $random.email }}",
              "password": "password"
            }
          }
        }
      ]
    }
  ]
}
*/
```

## Security Testing

### Authorization Tests
```php
public function test_admin_can_access_admin_panel()
{
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    
    $response = $this->get('/admin');
    $response->assertStatus(200);
}

public function test_regular_user_cannot_access_admin_panel()
{
    $user = User::factory()->create(['role' => 'user']);
    $this->actingAs($user);
    
    $response = $this->get('/admin');
    $response->assertStatus(403);
}
```

### Input Validation Tests
```php
public function test_invalid_email_is_rejected()
{
    $response = $this->post('/register', [
        'email' => 'invalid-email',
        'password' => 'password',
    ]);
    
    $response->assertStatus(302);
    $response->assertSessionHasErrors(['email']);
}
```

## Testing Metrics & Monitoring

### Key Metrics
- **Test Coverage**: Minimum 80% across the application
- **Test Execution Time**: Aim for fast feedback (under 5 minutes)
- **Test Reliability**: < 1% flaky tests
- **Bug Detection Rate**: Track bugs found by tests vs. production

### Monitoring
- **Test Results**: Automated reporting of test results
- **Performance Regression**: Monitor for performance degradation
- **Code Quality**: Track code quality metrics over time

This comprehensive testing strategy ensures the Laravel Pizza application maintains high quality, reliability, and maintainability across all modules and components.