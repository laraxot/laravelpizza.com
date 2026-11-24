---
title: "ADR — Queueable Actions al posto di Job duplicati"
type: decision
status: accepted
created: 2026-11-23
updated: 2026-11-24
decision-makers: [team Laraxot]
issues: []
---

# Queueable Actions al posto di Job duplicati

## Contesto

Nel progetto esistono code Laravel, notifiche accodabili e il modulo Job, ma la logica di business nuova deve avere un
unico ingresso riusabile sia in modo sincrono sia asincrono. Il progetto usa operazioni applicative riusabili in
`app/Actions/`: la stessa operazione non deve avere una versione parallela come Job, Service e chiamata diretta.
Duplicare la stessa regola in un `Job` e in un'Action (o in un servizio) crea due punti di manutenzione e rende meno
chiara la policy.

## Driver della decisione

- Una classe per caso d'uso, con un metodo pubblico tipizzato `execute()`.
- Un solo punto per contratto, autorizzazione, transazione, audit e test, nel modulo owner.
- Possibilità di esecuzione sincrona o accodata senza duplicare il caso d'uso.
- Separazione fra business logic e infrastruttura di coda.
- Coerenza con `Spatie\QueueableAction\QueueableAction`, già usato dai moduli.

## Alternative scartate

- Creare un `Job` Laravel per ogni caso d'uso o per ogni Action, duplicando la logica in un altro entrypoint.
- Mettere la logica nel Job e duplicarla nell'Action.
- Mettere la logica in `app/Services` o usare un Service come facciata permanente.
- Usare controller o listener come coordinatori di dominio non riusabili.

## Decisione

Le operazioni di business nuove sono classi in `app/Actions/` che usano `Spatie\QueueableAction\QueueableAction` ed
espongono `execute()`. `ShouldQueue`, notifiche e job infrastrutturali restano leciti quando il loro contratto è
realmente quello di Laravel, ma non devono diventare un secondo contenitore della stessa logica di dominio. Un Job
dedicato è ammesso solo quando esiste un requisito infrastrutturale distinto, documentato da un nuovo ADR.

## Conseguenze

- Buono: lo stesso caso d'uso può essere eseguito o accodato mantenendo un solo contratto e un solo test owner.
- Buono: autorizzazione, transazione, audit e test sono visibili nell'Action owner; la coda resta una modalità di
  esecuzione, non il luogo della logica di dominio.
- Cattivo: il legacy può ancora contenere Job o Service; non va migrato senza un inventario dei chiamanti, e non va
  replicato nel codice nuovo.

## Conferma

- Nuova logica in `app/Services`, o un nuovo Job che duplica un'Action, si respinge in revisione con un rimando a
  questo ADR; una nuova classe `*Job` cita questo ADR o una decisione che lo sostituisce.
- Il test architetturale (sui `Services`) e PHPStan fanno da controllo di contorno; l'uso di `QueueableAction` nelle
  Action nuove lo conferma la revisione, come dice la Verifica.
- Riferimento operativo: [actions-over-services](actions-over-services.md).

## Verifica

- `cd laravel && vendor/bin/pest Modules/Xot/tests/Arch/ArchitectureTest.php`: copre solo la regola sui `Services`
  (vedi [actions-over-services](actions-over-services.md)); nessun test automatico vieta un Job che duplica
  un'Action, quindi per i Job la verifica è la revisione.
- Per la revisione, l'elenco dei Job esistenti da confrontare con le Action:
  `rg -l 'implements ShouldQueue' laravel/Modules --glob '*/app/**'`.
