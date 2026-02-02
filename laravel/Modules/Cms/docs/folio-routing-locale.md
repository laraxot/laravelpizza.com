# Folio routing e locale (mcamara/laravel-localization)

## Come funziona

- **FolioVoltServiceProvider** (modulo Cms) registra le pagine Folio del tema pubblico e dei moduli con **prefisso lingua**.
- Per ogni lingua in **`config('laravellocalization.supportedLocales')`** (es. `it`, `en`) viene registrato un path Folio con **`->uri($locale)`**.
- Risultato: le pagine sono servite sotto **`/{locale}/...`** (es. `/it/`, `/en/events`, `/it/contact`).

## Middleware

- **LocaleSessionRedirect**: salva il locale in session quando è presente in URL; se manca, redirect con locale (da session o Accept-Language).
- **LaravelLocalizationRedirectFilter**: se `hideDefaultLocaleInURL` è true, redirect da `/it/...` a `/...` per la lingua di default.
- Inline: **`app()->setLocale($locale)`** per ogni request Folio.

## Implicazioni per i moduli e il tema

1. **Link**: tutti i link verso pagine pubbliche (home, events, community, login, register, ecc.) devono usare **`LaravelLocalization::localizeUrl($path)`**. Non usare `url('/events')` o `url(app()->getLocale() . '/events')`.
2. **Form**: le action di form (login, register, submit) devono essere localizzate con **`LaravelLocalization::localizeUrl('/login')`** ecc., altrimenti POST diventa GET dopo redirect.
3. **Componenti**: header, footer, nav, blocchi CTA, auth buttons: ovunque ci sia un `<a href="...">` o `action="..."` verso una pagina localizzata, usare gli helper di mcamara (vedi [laravel-localization-mcamara.mdc](../../../../.cursor/rules/laravel-localization-mcamara.mdc)).

## Dove sono definite le rotte

- Le rotte **non** sono in `routes/web.php` per il frontoffice.
- Sono definite da **Folio** in base ai file in:
  - **Tema**: `Themes/Meetup/resources/views/pages/` (path da XotData::getPubThemeViewPath('pages')).
  - **Moduli**: `Modules/{ModuleName}/resources/views/pages/` (se la cartella esiste).
- Ogni file Blade in `pages/` diventa una rotta; il prefisso `$locale` è aggiunto da Folio con **`->uri($locale)`**.

## Riferimenti

- [Regola laravel-localization-mcamara](../../../../.cursor/rules/laravel-localization-mcamara.mdc)
- [Lang: laravel-localization reference](../Lang/docs/laravel-localization-mcamara-reference.md)
- [Meetup localization standard](../Meetup/docs/localization-standard.md)
- [mcamara/laravel-localization README](https://github.com/mcamara/laravel-localization)
