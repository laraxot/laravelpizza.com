---
title: "Topic code-quality"
type: digest
status: active
qmd: "digest ceiling 100 code-quality"
---

# Topic code-quality

Sintesi automatica di 3 documenti (chiave `code-quality`).

## Code Quality Improvement Report — Lang

_Fonte: `bmad/code-quality-improvement-report.md`_

# Code Quality Improvement Report — Lang

> Baseline statica riproducibile per orientare il miglioramento. I conteggi sono segnali, non sostituiscono PHPStan, Pest o la review del flusso reale.


## GitHub (repo del componente)

```bash
cd laravel/Modules/Lang && git remote -v
# atteso: laraxot/module_lang_fila5
```

**Lezione grave:** in un conflitto Git, *entrambe* le parti possono essere sbagliate (`base_project_*` vs `base_workorder_*`). Non scegliere a caso: `git remote -v` nella cartella del modulo/tema.

## Baseline

| Indicatore | Valore |
|---|---:|
| File PHP applicativi/database/route | 72 |
| File di test PHP | 18 |
| Rapporto test/file PHP | 25% |
| Candidati senza strict types | 72 |
| Marker TODO/FIXME/HACK/XXX | 1 |
| Estensioni Filament potenzialmente dirette | 0 |
| Controller da classificare FO/BO | 0 |
| Classi in app/Services o app/Support | 0 |
| Priorità iniziale | **media** |

Rilevazione del 17 luglio 2026 sul working tree locale; esclusi vendor e dipendenze esterne.

## Code Quality Improvement Report — Lang

_Fonte: `code-quality-improvement-report.md`_

# Code Quality Improvement Report — Lang

> Baseline statica riproducibile per orientare il miglioramento. I conteggi sono segnali, non sostituiscono PHPStan, Pest o la review del flusso reale.


## GitHub (repo del componente)

```bash
cd laravel/Modules/Lang && git remote -v
# atteso: laraxot/module_lang_fila5
```

**Lezione grave:** in un conflitto Git, *entrambe* le parti possono essere sbagliate (`base_project_*` vs `base_workorder_*`). Non scegliere a caso: `git remote -v` nella cartella del modulo/tema.

## Baseline

| Indicatore | Valore |
|---|---:|
| File PHP applicativi/database/route | 72 |
| File di test PHP | 18 |
| Rapporto test/file PHP | 25% |
| Candidati senza strict types | 72 |
| Marker TODO/FIXME/HACK/XXX | 1 |
| Estensioni Filament potenzialmente dirette | 0 |
| Controller da classificare FO/BO | 0 |
| Classi in app/Services o app/Support | 0 |
| Priorità iniziale | **media** |

Rilevazione del 17 luglio 2026 sul working tree locale; esclusi vendor e dipendenze esterne.

## Code quality — modulo Lang

_Fonte: `code-quality-report.md`_

# Code quality — modulo Lang

Report locale (2026-07-17). Metodo: `phpstan analyse` livello max, `phpmd` (ruleset codesize+unusedcode), grep mirati (TODO/FIXME/@deprecated, dd()/dump(), facade in app/Actions, extends Filament diretto), rapporto file test/app.

## Numeri

- File in `app/`: 60
- File di test: 18 — rapporto test/app: 30%
- File con TODO/FIXME/@deprecated: 1
- PHPStan: 0 errori (livello max, sweep repo-wide 2026-07-16/17)
- Violazioni PHPMD (codesize+unusedcode): 15
- File in `app/Actions/` che importano Facade Laravel direttamente (violazione pattern QueueableAction, vedi skill `queueable-action-trait`): 3

### File con Facade in Actions da convertire

- Modules/Lang/app/Actions/SaveTransAction.php
- Modules/Lang/app/Actions/SyncTranslationsAction.php
- Modules/Lang/app/Actions/WriteTranslationFileAction.php

### Complessità / dimensione classi da rivedere

- Modules/Lang/app/Actions/Filament/AutoLabelAction.php:32                                          CyclomaticComplexity      The method execute() has a Cyclomatic Complexity of 34. The configured cyclomatic complexity threshold is 10.
- Modules/Lang/app/Actions/Filament/AutoLabelAction.php:32                                          ExcessiveMethodLength     The method execute() has 133 lines of code. Current threshold is set to 100. Avoid really long methods.
- Modules/Lang/app/Filament/Forms/Components/NationalFlagSelect.php:82                              CyclomaticComplexity      The method getFilteredCo
