# Asset Bundling con Vite

## Introduzione

Vite è un moderno strumento di bundling frontend che fornisce un ambiente di sviluppo estremamente veloce e bundle il codice per la produzione. Laravel integra perfettamente Vite attraverso un plugin ufficiale e una direttiva Blade per caricare gli asset sia in sviluppo che in produzione.

## Installazione e Configurazione

### Prerequisiti
- Node.js (16+)
- NPM

### Installazione Base
```bash
npm install --save-dev vite laravel-vite-plugin
```

### Configurazione di Vite
```javascript
// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
```

## Integrazione con Laravel

### Direttiva Blade
```blade
@vite(['resources/css/app.css', 'resources/js/app.js'])
```

### Configurazione Ambiente
```env
VITE_APP_NAME="il progetto"
VITE_APP_URL="${APP_URL}"
```

## Hot Reload e Sviluppo

### Avvio del Server di Sviluppo
```bash
npm run dev
```

### Configurazione CORS
```javascript
// vite.config.js
export default defineConfig({
    server: {
        cors: {
            origin: [
                'https://backend.laravel',
                'http://admin.laravel:8566',
            ],
        },
    },
});
```

## Deployment degli Asset

### Build per Produzione
```bash
npm run build
```

### Configurazione CDN
```javascript
// vite.config.js
export default defineConfig({
    build: {
        assetsDir: 'assets',
        manifest: true,
    },
});
```

## Risorse Utili

- [Documentazione Ufficiale Laravel Vite](https://laravel.com/docs/12.x/vite)
- [Laravel Vite Plugin](https://github.com/laravel/vite-plugin)
- [Tutorial Laracasts](https://laracasts.com/series/laravel-and-vite)
- [Guida Aulab](https://aulab.it/guide/136/build-e-bundling-degli-asset-in-laravel)
- [Troubleshooting](https://laravel-news.com/laravel-vite-errors)

## Best Practices

1. Utilizzare il caching del browser
2. Implementare il lazy loading per le immagini
3. Ottimizzare gli asset statici
4. Utilizzare CDN per gli asset pubblici
5. Monitorare le performance del bundle

## Troubleshooting

### Errori Comuni

1. **Manifest non trovato**
   - Verificare la configurazione di Vite
   - Eseguire `npm run build`
   - Controllare i permessi dei file

2. **Hot Reload non funzionante**
   - Verificare la configurazione CORS
   - Controllare le variabili d'ambiente
   - Riavviare il server di sviluppo

3. **Errori di Build**
   - Aggiornare le dipendenze
   - Verificare la compatibilità delle versioni
   - Controllare i log di build

## Migrazione da Laravel Mix

Per progetti esistenti che utilizzano Laravel Mix, consultare:
- [Guida alla Migrazione](https://dev.to/varzoeaa/laravel-mix-vs-vite-why-did-laravel-transitioned-to-vite-2k25)
- [Documentazione Mix](https://laravel-mix.com/) 
