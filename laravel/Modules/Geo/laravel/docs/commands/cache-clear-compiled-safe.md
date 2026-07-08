# Clear Compiled Cache Safe

Custom artisan command to safely clear Laravel's compiled cache files.

## Usage

```bash
php artisan cache:clear-compiled-safe
```

## Purpose

This command clears compiled cache files in `bootstrap/cache/` directory while **preserving** important files like `.gitignore` and `.gitkeep`.

## Why This Command Exists

The standard `php artisan optimize:clear` command:
- Requires database connection (can fail in production)
- May accidentally remove important files

This custom command:
- ✅ No database connection required
- ✅ Preserves `.gitignore` and `.gitkeep` files
- ✅ Only deletes `.php` files
- ✅ Shows detailed output of actions
- ✅ Resets OPCache automatically

## What It Does

1. Scans `bootstrap/cache/` directory
2. Deletes only `.php` files:
   - `compiled.php`
   - `config.php`
   - `routes.php`
   - `services.php`
   - `packages.php`
   - etc.
3. Skips non-PHP files:
   - `.gitignore`
   - `.gitkeep`
4. Resets PHP OPCache if available

## Example Output

```
Clearing compiled cache files in /path/to/bootstrap/cache...
  Deleted: modules.php
  Deleted: packages.php
  Deleted: services.php
  Deleted: settings.php

Cache cleared successfully!
+---------+-------+
| Action  | Count |
+---------+-------+
| Deleted | 4     |
| Skipped | 0     |
+---------+-------+
OPCache reset.
```

## When to Use

- After deploying code changes
- When cache files are corrupted
- Before running `composer dump-autoload`
- When `optimize:clear` fails due to database issues
- In CI/CD pipelines

## Related Commands

```bash
# Standard Laravel cache clear (requires DB)
php artisan optimize:clear

# Config cache only
php artisan config:clear

# Route cache only
php artisan route:clear

# View cache only
php artisan view:clear
```

## Technical Details

- **Location**: `app/Console/Commands/ClearCompiledCache.php`
- **Signature**: `cache:clear-compiled-safe`
- **Options**: `--gitignore` (preserve .gitignore, default behavior)
- **Return**: `Command::SUCCESS` on success, `Command::FAILURE` on error

## Safety Features

1. **File Extension Check**: Only deletes files with `.php` extension
2. **Protected Files**: Explicitly skips `.gitignore` and `.gitkeep`
3. **Existence Check**: Verifies directory exists before proceeding
4. **No Database**: Doesn't require database connection
5. **Detailed Logging**: Shows every file action taken
