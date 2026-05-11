# Geo Module Vite Build Configuration

> Configurazione Vite 7.x + Tailwind 4.x per moduli Laraxot

---

## Stato Attuale

✅ **Build funzionante** - 2026-04-27

```bash
cd laravel/Modules/Geo
npm run build

> module_geo_fila5@0.0.0 build
> vite build

✓ 18 modules transformed
✓ built in 310ms
```

---

## File Configurazione

### package.json

```json
{
  "name": "module_geo_fila5",
  "version": "0.0.0",
  "type": "module",
  "scripts": {
    "dev": "vite",
    "build": "vite build",
    "copy": "cp -r ./public/* ../../../public_html/assets/geo"
  },
  "devDependencies": {
    "@tailwindcss/vite": "^4.0.0",
    "laravel-vite-plugin": "^2.0.0",
    "tailwindcss": "^4.0.0",
    "vite": "^7.0.7",
    "lit": "^3.3.2",
    "leaflet": "^1.9.4"
  }
}
```

**Key points**:
- `"type": "module"` - ESM required
- Vite 7.x - Latest stable
- Tailwind 4.x - Via Vite plugin
- `copy` script - Copia asset in public_html

---

### vite.config.js

```javascript
import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import { fileURLToPath } from 'url';
import { dirname, resolve } from 'path';

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);

export default defineConfig({
    build: {
        outDir: './public',
        emptyOutDir: false,
        manifest: "manifest.json",
        rollupOptions: {
            output: {
                // chunking ottimizzato
            },
        },
    },
    plugins: [
        laravel({
            publicDirectory: '../../../public_html',
            buildDirectory: 'assets/geo',
            input: [
                resolve(__dirname, 'resources/css/app.css'),
                resolve(__dirname, 'resources/js/app.js'),
                resolve(__dirname, 'resources/js/components/coordinate-picker-lit.js')
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
```

**Key points**:
- `outDir: './public'` - Build locale
- `manifest: "manifest.json"` - Per Laravel Vite helper
- `publicDirectory: '../../../public_html'` - Root del progetto
- `buildDirectory: 'assets/geo'` - Namespace per modulo

---

### AdminPanelProvider.php

```php
use Filament\Support\Facades\Filament;
use Filament\Support\Assets\Js;
use Filament\Support\Assets\Css;

public function panel(Panel $panel): Panel
{
    $panel = parent::panel($panel);

    FilamentAsset::register([
        Js::make('coordinate-picker', 
            Vite::asset('resources/js/components/coordinate-picker-lit.js', 'assets/geo')
        )->module(),
        Css::make('coordinate-picker', 
            Vite::asset('resources/css/app.css', 'assets/geo')
        ),
    ]);

    return $panel;
}
```

**Key points**:
- `Vite::asset()` con secondo parametro `buildDirectory`
- `->module()` per ES modules
- Nome asset: `coordinate-picker` (matcha view)

---

## Asset Generati

```
public/assets/
├── map-picker-marker-fallback-Bu_stv-I.svg
├── layers-BWBAp2CZ.png / layers-2x-Bpkbi35X.png
├── marker-icon-hN30_KVU.png
├── manifest.json                    # Required
├── app-x1XGuNl0.css               # Tailwind styles
├── map-picker-marker-config-BUYAHFr5.css
├── map-picker-lit-BVoo2y5c.js     # Map picker component
├── coordinate-picker-lit-Bw9QhFFw.js  # Coordinate picker
└── map-picker-marker-config-B86ZfQ_m.js # Config + Leaflet
```

---

## Workflow Sviluppo

### 1. Setup Iniziale

```bash
cd laravel/Modules/Geo
npm install
```

### 2. Development

```bash
npm run dev
# Vite dev server + HMR
```

### 3. Build Produzione

```bash
npm run build
# Genera public/assets/ + manifest.json
```

### 4. Copy to Public (opzionale)

```bash
npm run copy
# Copia in public_html/assets/geo/
```

---

## Pattern per Altri Moduli

### Struttura Consigliata

```
Modules/{Nome}/
├── package.json
├── vite.config.js
├── resources/
│   ├── js/
│   │   └── components/
│   └── css/
└── public/          # Build output (gitignored)
```

### Vite Config Template

```javascript
// vite.config.js
export default defineConfig({
    build: {
        outDir: './public',
        manifest: "manifest.json",
    },
    plugins: [
        laravel({
            publicDirectory: '../../../public_html',
            buildDirectory: 'assets/{nome}',
            input: [
                resolve(__dirname, 'resources/js/app.js'),
                resolve(__dirname, 'resources/css/app.css'),
            ],
        }),
        tailwindcss(),
    ],
});
```

---

## Troubleshooting

### "Cannot find module 'laravel-vite-plugin'"

```bash
npm install -D laravel-vite-plugin
```

### "manifest.json not found"

```bash
npm run build
# Verifica che public/manifest.json esista
```

### Asset 404 in browser

Verifica:
1. Build eseguito: `npm run build`
2. Path corretto in `Vite::asset()`
3. `publicDirectory` punta a `public_html`
4. `buildDirectory` matcha con URL

---

## Collegamenti

- [Vite Docs](https://vitejs.dev/)
- [Laravel Vite](https://laravel.com/docs/vite)
- [Tailwind 4.x](https://tailwindcss.com/)
- [Story 8-40](../../../.planning/stories/8-40-geo-module-vite-build-success.story.md)

---

**Data**: 2026-04-27
**Modulo**: Geo
**Stato**: ✅ Build funzionante
