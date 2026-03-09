# Header Auth CTA Localization Memory

## Decisione da ricordare

I bottoni auth dell'header sono un punto di regressione facile:

- se il Blade usa stringhe hardcoded, l'header resta in italiano anche su `/en`, `/de`, `/fr`, ecc.;
- il microcopy deve arrivare da `pub_theme::navigation.auth.*`.

## Regola pratica

Quando tocco header/nav del tema:

- controllo subito le chiavi `navigation.php`;
- verifico `/it` e almeno una locale non italiana;
- aggiungo o aggiorno un Pest test di regressione.
