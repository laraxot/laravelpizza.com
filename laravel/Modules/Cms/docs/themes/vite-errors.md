# Gestione Errori Vite nei Temi

## Perché
I temi sono una componente fondamentale del modulo CMS e la loro corretta compilazione attraverso Vite è essenziale per il funzionamento dell'interfaccia utente. Gli errori di compilazione Vite possono bloccare la visualizzazione del tema e devono essere gestiti in modo sistematico.

## Errore Comune: Manifest non trovato

### Descrizione dell'Errore
```
Illuminate\Foundation\ViteException
Unable to locate file in Vite manifest: resources/css/app.css
```

Questo errore si verifica quando il sistema non trova il manifest Vite necessario per la corretta distribuzione degli asset del tema.

### Impatto
- Blocco del rendering del tema
- Mancata visualizzazione degli stili CSS
- Possibile compromissione dell'esperienza utente

### Struttura Standard di un Tema
```
ThemeName/
├── resources/
│   ├── css/
│   │   └── app.css
│   └── js/
│       └── app.js
├── dist/
├── package.json
└── vite.config.js
```

## Risoluzione

### 1. Verifica Preliminare
```bash
cd /var/www/html/_bases/base_predict_fila3_mono/laravel/Themes/[NomeTema]
```

### 2. Processo di Compilazione
```bash
# Installazione dipendenze
npm install

# Compilazione tema
npm run copy
```

### 3. Verifica Post-Compilazione
```bash
# Controllo manifest
cat dist/manifest.json

# Verifica permessi
ls -la dist/
```

## Prevenzione

### Integrazione nel Workflow di Sviluppo
1. Aggiungere controlli pre-commit per la compilazione dei temi
2. Implementare test automatici per la verifica degli asset
3. Documentare le modifiche alla struttura del tema

### Monitoraggio
- Log degli errori di compilazione
- Controlli periodici dei manifest
- Verifica dell'integrità dei file compilati

## Collegamenti Correlati
- [Documentazione Generale Errori](/project_docs/errors/README.md)
- [Gestione Temi CMS](../themes/README.md)
- [Processo di Deploy](../../project_docs/deployment/THEMES.md)

## Note Tecniche
- La compilazione deve essere eseguita per ogni tema individualmente
- I manifest sono specifici per tema
- La configurazione Vite deve essere allineata con la struttura Laravel

## Troubleshooting

### Configurazione Vite
```javascript
// vite.config.js
export default defineConfig({
    build: {
        outDir: 'dist',
        manifest: true,
        rollupOptions: {
            input: [
                'resources/css/app.css',
                'resources/js/app.js'
            ]
        }
    }
});
```

### Comandi di Debug
```bash
# Verifica Node.js e npm
node -v
npm -v

# Pulizia cache
npm cache clean --force

# Ricompilazione forzata
rm -rf dist/ node_modules/
npm install && npm run copy
```

## Manutenzione
- Aggiornare regolarmente le dipendenze npm
- Verificare la compatibilità con le versioni Laravel
- Mantenere backup dei file di configurazione 