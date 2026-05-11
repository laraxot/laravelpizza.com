# Design Comuni Argomenti

## Source Of Truth

La route `http://127.0.0.1:8000/it/tests/argomenti` passa da:

- [laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php](/var/www/_bases/base_fixcity_fila5/laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php)

La composizione CMS resta governata da:

- [laravel/config/local/fixcity/database/content/pages/tests.argomenti.json](/var/www/_bases/base_fixcity_fila5/laravel/config/local/fixcity/database/content/pages/tests.argomenti.json)

## Status

`argomenti` e' stata riallineata fino al punto in cui il gate strutturale di `main` risulta `100%` nell'audit coarse.

Questo la rende la prima pagina del batch effettivamente sbloccata per il lavoro visuale CSS/JS.

## CMS Changes Relevant To The Fix

Nel JSON sono stati allineati i blocchi a questa sequenza:

- breadcrumb con wrapper esterno `container#main-container`
- hero `argomenti`
- topics highlight
- topics grid
- feedback `faq-rating`
- contacts `faq`

## Linked Theme Report

- [argomenti-parity-2026-04-02.md](/var/www/_bases/base_fixcity_fila5/laravel/Themes/Sixteen/docs/design-comuni/argomenti-parity-2026-04-02.md)
