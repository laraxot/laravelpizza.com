---
title: "GenerateFormByFileAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Filament\\GenerateFormByFileAction"
qmd: "GenerateFormByFileAction conteggio campi fillable resource form WIP non genera"
---

# GenerateFormByFileAction

Dato il file di una Resource, conta i campi fillable del modello che corrispondono a metodi della Resource. Nome "Generate" ma non genera. Marcata WIP.

Codice: `app/Actions/Filament/GenerateFormByFileAction.php:16-120`.

## Input

- `SplFileInfo $file`: file della Resource.

## Output

`int`: numero di campi fillable che sono metodi della Resource.

## Invarianti

- `FIL-GENFORM-INV-1`: file non esistente o non `.php` ritorna 0 (righe 31-37). Test: tests/Unit/XotCommandsActionsHundredCoverageTest.php:26-33.
- `FIL-GENFORM-INV-2`: classe derivata dal percorso inesistente fa fallire `Assert::classExists` (riga 46). Test: Nessun test dedicato.
- `FIL-GENFORM-INV-3`: non scrive su disco. Test: Nessun test dedicato.

## Effetti collaterali

Nessuno.

## Errori

`Assert` per classe e modello non validi.

## Non fa

- Non genera alcuno schema: il conteggio è il solo output.
- `ddFile` non fa nulla (blocco commentato).
- Il nome della classe non corrisponde al comportamento.
