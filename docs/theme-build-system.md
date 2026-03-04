# Theme Build System - Vite Configuration

## Critical Rules

### 1. @vite() Directive - Theme Path Parameter
**CRITICAL**: When using `@vite()` in theme layouts, you MUST specify the second parameter to indicate the theme directory:

```blade
@vite(['resources/css/app.css', 'resources/js/app.js'], 'themes/Meetup')
```

**Why?** The second parameter tells Laravel where to find the Vite manifest and compiled assets.
Without it, Laravel looks in `laravel/public/build/` instead of `Themes/Meetup/public/build/`.

### 2. Rebuild After Changes
**CRITICAL**: After modifying CSS or JavaScript files, you MUST rebuild and copy assets to see changes:

```bash
cd /var/www/_bases/base_laravelpizza/laravel/Themes/Meetup
npm run build && npm run copy
```

**Why?** Changes to `resources/css/app.css` and `resources/js/app.js` are not immediately visible. Vite must:
1. Compile the assets (`npm run build`)
2. Copy them to the public directory (`npm run copy`)

Then refresh your browser to see changes at http://127.0.0.1:8000/it

## Build Commands

**MUST** be run from theme directory:

```bash
cd /var/www/_bases/base_laravelpizza/laravel/Themes/Meetup
npm install    # First time only
npm run dev    # Development (watch)
npm run build  # Production (vite build)
npm run copy   # Copy assets to public_html
```

## Build Configuration

The theme uses `laravel-vite-plugin` and outputs built assets to `./public` (relative to theme root).

### Copy Command Path Logic

The `npm run copy` command is:
```bash
cp -r ./public/* ../../../public_html/themes/Meetup
```

**Why this path?**
- Current directory: `/var/www/_bases/base_laravelpizza/laravel/Themes/Meetup`
- Source: `./public/*` (theme's built assets)
- Destination: `../../../public_html/themes/Meetup`

Path breakdown from theme directory:
1. `../` → `/var/www/_bases/base_laravelpizza/laravel/Themes`
2. `../../` → `/var/www/_bases/base_laravelpizza/laravel`
3. `../../../` → `/var/www/_bases/base_laravelpizza`
4. `../../../public_html/` → `/var/www/_bases/base_laravelpizza/public_html`

**Critical**: This application uses a custom `App\Application` class that overrides `publicPath()` to return `../public_html/` instead of the default `public/`. Theme assets MUST be copied to this custom public directory.

## Common Mistakes

❌ Running npm from laravel root directory
✅ Always cd to Themes/Meetup first

❌ Copying to `public/` directory
✅ Copy to `public_html/` (custom public path)

❌ Including TypeScript compilation in build
✅ Use only `vite build` (no tsc)
