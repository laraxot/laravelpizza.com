---
title: "Audit qualita' modulo Job"
type: story
status: in-review
module: Job
created: 2026-11-19
updated: 2026-11-19
issues: ["laraxot/base_techplanner_fila5#64"]
tags: [audit, qualita, docs, phpstan, pest]
qmd: "audit qualita story"
---

# Audit qualita' — modulo Job

Story BMAD dell'audit di qualita' coordinato nella issue
[#64](https://github.com/laraxot/base_techplanner_fila5/issues/64).
Ambito: solo `Modules/Job` (documentazione e `app/`).

## Baseline e risultato

| Verifica | Prima | Dopo |
|---|---|---|
| PHPStan max (`Modules/Job`) | 0 errori | 0 errori |
| Pest (`Modules/Job/tests`) | 10 falliti / 373 passati | 10 falliti / 373 passati |
| Occorrenze `mixed` in `app/` | 32 | 31 |

## Documentazione

- File `.md` con data/timestamp nel nome: 1 rinominati, 11 uniti al file canonico
  omonimo (contenuto unico conservato sotto "Contenuto unito da ..."), 3 rimossi perche' vuoti
  o gia' contenuti nel canonico. La data originale e' ora nel frontmatter `created:`.
- Duplicati esatti (contenuto identico) rimossi: 31; tenuta la copia meglio collocata
  (no `archive/`, `raw/`, suffissi `-1`/`_1`, maiuscole o underscore) e link interni aggiornati.
- `docs/index.md` (indice canonico): aggiunta la sezione "Mappa delle cartelle" con link relativi
  a tutte le aree; link rotti agli altri moduli corretti dove la destinazione era determinabile.

## Codice (`app/`)

- Rimossa la cartella `Filament/Tables/Columns/` (ActionGroup, ScheduleArguments, ScheduleOptions): copie non usate di `Filament/Columns/*` che estendevano `TextColumn` invece di `XotBaseTextColumn`
- Rimosso `Filament/Fields/Repeater.php` (copia non usata di `Filament/Forms/Components/Repeater`, che estende `XotBaseRepeater`)
- Rimossi file morti: `Models/MonitoredScheduledTask.aaa`, `Models/MonitoredScheduledTaskLogItem.aaa`, `Events/PresenceEvent.test`
- `Models/JobManager.php`: rimosse 25 righe duplicate del PHPDoc di classe

## Scoperte da gestire (non risolte in questo audit)

- Doppioni ancora referenziati: `Actions/ClearScheduleCacheAction` vs `Actions/Schedule/ClearScheduleCacheAction`, `Actions/GetActiveSchedulesAction` vs `Actions/Schedule/...`, due `JobStatsOverview`: da unificare aggiornando i consumatori
- `docs/` ha anche `readme.md` oltre a `README.md`/`index.md`/`INDEX.md`
- Nell'indice restano link rotti verso file mai esistiti o di altri progetti: da rivedere a mano.
- `docs/` contiene ancora `INDEX.md`, `README.md` e `index.md` affiancati (collisione su filesystem
  case-insensitive): da consolidare in un solo indice con decisione condivisa.

## Criteri di accettazione

- [x] PHPStan max a 0 errori senza ignore/baseline
- [x] Nessun `.md` con data nel nome
- [x] Nessun duplicato esatto in `docs/`
- [x] Test Pest non peggiorati
- [ ] Punti aperti sopra risolti
