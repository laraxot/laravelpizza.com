---
title: "Scopo BMAD — Job"
type: concept
status: active
updated: 2026-11-16
module: Job
qmd: "purpose bmad Job scopo code import export fallimenti scheduler perché esiste stato del codice"
related:
  - ../purpose.md
  - ./audits/job-audit.md
  - ./architecture.md
  - ./epics.md
---

# Scopo BMAD — Job

## Lo scopo in una frase

**Job rende visibile e governabile tutto ciò che accade fuori dalla richiesta HTTP — code, importazioni, esportazioni, lavori pianificati — e soprattutto i loro fallimenti.**

Il perché esteso (valore rispetto a Laravel nudo, cinque direzioni di miglioramento, confini) è nella SSoT del modulo: [../purpose.md](../purpose.md). Qui solo la sintesi BMAD e il confronto con il codice.

## Perché conta in una PA

Un lavoro asincrono che fallisce in silenzio è peggio di uno mai partito: chi lo ha chiesto crede che sia andato a buon fine. Il valore non è la coda (Laravel ce l'ha) ma la **superficie** in cui un funzionario, non un sistemista, vede che l'import di ieri si è fermato alla riga 4.312 e perché (`FailedImportRow`).

## Confini

- Job **esegue e osserva**; il contenuto del lavoro è del dominio.
- L'invio delle notifiche è di Notify; la validazione delle righe importate è del modulo che possiede il dato.

## Stato del codice rispetto allo scopo (verificato 2026-11-16)

| Promessa | Stato | Evidenza |
|---|---|---|
| Vedere code, batch, fallimenti | **mantenuta** | 9 Resource; `FailedJobResource`, `FailedImportRowResource` |
| Operare sulla coda in sicurezza | **mantenuta per `JobStatus`**, violata dal legacy e da 4 widget | [audit P1-1, P1-2](./audits/job-audit.md#finding) |
| Lavori pianificati che girano | **non mantenuta** — scheduler su DB non cablato | `JobServiceProvider.php:38,48-66`, `ExecuteTaskAction.php:18` |
| Accorgersi del lavoro che non parte più | **non mantenuta** (dipende dal punto precedente) | `ScheduleHistory`/`Result` mai popolati dal modulo |
| Il fallimento raggiunge chi l'ha chiesto | **non implementata** | nessun hook di coda attivo |
| Solo chi amministra gestisce la coda | **violata** su `Job`/`FailedJob`/`JobBatch` | `JobPolicy.php:32` ([P0-1](./audits/job-audit.md#p0-1--un-utente-qualsiasi-può-creare-righe-nella-tabella-jobs)) |
| ↳ verifica 2026-11-19 | **corretta nel codice** (E1, story in `review`) | `JobPolicy` ora deny-by-default su tutte le ability, bypass solo in `JobBasePolicy::before()` ([e1 story](./stories/e1-job-policy-create-deny.story.md)) |

## Riferimenti

[Audit](./audit.md) · [Architettura](./architecture.md) · [Decision log](./decision-log.md) · [Epics](./epics.md)
