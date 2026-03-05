# User Coverage Report

- Generated: 2026-03-05T08:01:21Z
- Threshold: 100%
- Exit code: 2

```text

  ⨯⨯⨯⨯⨯⨯⨯⨯..............
  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Actions\Is…  BindingResolutionException   
  Target class [Modules\User\Actions\IsUserAllowedAction] does not exist.

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1122
    1118▕             }
    1119▕         }
    1120▕ 
    1121▕         try {
  ➜ 1122▕             $reflector = new ReflectionClass($concrete);
    1123▕         } catch (ReflectionException $e) {
    1124▕             throw new BindingResolutionException("Target class [$concrete] does not exist.", 0, $e);
    1125▕         }
    1126▕

      [2m+6 vendor frames [22m
  7   Modules/User/tests/Feature/Actions/IsUserAllowedActionTest.php:18

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Actions\Is…  BindingResolutionException   
  Target class [Modules\User\Actions\IsUserAllowedAction] does not exist.

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1122
    1118▕             }
    1119▕         }
    1120▕ 
    1121▕         try {
  ➜ 1122▕             $reflector = new ReflectionClass($concrete);
    1123▕         } catch (ReflectionException $e) {
    1124▕             throw new BindingResolutionException("Target class [$concrete] does not exist.", 0, $e);
    1125▕         }
    1126▕

      [2m+6 vendor frames [22m
  7   Modules/User/tests/Feature/Actions/IsUserAllowedActionTest.php:28

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Actions\Is…  BindingResolutionException   
  Target class [Modules\User\Actions\IsUserAllowedAction] does not exist.

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1122
    1118▕             }
    1119▕         }
    1120▕ 
    1121▕         try {
  ➜ 1122▕             $reflector = new ReflectionClass($concrete);
    1123▕         } catch (ReflectionException $e) {
    1124▕             throw new BindingResolutionException("Target class [$concrete] does not exist.", 0, $e);
    1125▕         }
    1126▕

      [2m+6 vendor frames [22m
  7   Modules/User/tests/Feature/Actions/IsUserAllowedActionTest.php:38

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Ac…  UniqueConstraintViolationException   
  SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry 'test@example.com' for key 'users.users_email_unique' (Connection: user, Host: 127.0.0.1, Port: 3306, Database: laravelpizza_user, SQL: insert into `users` (`is_active`, `id`, `first_name`, `last_name`, `email`, `email_verified_at`, `password`, `remember_token`, `is_otp`, `lang`, `type`, `state`, `updated_at`, `created_at`) values (1, 8ca9ec2a-ec0f-4b46-9bc8-46c9ec96077a, Gennaro, Monti, test@example.com, 2026-03-05 09:04:48, $2y$12$17wtBU7ULghXAAMZFOsdkewGLaRM2r.BTEZphLzWpU.BL6sKvmGJu, kYMmbdh0Ta, 0, it, customer_user, active, 2026-03-05 09:04:48, 2026-03-05 09:04:48))

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
  14  Modules/User/tests/Feature/Actions/LoginUserActionTest.php:14

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Ac…  UniqueConstraintViolationException   
  SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry 'test@example.com' for key 'users.users_email_unique' (Connection: user, Host: 127.0.0.1, Port: 3306, Database: laravelpizza_user, SQL: insert into `users` (`is_active`, `id`, `first_name`, `last_name`, `email`, `email_verified_at`, `password`, `remember_token`, `is_otp`, `lang`, `type`, `state`, `updated_at`, `created_at`) values (1, 3afacdd5-c050-4a00-bfbb-0742488edb73, Paola, Marini, test@example.com, 2026-03-05 09:04:49, $2y$12$rcQRGMunYOFDQ7VXRX4vheBoCCydlDq5IFQPq0vMZ8Iz.b3yfIZnS, fsWX2RUFxA, 0, it, customer_user, active, 2026-03-05 09:04:49, 2026-03-05 09:04:49))

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
  14  Modules/User/tests/Feature/Actions/LoginUserActionTest.php:26

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Actions\LoginUserA…  ArgumentCountError   
  Too few arguments to function Pest\Mixins\Expectation::toThrow(), 0 passed and at least 1 expected

  at Modules/User/tests/Feature/Actions/LoginUserActionTest.php:37
     33▕     });
     34▕ 
     35▕     test('throws exception when user does not exist', function (): void {
     36▕         expect(fn () => app(LoginUserAction::class)->execute('nonexistent@example.com', 'password'))
  ➜  37▕             ->toThrow();
     38▕     });
     39▕ });
     40▕

  1   Modules/User/tests/Feature/Actions/LoginUserActionTest.php:37

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Actions\RevokeAllUserT…  LogicException   
  Invalid key supplied

  at vendor/league/oauth2-server/src/CryptKey.php:77
     73▕             if (!$this->isValidKey($this->keyContents, $this->passPhrase ?? '')) {
     74▕                 throw new LogicException('Unable to read key from file ' . $keyPath);
     75▕             }
     76▕         } else {
  ➜  77▕             throw new LogicException('Invalid key supplied');
     78▕         }
     79▕ 
     80▕         if ($keyPermissionsCheck === true && PHP_OS_FAMILY !== 'Windows') {
     81▕             // Verify the permissions of the key

      [2m+18 vendor frames [22m
  19  Modules/User/tests/Feature/Actions/RevokeAllUserTokensActionTest.php:15

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Actions\Re…  BindingResolutionException   
  Target class [Modules\User\Actions\RevokeAllUserTokensAction] does not exist.

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1122
    1118▕             }
    1119▕         }
    1120▕ 
    1121▕         try {
  ➜ 1122▕             $reflector = new ReflectionClass($concrete);
    1123▕         } catch (ReflectionException $e) {
    1124▕             throw new BindingResolutionException("Target class [$concrete] does not exist.", 0, $e);
    1125▕         }
    1126▕

      [2m+6 vendor frames [22m
  7   Modules/User/tests/Feature/Actions/RevokeAllUserTokensActionTest.php:29


  Tests:    8 failed, 14 passed (25 assertions)
  Duration: 8.30s
```
