# Header Auth Localization And CTA Rule

## Regola

Nella header navigation le label auth non possono essere hardcoded in italiano.

Devono sempre passare da:

- `pub_theme::navigation.auth.login`
- `pub_theme::navigation.auth.register`

## UI rule

Per guest navigation:

- `login` deve essere CTA secondaria;
- `register` deve essere CTA primaria;
- i due bottoni devono avere gerarchia visiva chiara e linkare alle route localizzate `/auth/login` e `/auth/register`.
- la `headernav` CMS non deve duplicare markup/style/copy auth: deve delegare al partial condiviso `pub_theme::components.ui.auth-buttons`.

## Test richiesto

La homepage localizzata deve verificare almeno:

- `/it` mostra `Accedi` e `Registrati`
- `/de` non mostra label italiane e mostra `Anmelden` e `Registrieren`
