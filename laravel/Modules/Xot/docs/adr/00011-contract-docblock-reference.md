---
title: "ADR 00011 — @contract docblock reference on Actions"
type: decision
status: superseded by 0011-contract-docblock-reference.md
created: 2026-11-23
updated: 2026-11-24
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/ADR-00011"
superseded_by: 0011-contract-docblock-reference.md
<<<<<<< .merge_file_9fc1ca
qmd: "00011 contract docblock reference actions"
=======
>>>>>>> .merge_file_E9ESg9
---

> Superseded da [0011-contract-docblock-reference.md](0011-contract-docblock-reference.md): numerazione malformata a cinque cifre della stessa decisione. Nessuna decisione nuova: il canonico prevale, questo file non va esteso.

# ADR 00011: @contract docblock reference on Actions

## Contesto

Il progetto usa la metodologia **@contract** per documentare il comportamento delle Action. Ogni Action deve avere un docblock `@contract` che punta a un file di contratto in `docs/contracts/` del modulo owner.

Questo permette:
- Documentazione del contratto separata dal codice
- Verifica automatica della presenza del file di contratto
- Riferimento chiaro per chi legge il codice

## Decisione

Ogni Action in `Modules/<M>/app/Actions/` deve avere:

```php
/**
 * @contract docs/contracts/<action-name>.md
 * @see Modules/<M>/docs/contracts/<action-name>.md
 */
final class SomeAction
{
    use QueueableAction;
    // ...
}
```

## Driver della decisione

- Il contratto deve essere trovabile dal codice senza duplicare la specifica nel docblock.
- Un controllo statico deve poter verificare esistenza e collegamento del file.

## Alternative scartate

- Tenere il contratto solo nel docblock dell'Action.
- Tenere un unico contratto globale senza collegamento all'Action concreta.

Il file di contratto deve esistere in `Modules/<M>/docs/contracts/` e deve seguire il formato standard:

```markdown
# Contratto: SomeAction

## Input
- `param1` (string): descrizione
- `param2` (int): descrizione

## Output
- `bool`: descrizione

## Invarianti
- L'azione non modifica lo stato se non tramite i metodi autorizzati

## Effetti collaterali
- Aggiorna il log delle attività
- Notifica l'assegnatario

## Errori
- `InvalidArgumentException` se i parametri non sono validi
- `DomainException` se lo stato non permette la transizione

## Non fa
- Non cancella i ticket
- Non modifica i permessi dell'utente
```

## Alternative scartate

- Conservare soltanto testo libero nel docblock: non è verificabile in modo
  affidabile dall'harness.
- Copiare il contratto dentro il codice: duplica la documentazione e la rende
  fragile quando cambia il comportamento.

## Conseguenze

### Positive
- Documentazione del contratto sempre aggiornata
- Riferimento chiaro per chi legge il codice
- Possibilità di audit automatico

### Negative
- Debito iniziale per aggiungere i contratti alle Action esistenti
- Mantenimento dei contratti quando le Action cambiano

## Conferma

La regola è verificata da `Modules/Xot/tests/Unit/Docs/ActionContractsAreCompleteTest.php` quando il contratto e l'Action esistono nel modulo owner.

## Cross-link

- [ADR 0001: Actions over services](0001-actions-over-services.md)
- [ADR 0002: QueueableAction](0002-queueable-actions-over-framework-jobs.md)
- [Action Contracts Are Complete Test](https://github.com/laraxot/base_fixcity_fila5/blob/main/laravel/Modules/Xot/tests/Unit/Docs/ActionContractsAreCompleteTest.php)
