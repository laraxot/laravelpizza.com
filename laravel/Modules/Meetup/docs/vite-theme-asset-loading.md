# Vite Asset Loading per Temi - Guida Completa

## Data
2025-11-29

## Problema Identificato

Quando si usa `@vite()` in un layout Blade di un tema, è necessario specificare il **build name** come secondo parametro per indicare a Vite dove cercare gli asset.

### ❌ Errore Comune

```blade
@vite(['resources/css/app.css', 'resources/js/app.js'])
```

**Problema**: Vite cerca gli asset in `laravel/resources/` invece di `laravel/Themes/Meetup/resources/`.

### ✅ Soluzione Corretta

```blade
@vite(['resources/css/app.css', 'resources/js/app.js'], 'themes/Meetup')
```

**Spiegazione**: Il secondo parametro `'themes/Meetup'` indica a Vite di risolvere i path relativi alla directory `Themes/Meetup/`.

## Come Funziona il Build Name

### Meccanismo di Risoluzione

1. **Senza build name** (default):
   - Path base: `base_path('resources')`
   - Cerca: `laravel/resources/css/app.css`

2. **Con build name `'themes/Meetup'`**:
   - Path base: `base_path('Themes/Meetup')`
   - Cerca: `laravel/Themes/Meetup/resources/css/app.css`

### Esempio Pratico

```blade
{{-- File: Themes/Meetup/resources/views/components/layouts/main.blade.php --}}

{{-- ✅ CORRETTO --}}
@vite(['resources/css/app.css', 'resources/js/app.js'], 'themes/Meetup')

{{-- ❌ ERRATO - cerca in laravel/resources/ --}}
@vite(['resources/css/app.css', 'resources/js/app.js'])
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
                'resources/css/app.css',              // App principale
                'resources/js/app.js',                // App principale
                'Themes/Meetup/resources/css/app.css', // ✅ Tema Meetup
                'Themes/Meetup/resources/js/app.js',   // ✅ Tema Meetup
            ],
            refresh: true,
        }),
    ],
});
```

## Struttura File Corretta

```
laravel/
├── resources/                    # Assets app principale
│   ├── css/app.css
│   └── js/app.js
├── Themes/
│   └── Meetup/
│       └── resources/            # Assets tema Meetup
│           ├── css/app.css      # ✅ File CSS tema
│           └── js/app.js        # ✅ File JS tema
└── vite.config.js               # Configurazione Vite
```

## Verifica e Troubleshooting

### 1. Verifica File Esistono

```bash
ls -la Themes/Meetup/resources/css/app.css
ls -la Themes/Meetup/resources/js/app.js
```

### 2. Verifica Configurazione Vite

```bash
grep -A 10 "Themes/Meetup" laravel/vite.config.js
```

### 3. Build Assets

```bash
cd laravel
npm run build
```

### 4. Verifica Browser

1. Apri DevTools (F12)
2. Tab "Network"
3. Filtra per "CSS" o "JS"
4. Verifica che gli asset vengano caricati correttamente

## Esempi per Altri Temi

### Tema "One"

```blade
@vite(['resources/css/app.css', 'resources/js/app.js'], 'themes/One')
```

### Tema Dinamico (da Config)

```blade
@php
$pubTheme = config('xra.pub_theme', 'Meetup');
@endphp
@vite(['resources/css/app.css', 'resources/js/app.js'], 'themes/' . $pubTheme)
```

## Best Practices

1. ✅ **Sempre specificare build name per temi**: Non assumere che Vite trovi automaticamente gli asset del tema.

2. ✅ **Usa path relativi**: I path in `@vite()` sono sempre relativi a `resources/` del tema specificato.

3. ✅ **Verifica configurazione**: Assicurati che `vite.config.js` includa gli asset del tema.

4. ✅ **Documenta**: Aggiorna sempre la documentazione quando modifichi la configurazione.

## Riferimenti

- File corretto: `Themes/Meetup/resources/views/components/layouts/main.blade.php`
- Documentazione tema: `Themes/Meetup/docs/vite-theme-asset-loading-fix.md`
- Best practices: `Themes/Meetup/docs/vite-asset-loading-best-practices.md`

## Checklist

- [x] Corretto `@vite` directive in `main.blade.php`
- [x] Verificato esistenza file CSS/JS
- [x] Verificato configurazione `vite.config.js`
- [x] Documentato best practices
- [ ] Testato hot reload
- [ ] Testato build produzione

