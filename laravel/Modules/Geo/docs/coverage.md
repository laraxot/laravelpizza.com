# Code Coverage: Geo

**Date:** 2026-01-17
**Lines Coverage:** N/A (Failed to parse)
**Test Exit Code:** 2

## Output

```text
────────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Traits\HasAddressTest >…   BindingResolutionException   
  Target class [config] does not exist.

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

      [2m+13 vendor frames [22m
  14  Modules/Geo/tests/Unit/Traits/HasAddressTest.php:47

  ──────────────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Traits\HasAddressTest >…   BindingResolutionException   
  Target class [config] does not exist.

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

      [2m+13 vendor frames [22m
  14  Modules/Geo/tests/Unit/Traits/HasAddressTest.php:47

  ──────────────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Traits\HasAddressTest >…   BindingResolutionException   
  Target class [config] does not exist.

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

      [2m+13 vendor frames [22m
  14  Modules/Geo/tests/Unit/Traits/HasAddressTest.php:47

  ──────────────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Traits\HasAddressTest >…   BindingResolutionException   
  Target class [config] does not exist.

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

      [2m+13 vendor frames [22m
  14  Modules/Geo/tests/Unit/Traits/HasAddressTest.php:47


  Tests:    98 failed, 22 warnings, 53 passed (224 assertions)
  Duration: 12.20s


```
