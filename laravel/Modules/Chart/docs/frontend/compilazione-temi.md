# Compilazione e Pubblicazione dei Temi

> Questo documento è un collegamento alla documentazione principale sulla compilazione e pubblicazione dei temi.

## Collegamenti

- [Documentazione Completa sulla Compilazione dei Temi](../laravel/Modules/Cms/docs/theme_compilation.md)
- [Processo di Build del Tema](../laravel/Modules/Cms/docs/theme-build-process.md)

## Sommario

La documentazione completa sulla compilazione e pubblicazione dei temi si trova nel modulo Cms. Include informazioni su:

- Architettura dei temi
- Processo di compilazione con Vite e Tailwind CSS
- Processo di pubblicazione degli asset
- Configurazione di Vite
- Gestione delle dipendenze
- Best practices per lo sviluppo e la produzione
- Troubleshooting

## Procedura Rapida

Per compilare e pubblicare un tema:

1. Entrare nella directory del tema:
   ```bash
   cd /var/www/html/base_<nome progetto>/laravel/Themes/One
   ```

2. Compilare gli asset:
   ```bash
   npm run build
   ```

3. Pubblicare gli asset compilati:
   ```bash
   npm run copy
   ```

Per maggiori dettagli, consultare la [documentazione completa](../laravel/Modules/Cms/docs/theme_compilation.md).
