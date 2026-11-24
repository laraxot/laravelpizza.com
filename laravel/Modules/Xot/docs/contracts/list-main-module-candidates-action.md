---
title: "ListMainModuleCandidatesAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\ListMainModuleCandidatesAction"
qmd: "ListMainModuleCandidatesAction moduli principali candidati pannello Filament AdminPanelProvider moduli abilitati"
---

# ListMainModuleCandidatesAction

Elenca i moduli abilitati che possono essere il modulo principale, cioè quelli con un pannello Filament. Codice: `app/Actions/ListMainModuleCandidatesAction.php` (classe a riga 20, `execute()` a riga 27).

## Input

- Nessuno.

## Output

- `array<string, string>`: nome => nome, ordinato per chiave.

## Invarianti

- `MAIN-MODULE-CANDIDATES-INV-1` — Solo moduli abilitati (`Module::allEnabled()`). Test: `tests/Unit/Datas/XotConfigDataTest.php` (menzione).
- `MAIN-MODULE-CANDIDATES-INV-2` — Un modulo è candidato solo se esiste il file `app/Providers/Filament/AdminPanelProvider.php`. Test: come sopra.
- `MAIN-MODULE-CANDIDATES-INV-3` — Il risultato è ordinato per nome. Test: come sopra.

## Effetti collaterali

Lettura di filesystem.

## Errori

- `Webmozart` se il nome del modulo non è stringa.

## Non fa

- Non verifica che il provider si carichi né che il pannello sia valido.
