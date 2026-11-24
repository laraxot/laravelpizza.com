---
title: "File parcheggiati — Job"
slug: parcheggio
module: Job
document_type: index
category: documentation
type: index
status: active
language: it-IT
created: 2026-11-18
updated: 2026-11-18
tags: [parcheggio, debito-tecnico]
description: "File con estensione finta spostati fuori da app/ in Job, con il motivo per ciascuna famiglia."
---

# File parcheggiati — Job

File spostati qui da `app/` il 2026-11-18. In `app/` sta solo codice che gira.

Un'estensione finta — `.boh`, `.up`, `.test`, `.disabled`, `.to_migra` — non
tiene un file fuori dal codice: lo rende invisibile a chi cerca e vivo per chi
lo trova. Il percorso dentro `parcheggio/` e' quello d'origine, quindi si sa
sempre da dove veniva.

| File (percorso d'origine sotto `app/`) | Byte |
|---|---|
| `app/Events/PresenceEvent.test` | 799 |


## Prima di riprenderne uno

Questi file **non sono stati esaminati riga per riga**: sono stati spostati,
non giudicati. Prima di copiarne uno nel codice vivo, confrontalo con quello
che c'e' adesso: in uno di questi, a ottobre, c'erano 135 righe di lavoro non
fuso che per poco non sono state cancellate. Quando il lavoro e' finito,
cancella il file parcheggiato.

## Tornati col sync del 21/11 e ritirati di nuovo (24/11/2026)

Il sync dei moduli (nessun marcatore) ha rimesso file che il progetto aveva cancellato il 06/11 (commit root
`66789173c`; `lang/it/.php` il 13/11, `95a546b25`) e che il repository del modulo ha ancora. **Esaminati**: nessun
chiamante in PHP, Blade, config o rotte (ricerca per nome di classe, `<livewire:...>`, `@livewire(...)` e chiavi
`job::livewire.*`). I gemelli Filament `JobStatusWidget`, `ScheduleCrudWidget`, `ScheduleStatusWidget` li hanno
sostituiti. Percorsi relativi alla radice del modulo, copiati qui con suffisso `.zero_used`.

| File | Byte |
|---|---|
| `app/Http/Livewire/Broad.php` | 986 |
| `app/Http/Livewire/Job/Status.php` | 6100 |
| `app/Http/Livewire/Schedule/Crud.php` | 3222 |
| `app/Http/Livewire/Schedule/Status.php` | 3166 |
| `app/Http/Livewire/_components.json` | 484 |
| `app/Filament/Resources/JobsWaitingResource/Pages/ListJobsWaiting.php` (doppione di `ListJobsWaitings`) | 1819 |
| `app/Phpstan/FormatSecondsPhpstanProbe.php` | 391 |
| `lang/it/.php` (file senza nome, chiavi segnaposto) | 638 |
| `resources/views/livewire/broad.blade.php` | 339 |
| `resources/views/livewire/job/status.blade.php` | 2898 |
| `resources/views/livewire/modal/schedule/create.blade.php` | 19585 |
| `resources/views/livewire/schedule/create.blade.php` | 17260 |
| `resources/views/livewire/schedule/crud.blade.php` | 3287 |
| `resources/views/livewire/schedule/status.blade.php` | 529 |

Lasciati dove sono: `app/Services/ScheduleService.php` (root l'aveva cancellato, ma `tests/Unit/Services/ScheduleServiceTest.php`
e `tests/Arch/debt.php` lo richiedono) e `resources/views/livewire/job/status.blade.php.backup_20251210_092150`
(estensione finta, non esaminato). Finche' il repository del modulo non li toglie, il prossimo sync li riporta.

Tracciato in
[module_quaeris_fila5#61](https://github.com/laraxot/module_quaeris_fila5/issues/61).
