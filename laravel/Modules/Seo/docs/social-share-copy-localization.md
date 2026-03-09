# Social share copy localization

## Contesto

Il componente `Modules/Seo/resources/views/components/social-share.blade.php` mostrava copy hardcoded inglese:

- `Copy to clipboard`
- `URL Copied!`

## Regola

Il componente social share e' riusato cross-theme, quindi i testi UI devono usare chiavi di traduzione e non stringhe hardcoded.

## Applicazione

- introdurre chiavi in `Themes/Meetup/lang/*/event.php` (scope `actions/messages`)
- consumare le chiavi nel componente SEO via `__()`

Questo evita regressioni i18n nel dettaglio evento e mantiene coerenza con il resto del tema.
