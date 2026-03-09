# Mcamara Laravel Localization Skill

## Quando usarla

Usare questa skill quando il problema riguarda:

- prefissi lingua nelle URL;
- middleware locale;
- redirect di localizzazione;
- link language-switcher;
- bug tipo "`/de` non rende tedesco".

## Workflow

1. Verificare `supportedLocales`.
2. Verificare dove viene registrato il gruppo route / Folio path localizzato.
3. Controllare che i middleware della libreria siano davvero cablati prima del rendering.
4. Rimuovere workaround nei Blade se stanno sostituendo il middleware corretto.
5. Verificare i link con `getLocalizedURL()` / `localizeUrl()`.
6. Aggiungere test espliciti per i prefissi lingua.

## Anti-pattern

- `app()->setLocale()` dentro template come soluzione permanente;
- test che leggono la locale corrente invece di richiedere `/de` o `/en`;
- link localizzati costruiti a mano.
