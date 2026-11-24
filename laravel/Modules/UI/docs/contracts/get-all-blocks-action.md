---
<<<<<<< .merge_file_NpE5jN
<<<<<<< HEAD
=======
>>>>>>> .merge_file_ku8jmo
title: "Contratto — GetAllBlocksAction"
type: contract
action: "Modules\UI\Actions\Block\GetAllBlocksAction"
tags: [contract, action, blocks, filament, filesystem]
created: 2026-11-24
updated: 2026-11-24
<<<<<<< .merge_file_NpE5jN
=======
title: "GetAllBlocksAction — contratto"
type: contract
owner: UI
status: accepted
updated: 2026-11-24
action: "Modules\\UI\\Actions\\Block\\GetAllBlocksAction"
qmd: "GetAllBlocksAction elenco blocchi Filament Blocks moduli ComponentFileData glob"
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_ku8jmo
---

# GetAllBlocksAction

<<<<<<< .merge_file_NpE5jN
<<<<<<< HEAD
=======
>>>>>>> .merge_file_ku8jmo
Sorgente: `app/Actions/Block/GetAllBlocksAction.php`. Perché è fatta così:
[ADR scoperta dei blocchi per cartella](../adr/block-discovery-by-filament-blocks-folder.md).
Chiamanti: `Modules/Cms/app/Filament/Fields/PageContent.php`, `PageContentBuilder.php`.

## Input

- Nessun parametro. Legge `config('modules.paths.generator.model.path')` e il filesystem di `base_path('Modules')`.

## Output

- `DataCollection<int, Modules\Xot\Datas\ComponentFileData>` con `name`, `class`, `module`, `path` (percorso reale)
  per ogni file `Modules/*/app/Filament/Blocks/*.php`.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| UI-BLOCKS-INV-1 | Ogni elemento viene da `Modules/<module>/app/Filament/Blocks/*.php`, e `module` è il modulo di quel percorso. | `UI-BLOCKS-INV-1` |
| UI-BLOCKS-INV-2 | `name` = basename della classe in snake_case senza il suffisso `_block`; è la chiave `type` salvata nei contenuti. | `UI-BLOCKS-INV-2` |

## Effetti collaterali

- Solo lettura del filesystem (`File::glob`, `realpath`). Non scrive, non mette in cache.

## Errori

- `Webmozart\Assert\InvalidArgumentException` se `modules.paths.generator.model.path` non è una stringa.
- `Safe\Exceptions\FilesystemException` da `realpath` se un file sparisce durante la scansione; le eccezioni di
  `GetClassNameByPathAction` per un file senza classe risalgono.

## Non fa

- Non istanzia i blocchi né controlla che estendano `XotBaseBlock` (lo verifica `Cms/tests/Feature/FilamentBuilderBlocksTest.php`).
- Non filtra per modulo attivo, tenant o permessi: ritorna tutto ciò che è su disco.
- Non ordina: l'ordine è quello di `glob`.
- Non legge le cartelle dei temi (`Themes/*`).
<<<<<<< .merge_file_NpE5jN
=======
Elenca i file dei blocchi Filament di tutti i moduli. Codice: `app/Actions/Block/GetAllBlocksAction.php:29-58`.

## Input

- Nessun parametro. Legge `config('modules.paths.generator.model.path')` e la cartella `Modules/*/<path>/../Filament/Blocks/*.php`.

## Output

- `DataCollection<int, ComponentFileData>`: uno per file, con `name`, `class`, `module`, `path`.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `UI-BLOCKS-INV-1` | Sono considerati solo i file `*.php` in `Filament/Blocks` di ciascun modulo. | righe 31-33 | Test: nessuno |
| `UI-BLOCKS-INV-2` | Il `name` è lo snake case del basename della classe, senza il suffisso `_block`. | righe 39-46 | Test: nessuno |
| `UI-BLOCKS-INV-3` | Il `module` è il segmento tra `Modules\` e `\Filament\` del FQCN. | riga 48 | Test: nessuno |

## Effetti collaterali

Nessuno: sola lettura del filesystem (glob e risoluzione del nome classe). Nessuna scrittura o servizio esterno.

## Errori

- `Assert::string` fallisce se il config del path non è una stringa.
- `Safe\realpath` lancia se il percorso non è risolvibile: l'eccezione non è gestita.

## Non fa

- Non verifica che la classe trovata sia un blocco valido o istanziabile.
- Non usa cache: il glob è ripetuto a ogni chiamata.
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_ku8jmo
