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
3. se il PHPDoc di una relazione audit/profile (`creator`, `updater`, `deleter`) punta a un model concreto, riallinearlo al contratto `\Modules\Xot\Contracts\ProfileContract`;
4. per queste relazioni il contratto viene prima del model concreto, per ridurre accoppiamento cross-modulo e mantenere il tipo stabile;
5. eseguire quality gate sul perimetro toccato;
6. aggiornare issue/discussion se la wave coinvolge molti moduli.
