# Lezione: niente codice con effetti nel blocco PHP delle pagine Folio

Data: 12/11/2026.

## Sintomo

Il test `Modules/User/tests/Feature/Auth/ResetPasswordMailTemplateTest` ("renders the German mail") falliva: con la
lingua `de`, l'email di reset usciva in italiano e con il link `/it/...`.

## Causa

`Themes/Meetup/resources/views/pages/auth/login.blade.php` e `register.blade.php` avevano, nel blocco PHP iniziale:

```php
$locale = request()->segments()[0] ?? 'it';
LaravelLocalization::setLocale($locale); app()->setLocale($locale);
```

Folio **esegue quel blocco anche solo per leggere `name()` e `middleware()`**, per esempio quando qualcuno chiama
`route('login')` (`InlineMetadataInterceptor`). `SpatieEmail` chiama `route('login')` mentre costruisce ogni email:
dove la richiesta non ha la lingua nell'URL (CLI, coda, scheduler, test) il blocco impostava `it` per tutto il resto
del processo. Promemoria e conferme spediti dalla coda potevano quindi uscire in italiano.

Trovato registrando un listener su `LocaleUpdated` con il backtrace: è il modo più veloce per sapere chi cambia la lingua.

## Regola

- Nelle pagine Folio il blocco PHP contiene solo `name()`, `middleware()`, `render()` e la classe Volt: nessuna
  chiamata con effetti (lingua, sessione, database, redirect).
- La lingua delle pagine pubbliche la imposta il middleware `SetFolioLocale` del modulo Cms.

Guardie: `Modules/Meetup/tests/Unit/Architecture/FolioPagesWithoutSideEffectsTest.php` (nessun `setLocale(` nelle
pagine del tema) e il test "generating the URL of a Folio page never changes the app language" in
`Modules/Meetup/tests/Feature/FrontOfficePrivacyAndSeoTest.php`.
