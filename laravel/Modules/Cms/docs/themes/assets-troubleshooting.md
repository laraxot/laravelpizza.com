# Risoluzione Problemi con Assets dei Temi

> [!NOTE]
> Questo documento è collegato alla documentazione principale in `/docs/VITE_ASSETS_TROUBLESHOOTING.md`

## Errori Comuni

### Manifest Vite non trovato
```
Illuminate\Foundation\ViteException
Unable to locate file in Vite manifest: resources/css/app.css.
```

Questo errore è uno dei più comuni nella gestione dei temi. Per la risoluzione dettagliata, consultare la [documentazione principale sulla risoluzione problemi Vite](/docs/VITE_ASSETS_TROUBLESHOOTING.md).

## Perché documentare qui?

1. **Centralizzazione**: Il modulo CMS è il punto centrale per la gestione dei temi
2. **Coerenza**: Mantiene la documentazione vicina al codice che gestisce i temi
3. **Manutenibilità**: Facilita l'aggiornamento della documentazione quando il codice del modulo cambia

## Collegamenti Rilevanti

- [Processo di Build dei Temi](theme-build-process.md)
- [Compilazione dei Temi](theme_compilation.md)
- [Documentazione Principale Vite](/docs/VITE_ASSETS_TROUBLESHOOTING.md)

## Comandi Utili

Il modulo fornisce il comando `theme:publish-assets` per la pubblicazione degli assets:

```bash
php artisan theme:publish-assets {nome-tema}
```

Per maggiori dettagli sul funzionamento interno, consultare:
- `Modules/Theme/Console/Commands/PublishThemeAssetsCommand.php`
- `Modules/Theme/Actions/PublishThemeAssetsAction.php`

## Best Practices

1. **Verifica Preliminare**
   - Controllare sempre l'esistenza del `package.json` nel tema
   - Verificare la presenza di `node_modules`
   - Controllare i permessi delle directory

2. **Processo di Pubblicazione**
   - Utilizzare sempre il comando fornito dal modulo
   - Non modificare manualmente i file nella directory `dist`
   - Pulire la cache dopo la pubblicazione

3. **Ambiente di Sviluppo**
   - In sviluppo: utilizzare `npm run dev`
   - In produzione: utilizzare `npm run copy`

Per una guida completa sulla risoluzione dei problemi, consultare la [documentazione principale](/docs/VITE_ASSETS_TROUBLESHOOTING.md). 