---
title: "ModuleAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\ModuleAction"
qmd: "ModuleAction modelli modulo singleton nome getModels Models directory reflection"
---

# ModuleAction

Oggetto con nome di modulo mutabile, singleton, che elenca i modelli di un modulo. Codice: `app/Actions/ModuleAction.php` (classe a riga 17, `getModels()`; `execute()` vuoto a riga 95).

## Input

- Nome del modulo impostato con `setName()` o `__construct()`.

## Output

- `getModels()`: `array<string, class-string>`.

## Invarianti

- `MODULE-ACTION-INV-1` — Modulo inesistente: `[]`. Test: nessuno.
- `MODULE-ACTION-INV-2` — `getModels()` legge `<percorso modulo>/Models`, non `app/Models`. Test: nessuno.
- `MODULE-ACTION-INV-3` — Le classi astratte sono escluse; gli errori di reflection sono ingoiati. Test: nessuno.

## Effetti collaterali

- `getInstance()` riusa la stessa istanza: `setName()` su un singleton cambia lo stato per tutti i chiamanti del processo.

## Errori

- Nessun check di esistenza della cartella prima di `File::files`: il comportamento su cartella assente va verificato.

## Non fa

- `execute()` è vuoto.
- Il percorso `Models` non corrisponde alla convenzione `app/Models` usata da `GetAllModelsByModuleNameAction`: probabile incoerenza, da verificare.
