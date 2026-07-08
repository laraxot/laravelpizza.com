# Debugbar Architecture

## Overview

This document explains how `fruitcake/laravel-debugbar` is integrated into the Laraxot modular architecture and resolves the issue of the debugbar not appearing on pages.

## Root Cause Analysis

### Problem

The debugbar was not appearing on `http://127.0.0.1:8000/it/tests/homepage` despite being installed.

### Investigation Results

| Check | Result |
|-------|--------|
| Package installed? | YES (`fruitcake/laravel-debugbar 4.2.x`) |
| Service provider discovered? | YES (`php artisan package:discover` shows Laravel Debugbar as discovered) |
| Response instrumentation? | ✅ YES — `fruitcake/laravel-debugbar` v4 usa listener `Illuminate\Foundation\Http\Events\RequestHandled` + `Terminating` (namespace `Fruitcake\\LaravelDebugbar`, non più `Barryvdh\\Debugbar\\Middleware\\InjectDebugbar` nel middleware stack web globale). |
| Config file exists? | ✅ YES (`laravel/config/debugbar.php`) |
| `APP_DEBUG` in .env? | ✅ `true` |
| `DEBUGBAR_ENABLED` in .env? | ❌ **`false`** — THIS WAS THE PROBLEM |
| `config('debugbar.enabled')` at runtime? | ❌ `false` (because env var is false) |

### Root Cause

The `.env` file had `DEBUGBAR_ENABLED=false`, which overrides `APP_DEBUG=true`. The debugbar's `isEnabled()` method checks `config('debugbar.enabled')`, which reads `env('DEBUGBAR_ENABLED', null)`. When set to `false` explicitly, it disables the debugbar regardless of `APP_DEBUG`.

## Architecture

### Module-Level Declaration

In this project, the Xot module declares debugbar as a dependency in its `composer.json`:

```json
{
  "require-dev": {
    "fruitcake/laravel-debugbar": "^4.2.8"
  }
}
```

The root `laravel/composer.json` uses `wikimedia/composer-merge-plugin`:

```json
{
  "extra": {
    "merge-plugin": {
      "include": ["Modules/*/composer.json"]
    }
  }
}
```

This means Xot's `require-dev` dependencies are **merged into the root composer.json** during `composer install/update`. The package is installed in the root `vendor/` directory, not inside the module.

### Why Module-Level Declaration?

1. **Declarative intent** — The Xot module declares that the project uses debugbar
2. **Centralized in module** — Changes to dev tools are tracked with the module that uses them
3. **No isolation** — Debugbar is inherently application-wide; it monitors ALL modules, themes, and routes

### Cleanup: Duplicate Package Names

Older Composer attempts used either the previous package name or a Laravel 12-only line:

```json
"barryvdh/laravel-debugbar": "^3.14",
"fruitcake/laravel-debugbar": "^3.16"
```

For Laravel 13, use the canonical package name and the 4.2 line:

```json
"fruitcake/laravel-debugbar": "^4.2.8"
```

The root `laravel/composer.json` must not duplicate debugbar. Xot owns the dev-tool declaration and Composer merges it into the root dependency graph.

## Configuration

### .env Settings

```env
APP_DEBUG=true
DEBUGBAR_ENABLED=true
```

- When `DEBUGBAR_ENABLED=null` (or not set), debugbar follows `APP_DEBUG`
- When `DEBUGBAR_ENABLED=true/false` explicitly, it **overrides** `APP_DEBUG`

### Config File

Located at `laravel/config/debugbar.php`. Key settings:

- `enabled` → `env('DEBUGBAR_ENABLED', null)` — controlled by .env
- `inject` → `true` — auto-injects before `</body>`
- `collectors` → fine-grained toggles for Query, View, Route, Livewire, etc.
- `except` → `['telescope*', 'horizon*']` — URIs to exclude

## Enabling/Disabling

### Enable Debugbar

```bash
cd laravel
# Edit .env and set:
DEBUGBAR_ENABLED=true

# Clear config cache (if cached):
php artisan config:clear

# Restart dev server:
php artisan serve
```

### Disable Debugbar

```bash
cd laravel
# Edit .env and set:
DEBUGBAR_ENABLED=false

# Or remove the line entirely to follow APP_DEBUG
```

## Troubleshooting Checklist

1. **Check .env:** `DEBUGBAR_ENABLED=true` (or remove line to follow `APP_DEBUG`)
2. **Clear config:** `php artisan config:clear`
3. **Check runtime config:** `php artisan tinker --execute="var_dump(config('debugbar.enabled'));"`
4. **Provider / stack:** Debugbar non è più un middleware web globale `InjectDebugbar`; in v4 viene montato tramite [`Fruitcake\LaravelDebugbar\ServiceProvider`](https://github.com/fruitcake/laravel-debugbar) e listener sugli eventi HTTP. Ignorare stack trace nei dump HTML storici che citano ancora `Barryvdh\Debugbar\Middleware\InjectDebugbar`.

### Composer nel sotto-progetto `Modules/Xot`

Il `composer.json` del modulo può creare un `Modules/Xot/vendor/` locale. Se una installazione precedente è **parziale** (file mancanti in `vendor/`), `composer dump-autoload` fallisce con «does not appear to be a file nor a folder». In quel caso: `rm -rf laravel/Modules/Xot/vendor`, poi ripetere `composer require` da `Modules/Xot`, quindi `rm -rf vendor` e dalla root `laravel/` eseguire `composer install` o `composer go` secondo la procedura di squadra.
5. **Tema Sixteen / parity CSS:** il file [`ticket-parity.css`](../../../Themes/Sixteen/resources/css/ticket-parity.css) è importato da `Themes/Sixteen/resources/css/app.css`. Se `#phpdebugbar` ha `display: none !important` **globale**, la barra resta invisibile anche col backend OK — gli screenshot parity usano solo `body.parity-capture-hide-dev-overlays`.
6. **Check package discovery:** `php artisan package:discover 2>&1 | grep -i debug`
7. **Verify HTML injection:** `curl -s http://127.0.0.1:8000/some-page | grep -i debugbar`

## Security Warning

**Never enable debugbar on publicly accessible production servers.** It leaks request data, queries, session data, and environment variables by design.

The project's `SecurityMiddleware` is configured to skip CSP headers for debugbar routes (`_debugbar/*`) in local environment only.

## References

- [fruitcake/laravel-debugbar on GitHub](https://github.com/fruitcake/laravel-debugbar)
- [Laravel Package Auto-Discovery](https://laravel.com/docs/packages#package-discovery)
- [wikimedia/composer-merge-plugin](https://github.com/wikimedia/composer-merge-plugin)
