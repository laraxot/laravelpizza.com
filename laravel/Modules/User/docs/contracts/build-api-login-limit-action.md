---
title: "BuildApiLoginLimitAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Auth\\BuildApiLoginLimitAction"
qmd: "BuildApiLoginLimitAction limite frequenza login API throttle 429 email IP user-login"
---

# BuildApiLoginLimitAction

Costruisce il limite di frequenza del `POST /api/user/login` (D-08, DCP-282), registrato come limiter `user-login` in `UserServiceProvider`. Codice: `app/Actions/Auth/BuildApiLoginLimitAction.php:19-42`.

## Input

- `Request $request`: legge `email` (se stringa) e l'IP del client (`execute`, riga 27).

## Output

- `Illuminate\Cache\RateLimiting\Limit` con chiave `email|IP` (email in minuscolo e traslitterata), 5 richieste per 60 secondi, e una risposta 429 personalizzata (righe 32-41).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `API-LOGIN-LIMIT-INV-1` | Il limite è `MAX_ATTEMPTS = 5` richieste per `DECAY_SECONDS = 60` secondi. | righe 21-25, 32 | Test: nessuno (il docblock cita un test di coerenza con `LoginWidget` non trovato in `tests/`). |
| `API-LOGIN-LIMIT-INV-2` | Se l'email non è una stringa la parte email della chiave è vuota: tutte le richieste senza email dallo stesso IP condividono il contatore. | riga 30 | Test: nessuno. |
| `API-LOGIN-LIMIT-INV-3` | Alla risposta di blocco il corpo è JSON con `success` false, `data` vuoto, stato 429 e header `Retry-After` inoltrati; i secondi vengono dall'header o da `DECAY_SECONDS`. | righe 33-41 | Test: nessuno. |

## Effetti collaterali

Nessuno al momento della costruzione. Il contatore è in cache, incrementato dal middleware di rate limiting (non da questa Action).

## Errori

- Nessuna eccezione propria. La risposta 429 è generata dalla closure di `response()`.

## Non fa

- Non conta solo i tentativi errati: a differenza del `LoginWidget` conta ogni richiesta (scelta dichiarata nel docblock, righe 15-17).
- Non azzera il contatore al successo.
