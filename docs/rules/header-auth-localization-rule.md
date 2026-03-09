# Header Auth Localization Rule

## Regola

Nel frontoffice pubblico i CTA auth dell'header devono essere sempre localizzati con chiavi di traduzione del tema.

## Regole operative

- usare `pub_theme::navigation.auth.login`
- usare `pub_theme::navigation.auth.register`
- vietato hardcodare `Accedi`, `Registrati` o equivalenti nel Blade dell'header;
- per lingue non italiane non devono apparire fallback italiani nel markup finale.

## UX

- `login` e' azione secondaria;
- `register` e' CTA primaria;
- desktop e mobile devono mantenere la stessa gerarchia visiva.
