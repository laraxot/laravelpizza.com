---
title: "Document Root Architecture"
type: concept
tags: [document, root, architecture]
created: 2026-07-14
updated: 2026-07-14
qmd: "document-root-architecture document root architecture"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./config-structure.md"
  - "./dto-structure-conventions.md"
  - "./dto-structure-rules.md"
  - "./interface-structure-clarification.md"
  - "./mail-templates-structure.md"
  - "./queueable-action-pattern.md"
  - "./sms-config-structure.md"
  - "./standardized-sms-config-structure.md"
---

# Document Root Architecture

## Overview

This project uses a **custom Laravel public path architecture** where the web-accessible document root is `public_html/` instead of the default `laravel/public/`.

## Architecture

```
/var/www/_bases/base_fixcity_fila5/
/var/www/_bases/base_ptvx_fila5/
├── public_html/                    ← ACTUAL DocumentRoot (Apache serves from here)
│   ├── index.php                   ← Entry point
│   ├── .htaccess
│   ├── assets/
│   ├── css/
│   ├── js/
│   ├── themes/
│   └── modules/
├── laravel/
│   ├── app/
│   │   └── Application.php         ← Custom class overriding public_path()
│   ├── bootstrap/
│   │   └── app.php                 ← Uses Application::configure()
│   └── public/                     ← Default Laravel folder (UNUSED but exists)
```

## How It Works

### 1. Custom Application Class

**File**: `laravel/app/Application.php`

```php
namespace App;

class Application extends \Illuminate\Foundation\Application
{
    public function publicPath($path = ''): string
    {
        $tmp = $this->basePath.'/../public_html/'.$path;
        $tmp = str_replace(['/', '\\'], [DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR], $tmp);
        if (realpath($tmp) === false) {
            return realpath($this->basePath.'/../public_html/').'/'.$path;
        }
        return realpath($tmp);
    }
}
```

**This overrides Laravel's default `public_path()` helper** to return `public_html/` instead of `laravel/public/`.

### 2. Bootstrap Configuration

**File**: `laravel/bootstrap/app.php`

```php
use App\Application;  // ← Uses custom Application class
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(...)
    ->withMiddleware(...)
    ->withExceptions(...)
    ->create();
```

The bootstrap **explicitly imports** `App\Application` instead of `Illuminate\Foundation\Application`.

### 3. Entry Point

**File**: `public_html/index.php`

```php
define('LARAVEL_DIR', __DIR__.'/../laravel');

require LARAVEL_DIR.'/vendor/autoload.php';
(require_once LARAVEL_DIR.'/bootstrap/app.php')
    ->handleRequest(Request::capture());
```

The entry point defines `LARAVEL_DIR` constant pointing to the Laravel installation.

### 4. Apache Configuration

**Active VHost**: `/etc/apache2/sites-enabled/fixcity.local.conf`

```apache
DocumentRoot /var/www/_bases/base_fixcity_fila5/public_html
```

## Verification

Test that `public_path()` resolves correctly:

```bash
cd /var/www/_bases/base_fixcity_fila5/laravel
php -r "require 'vendor/autoload.php'; \$app = require 'bootstrap/app.php'; echo public_path() . PHP_EOL;"
```

**Expected output**: `/var/www/_bases/base_fixcity_fila5/public_html`

## Why Both Directories Exist

### `public_html/` (ACTIVE)
- The **actual web-accessible directory**
- Apache serves from here
- Contains all public assets, themes, modules
- Built by theme/npm scripts

### `laravel/public/` (UNUSED)
- Default Laravel public folder
- **Not served by Apache**
- Exists as part of standard Laravel installation
- Can be safely ignored or removed

## Important Rules

1. **NEVER** reference `laravel/public/` in code - use `public_path()` helper instead
2. **ALWAYS** build themes/assets to `public_html/` (configured in package.json scripts)
3. **ALL** file uploads and public file storage use `public_path()` which resolves to `public_html/`
4. **NEVER** manually copy files to `laravel/public/` - they won't be web-accessible

## Theme Build Configuration

**File**: `laravel/Themes/Sixteen/package.json`

```json
{
  "scripts": {
    "copy": "cp -rv ./public/. ../../../public_html/themes/Sixteen/"
  }
}
```

Themes are built to `public_html/themes/{name}/`, NOT `laravel/public/themes/`.

## Environment Configuration

**File**: `laravel/.env.local`

```env
MIX_PUBLIC_FOLDER=/../public_html
```

This tells Vite/Mix to output to `public_html/`.

## Migration History

The project was originally set up following Laraxot conventions:

```bash
# Original setup (from install docs)
mv laravel/public public_html
```

However, instead of moving, the project now uses the **custom Application class** approach to override paths without removing the default folder.

## Troubleshooting

### Issue: Assets not loading
**Check**: Are they in `public_html/` or `laravel/public/`?
**Fix**: Move to `public_html/` and update build scripts if needed.

### Issue: `public_path()` returns wrong directory
**Check**: Is `laravel/app/Application.php` being loaded?
**Fix**: Verify `bootstrap/app.php` imports `App\Application` not `Illuminate\Foundation\Application`.

### Issue: File uploads going to wrong location
**Check**: Code using `public_path()` or hardcoded paths?
**Fix**: Always use `public_path()` helper, never hardcode paths.

## References

- Laravel Documentation: [Directory Structure](https://laravel.com/docs/structure)
- Laraxot Installation: `laravel/Modules/Xot/docs/install/install-from-zero.md`
- UI Module: `laravel/Modules/UI/docs/public-resources-management.md`
