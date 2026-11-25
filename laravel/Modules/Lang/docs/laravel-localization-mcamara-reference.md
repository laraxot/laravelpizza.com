---
title: "Localizzazione degli URL con mcamara/laravel-localization"
type: reference
module: Lang
updated: 2026-11-25
qmd: "mcamara laravel-localization supportedLocales localizeUrl getLocalizedURL getCurrentLocale middleware locale prefisso url lingua"
related:
  - ./folio-volt-localization.md
  - ./language-switcher-and-flags.md
  - ./adr/0001-cambio-lingua-con-url-localizzato.md
---
# Localizzazione degli URL con mcamara/laravel-localization

Riferimento unico per la lingua nell'URL. Il pacchetto e' una dipendenza di `Modules/Lang/composer.json`
(`mcamara/laravel-localization`); le lingue del sito sono quelle di `laravellocalization.supportedLocales`, non quelle
dell'editor delle traduzioni (vedi [translation-file-editor.md](translation-file-editor.md)).

## Configurazione

File `laravel/config/laravellocalization.php` (config di progetto, non del modulo). Valori al momento della scrittura:

| Chiave | Valore | Effetto |
|---|---|---|
| `supportedLocales` | `it`, `en`, `de`, `fr`, `es`, `ru` (ognuna con `name`, `script`, `native`, `regional`) | unica fonte delle lingue del sito |
| `localesOrder` | `it, en, de, fr, es, ru` | ordine nei selettori |
| `hideDefaultLocaleInURL` | `false` | il prefisso c'e' sempre, anche per la lingua di default |
| `useAcceptLanguageHeader` | `true` | la prima visita senza prefisso negozia la lingua con `Accept-Language` |
| `urlsIgnored` | `/skipped` | percorsi che il pacchetto non tocca |
| `httpMethodsIgnored` | `POST`, `PUT`, `PATCH`, `DELETE` | il redirect di localizzazione non scatta su questi metodi |

Una lingua nuova si aggiunge qui; widget, selettore e `ListLocaleOptionsAction` la leggono da questo array senza altre modifiche.

## Middleware

`laravel/bootstrap/app.php` registra gli alias del pacchetto: `localize` (`LaravelLocalizationRoutes`), `localizationRedirect`
(`LaravelLocalizationRedirectFilter`), `localeSessionRedirect`, `localeCookieRedirect`, `localeViewPath`. Inoltre
`redirectGuestsTo` manda gli ospiti a `LaravelLocalization::localizeUrl('/auth/login')`.

Le pagine pubbliche (Folio) montano `LaravelLocalizationRoutes`, `LocaleSessionRedirect` e `LaravelLocalizationRedirectFilter`
(non `LocaleCookieRedirect` ne' `LaravelLocalizationViewPath`): dettagli in [folio-volt-localization.md](folio-volt-localization.md).

## Chi imposta la lingua della richiesta

| Punto | Cosa fa |
|---|---|
| `Modules\Cms\Http\Middleware\SetFolioLocale` | pagine Folio: primo segmento dell'URL se supportato, altrimenti `users.lang` dell'utente se supportata, altrimenti `app.locale`; imposta sia `app()->setLocale()` sia `LaravelLocalization::setLocale()` |
| `Modules\Lang\Providers\RouteServiceProvider::registerLang()` | se il primo segmento e' una lingua di `supportedLocales`, chiama `app()->setLocale()`; la lingua, quando c'e', e' sempre il primo segmento |
| `Modules\Xot\Http\Middleware\SetPanelLocaleFromUserMiddleware` | pannelli Filament (URL senza prefisso): lingua salvata in `users.lang`, se supportata; anche per le richieste Livewire |
| `Modules\Lang\Filament\Actions\LocaleSwitcherRefresh` | azione dell'editor: salva `locale` in sessione e chiama `App::setLocale()` |
| `Modules\UI\Http\Middleware\SetLocale` | accetta solo `it`/`en` (lista fissa), salva in sessione; non e' il punto di riferimento per le lingue del sito |

Chiamare `app()->setLocale()` senza `LaravelLocalization::setLocale()` lascia `localizeUrl()`, `getLocalizedURL()` e `getCurrentLocale()`
sulla lingua precedente: tutti i link finiscono sulla lingua di default.

## Regole d'uso

1. **Link a pagine localizzate**: `LaravelLocalization::localizeUrl('/percorso')`, con il percorso senza prefisso. Mai costruire `'/'.$locale.'/...'` a mano.
2. **Action dei form** (login, registrazione, submit): localizzate (`localizeUrl('/login')`). Una POST verso un URL senza prefisso viene reindirizzata e diventa GET.
3. **Lingua corrente**: `LaravelLocalization::getCurrentLocale()`, non `app()->getLocale()`.
4. **Selettore di lingua**: `LaravelLocalization::getLocalizedURL($code, null, [], true)`; il quarto argomento forza il prefisso anche quando `hideDefaultLocaleInURL` e' `true`.
5. **Mai** una rotta o un controller solo per cambiare lingua: lo fa il widget (`LanguageSwitcherWidget`), che torna sulla stessa pagina nella lingua scelta.
6. **Test**: `refreshApplicationWithLocale($locale)` e richieste con prefisso (`$this->get('/en/')`).
7. **Cache delle rotte**: con le rotte tradotte del pacchetto la cache e' `php artisan route:trans:cache` (e `route:trans:clear`, `route:trans:list {locale}`), non `route:cache`; vale solo se si usano rotte tradotte con `LaravelLocalizationRoutes`.

## Errori comuni

- Link senza prefisso su una pagina che esiste solo sotto `/{lingua}`: 404 (le pagine Folio esistono solo con prefisso; il redirect da `/events` a `/it/events` lo fa Cms, vedi [folio-volt-localization.md](folio-volt-localization.md)).
- Elenco delle lingue scritto a mano in un selettore: usare `supportedLocales`.
- `config/laravellocalization.php` con una voce che non e' un array: `ThemeComposer::languages()` lancia `InvalidArgumentException` con il codice della lingua sbagliata.

## Riferimenti

- Pacchetto: <https://github.com/mcamara/laravel-localization>
- Routing delle pagine: [`Modules/Cms/docs/folio-routing-locale.md`](../../Cms/docs/folio-routing-locale.md)
- Decisione: [ADR 0001](adr/0001-cambio-lingua-con-url-localizzato.md)
