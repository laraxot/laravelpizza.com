# Theme Asset Build System

## Overview

The Meetup theme has a dual asset build system to support both static HTML prototyping and Laravel integration.

## The Two Build Systems

### 1. Static HTML Build (`resources/html/`)

**Purpose**: Build standalone static HTML prototypes for design and testing

**Location**: `Themes/Meetup/resources/html/`

**Config**: `Themes/Meetup/vite.config.js`

**Commands** (run from `Themes/Meetup/` directory):
```bash
cd /var/www/_bases/base_laravelpizza/laravel/Themes/Meetup
npm install    # Install theme-specific dependencies
npm run dev    # Start development server
npm run build  # Build static assets to resources/html/dist/
```

**Output**: Static HTML files in `resources/html/dist/`

**Vite Config**:
```javascript
{
    root: 'resources/html',
    build: {
        outDir: 'resources/html/dist',
    }
}
```

### 2. Laravel Integration Build (`resources/css` & `resources/js`)

**Purpose**: Compile theme assets for use in Laravel Blade templates

**Location**: `Themes/Meetup/resources/css/` and `Themes/Meetup/resources/js/`

**Config**: `/laravel/vite.config.js` (root)

**Commands** (run from Laravel root):
```bash
cd /var/www/_bases/base_laravelpizza/laravel
npm install        # Install Laravel dependencies
npm run build      # Build all assets including themes
```

**Output**: Compiled assets in `/laravel/public/build/`

**Root Vite Config**:
```javascript
laravel({
    input: [
        'resources/css/app.css',
        'resources/js/app.js',
        'Themes/Meetup/resources/css/app.css',
        'Themes/Meetup/resources/js/app.js',
    ],
    buildDirectory: 'build',
})
```

**Blade Usage**:
```blade
{{-- In Themes/Meetup/resources/views/components/layouts/main.blade.php --}}
@vite([
    'Themes/Meetup/resources/css/app.css',
    'Themes/Meetup/resources/js/app.js'
], 'themes/Meetup')
```

## The Critical Rule

**IMPORTANT**: For Laravel integration, assets MUST be in:
- `Themes/Meetup/resources/css/app.css` (NOT `resources/html/css/app.css`)
- `Themes/Meetup/resources/js/app.js` (NOT `resources/html/js/app.js`)

## Why Two Separate Systems?

1. **Static HTML (`resources/html/`)**:
   - Rapid prototyping without Laravel
   - Design approval and testing
   - Can be deployed as static site
   - Uses its own package.json and dependencies

2. **Laravel Integration (`resources/css` & `resources/js`)**:
   - Compiled via root Vite for Laravel
   - Includes Laravel-specific features (Alpine.js with Livewire)
   - Integrated with Blade components
   - Uses root package.json dependencies

## Workflow

### Step 1: Design Phase (Static HTML)

Work in `resources/html/`:

```bash
cd Themes/Meetup
npm run dev  # Start static server on port 5173
```

Edit files:
- `resources/html/index.html`
- `resources/html/css/app.css`
- `resources/html/js/app.js`

### Step 2: Laravel Integration

Copy finalized styles and scripts to Laravel resources:

```bash
# Copy CSS from static HTML to Laravel resources
cp resources/html/css/app.css resources/css/app.css

# Copy JS from static HTML to Laravel resources
cp resources/html/js/app.js resources/js/app.js
```

### Step 3: Build for Laravel

From Laravel root:

```bash
cd /var/www/_bases/base_laravelpizza/laravel
npm run build
```

This compiles:
- `Themes/Meetup/resources/css/app.css` → `public/build/assets/meetup-css-[hash].css`
- `Themes/Meetup/resources/js/app.js` → `public/build/assets/meetup-js-[hash].js`

## File Structure

```
Themes/Meetup/
├── package.json              # Theme-specific dependencies (for static HTML)
├── vite.config.js           # Static HTML build config
├── tailwind.config.js       # Tailwind config (shared)
└── resources/
    ├── html/                # Static HTML prototypes
    │   ├── css/
    │   │   └── app.css     # Static HTML styles
    │   ├── js/
    │   │   └── app.js      # Static HTML scripts
    │   ├── index.html
    │   └── dist/           # Built static files
    ├── css/                # Laravel CSS (compiled by root Vite)
    │   └── app.css         # ← THIS is used by Laravel
    ├── js/                 # Laravel JS (compiled by root Vite)
    │   └── app.js          # ← THIS is used by Laravel
    └── views/              # Blade templates
        └── components/
            └── layouts/
                └── main.blade.php  # Uses @vite()
```

## Dependencies

### Theme `package.json` (Static HTML)

Located in `Themes/Meetup/package.json`:

```json
{
  "devDependencies": {
    "vite": "^7.0.7",
    "tailwindcss": "^4.1.13",
    "@tailwindcss/vite": "^4.1.13",
    "alpinejs": "^3.15.0"
  }
}
```

### Root `package.json` (Laravel)

Located in `/laravel/package.json`:

```json
{
  "devDependencies": {
    "laravel-vite-plugin": "^2.0.0",
    "vite": "^7.0.6",
    "@tailwindcss/vite": "^4.1.13"
  }
}
```

## Tailwind CSS 4

Both systems use Tailwind CSS 4 with `@theme` syntax:

```css
@import 'tailwindcss';

@source '../views';  /* Scan Blade files */

@theme {
    --font-sans: 'Inter', ui-sans-serif, system-ui, sans-serif;
    --color-red-600: #dc2626;
    --color-slate-900: #0f172a;
}
```

## Common Issues

### Issue 1: Assets Not Found

**Symptom**: `View pub_theme::components.blocks.hero.main not found`

**Cause**: Assets not compiled or cached

**Solution**:
```bash
cd /var/www/_bases/base_laravelpizza/laravel
npm run build
php artisan view:clear
php artisan optimize:clear
```

### Issue 2: Wrong Vite Config

**Symptom**: Build succeeds but styles don't apply

**Cause**: Root vite.config.js pointing to wrong directory

**Check**: Ensure root vite.config.js has:
```javascript
'Themes/Meetup/resources/css/app.css'  // ✅ CORRECT
// NOT:
'Themes/Meetup/resources/html/css/app.css'  // ❌ WRONG
```

### Issue 3: Missing Dependencies

**Symptom**: `Error: Cannot find module 'alpinejs'`

**Cause**: Dependencies not installed in Laravel root

**Solution**:
```bash
cd /var/www/_bases/base_laravelpizza/laravel
npm install alpinejs --save-dev
npm run build
```

## Best Practices

1. **Always develop static HTML first** in `resources/html/`
2. **Copy finalized assets** to `resources/css` and `resources/js` for Laravel
3. **Run builds from correct directory**:
   - Static HTML: `cd Themes/Meetup && npm run build`
   - Laravel: `cd /laravel && npm run build`
4. **Clear caches** after each build: `php artisan optimize:clear`
5. **Keep static HTML in sync** with Laravel resources for reference

## Documentation References

- [Frontend Asset Management](frontend-asset-management.md)
- [Vite Theme Asset Loading Fix](vite-theme-asset-loading-fix.md)
- [Block Components Structure](block-components-structure.md)

---

**Theme**: Meetup
