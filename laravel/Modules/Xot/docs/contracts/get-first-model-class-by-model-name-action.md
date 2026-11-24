---
title: "GetFirstModelClassByModelNameAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Model\\GetFirstModelClassByModelNameAction"
qmd: "GetFirstModelClassByModelNameAction primo modello per nome scansione moduli keyExists Assert"
---

# GetFirstModelClassByModelNameAction

Risolve il FQCN di un modello per nome snake, scansionando tutti i moduli. Codice: `app/Actions/Model/GetFirstModelClassByModelNameAction.php`.

## Input

- `string $modelName`: nome snake del modello (chiave di `GetAllModelsAction`).

## Output

- `string`: FQCN del modello.

## Invarianti

- `GET-FIRST-MODEL-INV-1` — Se il nome non è tra i modelli trovati, lancia (`Assert::keyExists`). Prova: `execute()`. Test: nessuno.
- `GET-FIRST-MODEL-INV-2` — Il valore ritornato è una stringa (`Assert::string`). Prova: `execute()`. Test: nessuno.

## Effetti collaterali

Solo letture: scansione di tutti i moduli a ogni chiamata, senza cache.

## Errori

- `Webmozart\Assert\InvalidArgumentException` con messaggio che nomina la classe e la riga, se il modello non esiste.

## Non fa

- Non consulta `morph_map` (lo fa `GetModelClassByModelNameAction`, che la usa come fallback).
- Non normalizza il nome in snake: il chiamante deve passarlo già normalizzato.
