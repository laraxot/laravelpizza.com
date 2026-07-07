---
title: "Laraxot - Best Practices"
type: shard
confidence: high
created: 2026-05-11
parent: laraxot.md
lines: 100
tokens: ~130K
related:
  - ./INDEX.md
  - ./02-architecture.md
  - ./03-data-management.md
---

# Best Practices

## 1. Module Organization

```
Modules/YourModule/
├── Actions/           # Single-responsibility
├── Data/              # DTOs only
├── Filament/          # Admin resources
│   ├── Resources/
│   └── Pages/
├── Http/
│   ├── Controllers/   # Thin, delegate to actions
│   └── Requests/      # Form requests
├── Models/            # Eloquent + casts()
└── Providers/         # Module registration
```

## 2. Type Safety

```php
<?php
declare(strict_types=1);  // ALWAYS

namespace Modules\Geo\Actions;

class GetCoordsAction
{
    /**
     * @return LocationData
     */
    public function execute(string $addr): LocationData  // Return type
    {
        // No mixed types unless absolutely necessary
        return $this->geocode($addr);
    }
}
```

## 3. Error Handling

```php
try {
    $result = $action->execute($input);
} catch (ValidationException $e) {
    // Handle validation
    return back()->withErrors($e->validator);
} catch (GeoException $e) {
    // Handle domain-specific
    Log::error('Geo failed', ['ex' => $e]);
    return back()->with('error', __('geo::errors.lookup_failed'));
}
```

## 4. Configuration

```php
// config/yourmodule.php
return [
    'api' => [
        'key' => env('YOURMODULE_API_KEY'),
        'timeout' => 30,
    ],
    'features' => [
        'cache' => true,
        'queue' => false,
    ],
];
```

## 5. Testing

```php
class GetCoordsActionTest extends TestCase
{
    /** @test */
    public function it_returns_coordinates(): void
    {
        $result = app(GetCoordsAction::class)
            ->execute('Via Roma 1, Milano');
        
        $this->assertInstanceOf(LocationData::class, $result);
        $this->assertNotNull($result->lat);
        $this->assertNotNull($result->lng);
    }
}
```

## Quick Rules

| Rule | Status |
|------|--------|
| `declare(strict_types=1)` | Mandatory |
| Return types | Mandatory |
| Parameter types | Mandatory |
| PHPDoc for public methods | Mandatory |
| Tests for actions | Mandatory |
| XotBase* extension | Mandatory |

## References
- Testing: [06-testing](./06-testing.md)
- Troubleshooting: [07-troubleshooting](./07-troubleshooting.md)

---
*Shard 4/18 of laraxot.md | Load: 05-common-patterns.md or 06-testing.md*
