---
title: "Job: scopo del modulo"
type: documentation
module: Job
tags: [module, documentation, queue, scheduler]
qmd: "Job scopo modulo code queue import export failed jobs batch schedule fallimenti visibili"
related:
  - "./00-index.md"
  - "./architecture.md"
  - "./audit.md"
---

# Job

**Job rende visibile e governabile tutto cio' che accade fuori dalla richiesta HTTP: code, importazioni,
esportazioni, lavori pianificati, e soprattutto i loro fallimenti.**

Un lavoro asincrono che fallisce in silenzio e' peggio di uno mai partito: chi lo ha chiesto crede che sia
andato a buon fine. Laravel ha gia' code, batch e `failed_jobs`; quello che non ha e' una superficie in cui un
funzionario, non un sistemista, vede che l'importazione di ieri si e' fermata alla riga 4.312 e perche'
(`FailedImportRow`). Le Resource lo confermano: delle nove, due riguardano il fallimento (`FailedJob`,
`FailedImportRow`).

Mappa dei documenti: [00-index.md](00-index.md). Cosa c'e' nel codice: [architecture.md](architecture.md).
Cosa non funziona ancora e perche': [audit.md](audit.md).

## Confini

- Il **contenuto** del lavoro e' del dominio: Job esegue e osserva, non sa cosa sta importando.
- L'**invio** delle notifiche e' di Notify.
- Le **regole di validazione** delle righe importate sono del modulo che possiede il dato.

## Il modulo in numeri (misurati sul codice il 2026-11-25)

| Voce | N | Dove |
|---|---:|---|
| Resource Filament | 9 | `app/Filament/Resources`: `Job`, `JobsWaiting`, `JobBatch`, `JobManager`, `Schedule`, `Import`, `Export`, `FailedJob`, `FailedImportRow` |
| Pagine standalone | 4 | `Dashboard`, `JobMonitor`, `JobStatus`, `SettingPage` |
| Widget | 5 | `ClockWidget`, `JobStatusWidget`, `QueueListenWidget`, `ScheduleCrudWidget`, `ScheduleStatusWidget` |
| Model | 17 | `app/Models` (BaseModel, BaseMorphPivot, 15 di dominio) |
| Policy | 16 | `app/Models/Policies`: una per modello piu' `JobBasePolicy` |
| Action | 16 | `app/Actions` (7 in radice, 3 `Command/`, 4 `Console/`, 2 `Schedule/`) |
| Comandi Artisan | 4 | `worker:check`, `schedule:clear-cache`, `schedule:test-job`, `phpunit:test` |
| Migration | 14 | una per tabella |
| Lingue | 6 | `lang/`: it, en, de, es, fr, nb_NO |

## Come arrivare a uno scopo migliore (idee in ordine di valore)

1. **Il fallimento deve raggiungere chi ha chiesto il lavoro**: ogni lavoro porta il richiedente; al
   fallimento definitivo parte una notifica via Notify. La dashboard e' per chi amministra, la notifica per
   chi aspetta.
2. **Un import va ripreso, non rifatto**: con `FailedImportRow` popolata si puo' offrire "ritenta solo le
   righe fallite" (il dato c'e' gia').
3. **Errore di dato diverso da errore di sistema**: classificare il fallimento (dato, sistema, configurazione)
   e mostrarlo accanto all'errore; le azioni sono opposte.
4. **Un lavoro pianificato che smette di partire deve farsi notare**: registrare l'ultima esecuzione riuscita
   di ogni voce e segnalare quando supera l'intervallo atteso. Dipende dalla decisione D-2 sullo scheduler
   ([audit.md](audit.md#epiche-e-piano)).
5. **La ritentabilita' e' una proprieta' del lavoro**: dichiarare se un lavoro e' idempotente; per gli altri
   serve una chiave di idempotenza, prima di aggiungere `$tries`.

## Cartelle

| Cartella | Contenuto |
|---|---|
| `adr/` | decisioni architetturali (formato MADR), [indice](adr/index.md) |
| `contracts/` | contratto di comportamento di ogni Action con invarianti, [indice](contracts/index.md); il docblock della classe lo cita con `@contract` |
| `stories/` | story BMAD del modulo, [template](stories/0000-template.story.md) |
| `bmad/` | dossier BMAD del modulo, [README](bmad/README.md); le story BMAD stanno in `bmad/stories/` |
| `ecc/` | checklist ECC e stato dei controlli, [job-ecc-audit.md](ecc/job-ecc-audit.md) |
