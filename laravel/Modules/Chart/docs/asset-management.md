# Gestione Asset nel Modulo Chart

## Panoramica

Questo documento descrive la gestione degli asset (JavaScript, CSS, ecc.) nel modulo Chart.

## Collegamenti
- [Documentazione Principale](../../../docs/modules.md)
- [Configurazione Vite](../../../docs/vite.md)
- [Configurazione Laravel Mix](../../../docs/laravel-mix.md)

## Struttura Asset

```
Chart/
├── resources/
│   ├── assets/
│   │   ├── js/
│   │   │   ├── app.js
│   │   │   └── filament-chart-js-plugins.js
│   │   └── sass/
│   │       └── app.scss
│   └── dist/
│       └── .vite/
│           └── manifest.json
└── webpack.mix.js
```

## Configurazione Build

### Laravel Mix
Il modulo utilizza Laravel Mix per la compilazione degli asset:

```javascript
// webpack.mix.js
mix.setPublicPath('../../public').mergeManifest();
mix.js(__dirname + '/resources/assets/js/app.js', 'js/chart.js')
   .sass(__dirname + '/resources/assets/sass/app.scss', 'css/chart.css');
```

### Vite
Il modulo supporta anche Vite per lo sviluppo:

```json
// manifest.json
{
  "resources/css/app.css": {
    "file": "assets/app-l0sNRNKZ.js",
    "name": "app",
    "src": "resources/css/app.css",
    "isEntry": true
  },
  "resources/js/app.js": {
    "file": "assets/app-DP2rzg_V.js",
    "name": "app",
    "src": "resources/js/app.js",
    "isEntry": true
  }
}
```

## Best Practices

### Organizzazione File
1. Mantenere gli asset sorgente in `resources/assets/`
2. Utilizzare sottocartelle per tipo di asset (js, sass, etc.)
3. Seguire la convenzione di naming del progetto

### Build Process
1. Eseguire `npm run dev` durante lo sviluppo
2. Usare `npm run build` per la produzione
3. Verificare il manifest.json dopo ogni build

### Versioning
1. Gli asset vengono versionati automaticamente in produzione
2. Il manifest.json tiene traccia delle versioni
3. Utilizzare i mix() helper per il caricamento

## Risoluzione Problemi

### Conflitti di Build
1. Pulire la cache: `npm run clean`
2. Rimuovere node_modules: `rm -rf node_modules`
3. Reinstallare dipendenze: `npm install`

### Errori di Compilazione
1. Verificare i percorsi nel webpack.mix.js
2. Controllare le dipendenze nel package.json
3. Assicurarsi che i file sorgente esistano

## Manutenzione

### Aggiornamenti
1. Mantenere aggiornate le dipendenze npm
2. Verificare la compatibilità con Laravel Mix
3. Testare dopo ogni aggiornamento

### Monitoraggio
1. Controllare le dimensioni degli asset
2. Verificare i tempi di build
3. Monitorare l'utilizzo delle risorse

## Vedi Anche
- [Documentazione Chart.js](https://www.chartjs.org/docs/)
- [Documentazione Filament](https://filamentphp.com/docs)
- [Guida Asset Laravel](https://laravel.com/docs/asset-compilation) 