---
title: "VerifyOtpHashAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Otp\\VerifyOtpHashAction"
qmd: "VerifyOtpHashAction verifica OTP confronto hash check Illuminate"
---

# VerifyOtpHashAction

Verifica che un valore OTP in chiaro corrisponda all'hash salvato. Codice: `app/Actions/Otp/VerifyOtpHashAction.php:10-21`.

## Input

- `string $value`: valore inserito dall'utente.
- `string $hashedValue`: hash salvato (`execute`, riga 18).

## Output

- `bool`: esito di `check()` dell'hasher iniettato (riga 20).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `VERIFY-OTP-INV-1` | Il risultato è esattamente `check()` dell'hasher Illuminate. | riga 20 | `tests/Unit/Actions/Otp/OtpHashActionsTest.php` (riferimento alla classe) |

## Effetti collaterali

Nessuno.

## Errori

- Nessuna gestione esplicita.

## Non fa

- Non gestisce la scadenza (`password_expires_at`) né i tentativi errati.
