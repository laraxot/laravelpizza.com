---
title: "GetNewPasswordAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\User\\GetNewPasswordAction"
qmd: "GetNewPasswordAction nuova password temporanea pronunciabile hash salvataggio utente una sola volta"
---

# GetNewPasswordAction

Genera una nuova password temporanea pronunciabile, ne salva l'hash sull'utente e restituisce il valore in chiaro da comunicare una sola volta. Codice: `app/Actions/User/GetNewPasswordAction.php:14-34`.

## Input

- `UserContract $record`: deve essere un `Model` (riga 24).

## Output

- `string`: la password in chiaro, lunga 12 caratteri (riga 26).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `NEW-PWD-INV-1` | Sul modello è salvato solo l'hash `Hash::make`, mai il valore in chiaro. | righe 28-30 | `tests/Unit/Actions/User/GetNewPasswordActionTest.php` (riferimento alla classe) |
| `NEW-PWD-INV-2` | Il valore restituito è quello generato da `GetPronounceablePasswordAction` (Xot) con lunghezza 12. | riga 26 | come sopra |
| `NEW-PWD-INV-3` | Un record che non è un `Model` lancia `InvalidArgumentException`. | riga 24 | come sopra |

## Effetti collaterali

Un `save()` sul modello (eventi Eloquent inclusi). Nessuna transazione, nessuna notifica, nessuna invalidazione di sessioni.

## Errori

- `InvalidArgumentException` (Webmozart Assert) se il record non è un `Model`.

## Non fa

- Non notifica l'utente: il chiamante deve comunicare la password.
- Non imposta scadenza né `is_otp`.
