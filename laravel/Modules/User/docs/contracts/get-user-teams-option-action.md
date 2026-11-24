---
title: "GetUserTeamsOptionAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Team\\GetUserTeamsOptionAction"
qmd: "GetUserTeamsOptionAction opzioni select team utente team_user placeholder authId"
---

# GetUserTeamsOptionAction

Costruisce le opzioni di una Select con i team dell'utente corrente. Codice: `app/Actions/Team/GetUserTeamsOptionAction.php:10-31`.

## Input

- Nessuno: usa l'utente della richiesta tramite `authId()` (riga 19).

## Output

- `array<int|string, string>`: placeholder `'' => '--- Select ---'` seguito da `id team => nome team` (righe 22-29).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `TEAMS-OPT-INV-1` | Il placeholder è sempre la prima voce. | riga 22 | `tests/Unit/Actions/Team/GetUserTeamsOptionActionTest.php` (riferimento alla classe) |
| `TEAMS-OPT-INV-2` | Compaiono solo i team collegati tramite `team_user` all'utente corrente. | riga 19 | come sopra |
| `TEAMS-OPT-INV-3` | Le righe orfane (team cancellato) sono saltate. | riga 24 | come sopra; anche `tests/Unit/QuickWins/UserQuickWinsCoverageTest.php` (riferimento) |

## Effetti collaterali

Sola lettura (eager load di `team`).

## Errori

- Nessuna gestione esplicita.

## Non fa

- Non pagina: restituisce tutti i team dell'utente.
- Dubbio: se `authId()` è `null` la clausola diventa `user_id IS NULL` (comportamento di `where` con valore null), non un risultato vuoto esplicito. Da verificare.
