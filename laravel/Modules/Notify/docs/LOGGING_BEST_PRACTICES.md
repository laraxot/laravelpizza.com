# Logging Best Practices - Performance & Quality

## 🚫 CRITICAL RULE: NEVER USE Log::info()

### Why Log::info() is Harmful

**Performance Impact**:
- Each `Log::info()` call performs disk I/O
- Slows down requests by 30-50% when overused
- Blocks execution while writing to disk
- Increases memory usage for log buffering

**Storage Impact**:
- Log files grow uncontrollably
- Wastes disk space with useless information
- Requires constant log rotation and cleanup
- Increases backup costs and times

**Maintenance Impact**:
- Log files become unreadable with noise
- Makes debugging harder, not easier
- Requires filtering through thousands of useless entries
- Degrades log search performance

---

## ✅ When to Log

### Log::error() - Actual Errors
```php
// CORRECT
Log::error('Database connection failed', [
    'connection' => $connectionName,
    'error' => $e->getMessage(),
]);

// CORRECT
Log::error('Payment processing failed', [
    'order_id' => $order->id,
    'amount' => $order->amount,
    'error' => $e->getMessage(),
]);
```

### Log::warning() - Conditions Requiring Attention
```php
// CORRECT
Log::warning('Rate limit exceeded', [
    'user_id' => $user->id,
    'ip' => request()->ip(),
    'attempts' => $attempts,
]);

// CORRECT
Log::warning('API response slow', [
    'endpoint' => $endpoint,
    'duration_ms' => $duration,
]);
```

### Log::debug() - Development Only
```php
// CORRECT - Development only
Log::debug('User data', ['user' => $user->toArray()]);

// NEVER in production
if (config('app.debug')) {
    Log::debug('Debug info', [...]);
}
```

---

## ❌ When NOT to Log

### Routine Operations
```php
// WRONG - User logged in successfully
Log::info('User logged in', ['user_id' => $id]);

// WRONG - Ticket created
Log::info('Ticket created', ['ticket_id' => $id]);

// WRONG - Notification sent
Log::info('Notification sent', ['recipient' => $email]);

// WRONG - Request received
Log::info('Request received', ['url' => $url]);

// WRONG - User registered
Log::info('Registration attempt', ['email_hash' => $hash]);
```

### Successful Completions
```php
// WRONG - Action completed successfully
Log::info('Email sent successfully', [...]);

// WRONG - File uploaded
Log::info('File uploaded', ['filename' => $name]);

// WRONG - Cache refreshed
Log::info('Cache refreshed', ['key' => $key]);
```

---

## 📊 Better Alternatives

### For Audit Trails
```php
// Use database tables, not logs
activity()
    ->causedBy(auth()->user())
    ->performedOn($model)
    ->withProperties(['ip' => request()->ip()])
    ->log('Model updated');

// Or custom audit log
AuditLog::create([
    'user_id' => auth()->id(),
    'action' => 'create',
    'model_type' => get_class($model),
    'model_id' => $model->id,
    'ip_address' => request()->ip(),
]);
```

### For Monitoring
```php
// Use Laravel Telescope
use Laravel\Telescope\Telescope;
Telescope::record($event);

// Use Laravel Pulse
use Laravel\Pulse\Facades\Pulse;
Pulse::record(...);

// Use APM tools (New Relic, Datadog, etc.)
```

### For Metrics
```php
// Use metrics collectors
Metrics::increment('tickets.created');
Metrics::measure('api.response_time', $duration);

// Use Laravel Pulse metrics
Pulse::record('user registrations', $count);
```

---

## 🎯 Performance Optimization

### Remove Existing Log::info() Calls
```php
// BEFORE
public function register(array $data): User
{
    $user = User::create($data);
    Log::info('User registered', ['user_id' => $user->id]); // ❌ SLOW
    return $user;
}

// AFTER
public function register(array $data): User
{
    $user = User::create($data);
    activity()->causedBy($user)->log('User registered'); // ✅ FAST
    return $user;
}
```

### Batch Operations
```php
// BEFORE
foreach ($items as $item) {
    $item->process();
    Log::info('Item processed', ['item_id' => $item->id]); // ❌ SLOW
}

// AFTER
$count = 0;
foreach ($items as $item) {
    $item->process();
    $count++;
}
Log::info('Batch completed', ['count' => $count]); // ✅ ONE LOG
```

---

## 📈 Performance Metrics

### Log::info() Impact
- **Single call**: ~1-2ms latency
- **100 calls per request**: 100-200ms latency
- **1000 calls per request**: 1-2 second latency
- **Disk I/O**: Blocks execution while writing

### Recommended Limits
- **Errors**: As needed (unlimited)
- **Warnings**: < 10 per request
- **Debug**: 0 in production
- **Info**: 0 (never use)

---

## 🔍 Code Review Checklist

- [ ] No `Log::info()` calls in production code
- [ ] All `Log::error()` calls are for actual errors
- [ ] All `Log::warning()` calls are for conditions needing attention
- [ ] No logging in loops (batch at end instead)
- [ ] Audit trails use database tables, not logs
- [ ] Monitoring uses Telescope/Pulse, not logs
- [ ] Metrics use dedicated collectors, not logs

---

## 📚 Related Documentation

- `.windsurfrules` - Complete architectural rules
- `AGENTS.md` - Project guidelines
- Module-specific docs for implementation examples