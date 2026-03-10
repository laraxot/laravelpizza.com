# theme-i18n-no-hardcoded-strings-skill.md

## Scopo

Impedire regressioni i18n nei temi eliminando stringhe UI hardcoded.

## Procedura

1. Cercare stringhe hardcoded nel file tema da modificare.
2. Sostituire con chiavi traduzione (`pub_theme::...` o namespace modulo).
3. Aggiungere/allineare le chiavi nei file `lang/{locale}`.
4. Verificare che non restino testi hardcoded nella vista.
5. Aggiornare issue/discussion con il delta.

## Comandi utili

```bash
rg -n \"(Accedi|Registrati|Login|Sign up|Sign in)\" laravel/Themes
rg -n \"__\\(|@lang\\(\" laravel/Themes/Meetup/resources/views
```

## DoD

- nessuna nuova stringa hardcoded UI nel tema toccato
- chiavi traduzione presenti e coerenti
- tracciamento GitHub aggiornato
