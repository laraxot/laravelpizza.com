---
initiative: PHPStan Zero + Spatie Queueable Actions Conversion
author: AI Agent
status: completed
created: 2026-10-20
title: "BMAD Planning: Spatie Queueable Actions"
type: note
updated: 2026-10-23
tags: [docs, xot, phpstan-fix-plan]
qmd: "bmad planning   spatie queueable actions xot"
---

# BMAD Planning: Spatie Queueable Actions

## 1. Brainstorming (Perché?)

**Scopo:** le operazioni di business vivono nelle `app/Actions/`; `app/Services/` e i wrapper `app/Jobs/` non sono confini applicativi ammessi.

**Perché deve essere convertito in Spatie Queueable Actions:**
- `Spatie\QueueableAction\QueueableAction` permette a ogni azione di essere sia sincrona (`execute()`) che asincrona (`dispatch()` su coda).
- Il modulo `DbForge` già usa questo pattern (`StartQueryLogAction.php`, `GetFieldnamesByTablenameAction.php`). L'architettura esistente richiede coerenza.
- Con Queueable Actions: fallimenti si gestiscono con retry, si possono distribuire su worker, si possono testare in isolamento.
- Il progetto ha `spatie/laravel-queueable-action` già installato (`composer.lock` conferma), quindi non c'è dipendenza nuova.

**Perché NON cancellare ma convertire:** La funzionalità esistente (invio messaggi, gestione log, recupero dati) deve essere preservata; la conversione aggiunge solo la capacità di coda e il pattern standard.

## 2. Methodology: BMAD Step by Step

- **B = Brainstorming:** Fatto sopra (scopo: decoupling, retry, scala).
- **M = Methodology:** Per ogni modulo, identificare i file `Actions/*.php` che MANgano `use QueueableAction;`. Se mancano, aggiungere.
- **A = Architecture:** Eseguire conversione per modulo: `Cms`, `User`, `Notify`, `Activity`, `Gdpr`, `UI`, `Xot`, `Lang`, `Media`, `Tenant`, `Job`, `Setting`, `CloudStorage`, `Map`, `Chart`, `Geo`, `Limesurvey`, `Quaeris`.
- **D = Documentation:** Per ogni modulo, documentare in `docs/phpstan-fix-plan/` (o `docs/bmad/`) il percorso, lo scopo convertito, e verificare con `phpstan analyse`.

## 3. Filament Blueprint (Struttura del modulo)

Per ogni modulo: `app/Actions/` contiene le Action che usano `QueueableAction`, con entrypoint `execute()`. Non si ricreano `app/Services/` o `app/Jobs/`.

## 4. Second Brain / Hindsight Note

> 🧠 **From Hindsight memory (phpstan-fixes.md)**: Il modulo DbForge usa già `Spatie\QueueableAction\QueueableAction`; il progetto ha già il package installato; il baseline `phpstan.neon` ignora solo errori specifici di Tenant. La conversione deve mantenere `strict_types=1`, `Safe\json_decode`, e non introdurre suppressions.

---

# Piano Esecuzione Random / Parallel

Batch A (moduli con più errori): Notify, User, Cms, Gdpr, Tenant
Batch B (moduli con azioni esistenti ma incomplete): DbForge, Activity, Media, UI, Xot
Batch C (moduli minori): Lang, Job, Setting, CloudStorage, Chart, Geo, Quaeris, Limesurvey

Per ogni batch: subagent in parallelo, BMAD per batch, second brain per registrare decisioni.
