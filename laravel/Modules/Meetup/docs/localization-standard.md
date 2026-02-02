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

- **Locale corrente**: usare **`LaravelLocalization::getCurrentLocale()`** (preferire a `app()->getLocale()`).
- **Lingue supportate**: **`LaravelLocalization::getSupportedLocales()`** o **`getLocalesOrder()`** (es. per language switcher).

## Traduzioni (testi)

- Tutte le stringhe statiche devono usare **`__()`** o **`@lang`**.
- Domini chiave: `meetup::events`, `meetup::community`, `meetup::common`.

## Icone e bandiere

- Bandiere per le lingue: usare il set icone (es. `ui-flags.{code}`) con `x-filament::icon`; non hardcodare SVG/emoji.

## Preservare stato

- Il middleware di mcamara (LocaleSessionRedirect, LaravelLocalizationRedirectFilter) gestisce session/cookie e redirect. Non impostare manualmente il locale in session per le pagine pubbliche.

## Riferimenti incrociati

- [Themes/Meetup/docs/localization-standard.md](../../../Themes/Meetup/docs/localization-standard.md)
- [Cms/docs/folio-routing-locale.md](../Cms/docs/folio-routing-locale.md)
