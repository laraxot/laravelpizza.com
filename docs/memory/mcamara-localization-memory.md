# mcamara Localization Memory

## Decisione da ricordare

La localizzazione URL nel progetto non si implementa “a mano”.

La fonte di verita' e':

- gruppo route con `LaravelLocalization::setLocale()`;
- helper `localizeUrl()` e `getLocalizedURL()`;
- middleware del pacchetto registrati in `bootstrap/app.php`.

## Dettagli importanti

- il prefisso locale va sempre mostrato, anche per la lingua di default;
- i redirect di localizzazione non devono interferire con `POST/PUT/PATCH/DELETE`;
- i language switcher devono preservare la route corrente tramite `getLocalizedURL()`.
