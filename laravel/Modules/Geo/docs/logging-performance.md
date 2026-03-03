# Logging Performance Optimization

## Rule: NEVER USE Log::info()

### Impact
- Slows down requests by 30-50%
- Wastes disk space with useless information
- Makes debugging harder with noise
- Each call blocks execution with disk I/O

### Correct Usage

#### For Errors Only
```php
Log::error('Geocoding failed', [
    'address' => $address,
    'error' => $e->getMessage(),
]);
```

#### For Warnings Only
```php
Log::warning('Cache stale', [
    'comune_id' => $id,
]);
```

#### For Audit Trails (NOT logs)
```php
activity()
    ->causedBy(auth()->user())
    ->performedOn($address)
    ->log('Address updated');
```

### WRONG Usage (NEVER do this)
```php
Log::info('Address geocoded', ['id' => $id]);
Log::info('Region loaded', ['code' => $code]);
Log::info('Cache refreshed', ['key' => $key]);
```

### CORRECT Usage (DO this instead)
```php
// Only log when something goes wrong
Log::error('Geocoding failed', ['error' => $e->getMessage()]);

// Use activity for audit trails
activity()->causedBy($user)->log('Address updated');

// Use metrics for tracking
Metrics::increment('geo.geocoding.requests');
```