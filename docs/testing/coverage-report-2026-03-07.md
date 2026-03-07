# 📊 Report Test Coverage - 2026-03-07

## 📈 Stato Complessivo

| Modulo | Coverage | Test Files | Status |
|--------|----------|------------|--------|
| User |  | 64 | ❌ |
| Geo |  | 53 | ❌ |
| Meetup |  | 38 | ❌ |
| Activity |  | 39 | ❌ |
| Cms |  | 113 | ❌ |

## 📋 Dettagli Test

### User Modulo
```
  SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry 'user1@example.com' for key 'users.users_email_unique' (Connection: user, Host: 127.0.0.1, Port: 3306, Database: laravelpizza_user, SQL: insert into `users` (`is_active`, `id`, `first_name`, `last_name`, `email`, `email_verified_at`, `password`, `remember_token`, `is_otp`, `lang`, `type`, `state`, `updated_at`, `created_at`) values (1, 8c890bd9-daa5-47f4-8eac-0ca8d0c43aea, Demi, Vitale, user1@example.com, 2026-03-07 18:05:28, $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi, IbvDf8xbDe, 0, it, customer_user, active, 2026-03-07 18:05:28, 2026-03-07 18:05:28))

  at vendor/laravel/framework/src/Illuminate/Database/MySqlConnection.php:53
     49▕             $this->bindValues($statement, $this->prepareBindings($bindings));
     50▕ 
     51▕             $this->recordsHaveBeenModified();
     52▕ 
  ➜  53▕             $result = $statement->execute();
     54▕ 
     55▕             $this->lastInsertId = $this->getPdo()->lastInsertId($sequence);
     56▕ 
     57▕             return $result;

      [2m+13 vendor frames [22m
  14  Modules/User/tests/Feature/Actions/Socialite/LoginUserActionTest.php:85


  Tests:    1 failed, 2 risky, 58 skipped, 465 passed (943 assertions)
  Duration: 159.64s
```

### Geo Modulo
```
  ✓ it can be instantiated
  ✓ it has correct constants defined
  ✓ it has required methods

   PASS  Modules\Geo\tests\Unit\Services\HereServiceTest
  ✓ it has correct base URL
  ✓ it has static method for getting duration and length

   PASS  Modules\Geo\tests\Unit\Services\ServicesTest
  ✓ GeoService can be instantiated
  ✓ GoogleMapsService can be instantiated
  ✓ HereService can be instantiated

   PASS  Modules\Geo\tests\Unit\Transformers\TransformerTest
  ✓ GeoJsonResource can be instantiated
  ✓ GeoJsonCollection can be instantiated

  Tests:    414 passed (1160 assertions)
  Duration: 44.67s
```

### Meetup Modulo
```
  SQLSTATE[HY000]: General error: 1364 Field 'id' doesn't have a default value (Connection: meetup, Host: 127.0.0.1, Port: 3306, Database: laravelpizza_data, SQL: insert into `event_sponsor` (`event_id`, `sponsor_id`, `created_at`, `updated_at`) values (214, 21, 2026-03-07 18:09:41, 2026-03-07 18:09:41))

  at vendor/laravel/framework/src/Illuminate/Database/MySqlConnection.php:53
     49▕             $this->bindValues($statement, $this->prepareBindings($bindings));
     50▕ 
     51▕             $this->recordsHaveBeenModified();
     52▕ 
  ➜  53▕             $result = $statement->execute();
     54▕ 
     55▕             $this->lastInsertId = $this->getPdo()->lastInsertId($sequence);
     56▕ 
     57▕             return $result;

      [2m+12 vendor frames [22m
  13  Modules/Meetup/tests/Unit/Models/SponsorTest.php:67


  Tests:    6 failed, 8 risky, 273 passed (573 assertions)
  Duration: 86.53s
```

### Activity Modulo
```
  +'activity'
  

  at Modules/Activity/tests/Unit/SnapshotModelTest.php:13
      9▕ 
     10▕ test('snapshot uses default db connection while testing', function (): void {
     11▕     $model = new Snapshot();
     12▕ 
  ➜  13▕     expect($model->getConnectionName())->toBe((string) config('database.default'));
     14▕ });
     15▕ 
     16▕ test('snapshot returns activity connection outside testing env', function (): void {
     17▕     $model = new Snapshot();

  1   Modules/Activity/tests/Unit/SnapshotModelTest.php:13


  Tests:    3 failed, 179 passed (385 assertions)
  Duration: 45.57s
```

### Cms Modulo
```
  Syntax error

  at vendor/thecodingmachine/safe/lib/Exceptions/JsonException.php:9
      5▕ class JsonException extends \JsonException implements SafeExceptionInterface
      6▕ {
      7▕     public static function createFromPhpError(): self
      8▕     {
  ➜   9▕         return new self(\json_last_error_msg(), \json_last_error());
     10▕     }
     11▕ }
     12▕

      [2m+2 vendor frames [22m
  3   Modules/Tenant/app/Models/Traits/SushiToJson.php:86
  4   Modules/Cms/app/Models/Page.php:245


  Tests:    38 failed, 12 skipped, 391 passed (933 assertions)
  Duration: 137.18s
```
