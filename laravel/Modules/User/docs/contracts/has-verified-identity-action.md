---
title: "Contratto — HasVerifiedIdentityAction"
type: contract
action: "Modules\\User\\Actions\\Auth\\HasVerifiedIdentityAction"
created: 2026-11-23
updated: 2026-11-23
---

# HasVerifiedIdentityAction

## Input
- Utente autenticabile opzionale.
## Output
- `true` per email verificata o metodo `spid`/`cie`; `false` per utente assente o non verificato.
## Invarianti
- SPID/CIE attestano l'identità applicativa, ma non impostano `email_verified_at`.
## Effetti collaterali
- Nessuno: legge sessione e attributi grezzi.
## Errori
- Nessun errore applicativo per utente nullo: restituisce `false`.
## Non fa
- Non invia email, non modifica l'utente e non concede ruoli o permessi.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `HAS-VERIFIED-INV-1` | Un utente null dà `false`. | righe 33-35 | `tests/Unit/Actions/Auth/HasVerifiedIdentityActionTest.php` (riferimento alla classe) |
| `HAS-VERIFIED-INV-2` | SPID e CIE attestano l'identità senza impostare `email_verified_at`: l'email resta non verificata. | docblock righe 15-18, riga 44 | `tests/Feature/Auth/DigitalIdentityUserUpsertTest.php` (riferimento alla classe) |
| `HAS-VERIFIED-INV-3` | Legge gli attributi grezzi, quindi non lancia su un database non ancora migrato. | righe 41-44 | Test: nessuno. |

## Effetti collaterali

Nessuno: legge solo l'utente e i suoi attributi. Nessuna scrittura, nessun evento.

## Errori

- Nessuna eccezione per utente null: restituisce `false`.

## Non fa

- Non invia email, non modifica l'utente, non concede ruoli o permessi.
- Non rende "verificata" l'email: le mail al cittadino continuano a partire solo verso indirizzi confermati.
