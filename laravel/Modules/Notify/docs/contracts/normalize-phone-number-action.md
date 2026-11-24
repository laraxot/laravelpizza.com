---
title: "NormalizePhoneNumberAction (root) — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\NormalizePhoneNumberAction"
qmd: "NormalizePhoneNumberAction normalizza numero telefono prefisso 00 +39 E.164 root"
---

# NormalizePhoneNumberAction (root)

Normalizza un numero di telefono in forma `+<cifre>`. Versione generica, distinta da `SMS\NormalizePhoneNumberAction`.

## Input

- `?string $phoneNumber`: numero grezzo.

## Output

- `string`: numero con `+` iniziale, oppure `''` se l'input e' null o vuoto.

## Invarianti

- `NOTIFY-PHONENORM-INV-1`: input null o vuoto restituisce `''`. Test: `tests/Unit/Actions/NormalizePhoneNumberActionTest.php` (dedicato, asserti non verificati).
- `NOTIFY-PHONENORM-INV-2`: vengono mantenuti solo cifre e `+`; `00` iniziale diventa `+`. Stesso test.
- `NOTIFY-PHONENORM-INV-3`: un numero che inizia con `0` (senza `+`) riceve prefisso `+39`. Stesso test.
- `NOTIFY-PHONENORM-INV-4`: altri numeri senza `+` ricevono `+`. Stesso test.

## Effetti collaterali

- Nessuno.

## Errori

- Nessuna eccezione. Un input senza cifre (es. `abc`) produce `+`, valore non valido: non viene rifiutato.

## Non fa

- Non valida la lunghezza ne' il formato E.164 risultante.
- Non ha chiamanti nei sorgenti del modulo Notify (riferimenti solo in `docs/`).
