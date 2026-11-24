---
title: "GetTransKeyByModelClassAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Model\\GetTransKeyByModelClassAction"
qmd: "GetTransKeyByModelClassAction chiave traduzione modulo modello kebab Models namespace"
---

# GetTransKeyByModelClassAction

Costruisce la chiave di traduzione `modulo::chiave-kebab` da un FQCN di modello. Codice: `app/Actions/Model/GetTransKeyByModelClassAction.php`.

## Input

- `string $modelClass`: FQCN nella forma `Modules\<Mod>\Models\<...>\<Nome>`.

## Output

- `string`: per esempio `user::user-profile`.

## Invarianti

- `GET-TRANS-KEY-MODEL-INV-1` — Il modulo è il segmento tra `Modules\` e `\Models`, in minuscolo. Prova: `execute()`. Test: nessuno.
- `GET-TRANS-KEY-MODEL-INV-2` — La parte dopo `\Models\` è convertita in kebab (sottocartelle incluse, con `\` nel nome). Prova: `execute()`. Test: nessuno.

## Effetti collaterali

Nessuno.

## Errori

- Nessuna eccezione. Con un FQCN fuori da `Modules\...\Models\` il risultato è degenerato (`Str::between` e `Str::after` ritornano valori parziali): non gestito.

## Non fa

- Non verifica l'esistenza della classe o del file di traduzione.
