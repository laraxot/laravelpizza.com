---
title: "GetUserDataAction — contratto"
type: contract
owner: UI
status: accepted
tags: [contract, action, user, personal-data]
created: 2026-11-24
updated: 2026-11-24
action: "Modules\\UI\\Actions\\GetUserDataAction"
qmd: "GetUserDataAction utente autenticato UserData avatar ruolo permessi settings profile"
---

# GetUserDataAction

Sorgente: `app/Actions/GetUserDataAction.php`. Espone dati personali dell'utente autenticato (nome, email, avatar,
ruolo, permessi, `profile.extra`) come `Modules\UI\Datas\UserData`. Nel checkout attuale non ha chiamanti in
produzione, solo test: chi lo collega a una vista o a un'API legge prima «Non fa».

## Input

- Nessun parametro. Legge `Auth::user()` (guard di default).

## Output

- `UserData|null`: `null` se nessuno è autenticato o se l'autenticato non implementa `Modules\Xot\Contracts\UserContract`.
- Altrimenti `id`, `name`, `email` (`getAttribute`, `''` se non stringa), `avatar`, `role` (il **primo** nome di
  ruolo, `null` se non ne ha), `permissions` (nomi di tutti i permessi, anche via ruolo), `settings` (`profile.extra`
  se array, altrimenti `[]`).

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| UI-USERDATA-INV-1 | Senza utente autenticato del dominio (`UserContract`) ritorna `null`, mai dati parziali. | `UI-USERDATA-INV-1` |
| UI-USERDATA-INV-2 | Descrive solo l'utente autenticato: id, nome ed email sono i suoi attributi, non di altri. | `UI-USERDATA-INV-2` |
| UI-USERDATA-INV-3 | Non carica relazioni: il profilo si usa solo se già caricato (`relationLoaded('profile')`), altrimenti `settings = []`. | `UI-USERDATA-INV-3` |
| UI-USERDATA-INV-4 | `role` è il primo ruolo, `permissions` sono nomi (stringhe). | `UI-USERDATA-INV-4` |
| UI-USERDATA-INV-5 | `avatar` è l'URL del profilo se già caricato e non vuoto; altrimenti `profile_photo_path` se stringa non vuota; altrimenti `null`. | `UI-USERDATA-INV-5` |

Gli ID sono stabili: ogni test Pest li usa come `group` (`--group=UI-USERDATA-INV-4`).

## Effetti collaterali

- Nessuna scrittura, evento o coda. Legge ruoli e permessi tramite Spatie Permission (`getRoleNames()`,
  `getAllPermissions()`), che può interrogare il database se le relazioni non sono caricate.

## Errori

- Nessuna eccezione propria; errori del database su ruoli/permessi risalgono.

## Non fa

- Non accetta un utente come parametro: non usarla per descrivere un utente diverso da quello autenticato.
- Non filtra i dati per destinatario: il risultato contiene email, permessi e `profile.extra`; non va serializzato
  verso il browser o un'API pubblica senza scegliere i campi.
- Non filtra i permessi per guard o per team.
- Non mette in cache.

## Test

`tests/Unit/GetUserDataActionTest.php`. L'helper `uiAuthUser()` imposta ruoli e permessi con `setRelation()`: la
sottoclasse anonima di `User` deve rispondere a `relationLoaded()` con il genitore per ogni chiave diversa da
`profile`, altrimenti Spatie considera `roles` e `permissions` non caricati, li rilegge dal database e i test vedono
ruolo `null` e permessi vuoti (difetto del test, non dell'azione, corretto il 24 novembre).
