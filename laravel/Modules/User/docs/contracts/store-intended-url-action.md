---
title: "StoreIntendedUrlAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Auth\\StoreIntendedUrlAction"
qmd: "StoreIntendedUrlAction url.intended redirect login CMT-022 percorso interno open redirect commento accedi"
---

# StoreIntendedUrlAction

Ricorda la pagina a cui tornare dopo il login, per gli ospiti che non passano dal middleware `auth` (CMT-022). Codice: `app/Actions/Auth/StoreIntendedUrlAction.php:19-41`.

## Input

- `mixed $target`: atteso un percorso interno, per esempio `/it/blog/...` (`execute`, riga 23).

## Output

- `bool`: `true` se `url.intended` è stato scritto, `false` altrimenti (righe 25-31).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `STORE-INTENDED-INV-1` | Sono accettati solo stringhe che iniziano con un singolo `/`, senza `\` e senza spazi o caratteri di controllo. | righe 25, 34-40 | Test: nessuno. |
| `STORE-INTENDED-INV-2` | Un input rifiutato non tocca la sessione. | righe 25-27 | Test: nessuno. |
| `STORE-INTENDED-INV-3` | Il valore salvato è `url($target)`, cioè assoluto sull'host della richiesta. | riga 29 | Test: nessuno. |

## Effetti collaterali

Solo scrittura di sessione (`url.intended`). Nessun database, nessun evento.

## Errori

- Nessuna eccezione: l'input non valido produce `false`.

## Non fa

- Non verifica che il percorso esista come rotta.
- Usa `url()`, che prende l'host dalla richiesta: è la stessa fonte che `BuildPasswordResetUrlAction` evita per SEC-007. Il rischio qui è basso perché il valore resta nella sessione dello stesso utente, ma la scelta è incoerente con quella motivazione (dubbio aperto).
