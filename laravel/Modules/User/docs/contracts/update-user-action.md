---
title: "UpdateUserAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\User\\UpdateUserAction"
qmd: "UpdateUserAction aggiornamento utente transazione email univoca password hash campi esclusi rollback log"
---

# UpdateUserAction

Aggiorna un utente dentro una transazione: esclude i campi di sistema, gestisce password ed email, valida l'unicità dell'email e rilegge il modello. Codice: `app/Actions/User/UpdateUserAction.php:15-161`.

## Input

- `Model $user`: utente da aggiornare (`execute`, riga 28).
- `array<string, mixed> $data`: campi da aggiornare.

## Output

- `Model`: l'utente riletto con `fresh()` dopo il commit (righe 59-64).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `UPDATE-USER-INV-1` | Non si aggiornano `id`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`. | righe 87-95 | `tests/Unit/Actions/User/UpdateUserActionTest.php`, `tests/Unit/Actions/AdditionalActionsTest.php` (riferimenti alla classe) |
| `UPDATE-USER-INV-2` | Una password vuota non cambia la password; una non vuota è salvata come hash. | righe 98-107 | come sopra |
| `UPDATE-USER-INV-3` | L'email è salvata in minuscolo e non può coincidere con quella di un altro utente; altrimenti `ValidationException` sulla chiave `email`. | righe 110-113, 127-138 | come sopra |
| `UPDATE-USER-INV-4` | Un'eccezione dopo l'avvio della transazione fa rollback e viene rilanciata. | righe 36-75 | come sopra |

## Effetti collaterali

Nell'ordine: `beginTransaction`, `fill` + `save()` (eventi Eloquent), hook `afterUpdate` (vuoto di default), `commit`, log info con i nomi dei campi aggiornati, `fresh()`. In caso di errore: `rollBack`, log di errore, rilancio.

## Errori

- `ValidationException` se l'email è già usata da un altro utente (anche questa finisce nel log di errore, vedi Non fa).
- `\Exception` rilanciata dopo il rollback.

## Non fa

- Il log di errore (righe 68-72) include `$updateData`, che contiene la password già hashata e l'email in chiaro: dato sensibile in log. Da correggere (dubbio di sicurezza ad alta priorità).
- Il controllo di unicità email è applicativo: senza un vincolo UNIQUE a database due richieste concorrenti possono passare entrambe.
- Non intercetta `\Error`, solo `\Exception`.
