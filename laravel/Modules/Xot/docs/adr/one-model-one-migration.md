---
title: "ADR — Un modello persistente, una migrazione di creazione"
type: decision
status: superseded by 0004-one-model-one-migration.md
created: 2026-11-23
updated: 2026-11-24
decision-makers: [team]
issues: []
superseded_by: 0004-one-model-one-migration.md
---

> Superseded da [0004-one-model-one-migration.md](0004-one-model-one-migration.md): alias senza numero della stessa decisione. Nessuna decisione nuova: il canonico prevale, questo file non va esteso.

# Un modello persistente, una migrazione di creazione

## Contesto

Le migrazioni sono il ledger forward-only dello schema. Creazioni duplicate dello stesso tavolo rendono ambiguo l'owner e possono rompere ambienti già migrati.

## Driver della decisione

- Un modello persistente deve avere un owner riconoscibile.
- `XotBaseMigration` deriva modello e modulo dal filename canonical.
- Lo schema già distribuito non può essere riscritto con rollback distruttivi.

## Alternative scartate

- Più `create_*` per lo stesso modello in moduli o timestamp diversi.
- Modificare la migrazione già distribuita per aggiungere colonne.
- Usare nomi che descrivono una colonna invece della tabella owner.

## Decisione

Per ogni nuovo modello persistente esiste una sola migrazione canonical `YYYY_MM_DD_HHMMSS_create_<table>_table.php`, nel modulo owner. Pivot e tabelle tecniche hanno una propria migrazione esplicita. Ogni evoluzione successiva è una migrazione additive forward-only con `tableUpdate()` e guardie; il filename usa `snake_case`, nome tabella plurale e `_table`.

## Conseguenze

- Le nuove migrazioni sono facilmente verificabili e derivabili.
- Le duplicazioni storiche restano censite e non vanno rinominate o cancellate senza controllo del ledger.
- Una modifica di schema richiede test e, quando necessario, una story BMAD owner-localizzata.

## Conferma

La review cerca collisioni `create_*`, verifica `$model_class` per migrazioni additive e controlla `migration-filename-from-model-name.md` prima dell'esecuzione.
