# Meetup Coverage Report

- Generated: 2026-03-05T08:01:21Z
- Threshold: 100%
- Exit code: 1

```text

  ..............⨯.............................................................
  .....
  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Meetup\tests\Feature\Auth\AuthTest > it logout redirects…    
  Failed asserting that an array contains 419.

  at Modules/Meetup/tests/Feature/Auth/AuthTest.php:176
    172▕ 
    173▕     $response = $this->actingAs($user)
    174▕         ->post('/logout');
    175▕ 
  ➜ 176▕     expect($response->status())->toBeIn([200, 302, 303]);
    177▕     $this->assertGuest();
    178▕ });
    179▕

  1   Modules/Meetup/tests/Feature/Auth/AuthTest.php:176


  Tests:    1 failed, 80 passed (151 assertions)
  Duration: 29.43s
```
