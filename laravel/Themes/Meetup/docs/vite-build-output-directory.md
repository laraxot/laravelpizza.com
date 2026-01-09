# Vite Build Output Directory - Tema Meetup

## Data
2025-11-30

## ⚠️ IMPORTANTE - Configurazione Vite

Il tema Meetup usa `laravel-vite-plugin` che compila gli asset nella directory `./public/` del tema, **NON** in `resources/html/dist/`.

## Configurazione Vite

### vite.config.js

```javascript
import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin'

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: [...refreshPaths, 'app/Livewire/**'],
        }),
    ],
    build: {
        outDir: './public',  // ✅ Output nella directory public del tema
        emptyOutDir: false,
        manifest: 'manifest.json',
    },
});
```

**Punti Chiave:**
1. ✅ `outDir: './public'` - Vite compila gli asset in `Themes/Meetup/public/`
2. ✅ `laravel-vite-plugin` gestisce automaticamente il manifest e gli asset
3. ✅ Il manifest viene generato in `Themes/Meetup/public/manifest.json`

## Struttura Directory Corretta

```
Themes/Meetup/
├── resources/
│   ├── css/
│   │   └── app.css          # Source CSS
│   └── js/
│       └── app.js           # Source JS
├── public/                  # ✅ Output build (npm run build)
│   ├── assets/
│   │   ├── app-[hash].css   # CSS compilato
│   │   └── app-[hash].js    # JS compilato
│   └── manifest.json        # Manifest Vite
└── vite.config.js           # Configurazione Vite

public_html/
└── themes/
    └── Meetup/              # ✅ Output copy (npm run copy)
        ├── assets/
        │   ├── app-[hash].css
        │   └── app-[hash].js
        └── manifest.json
```

## Workflow Build e Copy

### 1. Build (`npm run build`)

```bash
cd /var/www/_bases/base_laravelpizza/laravel/Themes/Meetup
npm run build
```

**Output**: `Themes/Meetup/public/`
- `assets/app-[hash].css` - CSS compilato e minificato
- `assets/app-[hash].js` - JavaScript compilato e minificato
- `manifest.json` - Manifest Vite con mapping asset

### 2. Copy (`npm run copy`)

```bash
npm run copy
```

**Comando**: `cp -r ./public/* ../../../public_html/themes/Meetup`

**Cosa fa**:
- Copia tutti i file da `Themes/Meetup/public/` a `public_html/themes/Meetup/`
- Include `assets/` e `manifest.json`
- Rende gli asset accessibili via web

**Output**: `public_html/themes/Meetup/`

## Perché `./public/*` e Non `./resources/html/dist/*`?

### Configurazione Vite

Il `vite.config.js` del tema Meetup usa `laravel-vite-plugin` che:
1. **Compila gli asset** in `./public/` (configurato con `outDir: './public'`)
2. **Genera il manifest** in `./public/manifest.json`
3. **Gestisce automaticamente** il mapping degli asset per Laravel

### Differenza con Altri Temi/Moduli

Altri temi/moduli potrebbero usare configurazioni diverse:
- **Tema One**: `outDir: '../../public/build-one'` (output nella root Laravel)
- **Moduli**: `outDir: '../../public/build-module-name'` (output nella root Laravel)

Il tema Meetup usa invece:
- **Tema Meetup**: `outDir: './public'` (output locale nel tema)

### Vantaggi Output Locale

1. ✅ **Isolamento**: Gli asset del tema sono isolati nella directory del tema
2. ✅ **Portabilità**: Il tema può essere spostato facilmente
3. ✅ **Separazione**: Nessun conflitto con asset di altri temi/moduli
4. ✅ **Copy semplice**: Un solo comando copia tutto nella directory pubblica

## Comando Copy Corretto

### package.json

```json
{
  "scripts": {
    "build": "tsc && vite build",
    "copy": "cp -r ./public/* ../../../public_html/themes/Meetup"
  }
}
```

**Spiegazione Path**:
- `./public/*` - Source: directory `public/` del tema (relativo a `Themes/Meetup/`)
- `../../../public_html/themes/Meetup` - Destination:
  - `../` → `laravel/`
  - `../../` → `_bases/`
  - `../../../` → `base_laravelpizza/`
  - `../../../public_html/themes/Meetup` → `base_laravelpizza/public_html/themes/Meetup`

## Verifica

### Dopo Build

```bash
cd /var/www/_bases/base_laravelpizza/laravel/Themes/Meetup
ls -la public/
# Dovresti vedere:
# - assets/ (directory con CSS/JS compilati)
# - manifest.json
```

### Dopo Copy

```bash
ls -la /var/www/_bases/base_laravelpizza/public_html/themes/Meetup/
# Dovresti vedere gli stessi file copiati
```

### Test Accesso Web

```bash
# Verifica che gli asset siano accessibili
curl http://127.0.0.1:8000/themes/Meetup/assets/app-[hash].css
# Dovresti ricevere il CSS compilato
```

## Troubleshooting

### Problema: `npm run copy` fallisce con "No such file or directory"

**Causa**: Directory `public_html/themes/Meetup/` non esiste

**Soluzione**:
```bash
mkdir -p /var/www/_bases/base_laravelpizza/public_html/themes/Meetup
npm run copy
```

### Problema: Asset non trovati dopo copy

**Causa**: Path errati o directory non creata

**Verifica**:
```bash
# Verifica source
ls -la /var/www/_bases/base_laravelpizza/laravel/Themes/Meetup/public/

# Verifica destination
ls -la /var/www/_bases/base_laravelpizza/public_html/themes/Meetup/
```

### Problema: Manifest non trovato

**Causa**: Build non completato o manifest non generato

**Soluzione**:
```bash
# Ricompila
npm run build
# Verifica manifest
ls -la public/manifest.json
```

## Best Practices

1. ✅ **Sempre eseguire dalla directory del tema**: `cd Themes/Meetup`
2. ✅ **Build prima di copy**: `npm run build && npm run copy`
3. ✅ **Verificare output**: Controllare che `public/` contenga gli asset dopo build
4. ✅ **Verificare copy**: Controllare che `public_html/themes/Meetup/` contenga gli asset dopo copy
5. ✅ **Non modificare manualmente**: Non modificare manualmente gli asset in `public/`, sempre ricompilare

## Riferimenti

- `Themes/Meetup/vite.config.js` - Configurazione Vite
- `Themes/Meetup/package.json` - Scripts NPM
- `Themes/Meetup/docs/build-and-copy-workflow.md` - Workflow completo
- `Themes/Meetup/docs/npm-commands-execution-rule.md` - Regola esecuzione comandi

## Checklist

- [x] Documentata configurazione Vite corretta
- [x] Spiegato perché `./public/*` e non `./resources/html/dist/*`
- [x] Documentata struttura directory corretta
- [x] Aggiunto troubleshooting
- [x] Aggiunte best practices
