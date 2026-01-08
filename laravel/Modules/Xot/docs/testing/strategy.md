# Strategia di Testing

## 1. Panoramica

### 1.1 Obiettivi
- Garantire la qualità del codice
- Prevenire regressioni
- Verificare le performance
- Assicurare la sicurezza

### 1.2 Tipi di Test
- Unit Tests
- Integration Tests
- Feature Tests
- Performance Tests
- Security Tests

### 1.3 Metriche
- Test Coverage > 80%
- Zero critical bugs
- Performance SLA rispettati
- Security compliance

## 2. Unit Testing

### 2.1 Data Objects
```php
declare(strict_types=1);

namespace Tests\Modules\ModuleName\Data;

use Tests\TestCase;
use Modules\ModuleName\App\Data\UserData;

class UserDataTest extends TestCase
{
    public function test_it_creates_from_array(): void
    {
        $data = UserData::from([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
        
        $this->assertEquals('John Doe', $data->name);
        $this->assertEquals('john@example.com', $data->email);
    }
    
    public function test_it_validates_required_fields(): void
    {
        $this->expectException(\Exception::class);
        
        UserData::from([
            'name' => 'John Doe',
        ]);
    }
}
```

### 2.2 Actions
```php
declare(strict_types=1);

namespace Tests\Modules\ModuleName\Actions;

use Tests\TestCase;
use Modules\ModuleName\App\Actions\CreateUserAction;
use Modules\ModuleName\App\Data\UserData;

class CreateUserActionTest extends TestCase
{
    public function test_it_creates_a_user(): void
    {
        $userData = UserData::from([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
        
        $user = CreateUserAction::execute($userData);
        
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('john@example.com', $user->email);
    }
    
    public function test_it_handles_duplicate_email(): void
    {
        $this->expectException(DuplicateEmailException::class);
        
        $userData = UserData::from([
            'name' => 'John Doe',
            'email' => 'existing@example.com',
        ]);
        
        CreateUserAction::execute($userData);
    }
}
```

## 3. Integration Testing

### 3.1 API Endpoints
```php
declare(strict_types=1);

namespace Tests\Modules\ModuleName\Api;

use Tests\TestCase;

class UserApiTest extends TestCase
{
    public function test_it_creates_user_via_api(): void
    {
        $response = $this->postJson('/api/users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
        
        $response->assertCreated();
        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
    }
    
    public function test_it_validates_input(): void
    {
        $response = $this->postJson('/api/users', [
            'name' => 'John Doe',
        ]);
        
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['email']);
    }
}
```

### 3.2 Database
```php
declare(strict_types=1);

namespace Tests\Modules\ModuleName\Database;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class DatabaseTest extends TestCase
{
    public function test_it_maintains_referential_integrity(): void
    {
        $user = User::factory()->create();
        
        $this->expectException(\Exception::class);
        
        DB::table('users')->where('id', $user->id)->delete();
    }
}
```

## 4. Performance Testing

### 4.1 Response Time
```php
declare(strict_types=1);

namespace Tests\Modules\ModuleName\Performance;

use Tests\TestCase;
use Illuminate\Support\Facades\Cache;

class PerformanceTest extends TestCase
{
    public function test_api_response_time(): void
    {
        $start = microtime(true);
        
        $this->getJson('/api/users');
        
        $time = microtime(true) - $start;
        
        $this->assertLessThan(0.2, $time);
    }
    
    public function test_cache_performance(): void
    {
        Cache::shouldReceive('remember')
            ->once()
            ->andReturnUsing(function ($key, $ttl, $callback) {
                $start = microtime(true);
                $result = $callback();
                $time = microtime(true) - $start;
                
                $this->assertLessThan(0.1, $time);
                
                return $result;
            });
            
        $this->getJson('/api/users');
    }
}
```

### 4.2 Load Testing
```php
declare(strict_types=1);

namespace Tests\Modules\ModuleName\Load;

use Tests\TestCase;

class LoadTest extends TestCase
{
    public function test_concurrent_users(): void
    {
        $responses = [];
        
        for ($i = 0; $i < 100; $i++) {
            $responses[] = $this->getJson('/api/users');
        }
        
        foreach ($responses as $response) {
            $response->assertOk();
        }
    }
}
```

## 5. Security Testing

### 5.1 Authentication
```php
declare(strict_types=1);

namespace Tests\Modules\ModuleName\Security;

use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    public function test_unauthenticated_access(): void
    {
        $response = $this->getJson('/api/users');
        
        $response->assertUnauthorized();
    }
    
    public function test_invalid_token(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer invalid-token',
        ])->getJson('/api/users');
        
        $response->assertUnauthorized();
    }
}
```

### 5.2 Authorization
```php
declare(strict_types=1);

namespace Tests\Modules\ModuleName\Security;

use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    public function test_unauthorized_access(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
            ->getJson('/api/admin/users');
            
        $response->assertForbidden();
    }
}
```

## 6. CI/CD Integration

### 6.1 GitHub Actions
```yaml
name: Tests

on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    
    steps:
    - uses: actions/checkout@v2
    
    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.2'
        
    - name: Install dependencies
      run: composer install --prefer-dist --no-progress
        
    - name: Execute tests
      run: vendor/bin/phpunit
      
    - name: Upload coverage
      uses: codecov/codecov-action@v1
```

### 6.2 GitLab CI
```yaml
test:
  stage: test
  image: php:8.2
  script:
    - composer install --prefer-dist --no-progress
    - vendor/bin/phpunit
  coverage: '/Code Coverage: \d+\.\d+%/'
```

## 7. Best Practices

### 7.1 Organizzazione
- Test per ogni classe
- Test per ogni metodo pubblico
- Test per ogni edge case
- Test per ogni bug fix

### 7.2 Naming
- test_it_[behavior]
- test_[scenario]_[expected_result]
- test_[method]_[condition]
- test_[feature]_[scenario]

### 7.3 Struttura
- Setup
- Test
- Assert
- Cleanup

### 7.4 Performance
- Mock esterni
- Database in memoria
- Cache disabilitata
- Logging minimo 