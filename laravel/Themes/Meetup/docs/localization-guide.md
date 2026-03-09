# Localization — Theme Integration

## Overview

The project uses [mcamara/laravel-localization](https://github.com/mcamara/laravel-localization) for URL-based locale detection. Folio pages are localized via a custom `SetFolioLocale` middleware.

## Supported Locales

| Code | Language | Native | URL Example |
|---|---|---|---|
| `it` | Italian | italiano | `/it/events` |
| `en` | English | English | `/en/events` |
| `de` | German | Deutsch | `/de/events` |
| `fr` | French | français | `/fr/events` |
| `es` | Spanish | español | `/es/events` |
| `ru` | Russian | Pусский | `/ru/events` |

## How It Works

1. User visits `/de/events`
2. `SetFolioLocale` middleware reads first URL segment (`de`)
3. Checks if `de` is in `supportedLocales` → YES
4. Calls `app()->setLocale('de')` → Laravel locale is now German
5. All `__()`, `trans()`, `@lang()` calls use German translations
6. `LaravelLocalization::getCurrentLocale()` returns `'de'`

## Template Rules

### Localizing URLs
```blade
{{-- CORRECT: always use localizeUrl for links --}}
<a href="{{ LaravelLocalization::localizeUrl('/events') }}">Events</a>

{{-- WRONG: hardcoded locale --}}
<a href="/it/events">Events</a>
```

### Language Selector
See [Cms localization guide](../../Modules/Cms/docs/laravel-localization-guide.md#language-selector-pattern).

### HTML Lang Attribute
```blade
<html lang="{{ LaravelLocalization::getCurrentLocale() }}"
      dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">
```

## Translation Files

Theme-specific translations should be in the module's lang directory:
```
Modules/Meetup/lang/it/  → Italian
Modules/Meetup/lang/en/  → English
Modules/Meetup/lang/de/  → German
Modules/Meetup/lang/fr/  → French
Modules/Meetup/lang/es/  → Spanish
Modules/Meetup/lang/ru/  → Russian
```
