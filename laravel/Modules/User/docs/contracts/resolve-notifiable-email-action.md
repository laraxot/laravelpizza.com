---
title: "ResolveNotifiableEmailAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Auth\\ResolveNotifiableEmailAction"
qmd: "ResolveNotifiableEmailAction indirizzo email notifica reset password verifica getEmailForPasswordReset attributo email"
---

# ResolveNotifiableEmailAction

Risolve l'indirizzo a cui spedire le email di autenticazione (reset password, verifica email). Codice: `app/Actions/Auth/ResolveNotifiableEmailAction.php:18-40`.

## Input

- `Model $notifiable` (`execute`, riga 22).

## Output

- `?string`: l'indirizzo, oppure `null` se il modello non ne ha.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `RESOLVE-EMAIL-INV-1` | Se il modello espone `getEmailForPasswordReset()` il suo valore ha la precedenza sull'attributo `email`. | righe 24-29 | `tests/Unit/Actions/Auth/ResolveNotifiableEmailActionTest.php` (riferimento alla classe) |
| `RESOLVE-EMAIL-INV-2` | Un valore non stringa lancia un'eccezione (`Webmozart Assert`) e la mail non parte. | righe 26, 36 | come sopra |
| `RESOLVE-EMAIL-INV-3` | Senza metodo e senza attributo `email` valorizzato il risultato è `null`. | righe 31-33 | come sopra |

## Effetti collaterali

Nessuno.

## Errori

- `InvalidArgumentException` (Webmozart Assert) se il valore non è stringa.

## Non fa

- Non valida il formato dell'indirizzo.
- Incoerenza: il docblock (riga 15) promette `null` quando il modello non ha un indirizzo, ma se `getEmailForPasswordReset()` esiste e restituisce `null` l'`Assert::string` lancia (riga 26). Il contratto segue il codice; la discrepanza va sistemata in un intervento dedicato.
