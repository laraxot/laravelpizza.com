# mcamara Laravel Localization Rule

## Regola

Nel progetto gli URL localizzati devono seguire la convenzione del pacchetto `mcamara/laravel-localization`, non helper custom o concatenazioni manuali.

## Regole operative

- route pubbliche dentro gruppo con `LaravelLocalization::setLocale()`;
- middleware localizzazione registrati come alias e applicati al gruppo;
- link interni generati con `LaravelLocalization::localizeUrl()` oppure `LaravelLocalization::getLocalizedURL()`;
- language switcher costruito con `getLocalizedURL($locale, null, [], true)`;
- nessun hardcode di `/it`, `/en`, `/de` nelle viste pubbliche.

## Config di progetto da ricordare

- `hideDefaultLocaleInURL = false`
- `useAcceptLanguageHeader = true`
- `httpMethodsIgnored = ['POST', 'PUT', 'PATCH', 'DELETE']`

## Implicazione

Se un URL pubblico o un redirect non passa dagli helper del pacchetto, va considerato sospetto e corretto.
