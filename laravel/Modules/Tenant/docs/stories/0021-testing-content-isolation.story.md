---
title: "Isolamento dei contenuti tenant nei test"
status: active
qmd: "testing content isolation story isolamento contenuti"
---
<<<<<<< HEAD

# Isolamento dei contenuti tenant nei test

=======
# Isolamento dei contenuti tenant nei test

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.

>>>>>>> laraxot/dev
`GetTenantFilePathAction` usa una copia sotto `storage/framework/testing/tenant-content` per i JSON CMS quando l'applicazione gira in test. La copia viene inizializzata alla prima lettura dal contenuto versionato di `config/<tenant>/database/content`; le scritture dei test restano quindi fuori dal repository.

Questo mantiene `Section::getBlocksBySlug()` fedele alla produzione anche nei test che avviano direttamente `<x-section>`, evitando falsi verdi con header/footer privi di blocchi.

Verifica: i contratti Sixteen di header/footer passano con 21 test e 218 assertion.
<<<<<<< HEAD
=======


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

Aggiungere prova ripetibile (Pest exit code + conteggio, PHPStan, o skip host documentato).
>>>>>>> laraxot/dev
