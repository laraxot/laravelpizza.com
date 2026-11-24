---
title: "vite errors"
type: note
tags: [documentation]
created: 2026-09-26
<<<<<<< .merge_file_ysQMNz
<<<<<<< .merge_file_tZpVsW
<<<<<<< .merge_file_txan8c
<<<<<<< .merge_file_N9UVFI
updated: 2026-11-23
=======
=======
>>>>>>> .merge_file_LGQqzS
=======
>>>>>>> .merge_file_HAilLh
=======
>>>>>>> .merge_file_Ykzx27
<<<<<<< HEAD
updated: 2026-09-26
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
<<<<<<< .merge_file_ysQMNz
<<<<<<< .merge_file_tZpVsW
<<<<<<< .merge_file_txan8c
>>>>>>> .merge_file_KZ3B8M
=======
>>>>>>> .merge_file_LGQqzS
=======
>>>>>>> .merge_file_HAilLh
=======
>>>>>>> .merge_file_Ykzx27
qmd: "vite errors"
issues: []
discussions: []
---

# Gestione Errori Vite nei Temi

> **Obsoleto: `npm run copy` non esiste piu' (2026-11-11).** Gli asset dei temi
> arrivano nella document root con un symlink, non con una copia. Per il
> procedimento valido vedi
> [Xot/docs/theme-assets-workflow.md](/laravel/Modules/Xot/docs/theme-assets-workflow.md).
> Le istruzioni di copia qui sotto sono lasciate come documentazione storica.

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
cd /var/www/html/_bases/base_predict_fila5_mono/laravel/Themes/[NomeTema]
```

### 2. Processo di Compilazione
```bash
# Installazione dipendenze
npm install

# Compilazione tema
<<<<<<< .merge_file_ysQMNz
<<<<<<< .merge_file_tZpVsW
<<<<<<< .merge_file_txan8c
<<<<<<< .merge_file_N9UVFI
# public_html/themes/<Tema> è un symlink a laravel/Themes/<Tema>/public: niente copia (Modules/Xot/docs/wiki/concepts/public-html-symlink-assets.md)
=======
=======
>>>>>>> .merge_file_LGQqzS
=======
>>>>>>> .merge_file_HAilLh
=======
>>>>>>> .merge_file_Ykzx27
<<<<<<< HEAD
# niente npm run copy: public_html/themes/<Tema> è un symlink a ../../laravel/Themes/<Tema>/public
=======
<<<<<<< HEAD
# niente npm run copy: public_html/themes/<Tema> è un symlink a ../../laravel/Themes/<Tema>/public
=======
# public_html/themes/<Tema> è un symlink a laravel/Themes/<Tema>/public: niente copia (Modules/Xot/docs/wiki/concepts/public-html-symlink-assets.md)
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_ysQMNz
<<<<<<< .merge_file_tZpVsW
<<<<<<< .merge_file_txan8c
>>>>>>> .merge_file_KZ3B8M
=======
>>>>>>> .merge_file_LGQqzS
=======
>>>>>>> .merge_file_HAilLh
=======
>>>>>>> .merge_file_Ykzx27
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
<<<<<<< .merge_file_ysQMNz
<<<<<<< .merge_file_tZpVsW
<<<<<<< .merge_file_txan8c
<<<<<<< .merge_file_N9UVFI
- [Documentazione Generale Errori](/project_docs/errors/README.md)
- [Gestione Temi CMS](../themes/README.md)
=======
=======
>>>>>>> .merge_file_LGQqzS
=======
>>>>>>> .merge_file_HAilLh
=======
>>>>>>> .merge_file_Ykzx27
<<<<<<< HEAD
- [Documentazione Generale Errori](/project_docs/errors/README.md)
- [Gestione Temi CMS](../themes/README.md)
=======
<<<<<<< .merge_file_7vScen
- [Documentazione Generale Errori](/project_docs/errors/readme.md)
- [Gestione Temi CMS](../../../../Themes/README.md)
=======
- [Documentazione Generale Errori](/project_docs/errors/README.md)
- [Gestione Temi CMS](../themes/README.md)
>>>>>>> .merge_file_QXiiK6
>>>>>>> laraxot/dev
<<<<<<< .merge_file_ysQMNz
<<<<<<< .merge_file_tZpVsW
<<<<<<< .merge_file_txan8c
>>>>>>> .merge_file_KZ3B8M
=======
>>>>>>> .merge_file_LGQqzS
=======
>>>>>>> .merge_file_HAilLh
=======
>>>>>>> .merge_file_Ykzx27
- [Processo di Deploy](../../project_docs/deployment/themes.md)

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
npm install
<<<<<<< .merge_file_ysQMNz
<<<<<<< .merge_file_tZpVsW
<<<<<<< .merge_file_txan8c
<<<<<<< .merge_file_N9UVFI
=======
=======
>>>>>>> .merge_file_LGQqzS
=======
>>>>>>> .merge_file_HAilLh
=======
>>>>>>> .merge_file_Ykzx27
<<<<<<< HEAD
=======

>>>>>>> laraxot/dev
<<<<<<< .merge_file_ysQMNz
<<<<<<< .merge_file_tZpVsW
<<<<<<< .merge_file_txan8c
>>>>>>> .merge_file_KZ3B8M
=======
>>>>>>> .merge_file_LGQqzS
=======
>>>>>>> .merge_file_HAilLh
=======
>>>>>>> .merge_file_Ykzx27
npm install && npm run build
```

## Manutenzione
- Aggiornare regolarmente le dipendenze npm
- Verificare la compatibilità con le versioni Laravel
- Mantenere backup dei file di configurazione 