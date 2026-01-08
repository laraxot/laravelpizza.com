# Compilazione e Pubblicazione dei Temi

## Indice
- [Introduzione](#introduzione)
- [Architettura dei Temi](#architettura-dei-temi)
- [Processo di Compilazione](#processo-di-compilazione)
- [Processo di Pubblicazione](#processo-di-pubblicazione)
- [Configurazione di Vite](#configurazione-di-vite)
- [Gestione delle Dipendenze](#gestione-delle-dipendenze)
- [Best Practices](#best-practices)
- [Troubleshooting](#troubleshooting)

## Introduzione

Questo documento descrive il processo di compilazione e pubblicazione dei temi utilizzati nell'applicazione. I temi sono basati su Vite e Tailwind CSS e richiedono un processo di compilazione specifico per generare i file CSS e JavaScript ottimizzati per la produzione.

## Architettura dei Temi

I temi sono organizzati in directory separate all'interno della cartella `Themes`. Ogni tema ha la propria struttura di file e configurazioni indipendenti:

```
Themes/
  ├── One/                    # Tema principale
  │   ├── app/                # Logica PHP specifica del tema
  │   ├── assets/             # Asset statici (immagini, font, ecc.)
  │   ├── resources/          # Risorse sorgente (CSS, JS, Blade)
  │   │   ├── css/            # File CSS/SCSS sorgente
  │   │   ├── js/             # File JavaScript sorgente
  │   │   ├── views/          # Template Blade
  │   │   └── dist/           # Directory di output della compilazione
  │   ├── routes/             # Route specifiche del tema
  │   ├── package.json        # Dipendenze e script npm
  │   ├── tailwind.config.js  # Configurazione Tailwind CSS
  │   └── vite.config.js      # Configurazione Vite
  └── Two/                    # Tema secondario (struttura simile)
```

## Processo di Compilazione

Il processo di compilazione trasforma i file sorgente (CSS, JavaScript, ecc.) in file ottimizzati pronti per la produzione. Questo processo è gestito da Vite, un moderno bundler frontend.

### Comandi di Compilazione

Per compilare il tema, è necessario eseguire il seguente comando nella directory del tema:

```bash
cd /var/www/html/<nome progetto>/laravel/Themes/One
npm run build
```

Questo comando esegue lo script `build` definito nel file `package.json`:

```json
"scripts": {
    "dev": "vite",
    "build": "vite build",
    "watch": "vite build --watch",
    "copy": "cp -r ./resources/dist/* ../../../public_html/themes/One"
}
```

### Cosa Succede Durante la Compilazione

1. **Inizializzazione di Vite**: Vite legge la configurazione dal file `vite.config.js`
2. **Elaborazione dei File Sorgente**: 
   - I file CSS vengono processati da PostCSS e Tailwind CSS
   - I file JavaScript vengono transpilati e bundled
3. **Ottimizzazione**: 
   - Minificazione dei file
   - Eliminazione del codice inutilizzato (tree-shaking)
   - Generazione di nomi di file con hash per il cache busting
4. **Output**: I file compilati vengono salvati nella directory `resources/dist`

### Output della Compilazione

Dopo la compilazione, la directory `resources/dist` conterrà:

- File CSS compilati e ottimizzati
- File JavaScript compilati e ottimizzati
- Un file `manifest.json` che mappa i nomi dei file originali ai file compilati con hash

## Processo di Pubblicazione

Dopo la compilazione, è necessario copiare i file compilati nella directory pubblica accessibile dal web. Questo processo è gestito dallo script `copy` definito nel file `package.json`.

### Comandi di Pubblicazione

Per pubblicare il tema compilato, è necessario eseguire il seguente comando:

```bash
cd /var/www/html/<nome progetto>/laravel/Themes/One
npm run copy
```

Questo comando copia tutti i file dalla directory `resources/dist` alla directory pubblica `public_html/themes/One`:

```bash
cp -r ./resources/dist/* ../../../public_html/themes/One
```

### Perché Separare Compilazione e Pubblicazione

La separazione tra compilazione e pubblicazione offre diversi vantaggi:

1. **Flessibilità**: È possibile compilare il tema senza pubblicarlo immediatamente
2. **Controllo di Qualità**: È possibile verificare i file compilati prima di pubblicarli
3. **Ambienti Diversi**: È possibile adattare il processo di pubblicazione a diversi ambienti (sviluppo, staging, produzione)
4. **Rollback Facilitato**: In caso di problemi, è possibile tornare rapidamente a una versione precedente

## Configurazione di Vite

La configurazione di Vite è definita nel file `vite.config.js`:

```javascript
import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'

export default defineConfig({
    build: {
        outDir: __dirname + '/resources/dist',
        emptyOutDir: false,
        manifest: 'manifest.json',
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
```

### Punti Chiave della Configurazione

- **outDir**: Specifica la directory di output per i file compilati (`resources/dist`)
- **emptyOutDir**: Se impostato a `false`, non svuota la directory di output prima della compilazione
- **manifest**: Genera un file manifest che mappa i nomi dei file originali ai file compilati con hash
- **input**: Specifica i file di ingresso principali da compilare
- **refresh**: Abilita il refresh automatico del browser durante lo sviluppo

## Gestione delle Dipendenze

Le dipendenze frontend sono gestite tramite npm e definite nel file `package.json`:

```json
"devDependencies": {
    "@alpinejs/focus": "^3.14.9",
    "@tailwindcss/forms": "^0.5.10",
    "@tailwindcss/typography": "^0.5.16",
    "autoprefixer": "^10.4.21",
    "axios": "^1.8.4",
    "concurrently": "^9.1.2",
    "flowbite": "^3.1.2",
    "laravel-vite-plugin": "^1.2.0",
    "postcss": "^8.5.3",
    "postcss-nesting": "^13.0.1",
    "swiper": "^11.2.6",
    "tailwindcss": "^3.4.17",
    "vite": "^6.2.4"
}
```

### Installazione delle Dipendenze

Prima di compilare il tema per la prima volta, è necessario installare le dipendenze:

```bash
cd /var/www/html/<nome progetto>/laravel/Themes/One
npm install
```

### Aggiornamento delle Dipendenze

Per aggiornare le dipendenze:

```bash
cd /var/www/html/<nome progetto>/laravel/Themes/One
npm update
```

## Best Practices

### Sviluppo

1. **Modalità Watch**: Durante lo sviluppo, utilizzare `npm run watch` per ricompilare automaticamente i file quando vengono modificati
2. **Browser Sync**: Utilizzare browser-sync per aggiornare automaticamente il browser dopo ogni compilazione
3. **Organizzazione del Codice**: Mantenere una struttura ordinata dei file CSS e JavaScript

### Produzione

1. **Ottimizzazione delle Immagini**: Comprimere le immagini prima di includerle nel tema
2. **Purge CSS**: Utilizzare la funzionalità di purge di Tailwind CSS per rimuovere le classi non utilizzate
3. **Minificazione**: Assicurarsi che tutti i file siano minificati per la produzione
4. **Versioning**: Utilizzare il versioning dei file per il cache busting

## Troubleshooting

### Problemi Comuni

1. **Errori di Compilazione**: Verificare la sintassi dei file CSS e JavaScript
2. **Dipendenze Mancanti**: Assicurarsi che tutte le dipendenze siano installate con `npm install`
3. **Problemi di Permessi**: Verificare i permessi delle directory di output
4. **Cache del Browser**: Svuotare la cache del browser se le modifiche non sono visibili

### Soluzioni

1. **Pulizia della Cache**: Eliminare la directory `node_modules/.vite` e ricompilare
2. **Reinstallazione delle Dipendenze**: Eliminare `node_modules` e reinstallare con `npm install`
3. **Verifica dei Log**: Controllare i log di compilazione per identificare errori specifici

## Collegamenti tra versioni di theme_compilation.md
* [theme_compilation.md](docs/standards/theme_compilation.md)
* [theme_compilation.md](laravel/Modules/Cms/docs/theme_compilation.md)

