---
title: "DeleteUserAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\User\\DeleteUserAction"
qmd: "DeleteUserAction cancellazione utente conferma password logout delete messaggio errore"
---

# DeleteUserAction

Cancella l'account dopo la verifica della password di conferma. Codice: `app/Actions/User/DeleteUserAction.php:12-50`.

## Input

- `UserContract $user` (`execute`, riga 26).
- `string $confirmPassword`: password in chiaro da verificare.

## Output

- `array{success: bool, message: string}` (righe 24, 30-48).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `DELETE-USER-INV-1` | Senza password corrispondente l'utente non viene cancellato e non si esegue il logout. | righe 28-34 | `tests/Unit/Actions/User/DeleteUserActionTest.php`, `tests/Unit/Actions/AdditionalActionsTest.php` (riferimenti alla classe) |
| `DELETE-USER-INV-2` | Il logout della guard precede la cancellazione. | righe 37-38 | come sopra |
| `DELETE-USER-INV-3` | Ogni `\Exception` durante logout o delete è convertita in `success` false, senza rilancio. | righe 44-48 | come sopra |

## Effetti collaterali

Nell'ordine: verifica hash, logout della sessione (guard), DELETE dell'utente (`$user->delete()`; `BaseUser` non usa `SoftDeletes`, quindi è cancellazione fisica secondo il docblock di `BuildActiveUserProviderAction`). Nessuna transazione. Nessun log dell'errore.

## Errori

- Eccezioni `\Exception` assorbite: il messaggio è generico e l'errore non viene registrato (vedi Non fa).

## Non fa

- Non registra l'errore catturato: viola la regola "mai silenziare errori" di `security-2.md`.
- Se il delete fallisce, il logout è già avvenuto (riga 37 prima di riga 38): l'utente resta disconnesso ma non cancellato.
- I messaggi restituiti sono fissi in inglese e non passano dalle traduzioni.
- Non gestisce cascate su altri dati: non verificato in questo passo.
