# Code Coverage: Gdpr

**Date:** 2026-01-17
**Lines Coverage:** N/A (Failed to parse)
**Test Exit Code:** 2

## Output

```text
──────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Gdpr\tests\Unit\Models\GdprConsentTest…   BindingResolutionException   
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

      [2m+18 vendor frames [22m
  19  Modules/Gdpr/tests/Unit/Models/GdprConsentTest.php:9

  ──────────────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Gdpr\tests\Unit\Models\GdprConsentTest…   BindingResolutionException   
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

      [2m+18 vendor frames [22m
  19  Modules/Gdpr/tests/Unit/Models/GdprConsentTest.php:29

  ──────────────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Gdpr\tests\Unit\Models\GdprConsentTest > gdpr consent can be…  Error   
  Call to undefined function createGdprConsent()

  at Modules/Gdpr/tests/Unit/Models/GdprConsentTest.php:36
     32▕     expect($consent->user)->toBeInstanceOf(User::class)->and($consent->user->id)->toBe($user->id);
     33▕ });
     34▕ 
     35▕ test('gdpr consent can be withdrawn', function () {
  ➜  36▕     $consent = createGdprConsent(['withdrawn_at' => null]);
     37▕ 
     38▕     $consent->withdraw();
     39▕ 
     40▕     expect($consent->fresh()->withdrawn_at)->not->toBeNull();

  1   Modules/Gdpr/tests/Unit/Models/GdprConsentTest.php:36

  ──────────────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Gdpr\tests\Unit\Models\GdprConsentTest > gdpr consent scope…   Error   
  Call to undefined function createGdprConsent()

  at Modules/Gdpr/tests/Unit/Models/GdprConsentTest.php:44
     40▕     expect($consent->fresh()->withdrawn_at)->not->toBeNull();
     41▕ });
     42▕ 
     43▕ test('gdpr consent scope active works', function () {
  ➜  44▕     createGdprConsent(['withdrawn_at' => null]); // Active
     45▕     createGdprConsent(['withdrawn_at' => now()]); // Withdrawn
     46▕ 
     47▕     $activeCount = GdprConsent::active()->count();
     48▕

  1   Modules/Gdpr/tests/Unit/Models/GdprConsentTest.php:44


  Tests:    24 failed, 4 warnings, 2 passed (10 assertions)
  Duration: 4.04s


```
