# Configurazione Laravel Mix

## Panoramica

Questo documento descrive la configurazione e l'utilizzo di Laravel Mix nel progetto <nome progetto>.

## Collegamenti
- [Gestione Asset](asset-management.md)
- [Configurazione Vite](vite.md)
- [Documentazione Moduli](modules.md)

## Configurazione Base

### File Principale
```javascript
// webpack.mix.js
const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('public')
   .js('resources/js/app.js', 'js')
   .sass('resources/sass/app.scss', 'css')
   .version();
```

### Moduli
```javascript
// Modules/*/webpack.mix.js
mix.setPublicPath('../../public')
   .mergeManifest()
   .js(__dirname + '/Resources/assets/js/app.js', 'js/module.js')
   .sass(__dirname + '/Resources/assets/sass/app.scss', 'css/module.css');
```

## Funzionalità

### Merge Manifest
- Unisce i manifest dei moduli
- Gestisce il versioning degli asset
- Mantiene la compatibilità con Vite

### Versioning
- Aggiunge hash agli asset in produzione
- Aggiorna automaticamente i manifest
- Supporta il cache busting

### Compilazione
- Supporta JavaScript moderno
- Compila SCSS/SASS
- Minifica in produzione

## Best Practices

### Configurazione
1. Usare `mix.setPublicPath()` per il percorso pubblico
2. Abilitare `mergeManifest()` per i moduli
3. Configurare il versioning in produzione

### Organizzazione
1. Mantenere i file sorgente in `Resources/assets/`
2. Usare sottocartelle per tipo di asset
3. Seguire le convenzioni di naming

### Build Process
1. Eseguire `npm run dev` per lo sviluppo
2. Usare `npm run build` per la produzione
3. Verificare i manifest dopo ogni build

## Risoluzione Problemi

### Errori Comuni
1. Percorsi errati nel webpack.mix.js
2. Dipendenze mancanti nel package.json
3. Conflitti di versioning

### Soluzioni
1. Verificare i percorsi relativi
2. Installare le dipendenze necessarie
3. Pulire la cache e ricompilare

## Manutenzione

### Aggiornamenti
1. Mantenere aggiornato Laravel Mix
2. Verificare la compatibilità
3. Testare dopo ogni aggiornamento

### Monitoraggio
1. Controllare le dimensioni degli asset
2. Verificare i tempi di build
3. Monitorare l'utilizzo delle risorse

## Vedi Anche
- [Documentazione Laravel Mix](https://laravel-mix.com/docs)
- [Guida Asset Laravel](https://laravel.com/docs/asset-compilation)
- [Best Practices Webpack](https://webpack.js.org/guides/) 
