# Troubleshooting

## Introduzione

Questa sezione descrive i problemi più comuni che possono verificarsi durante lo sviluppo e la manutenzione del frontend del CMS, insieme alle relative soluzioni.

## Errori Comuni

### 1. Vite Manifest Non Trovato

#### Sintomi
- Errore "Vite manifest not found" in produzione
- Asset non caricati correttamente
- Pagine bianche o stili mancanti

#### Soluzioni
1. Verificare la configurazione di Vite
```javascript
// vite.config.js
export default defineConfig({
    build: {
        manifest: true,
    },
});
```

2. Eseguire il build
```bash
npm run build
```

3. Verificare i permessi
```bash
chmod -R 755 public/build
```

### 2. Hot Reload Non Funzionante

#### Sintomi
- Le modifiche non si aggiornano automaticamente
- Il server di sviluppo si blocca
- Errori di connessione

#### Soluzioni
1. Verificare la configurazione CORS
```javascript
// vite.config.js
export default defineConfig({
    server: {
        cors: {
            origin: ['http://localhost:5173'],
        },
    },
});
```

2. Riavviare il server
```bash
npm run dev
```

3. Verificare le variabili d'ambiente
```env
VITE_APP_URL=http://localhost:8000
```

### 3. Problemi di Build

#### Sintomi
- Errori durante il build
- Asset mancanti
- Performance scadenti

#### Soluzioni
1. Aggiornare le dipendenze
```bash
npm update
```

2. Verificare la compatibilità
```json
{
  "dependencies": {
    "vue": "^3.3.0",
    "react": "^18.2.0"
  }
}
```

3. Ottimizzare la configurazione
```javascript
// vite.config.js
export default defineConfig({
    build: {
        minify: 'terser',
        sourcemap: true,
    },
});
```

## Best Practices

### 1. Monitoraggio
- Utilizzare strumenti di analisi
- Monitorare gli errori
- Tracciare le performance

### 2. Manutenzione
- Aggiornare regolarmente le dipendenze
- Verificare la compatibilità
- Eseguire test regolari

### 3. Documentazione
- Mantenere aggiornata la documentazione
- Documentare le soluzioni
- Condividere le best practices

## Risorse Utili

- [Laravel Vite Documentation](https://laravel.com/docs/12.x/vite)
- [Vite Troubleshooting Guide](https://vitejs.dev/guide/troubleshooting.html)
- [Laravel News](https://laravel-news.com)

## Checklist di Verifica

### Prima del Deployment
- [ ] Eseguire il build
- [ ] Verificare gli asset
- [ ] Controllare i permessi

### Dopo il Deployment
- [ ] Verificare il caricamento
- [ ] Controllare gli errori
- [ ] Monitorare le performance

### Manutenzione Regolare
- [ ] Aggiornare le dipendenze
- [ ] Pulire la cache
- [ ] Verificare la sicurezza 

## Collegamenti tra versioni di troubleshooting.md
* [troubleshooting.md](laravel/Modules/Xot/docs/troubleshooting.md)
* [troubleshooting.md](laravel/Modules/Cms/docs/frontoffice/troubleshooting.md)

