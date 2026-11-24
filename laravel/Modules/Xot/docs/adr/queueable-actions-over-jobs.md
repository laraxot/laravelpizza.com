---
title: "ADR — Queueable Actions al posto di Job duplicati"
type: decision
status: superseded by 0002-queueable-actions-over-framework-jobs.md
created: 2026-11-23
updated: 2026-11-24
decision-makers: [team]
issues: []
superseded_by: 0002-queueable-actions-over-framework-jobs.md
<<<<<<< .merge_file_juC2OI
qmd: "queueable actions over jobs posto duplicati"
=======
>>>>>>> .merge_file_Wsf38n
---

> Superseded da [0002-queueable-actions-over-framework-jobs.md](0002-queueable-actions-over-framework-jobs.md): alias senza numero della stessa decisione. Nessuna decisione nuova: il canonico prevale, questo file non va esteso.

# Queueable Actions al posto di Job duplicati

## Contesto

Il progetto usa operazioni applicative riusabili in `app/Actions/`. La stessa operazione non deve avere una versione parallela come Job, Service e chiamata diretta.

## Driver della decisione

- Un solo punto per contratto, autorizzazione, transazione, audit e test.
- Possibilità di esecuzione sincrona o accodata senza duplicare la logica.
- Coerenza con `Spatie\QueueableAction\QueueableAction` già usato dai moduli.

## Alternative scartate

- Creare un Job Laravel per ogni Action.
- Mettere la logica nel Job e duplicarla nell'Action.
- Usare un Service come facciata permanente.

## Decisione

Le nuove operazioni applicative sono Queueable Actions con entry point `execute()`. Un Job dedicato è ammesso solo quando esiste un requisito infrastrutturale distinto e documentato da un nuovo ADR.

## Conseguenze

- I moduli condividono un contratto operativo e un solo test owner.
- Il legacy può contenere Job esistenti, ma non va replicato nel codice nuovo.
- La coda resta una modalità di esecuzione, non il luogo della logica di dominio.

## Conferma

PHPStan, arch test e code review verificano l'uso di `QueueableAction`; una nuova classe `*Job` deve citare questo ADR o una decisione sostitutiva.
