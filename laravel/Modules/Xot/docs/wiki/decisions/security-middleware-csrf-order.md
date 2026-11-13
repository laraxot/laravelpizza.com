---
title: "SecurityMiddleware — controlli CSRF e input prima di $next()"
type: decision
module: Xot
tags: [security, csrf, middleware, login, filament]
created: 2026-11-09
updated: 2026-11-11
status: accepted
qmd: "SecurityMiddleware enhanceCSRFProtection validateInputs prima di next 419 page expired login filament"
related:
  - ../../../app/Http/Middleware/SecurityMiddleware.php
---

# SecurityMiddleware: controlli prima della richiesta

## Problema

`validateInputs()` e `enhanceCSRFProtection()` venivano chiamati **dopo** `$next($request)`.

1. **Nessuna protezione reale**: quando il controllo fallisce l'azione è già stata eseguita
   (dati salvati, utente autenticato).
2. **Login impossibile**: il login Filament rigenera sessione e token CSRF. Il confronto
   a posteriori tra il token della richiesta e quello (nuovo) di sessione fallisce sempre
   → 419 "Page Expired" anche con credenziali corrette.

Verificato il 2026-11-05 e di nuovo il 2026-11-09 (la correzione era stata sovrascritta da
un sync del modulo) su `base_predict_fila5`.

## Decisione

Rate limiting → `validateInputs()` → `enhanceCSRFProtection()` → `$next()` → header → log.

## Regola

Non spostare i controlli dopo `$next()`. Chi sincronizza il modulo Xot fra progetti deve
portare questa versione anche nel repository del modulo (`laraxot/module_xot_fila5`).

## Aggiornamento 2026-11-10 — rate limiting

Il rate limiting dello stesso middleware bloccava il sito con 429:

| Difetto | Effetto |
|---|---|
| Contatore per IP su **tutte** le pagine, confrontato con il limite dell'indirizzo richiesto | dopo 5 pagine qualsiasi, `/it/auth/login` (limite 5) → 429 |
| Contatori per User-Agent e per indirizzo **condivisi tra tutti i visitatori** | 5 login al minuto in tutto il sito bloccavano il login per chiunque |
| `cache()->put($key, $n + 1, 60)` rinnova la scadenza a ogni richiesta | il blocco non scadeva finché arrivavano richieste |
| `api/tickets` controllato prima di `api/tickets/create` | limiti specifici mai applicati |

Decisione: un solo contatore `RateLimiter` per **IP + gruppo** (finestra fissa 60 s).
Limite generale 300 richieste/minuto; limiti stretti (login 10, registrazione 5, reset password 5)
solo per gli invii (metodi non GET/HEAD): aprire una pagina non consuma il limite di login.
