---
title: "GetAllModelsAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Model\\GetAllModelsAction"
qmd: "GetAllModelsAction elenco modelli tutti i moduli Module::all reflection classi"
---

# GetAllModelsAction

Raccoglie i modelli di tutti i moduli, delegando per modulo a `GetAllModelsByModuleNameAction`. Codice: `app/Actions/Model/GetAllModelsAction.php`.

## Input

- Nessuno. Legge i moduli con `Module::all()`.

## Output

- `array`: unione dei risultati per modulo. La chiave è il nome snake del modello, non un indice numerico (il docblock dice `array<int, class-string>`: incoerenza).

## Invarianti

- `GET-ALL-MODELS-INV-1` — I moduli il cui nome non è una stringa vengono saltati. Prova: `execute()`. Test: nessuno diretto.
- `GET-ALL-MODELS-INV-2` — I risultati dei moduli sono uniti con `array_merge`: con chiavi stringa uguali, l'ultimo modulo vince. Prova: `execute()`. Test: `tests/Unit/Actions/GetAllModelsActionTest.php`.

## Effetti collaterali

Solo letture: filesystem e reflection (che carica le classi trovate). Nessuna scrittura, nessuna cache.

## Errori

- Nessuna eccezione propria. Gli errori dei sotto-Action si propagano.

## Non fa

- Non filtra i modelli oltre quanto fatto da `GetAllModelsByModuleNameAction`.
- Non memorizza il risultato: a ogni chiamata rilegge il filesystem.
