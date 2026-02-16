# Regola Generale: Esecuzione Comandi NPM in Temi e Moduli

## Data
[DATE]

## ⚠️ REGOLA CRITICA

**I comandi NPM (`npm install`, `npm run build`, `npm run dev`, `npm run copy`, etc.) DEVONO essere eseguiti SEMPRE nella directory root del tema o modulo, NON nella root del progetto Laravel.**

## Perché?

### 1. Risoluzione Path Relativi

Ogni tema/modulo ha il suo `vite.config.js` che usa `resolve(__dirname, ...)` per risolvere i path:

```javascript
// vite.config.js in Themes/Meetup/
import { resolve } from 'path';

export default defineConfig({
    root: resolve(__dirname, 'resources/html'),  // ✅ __dirname = Themes/Meetup/
    build: {
        outDir: resolve(__dirname, 'resources/html/dist'),  // ✅ Path relativo a __dirname
    },
    resolve: {
        alias: {
            '@': resolve(__dirname, 'resources'),  // ✅ Alias relativo a __dirname
        },
    },
});
```

**Se esegui `npm run build` dalla root Laravel:**
- `__dirname` = `/var/www/_bases/base_laravelpizza/laravel`
- Path risolti: `laravel/resources/html` ❌ (SBAGLIATO)

**Se esegui `npm run build` da `Themes/Meetup/`:**
- `__dirname` = `/var/www/_bases/base_laravelpizza/laravel/Themes/Meetup`
- Path risolti: `Themes/Meetup/resources/html` ✅ (CORRETTO)

### 2. package.json e node_modules

NPM cerca `package.json` nella directory corrente:

```bash
# ✅ CORRETTO
cd /var/www/_bases/base_laravelpizza/laravel/Themes/Meetup
npm install  # Trova Themes/Meetup/package.json

# ❌ ERRATO
cd /var/www/_bases/base_laravelpizza/laravel
npm install  # Cerca laravel/package.json (potrebbe non esistere o essere diverso)
```

### 3. Isolamento Dipendenze

Ogni tema/modulo ha dipendenze specifiche:

```json
// Themes/Meetup/package.json
{
  "devDependencies": {
    "@tailwindcss/vite": "^4.1.13",  // Tailwind v4
    "vite": "^7.0.7"
  }
}
```

Se esegui `npm install` nella directory sbagliata:
- Potresti installare dipendenze nella directory sbagliata
- Potresti avere conflitti di versioni
- `node_modules` finirebbe nella directory sbagliata

## Regola Generale

### Per Temi

```bash
# ✅ SEMPRE esegui nella directory del tema
cd /var/www/_bases/base_laravelpizza/laravel/Themes/{ThemeName}
npm install
npm run dev
npm run build
npm run copy  # Se presente nello script
```

### Per Moduli con Assets Frontend

```bash
# ✅ SEMPRE esegui nella directory del modulo (o subdirectory con package.json)
cd /var/www/_bases/base_laravelpizza/laravel/Modules/{ModuleName}
# oppure
cd /var/www/_bases/base_laravelpizza/laravel/Modules/{ModuleName}/resources/views
npm install
npm run build
```

## Esempi Pratici

### Tema Meetup

```bash
# ✅ CORRETTO
cd /var/www/_bases/base_laravelpizza/laravel/Themes/Meetup
npm install
npm run dev
npm run build

# Pubblicazione asset frontend del tema (vedi Themes/Meetup/package.json)
npm run copy   # copia ./public/* in public_html/themes/Meetup

# ❌ ERRATO
cd /var/www/_bases/base_laravelpizza/laravel
npm install  # Cerca package.json nella root Laravel
```

### Tema One (User Module)

```bash
# ✅ CORRETTO
cd /var/www/_bases/base_laravelpizza/laravel/Modules/User/resources/views
npm install
npm run build
npm run copy

# ❌ ERRATO
cd /var/www/_bases/base_laravelpizza/laravel
npm install  # Non trova il package.json del tema
```

## Verifica

### Controllo Directory Corretta

```bash
# Verifica che package.json esista nella directory corrente
ls -la package.json

# Verifica che vite.config.js esista nella directory corrente
ls -la vite.config.js

# Verifica che node_modules sia nella directory corrente dopo npm install
ls -la node_modules
```

### Controllo Path Risolti

Dopo `npm run build`, verifica che gli asset siano compilati nella directory corretta:

```bash
# Per tema Meetup
ls -la Themes/Meetup/resources/html/dist/

# Per tema One
ls -la public_html/themes/One/
```

## Eccezioni

### Progetto Laravel Principale

Se il progetto Laravel principale ha un `package.json` nella root (`laravel/package.json`), puoi eseguire comandi NPM anche lì, MA:

1. **Non confondere**: Gli asset del progetto principale sono diversi dagli asset dei temi
2. **Non mescolare**: Non eseguire comandi NPM del tema nella root Laravel
3. **Separazione**: Mantieni sempre separati i comandi NPM per progetto principale e temi

## Best Practices

1. ✅ **Sempre cd nella directory corretta prima di npm install/build**
2. ✅ **Verifica package.json e vite.config.js esistano nella directory corrente**
3. ✅ **Documenta la directory corretta nei README dei temi/moduli**
4. ✅ **Usa script helper se necessario** (es. `./build-theme.sh`)

## Script Helper (Opzionale)

Puoi creare uno script helper nella root Laravel:

```bash
#!/bin/bash
# build-theme.sh
THEME_NAME=${1:-Meetup}
cd "Themes/${THEME_NAME}" || exit 1
npm install
npm run build
```

Uso:
```bash
./build-theme.sh Meetup
```

## Riferimenti

- `Themes/Meetup/package.json` - Esempio package.json tema
- `Themes/Meetup/vite.config.js` - Esempio vite.config tema
- `Modules/User/resources/views/package.json` - Esempio package.json modulo
- `Themes/Meetup/docs/frontend-asset-management.md` - Gestione asset frontend

## Checklist

- [x] Documentata regola generale
- [x] Spiegato perché (path relativi, package.json, isolamento)
- [x] Forniti esempi pratici
- [x] Documentate eccezioni
- [x] Aggiunte best practices
