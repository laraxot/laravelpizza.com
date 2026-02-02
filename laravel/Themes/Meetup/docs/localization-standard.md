# Localization Standard (Tema Meetup)

## Overview

Il tema Meetup implementa lo standard di localizzazione Laraxot basato su **mcamara/laravel-localization**. Header, footer, nav e componenti usano gli helper del package per URL e locale.

## Package di riferimento

- **mcamara/laravel-localization**: [README](https://github.com/mcamara/laravel-localization)
- **Regola progetto**: [.cursor/rules/laravel-localization-mcamara.mdc](../../../.cursor/rules/laravel-localization-mcamara.mdc)
- **Memoria**: [.cursor/memories/laravel-localization-mcamara.md](../../../.cursor/memories/laravel-localization-mcamara.md)
- **Riferimento completo**: [Modules/Lang/docs/laravel-localization-mcamara-reference.md](../../Modules/Lang/docs/laravel-localization-mcamara-reference.md)

## Componenti principali

### Language switcher

- **Componente**: `x-ui.language-switcher`
- Usa **`LaravelLocalization::getSupportedLocales()`** (o `getLocalesOrder()`) e **`LaravelLocalization::getLocalizedURL($code, null, [], true)`** per mantenere la pagina corrente e cambiare lingua.
- Locale corrente: **`LaravelLocalization::getCurrentLocale()`**.

### Navigation (header e footer)

- **Tutti i link** in `x-sections.header` e `x-sections.footer` devono usare **`LaravelLocalization::localizeUrl($path)`**.
- Esempi: home, events, community, sponsors, login, register, chat.

### Auth buttons

- Link login/register: **`LaravelLocalization::localizeUrl('/login')`**, **`LaravelLocalization::localizeUrl('/register')`**.

## Best practices

- **Non usare** `app()->getLocale()` nei componenti; preferire **`LaravelLocalization::getCurrentLocale()`** per coerenza con il package.
- **Non costruire** URL a mano (es. `url(app()->getLocale() . '/events')`); usare sempre **`LaravelLocalization::localizeUrl('/events')`**.
- Tutti i testi tradotti: **`__(...)`** o **`@lang`**; nessuna stringa hardcoded.

## Riferimenti incrociati

- [Modules/Meetup/docs/localization-standard.md](../../Modules/Meetup/docs/localization-standard.md)
- [Modules/Cms/docs/folio-routing-locale.md](../../Modules/Cms/docs/folio-routing-locale.md)
