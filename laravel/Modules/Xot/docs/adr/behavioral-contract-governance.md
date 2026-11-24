---
title: "Governance dei Behavioral Contract con invarianti verificabili"
type: decision
status: accepted
created: 2026-11-23
updated: 2026-11-24
decision-makers: [team back office]
issues: []
module: Xot
---

# Governance dei Behavioral Contract con invarianti verificabili

## Contesto

Xot possiede già la regola per i contratti delle Action e il test documentale che ne
controlla formato e collegamento. Manca però una procedura owner unica per elencare i
contratti, assegnare identificativi stabili alle invarianti e trovare il test Pest che
le dimostra. Come rendiamo il contratto operativo per agenti, review e harness senza
duplicare gli ADR sulle Action o il template ADR esistente?

## Driver della decisione

- Una promessa comportamentale deve avere un owner, un documento e una prova
  rintracciabile.
- Gli identificativi delle invarianti devono restare stabili quando cambia il testo o
  l'implementazione interna.
- Un agente deve poter passare dal codice al contratto e dal contratto al gruppo Pest
  senza ricostruire il contesto dal sorgente.
- La verifica deve continuare a funzionare con controlli source-level, anche quando
  il bootstrap Laravel è indisponibile.
- La convenzione deve convivere con il legacy: documentare il comportamento corrente
  non autorizza a estenderne i difetti.

## Alternative scartate

- **Solo prosa nei README e nei docblock**: non offre un identificativo né una prova
  ripetibile per ogni invariante.
- **Un catalogo centrale nel root del progetto**: rompe l'ownership dei moduli e si
  perderebbe nel mirror dei package repository.
- **Un test aggregato senza gruppi**: rende costoso isolare una promessa fallita e
  non consente al harness di chiedere la prova minima.
- **Copiare integralmente il workshop Laravel Day**: introduce un secondo workflow e
  non rispetta le convenzioni Xot già attive (`@contract`, Pest e test owner-locali).

## Decisione

Scelta: **contratto owner-local, indice operativo e invarianti con ID collegati a
gruppi Pest omonimi**, perché conserva l'ownership del modulo e rende la catena
`Action -> @contract -> invariant ID -> Pest group` interrogabile e verificabile.

- Ogni Action che persiste, chiama servizi esterni o produce effetti collaterali ha
  un file in `docs/contracts/`, con `type: contract`, `action: <FQCN>` e le sei
  sezioni canoniche nell'ordine definito dal template.
- Ogni invariante usa un ID stabile nel formato `<SCOPE>-INV-<N>` (per esempio
  `XOT-ACTION-INV-1`). Lo stesso ID compare nella tabella del contratto e nel test
  Pest con `->group('<ID>')`.
- Il docblock dell'Action contiene sia il riferimento editoriale
  `@see docs/contracts/<file>.md` sia il marker machine-readable
  `@contract docs/contracts/<file>.md`; entrambi puntano al contratto owner-local.
- `docs/contracts/INDEX.md` è il registro operativo: elenca contratto, owner,
  invarianti e comando Pest. `README.md` resta l'indice storico richiesto dai test
  di package e non viene sostituito.
- Un contratto aggiornato e il test che ne prova le invarianti cambiano insieme. Un
  comportamento legacy si documenta con i suoi limiti espliciti e non diventa
  modello per nuovo codice.

## Conseguenze

- Buono, perché review e agenti hanno un percorso breve e verificabile dalla promessa
  alla prova.
- Buono, perché i gruppi Pest permettono una verifica mirata (`--group=<ID>`) senza
  perdere la suite completa.
- Buono, perché il formato resta compatibile con `ActionContractsAreCompleteTest` e
  con l'ownership già descritta in `contract-authoring-standard.md`.
- Cattivo, perché ogni nuova invariante richiede disciplina nel mantenere unico il
  suo ID e aggiornare l'indice.
- Cattivo, perché l'indice può diventare obsoleto se una modifica aggiorna il codice
  senza aggiornare la documentazione owner.

## Conferma

- `cd laravel && vendor/bin/pest Modules/Xot/tests/Unit/Docs/ActionContractsAreCompleteTest.php`
  verifica formato e marker `@contract` dei contratti comportamentali.
- `cd laravel && vendor/bin/pest Modules/Xot/tests/Unit/Docs/PackagesHaveContractsAndAdrTest.php`
  verifica la presenza dei README owner e delle sezioni ADR obbligatorie.
- La review controlla che ogni ID nell'indice compaia nel contratto e in almeno un
  test Pest con lo stesso `->group('<ID>')`; il comando del gruppo riportato
  nell'indice deve essere eseguibile dalla directory `laravel/`.
- Una modifica al comportamento senza aggiornamento coordinato di contratto, indice
  e prova è una violazione di questo ADR.

## Verifica

```bash
cd laravel && vendor/bin/pest Modules/Xot/tests/Unit/Docs/ActionContractsAreCompleteTest.php \
  Modules/Xot/tests/Unit/Docs/PackagesHaveContractsAndAdrTest.php
```

- `Modules/Xot/tests/Unit/Docs/ActionContractsAreCompleteTest.php`: formato dei contratti, marker `@contract`, formato
  degli ID delle invarianti e group dichiarato esistente nei test del pacchetto.
- `Modules/Xot/tests/Unit/Docs/PackagesHaveContractsAndAdrTest.php`: README, sezioni ADR e indice dei file.
- Solo revisione: che ogni ID dell'indice compaia in un test con lo stesso `->group('<ID>')` e che il comando del group
  sia eseguibile da `laravel/`.
