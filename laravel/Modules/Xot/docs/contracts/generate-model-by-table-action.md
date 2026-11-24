---
title: "GenerateModelByTableAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Model\\GenerateModelByTableAction"
qmd: "GenerateModelByTableAction generazione modello da tabella non implementato LogicException stub"
---

# GenerateModelByTableAction

Stub: la generazione di un modello da una tabella non è implementata. Codice: `app/Actions/Model/GenerateModelByTableAction.php`.

## Input

- Nessuno.

## Output

- `void`, ma non ritorna mai: lancia sempre.

## Invarianti

- `GENERATE-MODEL-INV-1` — `execute()` lancia sempre `\LogicException('... not implemented')`. Prova: `execute()`. Test: nessuno.

## Effetti collaterali

Nessuno. Non scrive file e non legge la tabella.

## Errori

- `\LogicException` sempre.

## Non fa

- Non genera nulla. Il docblock cita generatori esterni come riferimento, non come dipendenza. Candidato alla rimozione: non è stato verificato che nessun chiamante lo usi.
