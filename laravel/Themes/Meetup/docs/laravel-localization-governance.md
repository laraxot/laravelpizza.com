# Theme Meetup And Laravel Localization

## Obiettivo

Nel tema `Meetup` il prefisso locale deve controllare la lingua del documento, le URL navigate dall'utente e gli elementi SEO del markup.

## Regole pratiche

- `/de` deve produrre pagina tedesca, non solo una route valida.
- Il layout principale deve esporre `lang` coerente con la locale attiva.
- Il language switcher deve usare `LaravelLocalization::getLocalizedURL()` o helper equivalenti del package.
- I link tematici verso pagine CMS, auth, eventi, profili e form submission devono essere localizzati con helper del package.
- Se la default locale e' nascosta nell'URL, il tema deve considerare normale il redirect verso URL senza prefisso default e non introdurre link misti.

## Test minimi del tema

- Verificare la home per almeno `it`, `en`, `de`.
- Verificare almeno una CTA o link del layout che resti nella stessa lingua.
- Verificare che una `form action` renderizzata in pagina localizzata non punti a URL nuda non localizzata.

## Fonte

- README ufficiale `mcamara/laravel-localization`: https://github.com/mcamara/laravel-localization
