---
title: "Contratto — ConsumeAuthSubmissionSlotAction"
type: contract
action: "Modules\\User\\Actions\\Auth\\ConsumeAuthSubmissionSlotAction"
tags: [contract, action, rate-limit, sicurezza]
created: 2026-11-24
updated: 2026-11-24
owner: User
status: accepted
qmd: "ConsumeAuthSubmissionSlotAction freno invio registrazione recupero password SEC-012 rate limiter IP email"
---

# ConsumeAuthSubmissionSlotAction

Sorgente: `app/Actions/Auth/ConsumeAuthSubmissionSlotAction.php`. Perché: [ADR](../adr/auth-submission-throttle-before-validation.md).

## Input

- `AuthThrottleScope $scope`: `Register` o `ForgotPassword`.
- `string $email`: quanto digitato (anche vuoto o non valido).
- `?string $ip`: IP della richiesta; null diventa `unknown`.

## Output

- `int`: 0 = invio consentito (e già conteggiato); > 0 = secondi da attendere.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| USER-AUTH-THROTTLE-INV-1 | Ogni chiamata con esito 0 conta un tentativo, qualunque sia l'esito della validazione che segue. | `USER-AUTH-THROTTLE-INV-1` |
| USER-AUTH-THROTTLE-INV-2 | Superato `MAX_PER_IP` per l'IP o `maxPerEmail()` per l'email nella finestra di `DECAY_SECONDS`, ritorna i secondi d'attesa (≥ 1). | `USER-AUTH-THROTTLE-INV-2` |
| USER-AUTH-THROTTLE-INV-3 | L'email si confronta in minuscolo e senza spazi; i due scope hanno contatori separati. | `USER-AUTH-THROTTLE-INV-3` |
| USER-AUTH-THROTTLE-INV-4 | Le chiavi in cache contengono solo lo sha256 di IP ed email, mai i valori in chiaro. | `USER-AUTH-THROTTLE-INV-4` |

## Effetti collaterali

- `RateLimiter::hit()` sulle chiavi IP ed email (store di cache di default) solo quando l'invio è consentito.

## Errori

- Nessuno proprio; un guasto dello store di cache si propaga.

## Non fa

- Non valida l'email e non tocca il database.
- Non limita il login: il login ha il suo freno in `LoginWidget` (solo tentativi errati).
- Non mostra il messaggio d'attesa: lo fa il widget chiamante con `user::throttle.auth_form.retry.message`.
