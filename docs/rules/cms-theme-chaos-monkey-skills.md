# CMS Theme Chaos Monkey Skills

## Core Debugging Skills

### Skill 1: Layer Identification

**Purpose**: Quickly identify which layer contains the issue

**Layers**:
1. Configuration (xra.php, config files)
2. Routing (Folio, routes)
3. Model (Eloquent, database)
4. Block (Block system, queries)
5. Template (Blade, views)
6. Middleware (request filtering)
7. Theme (assets, components)
8. Module (business logic)

**Steps**:
1. Observe symptom
2. Map symptom to layer
3. Check layer configuration
4. Trace execution flow
5. Validate assumptions

**Example**:
- Symptom: Page returns 404
- Layer: Routing
- Check: Folio registration, page slug, middleware

### Skill 2: Configuration Validation

**Purpose**: Validate configuration early and accurately

**Commands**:
```bash
# Check specific config
php artisan config:show xra

# Check all config
php artisan config:cache

# Clear config cache
php artisan config:clear
```

**Validation Points**:
- `xra.pub_theme` value
- `app.locale` value
- `app.url` value
- Database connections
- Module statuses

### Skill 3: Route Tracing

**Purpose**: Trace request through routing system

**Commands**:
```bash
# List all routes
php artisan route:list

# List specific route
php artisan route:list --path=it/events

# Clear route cache
php artisan route:clear
```

**Tracing Points**:
- Folio registration
- Route parameters
- Middleware execution
- Controller dispatch

### Skill 4: Model Query Debugging

**Purpose**: Debug model queries and relationships

**Commands**:
```bash
# Enable query logging
DB::enableQueryLog();

# Get query log
$queries = DB::getQueryLog();

# Check model relationships
$event->load('performers');
```

**Debugging Points**:
- Model class exists
- Relationship methods defined
- Database table exists
- Query scopes work correctly

### Skill 5: Block Execution Tracing

**Purpose**: Trace block execution flow

**Method**: Add debug statements to block code

**Example**:
```php
// In BlockData constructor
dump('Block type: ' . $type);
dump('Block data: ' . $data);
dump('Query config: ' . $query);

// In template
{{ dump($blocks) }}
{{ dump($blockData) }}
```

**Tracing Points**:
- Block type detection
- Query resolution
- View loading
- Data transformation

### Skill 6: Template Rendering Debugging

**Purpose**: Debug template rendering issues

**Commands**:
```bash
# Clear view cache
php artisan view:clear

# Check view exists
view()->exists('pub_theme::path')

# Get view path
$view->getPath()
```

**Debugging Points**:
- View path correct
- Namespace registered
- Variables passed correctly
- Template syntax valid

### Skill 7: Middleware Debugging

**Purpose**: Debug middleware execution

**Method**: Add middleware logging

**Example**:
```php
public function handle($request, Closure $next)
{
    Log::info('Middleware executing: ' . class_basename($this));
    $response = $next($request);
    Log::info('Middleware executed: ' . class_basename($this));
    return $response;
}
```

**Debugging Points**:
- Middleware registered
- Middleware order correct
- Middleware logic correct
- Exceptions handled properly

### Skill 8: Theme Asset Debugging

**Purpose**: Debug theme asset loading

**Commands**:
```bash
# Build theme assets
cd laravel/Themes/Meetup
npm run build
npm run copy

# Check asset paths
asset('css/app.css')
asset('js/app.js')
```

**Debugging Points**:
- Vite configuration correct
- Build output correct
- Asset paths correct
- Assets copied to public_html

### Skill 9: Module Integration Debugging

**Purpose**: Debug module integration issues

**Commands**:
```bash
# List modules
php artisan module:list

# Check module config
php artisan config:show modules

# Check module status
cat modules_statuses.json
```

**Debugging Points**:
- Module enabled
- Service provider registered
- Dependencies satisfied
- Module loads correctly

### Skill 10: Translation Debugging

**Purpose**: Debug translation issues

**Commands**:
```bash
# Check locale
app()->getLocale()

# Check translation exists
__('key')

# Clear translation cache
php artisan cache:clear
```

**Debugging Points**:
- Locale set correctly
- Translation file exists
- Translation key correct
- Namespace registered

## Recovery Skills

### Recovery 1: Emergency Cache Clear

**Purpose**: Clear all caches quickly

**Command**:
```bash
php artisan optimize:clear
```

**Effect**: Clears all caches including config, routes, views, compiled

### Recovery 2: Theme Asset Rebuild

**Purpose**: Rebuild and copy theme assets

**Commands**:
```bash
cd laravel/Themes/Meetup
npm run build
npm run copy
```

**Effect**: Rebuilds CSS/JS with Vite and copies to public_html

### Recovery 3: Service Restart

**Purpose**: Restart all development services

**Commands**:
```bash
# Stop services
pkill -f "php artisan serve"
pkill -f "npm run dev"

# Start services
cd laravel
php artisan serve &
npm run dev &
```

**Effect**: Stops and restarts PHP server and Vite dev server

### Recovery 4: Database Check

**Purpose**: Verify database connection and status

**Commands**:
```bash
php artisan db:show
php artisan migrate:status
```

**Effect**: Shows database connection info and migration status

### Recovery 5: Module Reset

**Purpose**: Reset module registration

**Commands**:
```bash
php artisan module:list
php artisan optimize:clear
```

**Effect**: Lists modules and clears all caches

## Advanced Skills

### Advanced Skill 1: Query Analysis

**Purpose**: Analyze slow or incorrect queries

**Method**:
```php
DB::enableQueryLog();
// Execute queries
$queries = DB::getQueryLog();
foreach ($queries as $query) {
    echo $query['query'] . "\n";
    echo "Bindings: " . json_encode($query['bindings']) . "\n";
    echo "Time: " . $query['time'] . "ms\n\n";
}
```

### Advanced Skill 2: Memory Profiling

**Purpose**: Identify memory usage issues

**Method**:
```php
$memoryBefore = memory_get_usage(true);
// Execute code
$memoryAfter = memory_get_usage(true);
$memoryUsed = $memoryAfter - $memoryBefore;
echo "Memory used: " . formatBytes($memoryUsed) . "\n";
```

### Advanced Skill 3: Request Tracing

**Purpose**: Trace complete request lifecycle

**Method**:
```php
Event::listen('*', function ($eventName, array $data) {
    if (strpos($eventName, 'kernel.handled') !== false) {
        Log::info('Event: ' . $eventName);
    }
});
```

### Advanced Skill 4: Performance Profiling

**Purpose**: Identify performance bottlenecks

**Method**:
```php
$start = microtime(true);
// Execute code
$end = microtime(true);
$duration = $end - $start;
echo "Duration: " . number_format($duration * 1000, 2) . "ms\n";
```

### Advanced Skill 5: Exception Tracking

**Purpose**: Track and analyze exceptions

**Method**:
```php
try {
    // Execute code
} catch (\Exception $e) {
    Log::error('Exception: ' . $e->getMessage());
    Log::error('File: ' . $e->getFile() . ':' . $e->getLine());
    Log::error('Trace: ' . $e->getTraceAsString());
    throw $e;
}
```

## Skill Application Examples

### Example 1: 404 Error

**Skill Application**:
1. Layer Identification → Routing layer
2. Route Tracing → Check route registration
3. Configuration Validation → Check Folio config
4. Template Rendering → Check view exists

### Example 2: Empty Content Area

**Skill Application**:
1. Layer Identification → Block layer
2. Block Execution Tracing → Trace block flow
3. Model Query Debugging → Check queries
4. Template Rendering → Check template variables

### Example 3: Missing Translation

**Skill Application**:
1. Layer Identification → Translation layer
2. Translation Debugging → Check locale and file
3. Configuration Validation → Check app locale
4. Module Integration → Check namespace registration

### Example 4: Component Not Responding

**Skill Application**:
1. Layer Identification → Livewire component layer
2. Module Integration → Check component registration
3. Template Rendering → Check component usage
4. Emergency Cache Clear → Clear all caches

### Example 5: Asset Not Loading

**Skill Application**:
1. Layer Identification → Theme asset layer
2. Theme Asset Debugging → Check build and copy
3. Configuration Validation → Check Vite config
4. Emergency Cache Clear → Clear asset cache

## Skill Development Plan

### Phase 1: Foundation Skills (Week 1)
- Layer Identification
- Configuration Validation
- Route Tracing
- Model Query Debugging

### Phase 2: Intermediate Skills (Week 2)
- Block Execution Tracing
- Template Rendering Debugging
- Middleware Debugging
- Theme Asset Debugging

### Phase 3: Advanced Skills (Week 3)
- Module Integration Debugging
- Translation Debugging
- Query Analysis
- Memory Profiling

### Phase 4: Mastery Skills (Week 4)
- Request Tracing
- Performance Profiling
- Exception Tracking
- Complex Problem Solving

## Skill Maintenance

### Daily Practice
- Use Layer Identification for all issues
- Validate configuration before debugging
- Trace routes for 404 errors

### Weekly Review
- Review query logs for optimization
- Check memory usage for bottlenecks
- Analyze exception logs for patterns

### Monthly Training
- Practice advanced skills
- Solve complex scenarios
- Update skill documentation

## Skill Resources

**Documentation**:
- Laravel Debugging Guide
- Eloquent Query Debugging
- Blade Template Debugging
- Livewire Component Debugging

**Tools**:
- Laravel Telescope
- Laravel Debugbar
- Query Logging
- Exception Tracking

**Best Practices**:
- Log early and often
- Validate assumptions
- Trace the flow
- Test fixes thoroughly

This skills document provides the practical debugging and recovery skills needed to handle chaos monkey scenarios in the CMS theme system.