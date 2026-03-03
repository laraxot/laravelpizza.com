# GdprServiceProvider fix - 2026-03-02

## Problem

Running `php laravel/artisan boost:add-skill jeffallan/claude-skills --skill laravel-specialist` caused a PHP fatal error:

```
Cannot use function Safe\realpath as realpath because the name is already in use
in GdprServiceProvider.php on line 12
```

## Root cause

`GdprServiceProvider.php` had a duplicate `use` statement for `Safe\realpath`:

```php
// Before (broken)
use function Safe\realpath;
use function Safe\realpath;  // duplicate line
```

The PHP engine interpreted the second `use function Safe\realpath as realpath` as trying to alias `realpath` to itself, but since `realpath` is already a built-in PHP function in the global namespace, it threw a fatal error.

## Fix applied

Removed both `use function Safe\realpath` lines entirely. The `realpath()` call in the `boot()` method works correctly with the native PHP function, which is already available without any import:

```php
// After (fixed)
$cookieConsentLangPath = realpath(__DIR__.'/../../lang/cookie-consent');
```

The `thecodingmachine/safe` package wraps PHP functions to throw exceptions instead of returning `false`. For this use case, the native `realpath()` is sufficient since the result is immediately checked with `if ($cookieConsentLangPath && is_dir(...))`.

## Impact

This error blocked `composer dump-autoload` from completing successfully via its `package:discover` post-dump hook. All `php artisan` commands that needed to bootstrap Laravel were also blocked.

## Prevention

- Never duplicate `use` statements in the same file
- If using `Safe\realpath`, import it exactly once: `use function Safe\realpath;`
- Run `php artisan config:clear` periodically to catch bootstrap errors early

## Files modified

- `app/Providers/GdprServiceProvider.php` - removed duplicate `use function Safe\realpath;` lines
