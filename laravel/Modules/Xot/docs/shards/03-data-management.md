---
title: "Laraxot - Data Management"
type: shard
confidence: high
created: 2026-05-11
parent: laraxot.md
lines: 50
tokens: ~65K
related:
  - ./INDEX.md
  - ./02-architecture.md
  - ./11-spatie-integration.md
---

# Data Management

## DTOs: Spatie Laravel Data

### Pattern
```php
use Spatie\LaravelData\Data;

class LocationData extends Data
{
    public function __construct(
        public readonly float $lat,
        public readonly float $lng,
        public readonly ?string $addr = null,
    ) {}
}
```

### Benefits
- Type-safe data transfer
- Validation built-in
- Immutable by default
- Easy serialization

## Actions: Spatie QueueableAction

### Pattern
```php
use Spatie\QueueableAction\QueueableAction;

class GetCoordsAction
{
    use QueueableAction;
    
    public function execute(string $addr): LocationData
    {
        // Implementation
        return new LocationData(lat: $lat, lng: $lng, addr: $addr);
    }
}
```

### Usage
```php
// Sync
$result = app(GetCoordsAction::class)->execute($addr);

// Async (queued)
app(GetCoordsAction::class)->onQueue('geo')->execute($addr);
```

## When to Use What

| Pattern | Use For | Example |
|---------|---------|---------|
| **DTO** | Data transfer | API responses, form data |
| **Action** | Business logic | Coordinate lookup, PDF gen |
| **Service** | Stateful operations | Complex multi-step flows |
| **Repository** | Data access | DB queries, caching |

## Anti-Patterns

```php
// ❌ Never: Services with single method
class UserService { public function create() {} }

// ✅ Always: Action for single responsibility
class CreateUserAction { public function execute() {} }
```

## References
- Spatie integration: [11-spatie-integration](./11-spatie-integration.md)
- Architecture: [02-architecture](./02-architecture.md)

---
*Shard 3/18 of laraxot.md | Load: 04-best-practices.md or 11-spatie-integration.md*
