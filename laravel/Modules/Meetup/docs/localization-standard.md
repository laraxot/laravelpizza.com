# Localization Standard (Modulo Meetup)

## Overview

Il modulo Meetup segue lo standard di localizzazione basato su **mcamara/laravel-localization**. Tutti gli URL pubblici e i link devono preservare il locale e usare gli helper del package.

## Package di riferimento

- **mcamara/laravel-localization**: [README](https://github.com/mcamara/laravel-localization)
- **Regola progetto**: [.cursor/rules/laravel-localization-mcamara.mdc](../../../../.cursor/rules/laravel-localization-mcamara.mdc)
- **Memoria**: [.cursor/memories/laravel-localization-mcamara.md](../../../../.cursor/memories/laravel-localization-mcamara.md)
- **Riferimento completo**: [Lang/docs/laravel-localization-mcamara-reference.md](../Lang/docs/laravel-localization-mcamara-reference.md)

## URL e link

- **Tutti i link** verso pagine localizzate (home, events, community, sponsors, login, register) devono usare **`LaravelLocalization::localizeUrl($path)`** (path senza prefisso lingua).
- **Form action** (login, register, submit) devono essere localizzati, altrimenti POST diventa GET dopo redirect.

```blade
<a href="{{ LaravelLocalization::localizeUrl('/events') }}">Events</a>
<a href="{{ LaravelLocalization::localizeUrl('/events/' . $event->slug) }}">{{ $event->title }}</a>
<form action="{{ LaravelLocalization::localizeUrl('/login') }}" method="POST">
```

## Locale e lingue supportate

- **Locale corrente nei Blade components**: rilevare dal primo segmento URL (`request()->segment(1)`), con fallback a `app()->getLocale()`. Il middleware `SetLocale` (`Modules/UI/Http/Middleware/SetLocale.php`) detecta il locale dall'URL e lo persiste in session.
- `LaravelLocalization::getCurrentLocale()` puo' non funzionare correttamente nel contesto Folio perche' `LaravelLocalization::setLocale()` non viene chiamato come nelle route tradizionali. Preferire URL detection.
- **Lingue supportate**: **`LaravelLocalization::getSupportedLocales()`** o **`getLocalesOrder()`** (es. per language switcher).

## Traduzioni (testi)

- Tutte le stringhe statiche devono usare **`__()`** o **`@lang`**.
- Domini chiave: `meetup::events`, `meetup::community`, `meetup::common`.

## Icone e bandiere

- Bandiere per le lingue: usare il set icone (es. `ui-flags.{code}`) con `x-filament::icon`; non hardcodare SVG/emoji.

## Preservare stato

- Il middleware `SetLocale` rileva il locale dall'URL prefix, lo persiste in session, e lo imposta con `app()->setLocale()`.
- Il middleware di mcamara (LocaleSessionRedirect, LaravelLocalizationRedirectFilter) e' registrato nel Folio middleware stack (`FolioVoltServiceProvider`) per gestire redirect.
- Il locale viene anche impostato dalla closure inline di Folio per ogni prefisso lingua.

## Route caching

- Il package **non è compatibile** con `php artisan route:cache` / `php artisan optimize` senza configurazione.
- Usare i comandi dedicati:
  - `php artisan route:trans:cache`
  - `php artisan route:trans:clear`
  - `php artisan route:trans:list {locale}`

## Testing

- In test può verificarsi 404 su rotte localizzate perché l’app viene bootstrapata prima della request.
- Soluzione: settare `Mcamara\LaravelLocalization\LaravelLocalization::ENV_ROUTE_KEY` per la lingua prima di fare request (pattern ufficiale nel README del package).

## Language switcher e hreflang

- Per cambiare lingua mantenendo la pagina corrente usare `LaravelLocalization::getLocalizedURL($localeCode, null, [], true)`.
- Aggiungere `rel="alternate"` e `hreflang` per SEO.

## Riferimenti incrociati

- [Themes/Meetup/docs/localization-standard.md](../../../Themes/Meetup/docs/localization-standard.md)
- [Cms/docs/folio-routing-locale.md](../Cms/docs/folio-routing-locale.md)
