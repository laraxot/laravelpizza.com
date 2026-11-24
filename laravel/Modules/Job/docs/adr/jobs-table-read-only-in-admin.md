---
title: "ADR — La tabella jobs nel pannello è in sola lettura: niente create/edit su JobResource"
type: decision
status: accepted
created: 2026-11-16
updated: 2026-11-24
module: Job
tags: [adr, filament, queue, jobs, resource]
related:
  - ../bmad/decision-log.md
qmd: "jobs table read only admin tabella"
---

# ADR: `JobResource` senza create ed edit

## Contesto

La tabella `jobs` è la coda `database` di Laravel: la scrive `dispatch()` e la consuma `queue:work`. Una riga
contiene un `payload` serializzato (classe, comando, tentativi). `JobResource` era nata dallo scaffolding standard
con `CreateJob`, `EditJob` e un form sul payload: una persona poteva creare o modificare un job a mano, cioè
iniettare un comando serializzato che il worker avrebbe eseguito. Decision log `../bmad/decision-log.md`, D-3.
Il pannello deve permettere di scrivere sulla coda?

## Decisione

`app/Filament/Resources/JobResource.php::getPages()` registra solo `index` (`ListJobs`) e `board` (`BoardJobs`),
con il commento `D-3`. Le azioni sulla coda passano dai comandi `queue:*` in allowlist
(`artisan-commands-from-ui-exact-match-allowlist.md`), mai dalla modifica diretta delle righe.

## Alternative scartate

- **Create/Edit solo per super-admin**: il rischio non è chi clicca ma il contenuto (un payload serializzato
  arbitrario); nessun caso d'uso reale lo richiede.
- **Edit limitato a `queue`/`available_at`**: riprogrammare un job si fa con `queue:retry` o rilanciando il
  dispatch, non riscrivendo la riga.

## Conseguenze

- Buono: la coda resta scritta solo dal codice; nessun form da mantenere sul payload.
- Debito: i file `JobResource/Pages/CreateJob.php` e `EditJob.php` esistono ancora ma non sono registrati; non vanno
  ricollegati.

## Verifica

`cd laravel && vendor/bin/pest Modules/Job/tests/Unit/Filament/Resources/JobResourceReadOnlyTest.php`: fallisce se
`JobResource::getPages()` registra una pagina diversa da `index` e `board`.
