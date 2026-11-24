---
title: "RetrieveSocialiteUserAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Socialite\\RetrieveSocialiteUserAction"
qmd: "RetrieveSocialiteUserAction ricerca socialite_users provider provider_id aggiorna token reflection placeholder no_token"
---

# RetrieveSocialiteUserAction

Cerca il collegamento SSO per provider e id esterno e ne aggiorna il campo `token` con il token ricevuto dal provider. Codice: `app/Actions/Socialite/RetrieveSocialiteUserAction.php`.

## Input

- `string $provider` (non vuoto), `SocialiteUserContract $user`.

## Output

- `?SocialiteUser`: il collegamento con `user` caricato e `token` aggiornato, oppure `null` se non esiste.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SOCIALITE-RETRIEVE-SU-INV-1` | Provider vuoto: `InvalidArgumentException`. | `execute()` | nessuno |
| `SOCIALITE-RETRIEVE-SU-INV-2` | ID non stringa né intero: `RuntimeException`. | `execute()` | nessuno |
| `SOCIALITE-RETRIEVE-SU-INV-3` | Senza token leggibile, il campo riceve `'no_token_'.time()`. | `execute()`, fallback | `tests/Unit/UserGapAttackCoverageTest.php:175-187` (istanza) |

## Effetti collaterali

Una SELECT con eager load di `user`. Se il collegamento esiste: UPDATE di `socialite_users.token`. Nessuna transazione, evento o coda.

## Errori

- `InvalidArgumentException` e `RuntimeException` come sopra.
- `ReflectionException` è catturata e ignorata in silenzio.

## Non fa

- Scrive nel database il token di accesso del provider. Se il modello non lo cifra (cast), il token è in chiaro: da verificare in `SocialiteUser`.
- Il valore placeholder `no_token_<timestamp>` finisce nel database come se fosse un token.
- Il token è letto con reflection da più fonti; l'ordine è `getToken()`, `token()`, proprietà `token`, accesso diretto.
- Chiamanti in produzione: 2 riferimenti nel perimetro cercato.
