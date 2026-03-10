# Skill: IDE Helper Models Refresh

## Trigger
Quando il task chiede di eseguire `php artisan ide-helper:models -W` o di correggere segnalazioni legate a phpdoc dei modelli.

## Principio
Il comando dipende dallo schema reale del database, quindi prima va distinto un errore infrastrutturale da un errore del modello.

## Passi
1. verificare docs-first su ide-helper e quality gates;
2. eseguire il comando in ambiente con connessioni DB raggiungibili;
3. se compaiono `SQLSTATE[HY000] [2002]`, trattarli come blocco ambientale finche' non si conferma il run live;
4. correggere solo le segnalazioni residue reali di model/relation/phpdoc;
5. aggiornare docs e thread GitHub con il perimetro reale del problema.
