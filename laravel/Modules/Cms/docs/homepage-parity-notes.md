# Homepage Parity Notes

La route `tests.homepage` continua a essere alimentata dal JSON CMS:
- [tests.homepage.json](/var/www/_bases/base_fixcity_fila5/laravel/config/local/fixcity/database/content/pages/tests.homepage.json)

La documentazione visuale e i fix attivi stanno nel tema:
- [homepage-parity-report.md](/var/www/_bases/base_fixcity_fila5/laravel/Themes/Sixteen/docs/design-comuni/homepage-parity-report.md)
- [header-search-analysis.md](/var/www/_bases/base_fixcity_fila5/laravel/Themes/Sixteen/docs/design-comuni/screenshots/homepage-parity/header-search-analysis.md)
- [footer-analysis.md](/var/www/_bases/base_fixcity_fila5/laravel/Themes/Sixteen/docs/design-comuni/screenshots/homepage-parity/footer-analysis.md)
- [logo-residual-analysis.md](/var/www/_bases/base_fixcity_fila5/laravel/Themes/Sixteen/docs/design-comuni/screenshots/homepage-parity/logo-residual-analysis.md)

Nota: in questa fase i residui sono quasi tutti nel layer di presentazione del tema, non nella struttura CMS dei blocchi.

## Structural Status

Confronto attuale utile della shell pagina:
- top-level `body` allineato tra riferimento e locale
- figli immediati di `main` allineati nello stesso ordine

Quindi la fase corrente resta coerente con il piano: mantenere la struttura CMS e rifinire i residui nel tema con CSS/JS.

## Tooling e docs correnti

Per i controlli visuali ripetibili il tooling canonico non e piu in `/tmp` ma qui:
- [inspectors.md](/var/www/_bases/base_fixcity_fila5/bashscripts/docs/homepage-visual-parity/inspectors.md)
- [inspect-readmore.mjs](/var/www/_bases/base_fixcity_fila5/bashscripts/inspectors/homepage-visual-parity/inspect-readmore.mjs)

Nota CMS aggiornata:
- i residui attivi della homepage sono quasi tutti nel tema Sixteen
- il confronto del CTA `VAI ALLA PAGINA` e tracciato in [readmore-analysis.md](/var/www/_bases/base_fixcity_fila5/laravel/Themes/Sixteen/docs/design-comuni/screenshots/homepage-parity/readmore-analysis.md)
