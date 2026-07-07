# Laravel Debugbar Troubleshooting Guide

## Problem: Debugbar Not Showing

### Root Cause Analysis

The Laravel Debugbar (`fruitcake/laravel-debugbar`) was not displaying despite being properly installed and enabled because of **strict security headers** set by the custom `SecurityMiddleware` in the project.

#### Specific Issues:

1. **Content-Security-Policy (CSP)**: The CSP header set by `SecurityMiddleware` was blocking Debugbar's inline scripts and styles
2. **X-Frame-Options: DENY**: This header prevented Debugbar from rendering in iframes
3. **Debugbar routes not excluded**: Security headers were being applied to Debugbar asset routes

### Configuration Status

- **Package**: `fruitcake/laravel-debugbar` v3.16.5 (installed)
- **APP_DEBUG**: `true` (enabled)
- **DEBUGBAR_ENABLED**: `true` (enabled in `.env`)
- **Config**: `laravel/config/debugbar.php` exists and is properly configured

## Solution

### 1. SecurityMiddleware Update

**File**: `laravel/Modules/Xot/app/Http/Middleware/SecurityMiddleware.php`

Added logic to skip security headers for Debugbar routes in local environment:

```php
public function handle(Request $request, \Closure $next): Response
{
    // 1. Rate Limiting avanzato
    $this->applyAdvancedRateLimiting($request);

    // 2. Headers di sicurezza
    $response = $next($request);
    Assert::isInstanceOf($response, Response::class);
    
    // Skip security headers for Debugbar routes in local environment
    // to allow Debugbar to function properly
    if (! $this->isDebugbarRoute($request) || ! app()->environment('local')) {
        $this->addSecurityHeaders($response);
    }

    // 3. Logging sicurezza
    $this->logSecurityEvents($request, $response);

    // 4. Validazione input avanzata
    $this->validateInputs($request);

    // 5. Protezione CSRF avanzata
    $this->enhanceCSRFProtection($request);

    return $response;
}

/**
 * Check if the request is for Debugbar routes.
 */
private function isDebugbarRoute(Request $request): bool
{
    $debugbarPrefix = config('debugbar.route_prefix', '_debugbar');
    
    return str_starts_with($request->path(), $debugbarPrefix)
        || str_starts_with($request->path(), 'vendor/debugbar')
        || str_contains($request->path(), '_debugbar');
}
```

### 2. PWAMiddleware Update

**File**: `laravel/Themes/Sixteen/app/Http/Middleware/PWAMiddleware.php`

Added the same exclusion for Debugbar routes:

```php
public function handle(Request $request, Closure $next): Response
{
    // Skip PWA headers for Debugbar routes in local environment
    // to allow Debugbar to function properly
    if ($this->isDebugbarRoute($request) && app()->environment('local')) {
        return $next($request);
    }

    $response = $next($request);
    // ... rest of the middleware
}
```

### 3. Config Update

**File**: `laravel/config/debugbar.php`

Added documentation about the SecurityMiddleware integration:

```php
/*
|--------------------------------------------------------------------------
| DebugBar route middleware
|--------------------------------------------------------------------------
|
| Additional middleware to run on the Debugbar routes
|
| IMPORTANT: In this project, SecurityMiddleware and PWAMiddleware are 
| configured to skip security headers (CSP, X-Frame-Options) for Debugbar 
| routes in local environment. This is necessary because the strict CSP 
| blocks Debugbar's inline scripts and styles required for rendering the 
| debug bar.
*/
'route_middleware' => [],
```

## How Debugbar Works in This Project

### Auto-Discovery

Laravel Debugbar uses **Package Auto-Discovery**, so no manual service provider registration is needed. The package is automatically loaded when:

1. `APP_DEBUG` is `true`
2. `DEBUGBAR_ENABLED` is `true` (or not set, defaults to `APP_DEBUG` value)
3. Environment is NOT `production` or `testing`

### Rendering Flow

1. Debugbar injects itself before `</body>` tag (via `'inject' => true` in config)
2. Assets are served from `/vendor/debugbar/*` routes
3. Data is stored in `storage/debugbar/` folder
4. Previous requests can be browsed if `'storage.open' => true`

### Security Considerations

**⚠️ WARNING**: Debugbar should NEVER be enabled in production:

- It leaks sensitive information (queries, session data, logs)
- Stored requests are accessible to anyone who knows the URL
- It can significantly slow down the application

The SecurityMiddleware exclusion is **only for local environment**:

```php
if (! $this->isDebugbarRoute($request) || ! app()->environment('local')) {
    $this->addSecurityHeaders($response);
}
```

## Verification Steps

### 1. Check Installation

```bash
cd laravel
composer show fruitcake/laravel-debugbar
```

Expected output: `fruitcake/laravel-debugbar v3.16.5`

### 2. Check Environment Variables

```bash
grep -E "APP_DEBUG|DEBUGBAR" laravel/.env
```

Expected:
```env
APP_DEBUG=true
DEBUGBAR_ENABLED=true
```

### 3. Clear Caches

```bash
cd laravel
php artisan config:clear
php artisan cache:clear
php artisan debugbar:clear
```

### 4. Test in Browser

1. Navigate to `http://fixcity.local` (or your local URL)
2. Debugbar should appear at the bottom of the page
3. Check browser console for any CSP errors

### 5. Verify Storage

```bash
ls -la laravel/storage/debugbar/
```

Should contain `.json` files for each request (after making some requests)

## Common Issues & Solutions

### Issue: Debugbar Still Not Showing

**Check**:
1. Is `APP_DEBUG=true` in `.env`?
2. Is `DEBUGBAR_ENABLED=true` in `.env`?
3. Is SecurityMiddleware applied globally?
4. Are you in `local` environment? (`APP_ENV=local`)

**Solution**:
```bash
php artisan config:clear
php artisan cache:clear
```

### Issue: CSP Errors in Console

**Check**: Browser console for `Content-Security-Policy` violations

**Solution**: Ensure SecurityMiddleware is skipping Debugbar routes (see above)

### Issue: Debugbar Shows But No Data

**Check**: `storage/debugbar/` folder permissions

**Solution**:
```bash
chmod -R 775 laravel/storage/debugbar/
chown -R www-data:www-data laravel/storage/debugbar/
```

### Issue: AJAX Requests Not Captured

**Check**: `'capture_ajax' => true` in `config/debugbar.php`

**Solution**: Ensure your AJAX requests send `X-Requested-With: XMLHttpRequest` header

## Configuration Options

### Enable/Disable Collectors

In `config/debugbar.php`, you can enable/disable specific collectors:

```php
'collectors' => [
    'phpinfo'         => true,  // Php version
    'messages'        => true,  // Messages
    'time'            => true,  // Time Datalogger
    'memory'          => true,  // Memory usage
    'exceptions'      => true,  // Exception displayer
    'log'             => true,  // Logs from Monolog
    'db'              => true,  // Show database queries
    'views'           => true,  // Views with their data
    'route'           => true,  // Current route information
    'auth'            => false, // Display authentication status
    'gate'            => true,  // Display Gate checks
    'session'         => true,  // Display session data
    'mail'            => true,  // Catch mail messages
    'livewire'        => true,  // Display Livewire
    // ... more collectors
],
```

### Storage Configuration

```php
'storage' => [
    'enabled'    => true,
    'open'       => env('DEBUGBAR_OPEN_STORAGE'), // Allow browsing previous requests
    'driver'     => 'file', // redis, file, pdo, socket, custom
    'path'       => storage_path('debugbar'),
],
```

### Query Optimization

For better performance with many queries:

```php
'db' => [
    'with_params'       => true,
    'backtrace'         => true,
    'soft_limit'        => 100,  // After 100 queries, no backtrace
    'hard_limit'        => 500,  // After 500 queries, ignored
],
```

## Related Files

- **Config**: `laravel/config/debugbar.php`
- **Middleware**: 
  - `laravel/Modules/Xot/app/Http/Middleware/SecurityMiddleware.php`
  - `laravel/Themes/Sixteen/app/Http/Middleware/PWAMiddleware.php`
- **Storage**: `laravel/storage/debugbar/`
- **Vendor**: `laravel/vendor/fruitcake/laravel-debugbar/`
- **Env**: `laravel/.env` (DEBUGBAR_ENABLED)
- **Documentation**: `docs/project/LARAVEL_DEBUGBAR_TROUBLESHOOTING.md`

## References

- **GitHub**: https://github.com/fruitcake/laravel-debugbar
- **Packagist**: https://packagist.org/packages/fruitcake/laravel-debugbar
- **Laravel Docs**: https://laravel.com/docs/debugging

## Lessons Learned

1. **Security headers can break dev tools**: Strict CSP and X-Frame-Options are great for production security but can break development tools like Debugbar
2. **Environment-specific exclusions**: Always check environment before disabling security features
3. **Package auto-discovery**: Modern Laravel packages auto-register, but you still need to check configuration
4. **Documentation is key**: Always document why certain exclusions exist (future maintainers will thank you)

---

**Last Updated**: 2026-04-01  
**Author**: Qwen Code AI Assistant  
**Status**: ✅ Resolved
