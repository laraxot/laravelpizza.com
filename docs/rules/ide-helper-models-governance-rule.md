# Regola: ide-helper models governance

## Regola

Quando si modifica il perimetro dei model Eloquent, delle relazioni o degli attributi persistiti, bisogna valutare una rigenerazione con:

```bash
cd laravel && php artisan ide-helper:models -W
```

## Vincoli operativi

- il comando va eseguito dalla cartella `laravel`;
- se i model usano connessioni multiple o schema reali, il run va fatto con accesso database effettivo;
- un errore di connessione del sandbox non va trattato come errore del model finche' non si riprova con accesso locale reale;
- i file generati da `ide-helper` sono forward-only: non si ripristinano vecchi PHPDoc da git.

## Dopo il run

1. controllare che non ci siano classi `Could not analyze`;
2. correggere solo le classi che falliscono davvero;
3. eseguire quality gate sul perimetro toccato;
4. aggiornare issue/discussion se la wave coinvolge molti moduli.
