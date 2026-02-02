# Theme Development Rules - Laravel Pizza Meetups

## 0. Theme Discovery (How to find the active theme)

**Rule**: The active theme is dynamically determined by the application state and environment.

1.  **Environment**: Check `.env` for `APP_URL` (defines the tenant/site).
2.  **Config Directory**: Configs are located in `laravel/config/local/{site_name}/` (e.g., `laravel/config/local/laravelpizza/`).
3.  **Active Theme**: Open `xra.php` and look for the `'pub_theme'` key (e.g., `'Meetup'`).
4.  **Physical Path**: Themes are located in `laravel/Themes/{ThemeName}/`.

## Critical Rules (MUST FOLLOW)

### 1. Custom Public Directory Path

**Rule**: This application uses a custom `App\Application` class that overrides `publicPath()`.

```php
// bootstrap/app.php
return Application::configure(basePath: dirname(__DIR__))
    // ...
```

**Implications**:
- Public directory is at `../public_html/` NOT `public/`
- Theme assets MUST be copied to `public_html/themes/Meetup/`
- Copy command: `cp -r ./public/* ../../../public_html/themes/Meetup`

### 2. Vite Theme Path Parameter

**Rule**: When using `@vite()` directive in theme layouts, the second parameter is REQUIRED.

```blade
<!-- ❌ WRONG -->
@vite(['resources/css/app.css', 'resources/js/app.js'])

<!-- ✅ CORRECT -->
@vite(['resources/css/app.css', 'resources/js/app.js'], 'themes/Meetup')
```

**Why**: Without the second parameter, Laravel looks for assets in the wrong location.

### 3. Asset Build Workflow

**Rule**: After modifying CSS or JavaScript, ALWAYS run build and copy.

```bash
cd /var/www/_bases/base_laravelpizza/laravel/Themes/Meetup
npm run build && npm run copy
```

**Why**: Changes are not visible until:
1. Vite compiles the assets (`npm run build`)
2. Assets are copied to public directory (`npm run copy`)

### 4. NPM Commands Directory

**Rule**: NPM commands MUST be run from theme directory, NOT laravel root.

```bash
# ❌ WRONG
cd /var/www/_bases/base_laravelpizza/laravel
npm install

# ✅ CORRECT
cd /var/www/_bases/base_laravelpizza/laravel/Themes/Meetup
npm install
```

**Why**: The theme has its own `package.json` with theme-specific build configuration.

### 5. Metatags Component Structure

**Rule**: The `<x-metatags>` component already includes the `<head>` tag.

```blade
<!-- ❌ WRONG - Duplicate head tag -->
<html>
<head>
    <x-metatags />
</head>
<body>...</body>
</html>

<!-- ✅ CORRECT - Metatags provides head tag -->
<html>
    <x-metatags>
        <!-- Additional head content goes in slot -->
    </x-metatags>
    <body>...</body>
</html>
```

**Why**: The metatags component includes `<head>`, meta tags, and `@vite()` directive.

### 6. JSON-LD Schema in Blade

**Rule**: Use `@verbatim` directive for JSON-LD structured data.

```blade
<!-- ❌ WRONG - Blade will try to parse @context -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization"
}
</script>

<!-- ✅ CORRECT - Verbatim prevents Blade parsing -->
@verbatim
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization"
}
</script>
@endverbatim
```

**Why**: The `@` symbol in JSON-LD conflicts with Blade syntax.

### 7. TypeScript in Build Script

**Rule**: Do NOT include TypeScript compilation in build script if not using TypeScript.

```json
// ❌ WRONG
{
  "scripts": {
    "build": "tsc && vite build"
  }
}

// ✅ CORRECT
{
  "scripts": {
    "build": "vite build"
  }
}
```

**Why**: TypeScript compilation will fail if no TypeScript files exist.

## Theme Architecture

### File Structure

```
Themes/Meetup/
├── resources/
│   ├── views/
│   │   ├── components/
│   │   │   ├── layouts/
│   │   │   │   └── main.blade.php (main layout)
│   │   │   └── blocks/
│   │   │       ├── hero/main.blade.php
│   │   │       ├── features/grid.blade.php
│   │   │       ├── stats/overview.blade.php
│   │   │       ├── testimonials/carousel.blade.php
│   │   │       ├── cta/banner.blade.php
│   │   │       └── sidebar/*.blade.php
│   │   └── pages/
│   │       └── index.blade.php (Folio page)
│   ├── css/
│   │   └── app.css (Tailwind CSS config)
│   ├── js/
│   │   └── app.js (JavaScript functionality)
│   └── html/ (static HTML prototype)
├── public/ (Vite build output - temporary)
├── docs/ (documentation)
├── package.json (theme dependencies & build scripts)
├── vite.config.ts (Vite configuration)
└── tailwind.config.js (Tailwind configuration)
```

### Content Configuration

**Location**: `config/local/laravelpizza/database/content/pages/home.json`

**Structure**:
```json
{
    "slug": "home",
    "content_blocks": {
        "it": [
            {
                "type": "hero",
                "data": {
                    "view": "pub_theme::components.blocks.hero.main",
                    "title": "Laravel Developers. Pizza. Community."
                }
            }
        ]
    }
}
```

**View Resolution**: `pub_theme::` → `Themes/Meetup/resources/views/`

## Design System

### Colors

**Primary**: Red (Pizza/Meetup Brand)
- `red-500`: #ef4444
- `red-600`: #dc2626
- `red-700`: #b91c1c

**Background**: Slate (Dark Theme)
- `slate-900`: #0f172a (main background)
- `slate-800`: #1e293b (cards, navigation)
- `slate-700`: #334155 (borders)

**Text**:
- White: Primary text on dark background
- `gray-300`: Secondary text
- `gray-400`: Tertiary text

### Components

**Button Primary**:
```css
.btn-primary {
    @apply bg-red-600 text-white px-6 py-3 rounded-lg font-semibold;
    @apply hover:bg-red-700 focus:outline-none;
    @apply focus:ring-2 focus:ring-red-500 focus:ring-offset-2;
}
```

**Feature Card**:
```css
.feature-card {
    @apply bg-slate-800/50 backdrop-blur-sm border border-slate-700 rounded-xl p-8;
    @apply hover:border-red-500/50 transition-colors duration-200;
}
```

**Event Card**:
```css
.event-card {
    @apply bg-slate-800 border border-slate-700 rounded-xl overflow-hidden;
    @apply hover:border-red-500/50 transition-all duration-300;
}
```

## Development Workflow

### Initial Setup

```bash
# 1. Navigate to theme directory
cd /var/www/_bases/base_laravelpizza/laravel/Themes/Meetup

# 2. Install dependencies
npm install

# 3. Build assets
npm run build

# 4. Copy to public directory
npm run copy
```

### Development Cycle

```bash
# 1. Make changes to resources/css/app.css or resources/js/app.js

# 2. Rebuild and copy
npm run build && npm run copy

# 3. Clear Laravel cache (if needed)
cd /var/www/_bases/base_laravelpizza/laravel
php artisan view:clear
php artisan cache:clear

# 4. Test at http://127.0.0.1:8000/it
```

### Watch Mode (Development)

```bash
cd /var/www/_bases/base_laravelpizza/laravel/Themes/Meetup
npm run dev
```

**Note**: Watch mode runs Vite dev server but still requires `npm run copy` after changes.

## Troubleshooting

### Assets Not Loading

**Symptom**: Styles or JavaScript not working

**Check**:
1. Did you run `npm run build && npm run copy`?
2. Is the `@vite()` second parameter correct? (`'themes/Meetup'`)
3. Are assets in `public_html/themes/Meetup/assets/`?

**Fix**:
```bash
cd /var/www/_bases/base_laravelpizza/laravel/Themes/Meetup
npm run build && npm run copy
```

### View Not Found

**Symptom**: `View [pub_theme::components.blocks.hero.main] not found`

**Check**:
1. Does the blade file exist at `Themes/Meetup/resources/views/components/blocks/hero/main.blade.php`?
2. Is the view path correct in `home.json`?

**Fix**: Create the missing blade component file.

### Duplicate Head Tag Error

**Symptom**: ParseError or HTML validation errors

**Check**: Are you wrapping `<x-metatags>` in a `<head>` tag?

**Fix**: Remove the wrapping `<head>` tag.

### Build Fails with TypeScript Error

**Symptom**: `tsc: command not found` or TypeScript compilation errors

**Check**: Is `tsc &&` in the build script when you're not using TypeScript?

**Fix**: Remove `tsc &&` from package.json build script.

## 8. Philosophical Approach: separation of concerns

**Concept**: The theme is a distinct entity from the business logic.

- **Modularity**: Themes reside in `laravel/Themes/`, isolated from `laravel/app/` and `laravel/Modules/`.
- **Knowledge Base**: Always study the `docs/` folder within the theme and its associated modules *before* starting work.
- **Continuous Documentation**: Update the `docs/` content immediately after implementation to preserve architectural intent.
- **Critical Thinking**: Approach UI/UX changes not just as code tasks, but as part of a philosophical alignment with the "Laraxot" methodology.

## References

- **Implementation Log**: `docs/2025-11-30-implementation-log.md`
- **Build System**: `docs/theme-build-system.md`
- **Static Prototype**: `resources/html/` (working reference implementation)
- **Vite Config**: `vite.config.ts`
- **Tailwind Config**: `tailwind.config.js`

## Quick Reference

| Task | Command | Location |
|------|---------|----------|
| Install dependencies | `npm install` | Theme directory |
| Build assets | `npm run build` | Theme directory |
| Copy to public | `npm run copy` | Theme directory |
| Build + Copy | `npm run build && npm run copy` | Theme directory |
| Watch mode | `npm run dev` | Theme directory |
| Clear cache | `php artisan view:clear && php artisan cache:clear` | Laravel root |
| Test homepage | Browse to `http://127.0.0.1:8000/it` | - |
