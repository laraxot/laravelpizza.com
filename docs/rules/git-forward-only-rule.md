# Git Forward-Only Rule

## Regola vincolante

Nel progetto si lavora **solo in avanti**:

- e' consentito studiare/storico con `git log`, `git show`, `git diff`;
- **non** e' consentito recuperare o ripristinare versioni vecchie come strategia di lavoro ordinaria;
- **non** si usano `git checkout -- <file>` o `git restore <file>` per tornare a una versione precedente di un file condiviso;
- **non** si usano `git reset --hard`, `git clean -fd` o altre azioni distruttive per "ripulire" il workspace condiviso.

## Rafforzamento operativo (2026-03-10)

La regola vale anche sotto pressione, durante hotfix o incidenti:

- non si torna indietro con comandi di rollback del workspace;
- si legge lo storico con `git show`/`git diff`;
- si produce una patch minima forward-only sul codice corrente;
- si aggiorna sempre Issue/Discussion con il razionale della correzione.

## Perche'

- il repository e' condiviso da piu' agenti e persone, quindi tornare indietro localmente puo' cancellare o nascondere lavoro concorrente;
- la storia Git serve come audit trail e come strumento di diagnosi, non come scorciatoia operativa per annullare il presente;
- un rollback locale opaco rende piu' difficile capire quale contratto fosse corretto e quale correzione sia stata introdotta davvero;
- nel progetto la correzione giusta e' una modifica nuova, piccola, leggibile e tracciabile.

## Comportamenti richiesti

1. Correggere i problemi con nuove commit/modifiche incrementali.
2. Evitare rollback distruttivi del workspace condiviso.
3. Documentare nelle issue/discussions ogni correzione significativa.
4. Se un refactor rimuove metodi o helper usati ancora dal codice attivo, studiare il contratto con `git show` e reintrodurre solo wrapper compatibili minimi, senza copiare interi file storici.
5. Quando si studia uno storico, il risultato va tradotto in codice e docs attuali: mai ripristino wholesale, sempre adattamento al perimetro corrente.
6. Se un file e' sbagliato, lo si corregge nel presente; non si "riporta indietro" il file a uno snapshot passato.
7. Se la tentazione e' usare `reset`, `restore` o `revert`, fermarsi e riscrivere il piano come: lettura storico -> comprensione contratto -> patch minima forward-only -> quality gate -> issue/discussion.
8. `git revert` non e' la strategia standard del progetto: prima si ragiona sullo stato corrente e si produce una correzione forward-only esplicita.

## Comportamenti vietati

- `git reset --hard`
- `git checkout -- <file>`
- `git checkout <sha> -- <file>`
- `git restore --source ...`
- `git clean -fd` come scorciatoia per "ripulire"
- `git revert` usato per annullare meccanicamente lavoro recente senza correggere il presente
- `git commit --amend` su lavoro gia' condiviso

## Chiarimento

Il principio non e' solo "non riscrivere la history".

Il principio corretto e':
- usare git per capire il passato;
- non usare git per riportare il repository indietro;
- correggere il codice attuale con un nuovo passo coerente col perimetro presente.

## Obiettivo

Mantenere tracciabilita', collaborazione multi-agente e audit lineare del lavoro.
