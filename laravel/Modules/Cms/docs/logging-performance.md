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
Log::error('Page render failed', [
    'slug' => $slug,
    'error' => $e->getMessage(),
]);
```

#### For Warnings Only
```php
Log::warning('Cache miss', [
    'page_slug' => $slug,
]);
```

#### For Audit Trails (NOT logs)
```php
activity()
    ->causedBy(auth()->user())
    ->performedOn($page)
    ->log('Page updated');
```

### WRONG Usage (NEVER do this)
```php
Log::info('Page rendered', ['slug' => $slug]);
Log::info('Block loaded', ['block_id' => $id]);
Log::info('Menu cached', ['menu_id' => $id]);
```

### CORRECT Usage (DO this instead)
```php
// Only log when something goes wrong
Log::error('Page render failed', ['error' => $e->getMessage()]);

// Use activity for audit trails
activity()->causedBy($user)->log('Page updated');

// Use metrics for tracking
Metrics::increment('cms.pages.rendered');
```