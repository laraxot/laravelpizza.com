# IDE Helper Models Wave - 2026-03-10

## Contesto

L'utente ha richiesto l'esecuzione di:

```bash
cd laravel && php artisan ide-helper:models -W
```

Il primo run nel sandbox mostrava errori di connessione per model multi-connessione come `Modules\Activity\Models\Activity` e `Modules\Xot\Models\Session`.

## Diagnosi corretta

Il problema iniziale non era nel codice dei model ma nell'accesso al database locale dal sandbox.

Dopo il rerun con accesso DB reale, la wave `ide-helper` ha completato la rigenerazione dei PHPDoc senza classi `Could not analyze`.

## Impatto

- i wrapper Passport e i model Sushi del modulo `User` restano compatibili con `ide-helper`;
- i PHPDoc dei model `User` sono stati riallineati al database corrente;
- la procedura corretta da ricordare e': prima distinguere errore ambientale da errore del model, poi correggere solo i casi reali.
