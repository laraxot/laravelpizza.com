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
