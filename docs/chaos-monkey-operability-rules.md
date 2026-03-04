# Chaos Monkey Operability Rules (Xot)

## Scopo
Definire regole runtime del core Xot per contenere fault randomizzati senza rompere i contratti architetturali.

## Regole Non Negoziabili
1. Tutte le classi Filament devono estendere `XotBase*`.
2. Nessuna traduzione manuale `->label()`, `->placeholder()`, `->helperText()`.
3. Action pattern invariato: `app(Action::class)->execute(...)`, senza constructor DI.
4. `belongsToManyX()` obbligatorio dove previsto.
5. Nessun workaround con route/controller nel frontoffice.

## Strategia Incident Response
1. Isolare il layer rotto (Xot base, modulo, tema, CMS data).
2. Verificare prima i contratti Xot, poi il codice custom.
3. Correggere la violazione del contratto, non il sintomo.
4. Aggiungere test o static rule che blocca la ricaduta.

## Check Tecnici
```bash
./vendor/bin/phpstan analyze Modules/Xot --level=10
php artisan test --filter=Xot --compact
```

## Escalation
Se il fault coinvolge più moduli, trattare Xot come sorgente di verità e sincronizzare i rules-index dipendenti.
