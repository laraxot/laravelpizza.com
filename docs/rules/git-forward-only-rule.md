# Git Forward-Only Rule

## Regola vincolante

Nel progetto si lavora **solo in avanti**:

- e' consentito studiare/storico con `git log`, `git show`, `git diff`;
- **non** e' consentito recuperare o ripristinare versioni vecchie come strategia di lavoro ordinaria.

## Comportamenti richiesti

1. Correggere i problemi con nuove commit/modifiche incrementali.
2. Evitare rollback distruttivi del workspace condiviso.
3. Documentare nelle issue/discussions ogni correzione significativa.
4. Se un refactor rimuove metodi o helper usati ancora dal codice attivo, studiare il contratto con `git show` e reintrodurre solo wrapper compatibili minimi, senza copiare interi file storici.
5. Quando si studia uno storico, il risultato va tradotto in codice e docs attuali: mai ripristino wholesale, sempre adattamento al perimetro corrente.

## Obiettivo

Mantenere tracciabilita', collaborazione multi-agente e audit lineare del lavoro.
