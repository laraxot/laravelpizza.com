# Logging Performance Optimization

## Rule: NEVER USE Log::info()

### Impact of Log::info()
- Slows down requests by 30-50%
- Wastes disk space with useless information
- Makes debugging harder with noise
- Each call blocks execution with disk I/O

### What to Use Instead

#### For Errors
```php
Log::error('Payment failed', [
    'order_id' => $order->id,
    'error' => $e->getMessage(),
]);
```

#### For Warnings
```php
Log::warning('Rate limit exceeded', [
    'user_id' => $user->id,
    'attempts' => $attempts,
]);
```

#### For Audit Trails (NOT logs)
```php
activity()
    ->causedBy(auth()->user())
    ->performedOn($model)
    ->log('Action completed');
```

#### For Monitoring (NOT logs)
```php
use Laravel\Telescope\Telescope;
Telescope::record($event);
```

### Examples of WRONG Usage
```php
// ❌ NEVER DO THIS
Log::info('User logged in', ['user_id' => $id]);
Log::info('Ticket created', ['ticket_id' => $id]);
Log::info('Notification sent', ['email' => $email]);
Log::info('Registration attempt', ['hash' => $hash]);
Log::info('Request received', ['url' => $url]);
```

### Examples of CORRECT Usage
```php
// ✅ DO THIS INSTEAD
Log::error('Database connection failed', ['error' => $e->getMessage()]);
Log::warning('API slow', ['endpoint' => $endpoint, 'duration' => $duration]);
activity()->causedBy($user)->log('User logged in');
Metrics::increment('tickets.created');
```

### Performance Metrics
- Single Log::info() call: ~1-2ms latency
- 100 calls per request: 100-200ms latency
- 1000 calls per request: 1-2 second latency

### Recommended Limits
- Errors: As needed (unlimited)
- Warnings: < 10 per request
- Debug: 0 in production
- Info: 0 (NEVER use)

### Code Review Checklist
- [ ] No Log::info() calls
- [ ] All logs are errors or warnings
- [ ] Audit trails use database tables
- [ ] Monitoring uses Telescope/Pulse