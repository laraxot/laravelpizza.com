# No Hardcoded Theme Strings Rule

## Regola canonica

Nei temi di LaravelPizza non si hardcodano stringhe UI.

Ogni testo visibile nel frontoffice deve usare una chiave di traduzione, con namespace coerente:

- `pub_theme::...` per il tema;
- `module::...` per contenuti posseduti dal modulo.

## Anti-pattern vietati

- CTA scritte raw dentro Blade (`Accedi`, `Registrati`, `Log in`, `Sign up`, ecc.);
- voci menu, heading, footer copy, badge, empty states o messaggi inline hardcoded;
- fallback italiani dentro pagine con locale diverso;
- traduzioni "temporanee" nel Blade in attesa di sistemare i file `lang`.

## Pattern corretto

1. aggiungere o aggiornare le chiavi in `lang/{locale}/*.php`;
2. usare solo `__()`, `@lang()` o equivalent wrapper con namespace corretto;
3. coprire almeno una route localizzata nei test se il testo e' user-facing.

## Impatto

Questa regola vale per tutti i temi attivi e per qualunque view modulo che renda markup del tema.
