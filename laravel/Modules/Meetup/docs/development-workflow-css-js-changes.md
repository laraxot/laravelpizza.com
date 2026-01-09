# Workflow Sviluppo - Modifiche CSS/JS

## Data
2025-11-30

## ⚠️ REGOLA CRITICA

**OGNI VOLTA che modifichi file CSS (`resources/css/app.css`) o JavaScript (`resources/js/app.js`), DEVI eseguire `npm run build && npm run copy` per vedere le modifiche nel browser.**

## Perché?

### 1. Vite Compilation

I file CSS e JS sono **source files** che devono essere compilati da Vite:
- `resources/css/app.css` → Vite compila Tailwind CSS e genera CSS ottimizzato
- `resources/js/app.js` → Vite bundle JavaScript e genera JS ottimizzato

**Senza build**: Le modifiche ai file source NON sono visibili nel browser.

### 2. Asset Distribution

Dopo la compilazione, gli asset devono essere copiati nella directory pubblica:
- `public/assets/app-[hash].css` → `public_html/themes/Meetup/assets/app-[hash].css`
- `public/assets/app-[hash].js` → `public_html/themes/Meetup/assets/app-[hash].js`

**Senza copy**: Gli asset compilati NON sono accessibili via web.

## Workflow Completo

### Modifica CSS/JS

1. **Modifica i file source**:
   ```bash
   # Modifica CSS
   vim resources/css/app.css

   # Modifica JS
   vim resources/js/app.js
   ```

2. **Build e Copy** (OBBLIGATORIO):
   ```bash
   cd /var/www/_bases/base_laravelpizza/laravel/Themes/Meetup
   npm run build && npm run copy
   ```

3. **Verifica nel browser**:
   - Apri `http://127.0.0.1:8000/it`
   - Hard refresh (Ctrl+Shift+R) per pulire cache browser

## Comandi

### Build e Copy (Produzione)

```bash
cd /var/www/_bases/base_laravelpizza/laravel/Themes/Meetup
npm run build && npm run copy
```

**Cosa fa**:
1. `npm run build`:
   - Compila TypeScript (`tsc`)
   - Compila CSS con Tailwind (`vite build`)
   - Genera `public/assets/app-[hash].css`
   - Genera `public/assets/app-[hash].js`
   - Genera `public/manifest.json`

2. `npm run copy`:
   - Copia `public/*` → `public_html/themes/Meetup/`
   - Rende gli asset accessibili via web

### Dev Mode (Sviluppo con Hot Reload)

```bash
cd /var/www/_bases/base_laravelpizza/laravel/Themes/Meetup
npm run dev
```

**Cosa fa**:
- Avvia Vite dev server con hot reload
- Le modifiche CSS/JS sono visibili automaticamente
- **NON serve** `npm run copy` in dev mode

**Nota**: In dev mode, Vite serve gli asset direttamente, non dalla directory pubblica.

## Quando Eseguire Build e Copy

### ✅ SEMPRE Eseguire

- Dopo modifiche a `resources/css/app.css`
- Dopo modifiche a `resources/js/app.js`
- Dopo modifiche a `tailwind.config.js`
- Dopo modifiche a `vite.config.js`
- Prima di testare nel browser (`http://127.0.0.1:8000/it`)
- Prima di commitare modifiche CSS/JS

### ❌ NON Serve

- Durante `npm run dev` (hot reload automatico)
- Per modifiche a file Blade (`.blade.php`)
- Per modifiche a file PHP
- Per modifiche a file di configurazione Laravel

## Verifica Modifiche

### 1. Verifica Build

```bash
# Verifica che gli asset siano stati compilati
ls -la public/assets/
# Dovresti vedere: app-[hash].css, app-[hash].js, manifest.json
```

### 2. Verifica Copy

```bash
# Verifica che gli asset siano stati copiati
ls -la public_html/themes/Meetup/assets/
# Dovresti vedere gli stessi file
```

### 3. Verifica Browser

1. Apri `http://127.0.0.1:8000/it`
2. **Hard refresh** (Ctrl+Shift+R o Cmd+Shift+R) per pulire cache
3. Verifica che le modifiche siano visibili
4. Apri DevTools → Network per verificare che gli asset siano caricati

### 4. Verifica Hash

Gli asset hanno hash nel nome (`app-[hash].css`). Se l'hash cambia dopo build, significa che il contenuto è cambiato:

```bash
# Prima build
ls public/assets/app-*.css
# Output: app-ABC123.css

# Dopo modifiche CSS + build
ls public/assets/app-*.css
# Output: app-XYZ789.css (hash diverso = contenuto modificato)
```

## Troubleshooting

### Problema: Modifiche CSS non visibili

**Causa**: Build non eseguito o cache browser

**Soluzione**:
```bash
# 1. Esegui build e copy
npm run build && npm run copy

# 2. Pulisci cache browser (Ctrl+Shift+R)

# 3. Verifica che gli asset siano stati copiati
ls -la public_html/themes/Meetup/assets/
```

### Problema: Asset 404 (Not Found)

**Causa**: Copy non eseguito o path errati

**Soluzione**:
```bash
# 1. Verifica che la directory esista
ls -la public_html/themes/Meetup/

# 2. Se non esiste, creala
mkdir -p public_html/themes/Meetup

# 3. Esegui copy
npm run copy

# 4. Verifica
ls -la public_html/themes/Meetup/assets/
```

### Problema: Stili vecchi ancora visibili

**Causa**: Cache browser o manifest non aggiornato

**Soluzione**:
```bash
# 1. Ricompila
npm run build && npm run copy

# 2. Pulisci cache Laravel
cd /var/www/_bases/base_laravelpizza/laravel
php artisan view:clear
php artisan optimize:clear

# 3. Hard refresh browser (Ctrl+Shift+R)
```

## Best Practices

1. ✅ **Sempre eseguire build e copy dopo modifiche CSS/JS**
2. ✅ **Verificare nel browser dopo ogni build**
3. ✅ **Usare hard refresh per pulire cache**
4. ✅ **Verificare che gli asset siano stati copiati**
5. ✅ **Usare `npm run dev` durante sviluppo attivo** (hot reload)
6. ✅ **Usare `npm run build && npm run copy` prima di testare in produzione**

## Script Helper (Opzionale)

Puoi creare uno script helper per automatizzare:

```bash
#!/bin/bash
# build-and-test.sh
cd /var/www/_bases/base_laravelpizza/laravel/Themes/Meetup
npm run build && npm run copy
echo "✅ Build e copy completati! Apri http://127.0.0.1:8000/it"
```

## Riferimenti

- `Themes/Meetup/package.json` - Scripts NPM
- `Themes/Meetup/vite.config.js` - Configurazione Vite
- `Themes/Meetup/docs/build-and-copy-workflow.md` - Workflow completo
- `Themes/Meetup/docs/vite-build-output-directory.md` - Output directory

## Checklist

- [x] Documentata regola critica (build e copy obbligatori)
- [x] Spiegato perché (Vite compilation, asset distribution)
- [x] Documentato workflow completo
- [x] Aggiunto troubleshooting
- [x] Aggiunte best practices
