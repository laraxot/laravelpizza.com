---title: "ADR — @contract nel docblock delle Action"
type: decision
status: superseded by 00011-contract-docblock-reference.md
created: 2026-11-23
updated: 2026-11-24
issues: []
qmd: "contract docblock reference action"
---

Superseded da [00011-contract-docblock-reference.md](00011-contract-docblock-reference.md).


# ADR: @contract nel docblock delle Action

## Contesto

Le Action in `Modules/*/app/Actions/` sono classi che contengono logica applicativa da invocare (`execute`). Molte
scrivono dati o chiamano servizi esterni, ma mancava una convenzione documentale per riferirsi al loro contratto
comportamentale. Il progetto usa la metodologia `@contract`: il contratto vive in `docs/contracts/` del modulo owner,
separato dal codice, e il docblock dell'Action rimanda al file. Come rendere il contratto trovabile dal codice e
verificabile da una macchina, senza duplicare la specifica nel docblock?

## Driver della decisione

- Il contratto deve essere trovabile dal codice senza duplicare la specifica nel docblock.
- Un controllo statico deve poter verificare esistenza e collegamento del file.
- Riferimento chiaro per chi legge il codice, con documentazione che non si perde nei refactoring.

## Alternative scartate

- Aggiungere `@contract` a tutte le Action: sovra-ingegnerizzazione per quelle che sono solo wrapper o funzioni pure.
- Creare un contratto formale per ogni Action: boilerplate inutile.
- Tenere il contratto solo nel docblock dell'Action, o come testo libero inline: non è verificabile in modo affidabile
  dall'harness, non è riutilizzabile e si perde nei refactoring; copiare il contratto dentro il codice lo duplica e lo
  rende fragile quando cambia il comportamento.
- Tenere un unico contratto globale senza collegamento all'Action concreta.

## Decisione

**Ogni Action che scrive dati, chiama servizi esterni o ha effetti collaterali ha un file di contratto in
`Modules/<M>/docs/contracts/<action-kebab>.md` e un docblock `@contract` che vi rimanda.** Le Action pure (formattano,
calcolano) possono farne a meno.

```php
/**
 * @contract docs/contracts/<action-kebab>.md
 * @see Modules/<M>/docs/contracts/<action-kebab>.md
 */
final class SomeAction
{
    use QueueableAction;
}
```

- `@contract docs/contracts/<file>.md` è il marcatore machine-readable cercato dagli strumenti; `@see` è un
  riferimento editoriale aggiuntivo e da solo non basta. Vale anche la forma storica
  `Contratto di comportamento: docs/contracts/<file>.md`.
- Il file di contratto ha frontmatter `type: contract` e `action: "<FQCN>"` e le sei sezioni canoniche (Input, Output,
  Invarianti, Effetti collaterali, Errori, Non fa), nell'ordine definito da
  [contract-authoring-standard](../contracts/contract-authoring-standard.md) e dalla regola
  [action-behavioral-contract](../rules/action-behavioral-contract.md).

## Conseguenze

- Buono: la documentazione del contratto punta a file markdown viventi e il riferimento è chiaro per chi legge il
  codice; un'Action con effetti collaterali senza `@contract` viene segnalata dai test; coerente con
  [actions-over-services](0017-actions-over-services.md) e con [behavioral-contract-governance](0023-behavioral-contract-governance.md).
- Cattivo: richiede di creare o verificare i file `docs/contracts/<action-kebab>.md`; il debito iniziale è aggiungere
  contratti e `@contract` alle Action esistenti, e mantenerli quando le Action cambiano.

## Conferma

La regola è verificata da `ActionContractsAreCompleteTest` quando il contratto e l'Action esistono nel modulo owner;
`PackagesHaveContractsAndAdrTest` verifica la presenza delle cartelle e dei README owner.

## Verifica

- `cd laravel && vendor/bin/pest Modules/Xot/tests/Unit/Docs/ActionContractsAreCompleteTest.php`: ogni contratto ha le
  sei sezioni, la sua `action` esiste e il docblock dell'Action contiene `@contract docs/contracts/<file>.md`; le Action
  dell'elenco `REQUIRED` hanno il contratto (`Modules/Xot/tests/Unit/Docs/ActionContractsAreCompleteTest.php`).
- `cd laravel && vendor/bin/pest Modules/Xot/tests/Unit/Docs/PackagesHaveContractsAndAdrTest.php`
  (`Modules/Xot/tests/Unit/Docs/PackagesHaveContractsAndAdrTest.php`).
- Solo revisione: che una nuova Action con effetti collaterali fuori dall'elenco `REQUIRED` abbia il contratto.
