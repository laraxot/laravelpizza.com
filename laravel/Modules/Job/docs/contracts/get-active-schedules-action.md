---
title: "Contratto — GetActiveSchedulesAction (Schedule)"
type: contract
owner: Job
status: accepted
updated: 2026-11-24
action: "Modules\\Job\\Actions\\Schedule\\GetActiveSchedulesAction"
qmd: "GetActiveSchedulesAction schedule attivi cache rememberForever job::model job::cache JOB-SCHED-INV"
---

# GetActiveSchedulesAction (Schedule)

Restituisce gli schedule attivi, con cache opzionale. Codice: `app/Actions/Schedule/GetActiveSchedulesAction.php:13-52`.

## Input

- Nessun argomento. Legge `config('job::cache.enabled')`, `job::cache.store`, `job::cache.key` e `job::model` (senza default).

## Output

- `Illuminate\Support\Collection<int, Schedule>`: il risultato di `active()->get()` del modello risolto.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `JOB-SCHED-INV-1` | Con cache disabilitata restituisce `active()->get()` del modello risolto da `config('job::model')`, dopo `app()` e asserzione `instanceof Schedule`. | Test: nessuno comportamentale. `tests/Unit/Actions/Schedule/ScheduleActionsTest.php:16` (solo struttura). |
| `JOB-SCHED-INV-2` | `config('job::model')` senza valore fa lanciare `InvalidArgumentException` a ogni chiamata: non c'e' default. | Test: nessuno. |
| `JOB-SCHED-INV-3` | Con `job::cache.enabled` vero, il risultato e' messo in cache con `rememberForever` sotto `job::cache.key` nello store `job::cache.store`; alla cache hit il DB non viene interrogato. | Test: nessuno. |

Nota: `job::model` non e' definita nel modulo. Con la configurazione attuale INV-1 lancia (vedi INV-2).

## Effetti collaterali

- Lettura DB (`active()->get()`) quando non c'e' cache o alla cache miss.
- Scrittura cache (`rememberForever`) solo con cache abilitata. Nessuna transazione, nessun evento.
- Non invalida la cache: l'invalidazione e' di `ClearScheduleCacheAction`.

## Errori

- `Webmozart\Assert\InvalidArgumentException` se una config attesa non e' stringa, o se `job::model` non risolve a un `Schedule`, o se il valore in cache non e' una `Collection`.

## Non fa

- Non filtra per tenant, ne' ordina. Il criterio di "attivo" e' lo scope `active()` del modello.
- Nessun chiamante di produzione trovato: `Services/ScheduleService.php:11-12` lo cita solo nel docblock. L'errore di config non emerge quindi in produzione finche' nessuno lo invoca. Da verificare.
