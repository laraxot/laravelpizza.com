---
title: "ADR — Un modello persistente, una migrazione owner di creazione"
type: decision
status: accepted
created: 2026-11-23
updated: 2026-11-24
decision-makers: [team Laraxot]
issues: []
---

# Un modello persistente, una migrazione owner di creazione

## Contesto

Le migrazioni sono il ledger forward-only dello schema. In una struttura modulare la tabella deve avere un proprietario
riconoscibile: più migrazioni `create` per lo stesso modello, o migrazioni sparse in moduli diversi, rendono ambiguo
l'owner, fanno divergere schema, modello e connessione e possono rompere ambienti già migrati. Il problema emerge spesso
solo su un database nuovo o nello scratch test.

## Driver della decisione

- Ownership esplicita del modello e della tabella, con un'unica fonte per la creazione dello schema.
- `XotBaseMigration` deriva modello e modulo dal filename canonical, quindi il nome è parte del contratto.
- Lo schema già distribuito non può essere riscritto con rollback distruttivi: migrazioni additive e ri-eseguibili
  secondo le regole del progetto.
- Audit statico semplice e ripetibile.

## Alternative scartate

- Una migrazione `create` per ogni modulo che usa il modello, o più `create_*` per lo stesso modello con timestamp
  diversi.
- Una migrazione monolitica per più modelli non appartenenti allo stesso aggregate.
- Modificare la migrazione già distribuita per aggiungere colonne.
- Usare nomi che descrivono una colonna invece della tabella owner.
- Correggere lo schema direttamente nel database senza una migrazione owner.

## Decisione

Per ogni modello Eloquent persistente nuovo si crea una sola migrazione di creazione, nel modulo che possiede il
modello, con nome `YYYY_MM_DD_HHMMSS_create_<modello_plurale>_table.php` (snake_case, plurale, `_table`; il timestamp
serve al ledger Laravel, non è una data nel nome dell'ADR). La cartella canonica è `database/migrations/`, minuscola,
e la migrazione usa `XotBaseMigration` quando il contratto del modulo lo richiede. Pivot e tabelle tecniche hanno una
propria migrazione esplicita. Ogni evoluzione successiva è una migrazione additiva forward-only con `tableUpdate()` e
guardie (`hasColumn()`), e solo quando la storia dello schema lo richiede.

## Conseguenze

- Buono: ownership, connessione e schema sono rintracciabili; le nuove migrazioni sono facilmente verificabili e
  derivabili.
- Buono: i test possono verificare una sola migrazione owner per tabella.
- Cattivo: il legacy può contenere doppioni o modelli senza tabella. Le duplicazioni storiche restano censite e si
  correggono con audit e migrazioni forward-only, mai con cancellazioni distruttive automatiche né rinominando o
  cancellando senza controllo del ledger.
- Una modifica di schema richiede test e, quando necessario, una story BMAD owner-localizzata.

## Conferma

- Gli audit del modulo verificano naming, owner e schema.
- La review cerca collisioni `create_*`, verifica `$model_class` per le migrazioni additive e legge
  [migration-filename-from-model-name](../wiki/rules/migration-filename-from-model-name.md) prima dell'esecuzione.
- Prima di una migrazione si controllano modello, tabella, connessione e chiamanti.
- Riferimento: [XotBaseMigration](../../app/Database/Migrations/XotBaseMigration.php).

## Verifica

- `cd laravel && vendor/bin/pest Modules/Xot/tests/Unit/XotMigrationUuidModelClassCoverageTest.php` copre la
  risoluzione del modello da parte di `XotBaseMigration` (`Modules/Xot/app/Database/Migrations/XotBaseMigration.php`).
- Non esiste un test che verifichi nome e unicità delle migrazioni di creazione per modello: la verifica è la
  revisione con `rg --files laravel/Modules -g '*create_<tabella>_table.php'`.
