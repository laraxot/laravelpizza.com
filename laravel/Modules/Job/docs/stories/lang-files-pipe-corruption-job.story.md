---
title: "lang files pipe corruption job.story"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "lang files pipe corruption job.story"
issues: []
discussions: []
---

# Story: file di lingua Job corrotti da una pipe prima di ogni carattere

Status: done

## GitHub (tracciamento)

| Artefatto | URL |
|---|---|
| Issue (module_job_fila5) | https://github.com/laraxot/module_job_fila5/issues/58 |

Pattern gemello di [`Modules/Activity/docs/stories/lang-files-pipe-corruption.story.md`](../../Activity/docs/stories/lang-files-pipe-corruption.story.md)
(issue https://github.com/laraxot/module_job_fila5/issues/58 rimanda a
`laraxot/module_activity_fila5` per il precedente). Story separata perche' `Modules/Job`
e' un submodule con ownership/repo propri, non lo stesso repo di Activity.

## Story

Come agente che esegue root-cause di un crash live (`/user/admin`,
`array_replace_recursive(): Argument #2 must be of type array, int given`), voglio che
gli 8 file di lingua di Job tornino a restituire un array vero, cosi' il loader di
traduzioni Laravel smette di ricevere `int(1)` da uno di essi.

## Acceptance Criteria

1. Gli 8 file in `Modules/Job/lang/lang/it/` aprono con `<?php` e restituiscono un array
   (non `1`), verificato con `include()` + `gettype()`, non solo `php -l`.
2. Zero caratteri `|` di corruzione nei file.
3. Provenienza dichiarata: contenuto ripreso da un commit reale del submodule, non
   ricostruito a mano.

## Tasks / Subtasks

- [x] Individuare gli 8 file corrotti durante lo scan del crash live (AC: 1, 2)
- [x] Confermare il pattern: byte `0x7C` prima di ogni carattere, `<?php` mai contiguo,
      `include()` restituisce `int(1)` (identico a Activity)
- [x] Recuperare da `git -C Modules/Job show a081589c:lang/lang/it/<nome>.php`, scrivere
      nel working tree (AC: 3)
- [x] Verificare via `include()` che ognuno restituisca `array` (AC: 1)
- [x] Lock protocol (check/lock/unlock) sugli 8 path durante l'edit

## Dev Notes

### Perche' `php -l` non basta

Stesso motivo di Activity: senza `<?php` contiguo, PHP tratta il file come testo
inline, non come codice — `php -l` dice "No syntax errors" a vuoto, non perche' il file
sia un array valido.

### File e conteggio chiavi verificato

| file | chiavi top-level |
|---|---:|
| `jobs_waiting.php` | 1 |
| `job_manager.php` | 2 |
| `edit_failed_import_row.php` | 1 |
| `import.php` | 2 |
| `failed_job.php` | 1 |
| `job_batch.php` | 2 |
| `job.php` | 10 |
| `failed_import_row.php` | 1 |

### Origine non determinata

Come per Activity, non e' noto quale strumento abbia inserito le pipe. Non
approfondito in questa sessione (era root-cause del crash live, non un audit dedicato).
Se serve, vale la stessa domanda aperta nella Discussion #21 di Activity.

### Testing standards

Nessun test nuovo, stesso ragionamento di Activity: e' una proprieta' del file
sorgente, non un comportamento di dominio esprimibile in Pest.

### References

- [Source: laravel/Modules/Activity/docs/stories/lang-files-pipe-corruption.story.md] — pattern gemello, stesso meccanismo di corruzione
- [Source: laravel/Modules/User/docs/stories/lang-files-empty-stub-corruption.story.md] — trovato nella stessa sessione, meccanismo diverso, stesso crash live

## Dev Agent Record

### Completion Notes List

- 8/8 file parsano e restituiscono un array con i conteggi sopra.
- Nessun altro file corrotto trovato in `Modules/Job/lang/` durante questa sessione
  (scan non esaustivo, mirato al crash live).

### File List

- `laravel/Modules/Job/lang/lang/it/jobs_waiting.php` — riparato
- `laravel/Modules/Job/lang/lang/it/job_manager.php` — riparato
- `laravel/Modules/Job/lang/lang/it/edit_failed_import_row.php` — riparato
- `laravel/Modules/Job/lang/lang/it/import.php` — riparato
- `laravel/Modules/Job/lang/lang/it/failed_job.php` — riparato
- `laravel/Modules/Job/lang/lang/it/job_batch.php` — riparato
- `laravel/Modules/Job/lang/lang/it/job.php` — riparato
- `laravel/Modules/Job/lang/lang/it/failed_import_row.php` — riparato
