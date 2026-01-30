# Compilazione dei Temi

## Meccanismo di Build Vite

### Processo di Compilazione

1. **Fase di Build**
   ```javascript
   build: {
     outDir: 'public',
     emptyOutDir: false,  // CRITICO: preserva gli asset esistenti
     manifest: 'manifest.json'  // CRITICO: mapping degli asset
   }
   ```

2. **Flusso di Compilazione**
   ```
   Input Files → Vite Build → Manifest Generation → Asset Output
   ```

3. **Ruolo del Manifest**
   - Mappa i nomi originali dei file ai loro hash
   - Permette il caricamento dinamico degli asset
   - Mantiene la coerenza tra sviluppo e produzione

### Architettura Multi-Tema

1. **Struttura Asset**
   ```
   Theme/
   ├── public/
   │   ├── assets/
   │   │   ├── app.[hash].js
   │   │   └── app.[hash].css
   │   └── manifest.json    # Mappa gli asset del tema
   └── vite.config.js
   ```

2. **Gestione Manifest**
   - Ogni tema ha il suo `manifest.json`
   - Il manifest contiene il mapping degli asset
   - Laravel usa il manifest per caricare gli asset corretti

### Configurazione Critica

1. **emptyOutDir: false**
   ```javascript
   // CORRETTO: preserva gli asset
   build: { emptyOutDir: false }
   
   // ERRATO: cancella gli asset esistenti
   build: { emptyOutDir: true }
   ```

2. **manifest: 'manifest.json'**
   ```javascript
   // CORRETTO: manifest specifico
   build: { manifest: 'manifest.json' }
   
   // ERRATO: manifest generico
   build: { manifest: true }
   ```

### Integrazione con Laravel

1. **Caricamento Asset**
   ```php
   // Laravel usa il manifest per caricare gli asset
   Vite::asset('resources/js/app.js');
   ```

2. **Gestione Multi-Tema**
   ```php
   // Ogni tema ha il suo manifest
   Theme::asset('app.js');
   ```

### Best Practices

1. **Configurazione Vite**
   ```javascript
   export default defineConfig({
     plugins: [
       laravel({
         input: ['resources/css/app.css', 'resources/js/app.js'],
         refresh: true
       })
     ],
     build: {
       outDir: 'public',
       emptyOutDir: false,
       manifest: 'manifest.json',
       rollupOptions: {
         input: {
           app: path.resolve(__dirname, 'resources/js/app.js'),
           css: path.resolve(__dirname, 'resources/css/app.css')
         }
       }
     }
   })
   ```

2. **Verifica Post-Build**
   - Controllare la presenza del manifest
   - Verificare gli hash degli asset
   - Testare il caricamento degli asset

### Troubleshooting Avanzato

1. **Problemi di Build**
   - Asset mancanti: verificare `emptyOutDir`
   - Hash non corretti: controllare il manifest
   - Conflitti di asset: verificare i path

2. **Debug Manifest**
   ```javascript
   // Contenuto tipico del manifest
   {
     "resources/js/app.js": {
       "file": "assets/app.8e5d87a6.js",
       "src": "resources/js/app.js",
       "isEntry": true
     }
   }
   ```

### Considerazioni di Performance

1. **Ottimizzazione Build**
   - Utilizzare `emptyOutDir: false` per build incrementali
   - Mantenere il manifest per il caching
   - Evitare sovrascritture non necessarie

2. **Gestione Cache**
   - Il manifest permette il caching efficiente
   - Gli hash degli asset facilitano l'invalidazione
   - La coesistenza degli asset migliora le performance

### Security Considerations

1. **Protezione Asset**
   - Verificare i permessi della directory `public`
   - Controllare l'integrità del manifest
   - Prevenire accessi non autorizzati

2. **Validazione Build**
   - Verificare la correttezza degli hash
   - Controllare la completezza degli asset
   - Assicurare la coerenza del manifest

## Collegamenti tra versioni di theme_compilation.md
* [theme_compilation.md](docs/standards/theme_compilation.md)
* [theme_compilation.md](laravel/Modules/Cms/docs/theme_compilation.md)

