# Design Comuni - Risultati Ricerca

## Scope

Pagina locale: `http://127.0.0.1:8000/it/tests/risultati-ricerca`
JSON CMS: [tests.risultati-ricerca.json](/var/www/_bases/base_fixcity_fila5/laravel/config/local/fixcity/database/content/pages/tests.risultati-ricerca.json)

## Stato corrente verificato

La shell top-level del `body` e coerente con il riferimento, ma dentro `main` restano differenze strutturali rilevanti.

Differenze confermate:
- manca `h1.visually-hidden#search-container`
- il breadcrumb non e ancora incapsulato nel `div#main-container.container` del riferimento
- i blocchi finali `bg-primary`, `bg-grey-card.shadow-contacts` e `it-example-modal` non risultano nella shell locale

## Documentazione canonica nel tema

- [risultati-ricerca-parity-2026-04-03.md](/var/www/_bases/base_fixcity_fila5/laravel/Themes/Sixteen/docs/design-comuni/risultati-ricerca-parity-2026-04-03.md)
- [analysis.md](/var/www/_bases/base_fixcity_fila5/laravel/Themes/Sixteen/docs/design-comuni/screenshots/risultati-ricerca-parity/analysis.md)
- [reference-risultati-ricerca.png](/var/www/_bases/base_fixcity_fila5/laravel/Themes/Sixteen/docs/design-comuni/screenshots/risultati-ricerca-parity/reference-risultati-ricerca.png)
- [local-risultati-ricerca.png](/var/www/_bases/base_fixcity_fila5/laravel/Themes/Sixteen/docs/design-comuni/screenshots/risultati-ricerca-parity/local-risultati-ricerca.png)

## Nota operativa

Per `risultati-ricerca` il gate strutturale non e ancora sufficiente per considerare corretto un pass esclusivamente CSS/JS.
