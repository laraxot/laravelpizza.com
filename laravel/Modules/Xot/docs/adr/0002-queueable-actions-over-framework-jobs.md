---
title: "Le operazioni applicative usano Queueable Actions, non Job duplicati"
type: decision
status: accepted
created: 2026-11-23
updated: 2026-11-23
decision-makers: [team Laraxot]
issues: []
---

# Le unità di business usano Spatie Queueable Actions

## Contesto

Nel progetto esistono code Laravel, notifiche accodabili e il modulo Job, ma
la logica di business nuova deve avere un unico ingresso riusabile sia in modo
sincrono sia asincrono. Duplicare la stessa regola in un `Job` e in un
servizio/action crea due punti di manutenzione e rende meno chiara la policy.

## Driver della decisione

- una classe per caso d'uso;
- un metodo pubblico tipizzato `execute()`;
- possibilità di dispatch asincrono senza duplicare il caso d'uso;
- test Pest e contract nel modulo owner;
- separazione fra business logic e infrastruttura di coda.

## Alternative scartate

- creare un `Job` Laravel per ogni caso d'uso e duplicare la logica in un altro entrypoint;
- mettere la logica in `app/Services`;
- usare controller o listener come coordinatori di dominio non riusabili.

## Decisione

Le operazioni di business nuove sono classi in `app/Actions/` che usano
`Spatie\QueueableAction\QueueableAction` e espongono `execute()`.
`ShouldQueue`, notifiche e job infrastrutturali restano leciti quando il loro
contratto è realmente quello di Laravel, ma non devono diventare un secondo
contenitore della stessa logica di dominio.

## Conseguenze

- Buono: lo stesso caso d'uso può essere eseguito o accodato mantenendo un solo contratto.
- Buono: autorizzazione, transazione, audit e test sono visibili nell'Action owner.
- Cattivo: il legacy può ancora contenere Job o Service; non va migrato senza inventario dei caller.

## Conferma

- nuova logica in `app/Services` o un nuovo Job che duplica un'Action viene respinta in review;
- il test architetturale e PHPStan verificano il pattern QueueableAction dove richiesto;
- riferimento operativo: [0001 Actions over Services](0001-actions-over-services.md).
