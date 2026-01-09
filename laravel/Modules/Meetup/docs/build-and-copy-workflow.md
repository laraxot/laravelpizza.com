# Build e Copy Workflow - Tema Meetup

## Data
2025-11-29

## Panoramica

Il workflow di build e copy per il tema Meetup consiste in due passaggi:
1. **`npm run build`**: Compila gli asset CSS/JS con Vite
2. **`npm run copy`**: Copia gli asset compilati nella directory pubblica dove Laravel può servirli

## Perché Eseguire Questi Comandi?

### 1. `npm run build`

**Scopo**: Compila gli asset frontend (CSS, JS) per la produzione.

**Cosa fa**:
- Esegue TypeScript compiler (`tsc`) per verificare errori TypeScript
- Esegue Vite build che:
  - Compila Tailwind CSS in CSS ottimizzato
  - Bundle JavaScript con tree-shaking
  - Minifica e ottimizza gli asset
  - Output in `./public/` (come configurato in `vite.config.js` con `outDir: './public'`)

**Output**: `Themes/Meetup/public/`
- `assets/app-[hash].css` - CSS compilato e minificato
- `assets/app-[hash].js` - JavaScript compilato e minificato
- `manifest.json` - Manifest Vite con mapping asset

### 2. `npm run copy`

**Scopo**: Copia gli asset compilati nella directory pubblica accessibile da Laravel.

**Cosa fa**:
- Copia tutti i file da `Themes/Meetup/public/*` a `public_html/themes/Meetup/`
- Include `assets/` directory e `manifest.json`
- Rende gli asset accessibili via web (es. `/themes/Meetup/assets/app-[hash].css`)

**Output**: `public_html/themes/Meetup/`

## Configurazione

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

### package.json Scripts

```json
{
  "scripts": {
    "dev": "vite",                    // Sviluppo con hot reload
    "build": "tsc && vite build",     // Build produzione
    "copy": "cp -r ./public/* ../../../public_html/themes/Meetup"  // Copia asset
  }
}
```

## Workflow Completo

### Sviluppo

```bash
cd /var/www/_bases/base_laravelpizza/laravel/Themes/Meetup
npm run dev  # Hot reload, nessun copy necessario
```

### Produzione

```bash
cd /var/www/_bases/base_laravelpizza/laravel/Themes/Meetup
npm run build  # Compila asset
npm run copy   # Copia nella directory pubblica
```

### Workflow Combinato

```bash
cd /var/www/_bases/base_laravelpizza/laravel/Themes/Meetup
npm run build && npm run copy  # Esegue entrambi in sequenza
```

## Struttura Directory

```
Themes/Meetup/
├── resources/
│   └── html/
│       ├── css/app.css          # Source CSS
│       ├── js/app.js            # Source JS
│       └── dist/                # ✅ Output build (npm run build)
│           ├── css/app.css      # CSS compilato
│           └── js/main.js       # JS compilato
├── public/                      # Asset pubblici del tema
│   └── (immagini, font, etc.)
└── vite.config.js               # Configurazione Vite

public_html/
└── themes/
    └── Meetup/                  # ✅ Output copy (npm run copy)
        ├── css/
        ├── js/
        └── (altri asset)
```

## Perché Due Passaggi?

### Separazione Responsabilità

1. **Build**: Compilazione e ottimizzazione (Vite)
2. **Copy**: Distribuzione nella directory pubblica (Laravel)

### Vantaggi

- ✅ **Isolamento**: Build separata dalla distribuzione
- ✅ **Flessibilità**: Puoi modificare il copy senza rifare il build
- ✅ **Versioning**: Puoi mantenere versioni diverse degli asset
- ✅ **Testing**: Puoi testare il build prima di copiarlo

## Verifica

### Dopo `npm run build`

```bash
# Verifica che gli asset siano stati compilati
ls -la Themes/Meetup/public/
# Dovresti vedere: assets/ directory e manifest.json
```

### Dopo `npm run copy`

```bash
# Verifica che gli asset siano stati copiati
ls -la public_html/themes/Meetup/
# Dovresti vedere gli asset copiati
```

### Test Accesso Web

```bash
# Verifica che gli asset siano accessibili via web
# (sostituisci [hash] con l'hash reale dal manifest.json)
curl http://127.0.0.1:8000/themes/Meetup/assets/app-[hash].css
# Dovresti ricevere il CSS compilato
```

## Troubleshooting

### Problema: `npm run copy` fallisce

**Causa**: Directory `public_html/themes/Meetup/` non esiste

**Soluzione**:
```bash
mkdir -p public_html/themes/Meetup
npm run copy
```

### Problema: Asset non aggiornati

**Causa**: Cache browser o asset non copiati

**Soluzione**:
```bash
# Ricompila e ricopia
npm run build && npm run copy
# Pulisci cache browser (Ctrl+Shift+R)
```

### Problema: Path errati nello script copy

**Causa**: Path relativi non corretti

**Verifica**:
```bash
# Dalla directory Themes/Meetup/
pwd  # Dovrebbe essere: .../laravel/Themes/Meetup
ls -la public/  # Verifica che esista
ls -la ../../../public_html/themes/Meetup  # Verifica destinazione
```

## Best Practices

1. ✅ **Sempre eseguire dalla directory del tema**: `cd Themes/Meetup`
2. ✅ **Build prima di copy**: `npm run build && npm run copy`
3. ✅ **Verificare output**: Controllare che gli asset siano stati compilati e copiati
4. ✅ **Versioning**: Considerare versioning degli asset per cache busting
5. ✅ **Automazione**: Usare script helper per automatizzare il processo

## Script Helper (Opzionale)

```bash
#!/bin/bash
# build-and-copy.sh
cd /var/www/_bases/base_laravelpizza/laravel/Themes/Meetup
npm run build && npm run copy
echo "✅ Build e copy completati!"
```

## Riferimenti

- `Themes/Meetup/vite.config.js` - Configurazione Vite
- `Themes/Meetup/package.json` - Scripts NPM
- `Themes/Meetup/docs/npm-commands-execution-rule.md` - Regola esecuzione comandi
- `Themes/Meetup/docs/frontend-asset-management.md` - Gestione asset frontend

## Checklist

- [x] Documentato workflow build e copy
- [x] Spiegato perché (separazione responsabilità, flessibilità)
- [x] Documentata struttura directory
- [x] Aggiunto troubleshooting
- [x] Aggiunte best practices
