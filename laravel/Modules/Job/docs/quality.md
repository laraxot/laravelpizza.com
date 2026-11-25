---
title: "Job: qualita', gate e test"
type: guide
module: Job
status: active
qmd: "Job qualita gate PHPStan PHPMD PHPInsights Pest test coverage duplicati arch debito"
related:
  - ./README.md
  - ./audit.md
  - ./architecture.md
---

# Job: qualita', gate e test

Solo cio' che e' ancora vero e verificabile. I rapporti storici di sessione (correzioni PHPStan di gennaio 2025,
analisi con file di policy corrotti dal merge del 2025-11, punteggi DRY/KISS di ottobre 2025, censimenti
automatici di metodi omonimi) descrivevano un codice che non esiste piu' e non sono stati conservati.

## Gate

Dalla cartella `laravel/`:

```bash
php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/Job --no-progress
./vendor/bin/pest Modules/Job/tests --no-coverage      # solo fuori produzione, con DB di test raggiungibile
./vendor/bin/pint Modules/Job
```

| Gate | Ultimo esito noto |
|---|---|
| PHPStan `Modules/Job` | 0 errori (livello del progetto, nessuna baseline, nessun `@phpstan-ignore` senza motivo), misurato il 2026-11-16, anche sul tree `Modules` |
| Pest | parziale: `JobStatusAuthorizationTest` 17 pass; suite completa non eseguita per carico macchina e DB di test non sempre raggiungibile. Nessun numero di coverage prodotto: **non c'e' un baseline**, chi riprende con il DB raggiungibile deve crearlo qui |
| PHPMD (2026-09-22) | 124 righe di findings, debito preesistente: parametri Policy prefissati `_` (convenzione "parametro non usato", probabile falso positivo), complessita' ciclomatica di `Schedule::getArguments()` (13/10) e `FormatSeconds::formatSeconds()` (11/10), `MissingImport` in alcuni test |
| PHPInsights (2026-09-22) | Code 90.6, Complexity 100, Architecture 71.4, Style 87.7: ordine degli import e degli elementi di classe, brace style delle classi vuote |

I numeri PHPMD e PHPInsights sono istantanee datate: rilanciare prima di citarli.

## Test

- Solo Pest, mai PHPUnit diretto; i test stanno nel modulo: `tests/Unit`, `tests/Feature`, `tests/Arch`
  (57 file PHP, 50 `*Test.php`). Mai `RefreshDatabase`, mai `migrate:fresh`/`--force`: i dati sono sacri.
- Test dei browser (Playwright): se servono, in `tests/Playwright/` del modulo; oggi la cartella non esiste.
- Debolezze note: nessun `Livewire::test` sulle superfici operative; 25 file usano `ReflectionClass` invece di
  esercitare il comportamento; `tests/Unit/ScratchA9TmpTest.php` e' temporaneo. Vedi epica E5 in
  [audit.md](audit.md#epiche-e-piano).
- Il comportamento atteso di ogni Action con effetti collaterali e' nel suo [contratto](contracts/index.md); un
  invariante con `->group('<ID>')` si verifica con `pest Modules/Job/tests --group=<ID>`. Oggi nessun test usa i
  group `JOB-...`: gli invarianti sono "non coperti" in senso stretto.

## Debito di architettura misurato

`tests/Arch/debt.php` elenca le classi che violano una regola di `Modules/Xot/tests/Arch/ArchitectureTest.php`: oggi
solo `Modules\Job\Services\ScheduleService` (regola No Services). Il debito puo' solo scendere: chi corregge una
classe la toglie dall'elenco, chi aggiunge una voce lo spiega nella PR.

## Convenzioni emerse dal lavoro sul modulo

- **Trait solo da widget e PHPStan `trait.unused`**: `Traits/FormatSeconds` e' usato da tre widget statistici
  scoperti per discovery; `app/Phpstan/FormatSecondsPhpstanProbe.php` e' la classe-sonda che lo rende visibile a
  PHPStan, invece di un ignore globale in `phpstan.neon`.
- **Schema del form di `Schedule`**: `CreateSchedule::getFormSchema()` ritorna `array<Htmlable|string>`; il valore
  delegato alla Resource e' inferito come `array` generico e oggi si restringe con un `@var` locale
  (`CreateSchedule.php`, righe 35 e 41). Il modo piu' solido sarebbe validare a runtime ogni elemento
  (`Htmlable` o `string`) e costruire una lista nuova; non e' stato fatto.
- **Policy**: non cancellare ne' fondere i file `extends JobBasePolicy {}` (vedi [architecture.md](architecture.md)).
- **Logica nuova**: Action Queueable, mai `app/Services` o `app/Support`.
- **Lingua**: titoli e flash letterali sono debito (audit P2); le stringhe vanno nei file di `lang/`.
