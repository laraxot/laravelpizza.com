# Design Comuni Argomento

## Source Of Truth

La route `http://127.0.0.1:8000/it/tests/argomento` passa da:

- [laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php](/var/www/_bases/base_fixcity_fila5/laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php)

Il contenuto CMS e la composizione blocchi arrivano da:

- [laravel/config/local/fixcity/database/content/pages/tests.argomento.json](/var/www/_bases/base_fixcity_fila5/laravel/config/local/fixcity/database/content/pages/tests.argomento.json)

## Current Structure From JSON

Blocchi dichiarati:

- `pub_theme::components.blocks.breadcrumb.default`
- `pub_theme::components.blocks.hero.default`
- `pub_theme::components.blocks.cards.grid`
- `pub_theme::components.blocks.links.list`

## Why Parity Is Not Reached

La reference `argomento.html` non e' costruita come semplice `breadcrumb + hero + cards-grid + links-list`.

La reference usa invece una pagina molto piu' articolata con:

- hero wrapper con immagine di sfondo
- card hero sovrapposta
- blocco laterale `gestito da`
- piu' sezioni editoriali sotto la piega

Quindi il mismatch e' prima di tutto di composizione CMS e non di styling.

## Linked Theme Report

- [laravel/Themes/Sixteen/docs/design-comuni/argomento-parity-2026-04-02.md](/var/www/_bases/base_fixcity_fila5/laravel/Themes/Sixteen/docs/design-comuni/argomento-parity-2026-04-02.md)
