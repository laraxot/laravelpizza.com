# Memory: IDE Helper Live DB

- `ide-helper:models -W` in questo progetto legge lo schema reale di piu' connessioni (`mysql`, `activity`, `gdpr`, `xot`).
- Gli errori `SQLSTATE[HY000] [2002]` visti nel sandbox non sono automaticamente problemi dei modelli.
- Prima di correggere codice o phpdoc bisogna confermare il run in ambiente con MySQL locale raggiungibile.
