---
title: "SMS\\NormalizePhoneNumberAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\SMS\\NormalizePhoneNumberAction"
qmd: "NormalizePhoneNumberAction SMS numero telefono prefisso 39 Italia parentesi E.164 Assert"
---

# SMS\NormalizePhoneNumberAction

Normalizzazione del numero per gli invii SMS. Distinta dalla versione root (`normalize-phone-number-action`): questa lancia eccezioni per input inutilizzabili e assume l'Italia come default.

## Input

- `string $phoneNumber`.

## Output

- `string` in forma `+<cifre>`.

## Invarianti

- `NOTIFY-SMSPHONE-INV-1`: parentesi con cifre vengono rimosse, poi restano solo cifre; gli zeri iniziali vengono tolti. Test: `tests/Unit/Actions/SMS/NormalizePhoneNumberActionTest.php` (dedicato, asserti non verificati).
- `NOTIFY-SMSPHONE-INV-2`: un input internazionale (`+` o `00` iniziale) diventa `+<cifre>`. Stesso test.
- `NOTIFY-SMSPHONE-INV-3`: un numero nazionale riceve `39` se non inizia gia' con `39`. Stesso test.
- `NOTIFY-SMSPHONE-INV-4`: nessuna cifra utile lancia `Assert` (notEmpty). Stesso test.

## Effetti collaterali

- Nessuno.

## Errori

- Eccezioni di `Assert` su stringa o contenuto vuoto.

## Rischi rilevati

- Un mobile italiano nazionale che inizia per `39` (es. prefisso 339) non riceve `39` e diventa `+339...`, numero errato. Il controllo del prefisso non distingue il codice Paese dal numero.

## Non fa

- Non valida la lunghezza del numero.
