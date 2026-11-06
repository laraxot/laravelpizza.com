---
title: "Queueable Actions come boundary applicativo"
type: architecture
status: active
module: Xot
tags: [architecture, queueable-actions, jobs, services, bmad]
updated: 2026-10-23
qmd: "queueable actions xot"
---

# Queueable Actions

## Decisione

I moduli non creano `app/Jobs/`, `app/Services/` o il refuso `app/Servces/`.
Il comportamento applicativo vive in `app/Actions/` e usa
`Spatie\QueueableAction\QueueableAction`. L'esecuzione sincrona usa
`execute(...)`; l'esecuzione asincrona usa `ActionJob` o
`$action->onQueue()->execute(...)`.

## Perché

Una sola astrazione mantiene insieme contratto, esecuzione sincrona, coda,
serializzazione dei modelli, middleware, retry e test. Un Job separato che
chiama un Service o un'Action crea invece un wrapper duplicato: nasconde il
contratto reale, moltiplica i punti di dispatch e rende divergenti le vie sync
e async.

La coda è un dettaglio di esecuzione dell'Action, non una cartella di dominio.
Il nome della classe descrive quindi il comportamento (`GeocodeTicketAddressAction`),
mentre `ActionJob` fornisce il trasporto Laravel quando serve.

Gli oggetti dati seguono la stessa regola di ownership: i DTO e gli oggetti di
trasporto vivono in `app/Datas/`, con namespace `Modules\\<Module>\\Datas`.
Le varianti `app/Data/` e `app/DTOs/` sono vietate perché duplicano il confine
e rendono ambiguo il percorso canonico per autoload, documentazione e strumenti.

## Regole operative

- ogni Action tipizza `execute()` e usa il trait QueueableAction;
- per batch usare `new ActionJob(app(Action::class), [$parameter])`;
- aggiornare caller, scheduler, test e docs nella stessa modifica;
- non lasciare alias di compatibilità in `app/Jobs` o `app/Services`;
- non usare un Service per logica che può essere un'Action; estrarre un helper
  solo se non rappresenta un caso d'uso applicativo.

Questa decisione vale per moduli e temi: il tema consuma Actions del modulo
owner e non ricrea Jobs/Services nella propria app.
