---
title: "theme build process"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "theme build process"
issues: []
discussions: []
status: draft
---

# Processo di Build del Tema in il progetto

> **Obsoleto: `npm run copy` non esiste piu' (2026-11-11).** Gli asset dei temi
> arrivano nella document root con un symlink, non con una copia. Per il
> procedimento valido vedi
> [Xot/docs/theme-assets-workflow.md](/laravel/Modules/Xot/docs/theme-assets-workflow.md).
> Le istruzioni di copia qui sotto sono lasciate come documentazione storica.

Questo documento fornisce una panoramica del processo di build e pubblicazione del tema principale di il progetto. Per una documentazione più dettagliata, consultare il [documento completo nel modulo CMS](../../laravel/modules/cms/project_docs/theme-build-process.md).

## Comandi Principali

Il tema principale di il progetto ("One") richiede due step separati per compilare e pubblicare le modifiche:

1. **Build degli asset** - Compila i file sorgente in file ottimizzati:

```bash
cd /var/www/html/<directory progetto>/laravel/Themes/One
npm run build
```

2. **Pubblicazione degli asset** - Copia i file compilati nella directory pubblica:

```bash
<<<<<<< .merge_file_Fcjbo2
# niente npm run copy: public_html/themes/<Tema> è un symlink a ../../laravel/Themes/<Tema>/public
=======
>>>>>>> .merge_file_U36wMn
```

È fondamentale eseguire entrambi i comandi per vedere le modifiche nel frontend dell'applicazione.

## Struttura e Processo

Il tema utilizza:
- **Vite** come bundler
- **Tailwind CSS** per lo styling
- **AlpineJS** per l'interattività

Il processo di build genera asset ottimizzati in `resources/dist` e il comando `copy` li sposta in `public_html/themes/One`.

## Integrazione con il Modulo CMS

Il tema è strettamente integrato con il modulo CMS di il progetto, che fornisce:
- Gestione dei contenuti
- Configurazione dei template
- Definizione dei blocchi di contenuto

Per ulteriori dettagli su come funziona l'integrazione, consultare la [documentazione del modulo CMS](../../laravel/modules/cms/project_docs/theme-cms-integration.md).

## Risorse Aggiuntive

- [Sviluppo Frontend in il progetto](./frontend-overview.md)
- [Personalizzazione del Tema](./theme-customization.md)
- [Struttura dei Componenti](./theme-components.md)
- [Integrazione con Filament](./filament-integration.md) 
