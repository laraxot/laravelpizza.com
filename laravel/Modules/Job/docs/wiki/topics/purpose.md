---
title: "Topic purpose"
type: digest
status: active
qmd: "digest ceiling 100 purpose"
---

# Topic purpose

Sintesi automatica di 3 documenti (chiave `purpose`).

## Scopo BMAD — Job

_Fonte: `bmad/purpose.md`_

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
| Accorgers

## Job — perche' esiste

_Fonte: `purpose.md`_

# Job — perche' esiste

## Lo scopo in una frase

**Job rende visibile e governabile tutto cio' che accade fuori dalla richiesta HTTP:
code, importazioni, esportazioni, lavori pianificati — e soprattutto i loro
fallimenti.**

## L'evidenza

Le Resource dicono esattamente qual e' la priorita' del modulo:

`Job`, `JobsWaiting`, `JobBatch`, `JobManager`, `Schedule`, `Import`, `Export`,
**`FailedJob`**, **`FailedImportRow`**.

Due delle nove riguardano il fallimento. Non e' un caso: **un lavoro asincrono che
fallisce in silenzio e' peggio di un lavoro che non e' mai partito**, perche' chi lo ha
richiesto crede che sia andato a buon fine.

15 Action e 2 Widget: il modulo amministra, e mostra lo stato.

## Il valore che aggiunge rispetto a Laravel nudo

Laravel ha code, batch e `failed_jobs`. Quello che non ha e' una **superficie** in cui
un funzionario — non un sistemista — possa vedere che l'importazione di ieri sera si e'
fermata alla riga 4.312 e perche'. `FailedImportRow` esiste per questo: non "l'import e'
fallito", ma **quale riga** e **quale errore**.

## Come raggiungerlo **meglio**

## Job — perche' esiste

_Fonte: `wiki/purpose.md`_

# Job — perche' esiste

## Lo scopo in una frase

**Job rende visibile e governabile tutto cio' che accade fuori dalla richiesta HTTP:
code, importazioni, esportazioni, lavori pianificati — e soprattutto i loro
fallimenti.**

## L'evidenza

Le Resource dicono esattamente qual e' la priorita' del modulo:

`Job`, `JobsWaiting`, `JobBatch`, `JobManager`, `Schedule`, `Import`, `Export`,
**`FailedJob`**, **`FailedImportRow`**.

Due delle nove riguardano il fallimento. Non e' un caso: **un lavoro asincrono che
fallisce in silenzio e' peggio di un lavoro che non e' mai partito**, perche' chi lo ha
richiesto crede che sia andato a buon fine.

15 Action e 2 Widget: il modulo amministra, e mostra lo stato.

## Il valore che aggiunge rispetto a Laravel nudo

Laravel ha code, batch e `failed_jobs`. Quello che non ha e' una **superficie** in cui
un funzionario — non un sistemista — possa vedere che l'importazione di ieri sera si e'
fermata alla riga 4.312 e perche'. `FailedImportRow` esiste per questo: non "l'import e'
fallito", ma **quale riga** e **quale errore**.

## Come raggiungerlo **meglio**
