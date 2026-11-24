---
<<<<<<< HEAD
title: "Contratto — ConsumeAuthSubmissionSlotAction"
type: contract
action: "Modules\User\Actions\Auth\ConsumeAuthSubmissionSlotAction"
tags: [contract, action, rate-limit, sicurezza]
created: 2026-11-24
updated: 2026-11-24
=======
title: "ConsumeAuthSubmissionSlotAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Auth\\ConsumeAuthSubmissionSlotAction"
qmd: "ConsumeAuthSubmissionSlotAction freno invio registrazione recupero password SEC-012 rate limiter IP email"
>>>>>>> laraxot/dev
---

# ConsumeAuthSubmissionSlotAction

<<<<<<< HEAD
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
=======
Freno agli invii dei moduli di registrazione e recupero password (SEC-012): una finestra per IP e una per email. Codice: `app/Actions/Auth/ConsumeAuthSubmissionSlotAction.php:17-48`.

## Input

- `AuthThrottleScope $scope`: ambito del modulo (fornisce il massimo per email e la durata).
- `string $email`: normalizzata con `trim` e minuscolo; se vuota la finestra email non si applica.
- `?string $ip`: se nullo la chiave IP usa il valore `unknown`.

## Output

- `int`: 0 se l'invio è consentito (e conteggiato); altrimenti i secondi da attendere, almeno 1 (righe 31-41).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `AUTH-SUBMIT-INV-1` | Se una finestra è già esaurita nessuna finestra viene incrementata: il tentativo non conta. | righe 31-35 prima di 37-39 | Test: nessuno. |
| `AUTH-SUBMIT-INV-2` | Se l'invio è consentito tutte le finestre (IP ed email) sono incrementate di un'unità con durata `DECAY_SECONDS`. | righe 37-41 | Test: nessuno. |
| `AUTH-SUBMIT-INV-3` | Le chiavi contengono l'hash SHA-256 di IP ed email, non il dato in chiaro. | righe 44-46 | Test: nessuno. |
| `AUTH-SUBMIT-INV-4` | Tutti i ip nulli condividono la stessa finestra (`unknown`). | riga 24 | Test: nessuno. |

## Effetti collaterali

Scrive solo nel `RateLimiter` (cache), nessun database, nessun evento. Il controllo avviene prima della validazione e della scrittura del chiamante, come richiesto dal docblock.

## Errori

- Nessuna eccezione. Il caso bloccato è un intero positivo, non un'eccezione.

## Non fa

- Non valida il modulo né invia email.
- Non distingue il successo dal fallimento del tentativo: ogni invio conta.
>>>>>>> laraxot/dev
