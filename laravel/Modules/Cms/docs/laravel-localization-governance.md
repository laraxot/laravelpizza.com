# Laravel Localization Governance

## Contesto

Il progetto usa `mcamara/laravel-localization` come layer applicativo per negotiation lingua, redirect intelligenti e URL localizzate. Questo cambia il contratto di routing del frontoffice: la locale non e' un dettaglio di view, ma parte dell'identita' della route.

## Regole

- Le pagine pubbliche devono avere URL localizzata come URL canonica di rendering.
- Le URL senza prefisso locale esistono per redirect o fallback, non per servire contenuti duplicati con lingua variabile.
- Header, footer, blocchi CMS, CTA e form action devono usare helper `LaravelLocalization` invece di concatenare `"/".app()->getLocale()`.
- Le route localizzate vanno testate con assert semantiche sulla lingua finale del documento.

## Middleware e redirect

- `localeSessionRedirect` va considerato il punto in cui la lingua richiesta viene memorizzata e riapplicata.
- `localizationRedirect` evita duplicazioni quando la locale di default va nascosta nell'URL.
- Se una pagina come `/de` deve rendere la home in tedesco, il sistema deve produrre markup coerente con la locale richiesta e non limitarsi a cambiare solo il path.

## Caching

- Se il progetto usa route localization o translated routes del package, evitare `route:cache` e `optimize` come sostituti indifferenti.
- Il caching corretto e' `php artisan route:trans:cache`.

## Testing

- Un test su pagina localizzata deve verificare almeno uno di questi segnali:
- `<html lang="xx">`
- URL localizzata finale attesa
- contenuti o traduzioni inequivocabilmente appartenenti alla locale
- Per casi che falliscono per bootstrap precoce in ambiente test, usare il bootstrap per-locale del package basato su `LaravelLocalization::ENV_ROUTE_KEY`.

## Fonte

- README ufficiale `mcamara/laravel-localization`: https://github.com/mcamara/laravel-localization
