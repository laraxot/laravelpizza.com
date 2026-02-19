# Localization Standard (Tema Meetup)

## Overview

Il tema Meetup implementa lo standard di localizzazione Laraxot basato su **mcamara/laravel-localization**. Header, footer, nav e componenti usano gli helper del package per URL e locale.

## Package di riferimento

- **mcamara/laravel-localization**: [README](https://github.com/mcamara/laravel-localization)
- **Regola progetto**: [.cursor/rules/laravel-localization-mcamara.mdc](../../../.cursor/rules/laravel-localization-mcamara.mdc)
- **Memoria**: [.cursor/memories/laravel-localization-mcamara.md](../../../.cursor/memories/laravel-localization-mcamara.md)
- **Riferimento completo**: [Modules/Lang/docs/laravel-localization-mcamara-reference.md](../../modules/lang/docs/laravel-localization-mcamara-reference.md)

## Locale detection in Folio context (CRITICAL)

Nel contesto Folio, `LaravelLocalization::setLocale()` NON viene chiamato come nelle route tradizionali. La detection avviene tramite:

1. **URL prefix** (source of truth): il primo segmento dell'URL (es. `/en/events` -> `'en'`)
2. **Session**: persistito dal middleware `SetLocale` dopo la prima detection da URL
3. **Config default**: `config('app.locale')` come fallback

Il middleware `SetLocale` (`Modules/UI/Http/Middleware/SetLocale.php`) rileva il locale dall'URL, lo persiste in session, e chiama `app()->setLocale()`. Questo garantisce che `app()->getLocale()` restituisca sempre il valore corretto.

**Pattern corretto per Blade components:**
```php
// Rileva dal URL (più affidabile in Folio)
$segments = request()->segments();
$urlLocale = $segments[0] ?? null;
$supportedKeys = array_keys($locales);
$currentLocale = (is_string($urlLocale) && in_array($urlLocale, $supportedKeys, true))
    ? $urlLocale
    : app()->getLocale();
```

## Componenti principali

### Language switcher

- **Componente**: `x-ui.language-switcher`
- Usa **`LaravelLocalization::getSupportedLocales()`** per la lista delle lingue.
- Usa **`LaravelLocalization::getLocalizedURL($code, null, [], true)`** per i link (mantiene pagina corrente).
- Locale corrente: rileva dal primo segmento URL, con fallback a `app()->getLocale()`.

### Navigation (header e footer)

- **Tutti i link** in `x-sections.header` e `x-sections.footer` devono usare **`LaravelLocalization::localizeUrl($path)`**.
- Esempi: home, events, community, sponsors, login, register, chat.

### Auth buttons

- Link login/register: **`LaravelLocalization::localizeUrl('/login')`**, **`LaravelLocalization::localizeUrl('/register')`**.

## Best practices

- **Per il locale corrente** nei Blade components, rilevare dal primo segmento URL (`request()->segment(1)`), con fallback a `app()->getLocale()`. Questo e' affidabile nel contesto Folio perche' il middleware `SetLocale` detecta dal URL e persiste in session.
- **Non costruire** URL a mano (es. `url(app()->getLocale() . '/events')`); usare sempre **`LaravelLocalization::localizeUrl('/events')`**.
- Tutti i testi tradotti: **`__(...)`** o **`@lang`**; nessuna stringa hardcoded.
- `LaravelLocalization::getCurrentLocale()` puo' non funzionare correttamente in Folio perche' `setLocale()` non viene chiamato. Preferire URL detection.

## Regole operative (mcamara)

### Redirect + SEO

- È **fortemente raccomandato** usare middleware di redirect (session/cookie + redirect filter) per evitare contenuti diversi sulla stessa URL e problemi di **duplicate content SEO**.
- I link devono essere sempre localizzati per evitare redirect ad ogni click.

### Form e richieste POST

- Qualsiasi `action` di form che punta a route localizzate **deve** usare URL localizzati.
- Se non lo fai, il middleware può fare redirect e trasformare **POST in GET**.

### hreflang

- Nel language switcher usare `rel="alternate"` e `hreflang`.
- Per mantenere la pagina corrente e cambiare lingua: `LaravelLocalization::getLocalizedURL($localeCode, null, [], true)`.

## Route caching

- Il package **non è compatibile** con `php artisan route:cache` / `php artisan optimize` senza configurazione.
- In produzione usare:
  - `php artisan route:trans:cache`
  - `php artisan route:trans:clear`
  - `php artisan route:trans:list {locale}`

## Testing

- In test l’app viene bootstrapata prima della request: può causare 404 sulle rotte localizzate.
- Soluzione: settare `Mcamara\LaravelLocalization\LaravelLocalization::ENV_ROUTE_KEY` prima di fare request nelle suite (pattern ufficiale nel README del package).

## Middleware (Laravel 11/12)

- Su Laravel 11+ gli alias middleware si registrano in `bootstrap/app.php` (`withMiddleware()->alias([...])`), non solo in `Http\Kernel.php`.

## Riferimenti incrociati

- [Modules/Meetup/docs/localization-standard.md](../../modules/meetup/docs/localization-standard.md)
- [Modules/Cms/docs/folio-routing-locale.md](../../modules/cms/docs/folio-routing-locale.md)
