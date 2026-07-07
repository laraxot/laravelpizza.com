# FixCity Project Configuration

**Last Updated**: 2026-03-30  
**Source**: `laravel/.env` + `laravel/config/local/fixcity/xra.php`

## Quick Reference

| Setting | Value | Source |
|---------|-------|--------|
| **APP_URL** | `http://fixcity.local` | `.env` |
| **Domain** | `fixcity.local` | Derived |
| **Config Path** | `config/local/fixcity/xra.php` | Derived |
| **Active Theme** | `Sixteen` | Config |
| **Document Root** | `public_html/` | Structure |
| **Primary Lang** | `it` | Config |

## Theme Detection Algorithm

The active theme is determined by this algorithm:

```php
/**
 * Detect active theme from APP_URL
 *
 * @return string Theme name
 */
function detectTheme(): string
{
    // 1. Read APP_URL
    $appUrl = env('APP_URL', 'http://fixcity.local');
    // Result: "http://fixcity.local"
    
    // 2. Remove protocol and www
    $domain = str_replace(
        ['http://', 'https://', 'www.'], 
        '', 
        $appUrl
    );
    // Result: "fixcity.local"
    
    // 3. Explode by dot and reverse
    $parts = array_reverse(explode('.', $domain));
    // Result: ["local", "fixcity"]
    
    // 4. Join with slash
    $configPath = implode('/', $parts);
    // Result: "local/fixcity"
    
    // 5. Read config file
    $config = include base_path("config/{$configPath}/xra.php");
    
    // 6. Return theme
    return $config['pub_theme'];
    // Result: "Sixteen"
}
```

## Configuration File

**Path**: `laravel/config/local/fixcity/xra.php`

```php
<?php

declare(strict_types=1);

return [
    'adm_home' => '01',
    'enable_ads' => '1',
    'main_module' => 'Fixcity',
    'primary_lang' => 'it',
    'pub_theme' => 'Sixteen',              // ← ACTIVE THEME
    'search_action' => 'it/videos',
    'show_trans_key' => false,
    'disable_admin_dynamic_route' => true,
    'disable_frontend_dynamic_route' => false,
    'register_adm_theme' => false,
    'register_pub_theme' => true,
];
```

## Project Structure

```
base_fixcity_fila5/
├── public_html/                    # 📁 DOCUMENT ROOT
│   ├── assets/                    # Theme assets (CSS, JS, images)
│   ├── index.php                  # Entry point
│   └── ...
│
├── laravel/                       # 🎂 LARAVEL APPLICATION
│   ├── .env                       # Environment config (APP_URL)
│   ├── config/
│   │   └── local/fixcity/xra.php # Theme config
│   ├── Modules/                   # Feature modules
│   │   ├── AI/
│   │   ├── Activity/
│   │   ├── Blog/
│   │   └── ...
│   └── Themes/                    # Frontend themes
│       ├── Sixteen/              # ✅ ACTIVE THEME
│       │   ├── app/
│       │   ├── resources/
│       │   ├── public/
│       │   └── docs/
│       └── TwentyOne/            # ⚠️ Inactive
│
├── docs/                          # 📚 PROJECT DOCUMENTATION
│   ├── README.md
│   ├── project/
│   ├── modules/
│   └── themes/
│
└── bashscripts/                   # 🔧 UTILITY SCRIPTS
    ├── docs/
    ├── ai/
    └── ...
```

## Paths Reference

### Absolute Paths

| Path | Description | Example |
|------|-------------|---------|
| `base_path()` | Project root | `/var/www/_bases/base_fixcity_fila5/` |
| `base_path('public_html')` | Document root | `.../public_html/` |
| `base_path('laravel')` | Laravel app | `.../laravel/` |
| `base_path('laravel/Themes/Sixteen')` | Active theme | `.../laravel/Themes/Sixteen/` |
| `base_path('laravel/Modules')` | Modules | `.../laravel/Modules/` |

### Relative to Theme

| Path | Description |
|------|-------------|
| `app/` | Theme PHP classes |
| `resources/views/` | Blade templates |
| `resources/js/` | JavaScript files |
| `resources/css/` | CSS/SCSS files |
| `public/` | Theme assets (compiled to public_html/assets/) |
| `docs/` | Theme documentation |

## Environment Variables

### Critical Variables

```bash
# laravel/.env

APP_NAME=Laravel
APP_ENV=local
APP_DEBUG=true
APP_URL=http://fixcity.local          # ← Used for theme detection

DB_CONNECTION=sqlite
DB_DATABASE=fixcity_data

# Theme-specific
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
```

## Documentation Guidelines

### DRY (Don't Repeat Yourself)

- **Project-wide docs**: `docs/`
- **Module-specific docs**: `laravel/Modules/*/docs/`
- **Theme-specific docs**: `laravel/Themes/Sixteen/docs/`
- **Cross-reference**: Use links, not copies

### KISS (Keep It Simple, Stupid)

- **Essential only**: Remove nice-to-have docs
- **Flat structure**: Max 3 levels of nesting
- **Clear naming**: Descriptive filenames
- **Single purpose**: One topic per file

### File Naming

✅ **CORRECT**:
- `configuration.md` (lowercase, kebab-case)
- `00-index.md` (numeric prefix for ordering)
- `README.md` (standard)

❌ **WRONG**:
- `Configuration.md` (PascalCase)
- `2026-03-30-update.md` (date in filename)
- `temp.md` (non-descriptive)

## Related Documentation

- [Documentation Reorganization Architecture](_bmad/bmm/3-solutioning/docs-reorganization-architecture.md)
- [Docs Reorganization PRD](_bmad/bmm/2-plan/docs-reorganization-prd.json)
- [Find Duplicates Script](bashscripts/docs/find-doc-duplicates.sh)

---

**Maintenance**: Update this file when APP_URL or theme configuration changes
