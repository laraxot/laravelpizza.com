# Static HTML Deployment Workflow

## Overview

The Meetup theme supports **dual deployment**:
1. **Static HTML prototype** - Standalone HTML/CSS/JS files
2. **Laravel integration** - Blade templates with Livewire/Volt

## Static HTML Workflow

### Purpose

The static HTML version allows:
- ✅ Independent preview without Laravel
- ✅ Design approval from stakeholders
- ✅ Frontend development isolation
- ✅ Faster iteration during design phase
- ✅ Accessible via direct URL

### Build Commands

**Location**: `/var/www/_bases/base_laravelpizza/laravel/Themes/Meetup`

```bash
cd /var/www/_bases/base_laravelpizza/laravel/Themes/Meetup

# Build static HTML assets
npm run build

# Copy to public web directory
npm run copy
```

### What Happens

#### 1. `npm run build`

**Script**: `vite build`

**Process**:
1. Runs Vite build on `resources/css/app.css` and `resources/js/app.js`
2. Outputs compiled assets to `./public/`
3. Creates `manifest.json` for asset mapping

**Vite Config**: `Themes/Meetup/vite.config.js`

```javascript
{
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
        }),
    ],
    build: {
        outDir: './public',           // ← Outputs here!
        emptyOutDir: false,
        manifest: 'manifest.json',
    }
}
```

**Output**:
```
Themes/Meetup/public/
├── assets/
│   ├── app-[hash].css    # Compiled, minified CSS
│   └── app-[hash].js     # Compiled, minified JS
└── manifest.json         # Vite manifest
```

**CRITICAL**: Vite outputs to `./public/` NOT `resources/html/dist/`

#### 2. `npm run copy`

**Script**: `cp -r ./public/* ../../../public_html/themes/Meetup`

**Source**: `Themes/Meetup/public/*`

**Destination**: `/var/www/_bases/base_laravelpizza/public_html/themes/Meetup`

**Result**: Static HTML files accessible via web server

### Access URLs

After build and copy:

**Static HTML**: `https://yourdomain.com/themes/Meetup/index.html`

**Laravel App**: `https://yourdomain.com/` (or `/it`, `/en`, etc.)

## Complete Workflow

### Phase 1: Design (Static HTML)

```bash
cd Themes/Meetup

# Install dependencies
npm install

# Start development server
npm run dev  # Runs on port 5173

# Edit files in resources/html/
# - index.html
# - css/app.css
# - js/app.js
```

### Phase 2: Build Static

```bash
# Build static assets
npm run build

# Copy to public directory
npm run copy
```

**Result**: Static site available at `/themes/Meetup/`

### Phase 3: Laravel Integration

```bash
# Copy CSS from static HTML to Laravel resources
cp resources/html/css/app.css resources/css/app.css

# Copy JS from static HTML to Laravel resources
cp resources/html/js/app.js resources/js/app.js

# Build for Laravel (from root)
cd ../..
npm run build

# Clear caches
php artisan optimize:clear
```

**Result**: Laravel app uses theme styles

## Directory Structure

```
Themes/Meetup/
├── package.json           # Theme npm config
├── vite.config.js        # Theme Vite build config
├── tailwind.config.js    # Shared Tailwind config
├── public/               # BUILD OUTPUT - deployed to web server ← DEPLOY THIS
│   ├── assets/          # Vite compiled CSS/JS (with hashes)
│   └── manifest.json    # Vite manifest
├── resources/
│   ├── html/            # Static HTML prototypes (optional)
│   │   ├── index.html
│   │   ├── css/app.css
│   │   └── js/app.js
│   ├── css/             # Laravel CSS SOURCE (built by Vite) ← SOURCE
│   │   └── app.css
│   ├── js/              # Laravel JS SOURCE (built by Vite) ← SOURCE
│   │   └── app.js
│   └── views/           # Blade templates
└── docs/                # Documentation
```

**Key Understanding**:
- `resources/css/` and `resources/js/` = SOURCE files
- `public/` = BUILD OUTPUT (compiled, minified, hashed)
- `npm run build` reads SOURCE, writes to OUTPUT
- `npm run copy` deploys OUTPUT to web server

## NPM Scripts Reference

```json
{
  "scripts": {
    "dev": "vite",                                          // Dev server for theme assets
    "build": "vite build",                                 // Build theme assets to ./public/
    "preview": "vite preview",                             // Preview built site
    "copy": "cp -r ./public/* ../../../public_html/themes/Meetup"  // Deploy ./public/* to web server
  }
}
```

**Critical**: The `copy` command MUST use `./public/*` as source, NOT `./resources/html/dist/*`

## When to Use Each Command

### `npm run dev`
- **Use when**: Developing static HTML prototype
- **Starts**: Vite dev server on port 5173
- **Live reload**: Yes
- **HMR**: Yes (Hot Module Replacement)

### `npm run build`
- **Use when**: Ready to deploy static HTML
- **Output**: Optimized, minified files
- **Source maps**: Production mode

### `npm run copy`
- **Use when**: Deploying static HTML to web server
- **Requires**: `npm run build` must be run first
- **Copies**: All files from `./public/` to public web directory

### Laravel Build (from root)
- **Use when**: Integrating theme with Laravel app
- **Command**: `cd ../.. && npm run build`
- **Compiles**: `resources/css/app.css` and `resources/js/app.js`
- **Output**: `public/build/assets/`

## Troubleshooting

### Issue: Copy Command Fails

**Error**: `cp: cannot create directory`

**Cause**: Destination directory doesn't exist

**Solution**:
```bash
mkdir -p /var/www/_bases/base_laravelpizza/public_html/themes/Meetup
npm run copy
```

### Issue: Build Fails

**Error**: `Cannot find module 'typescript'`

**Solution**:
```bash
npm install
npm run build
```

### Issue: Static HTML Not Accessible

**Check**:
1. Files copied to correct location?
   ```bash
   ls -la /var/www/_bases/base_laravelpizza/public_html/themes/Meetup
   ```

2. Web server configured correctly?
   - Check Nginx/Apache config
   - Verify document root

3. File permissions correct?
   ```bash
   chmod -R 755 /var/www/_bases/base_laravelpizza/public_html/themes/Meetup
   ```

## Best Practices

### 1. Keep Static HTML Synced

After finalizing static HTML, always copy to Laravel resources:

```bash
# Copy CSS
cp resources/html/css/app.css resources/css/app.css

# Copy JS (but adapt for Laravel/Alpine.js)
cp resources/html/js/app.js resources/js/app.js
```

### 2. Version Control

Add to `.gitignore`:
```
Themes/Meetup/resources/html/dist/
Themes/Meetup/resources/html/node_modules/
```

Commit to Git:
```
Themes/Meetup/resources/html/css/app.css
Themes/Meetup/resources/html/js/app.js
Themes/Meetup/resources/html/index.html
```

### 3. Deployment Workflow

**Development**:
```bash
cd Themes/Meetup
npm run dev
```

**Staging** (static preview):
```bash
npm run build && npm run copy
```

**Production** (Laravel):
```bash
# Update Laravel resources
cp resources/html/css/app.css resources/css/app.css
cp resources/html/js/app.js resources/js/app.js

# Build for Laravel
cd ../..
npm run build
php artisan optimize:clear
```

## Summary

**Build Flow**:

```
resources/css/app.css + resources/js/app.js  (SOURCE)
    ↓
npm run build (Vite processes and compiles)
    ↓
public/assets/app-[hash].css + app-[hash].js  (OUTPUT)
    ↓
npm run copy (Deploys to web server)
    ↓
../../../public_html/themes/Meetup/  (DEPLOYED)
```

**Key Rules**:

1. ✅ **Source**: `resources/css/` and `resources/js/` contain the source files
2. ✅ **Output**: `public/` contains compiled, production-ready assets (configured in `vite.config.js` line 21: `outDir: './public'`)
3. ✅ **Deploy**: ALWAYS copy from `./public/*` NOT `./resources/html/dist/*`
4. ✅ **Why**: Vite outputs to `./public/` which follows standard web server conventions for publicly accessible files

**Commands**:

```bash
cd /var/www/_bases/base_laravelpizza/laravel/Themes/Meetup
npm run build      # Compiles resources/* → public/
npm run copy       # Deploys public/* → web server
```

**Laravel Integration** (separate build):

```bash
cd /var/www/_bases/base_laravelpizza/laravel
npm run build      # Uses ROOT vite.config.js
```

---

**Theme**: Meetup
**Changes**: Corrected build output path from `resources/html/dist/` to `public/`
