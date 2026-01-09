# Vite Asset Loading - Best Practices per Temi

## Data
2025-11-29

## Panoramica

Quando si lavora con temi personalizzati in Laravel, è fondamentale utilizzare correttamente la direttiva `@vite` per caricare gli asset CSS e JavaScript specifici del tema.

## Problema Comune

### ❌ Errore Frequente

```blade
@vite(['resources/css/app.css', 'resources/js/app.js'])
```

**Problema**: Questa chiamata cerca gli asset nella directory `resources/` dell'applicazione principale, non nel tema.

### ✅ Soluzione Corretta

```blade
@vite(['resources/css/app.css', 'resources/js/app.js'], 'themes/Meetup')
```

**Spiegazione**: Il secondo parametro `'themes/Meetup'` indica a Vite di cercare gli asset relativi alla directory del tema `Themes/Meetup/`.

## Come Funziona

### Struttura Directory

```
laravel/
├── resources/                    # Assets applicazione principale
│   ├── css/app.css
│   └── js/app.js
└── Themes/
    └── Meetup/
        └── resources/            # Assets tema Meetup
            ├── css/app.css
            └── js/app.js
```

### Risoluzione Path

Quando usi `@vite(['resources/css/app.css', 'resources/js/app.js'], 'themes/Meetup')`:

1. Vite prende il secondo parametro: `'themes/Meetup'`
2. Risolve il path base: `base_path('Themes/Meetup')`
3. Cerca gli asset relativi: `Themes/Meetup/resources/css/app.css`
4. Carica gli asset corretti per il tema

## Esempi per Altri Temi

### Tema "One"

```blade
@vite(['resources/css/app.css', 'resources/js/app.js'], 'themes/One')
```

### Tema Dinamico

```blade
@php
$theme = config('xra.pub_theme', 'Meetup');
@endphp
@vite(['resources/css/app.css', 'resources/js/app.js'], 'themes/' . $theme)
```

## Configurazione Vite

### vite.config.js Principale

Il file `laravel/vite.config.js` deve includere gli asset del tema:

```javascript
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'Themes/Meetup/resources/css/app.css',  // ✅ Asset tema
                'Themes/Meetup/resources/js/app.js',    // ✅ Asset tema
            ],
            refresh: true,
        }),
    ],
});
```

## Verifica

### Controllo Asset Caricati

1. Apri la pagina nel browser
2. Apri DevTools (F12)
3. Vai alla tab "Network"
4. Filtra per "CSS" o "JS"
5. Verifica che gli asset vengano caricati da:
   - ✅ `http://127.0.0.1:8000/build/assets/app-xxx.css` (con hash)
   - ❌ NON da `http://127.0.0.1:8000/resources/css/app.css` (path statico)

### Controllo Console

Se gli asset non vengono caricati, vedrai errori nella console del browser:
- `Failed to load resource: the server responded with a status of 404`
- `GET http://127.0.0.1:8000/resources/css/app.css 404 (Not Found)`

## Troubleshooting

### Problema: Asset non trovati

**Causa**: Path errato o file mancanti

**Soluzione**:
1. Verifica che i file esistano:
   ```bash
   ls -la Themes/Meetup/resources/css/app.css
   ls -la Themes/Meetup/resources/js/app.js
   ```

2. Verifica la configurazione Vite:
   ```bash
   cat laravel/vite.config.js | grep -A 5 "Themes/Meetup"
   ```

3. Esegui build:
   ```bash
   npm run build
   ```

### Problema: Stili non applicati

**Causa**: CSS non compilato o Tailwind non configurato

**Soluzione**:
1. Verifica che Tailwind sia configurato in `app.css`:
   ```css
   @import 'tailwindcss';
   @source '../views';
   ```

2. Esegui dev server:
   ```bash
   npm run dev
   ```

## Best Practices

1. **Sempre specificare il build name per temi**: Usa sempre il secondo parametro `'themes/{ThemeName}'` quando carichi asset da un tema.

2. **Usa path relativi**: I path negli array `@vite()` sono sempre relativi alla directory `resources/` del tema.

3. **Verifica la configurazione**: Assicurati che `vite.config.js` includa gli asset del tema nell'array `input`.

4. **Documenta i cambiamenti**: Aggiorna sempre la documentazione quando modifichi la configurazione Vite.

## Riferimenti

- [Laravel Vite Plugin Documentation](https://laravel.com/docs/vite)
- [Vite Configuration](https://vitejs.dev/config/)
- Documentazione progetto: `Themes/Meetup/docs/vite-theme-asset-loading-fix.md`

## Checklist Implementazione

- [x] Corretto `@vite` directive in `main.blade.php`
- [x] Verificato esistenza file CSS/JS nel tema
- [x] Verificato configurazione `vite.config.js`
- [x] Documentato best practices
- [ ] Testato in produzione
- [ ] Verificato hot reload in sviluppo
