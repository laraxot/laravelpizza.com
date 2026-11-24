---
title: "Contratto — GetUserDataAction"
type: contract
action: "Modules\UI\Actions\GetUserDataAction"
tags: [contract, action, user, personal-data]
created: 2026-11-24
updated: 2026-11-24
---

# GetUserDataAction

Sorgente: `app/Actions/GetUserDataAction.php`. Espone dati personali dell'utente autenticato (nome, email, avatar,
ruolo, permessi, `profile.extra`) come `Modules\UI\Datas\UserData`. Nel checkout attuale non ha chiamanti in
produzione, solo test: chi lo collega a una vista o a un'API legge prima «Non fa».

## Input

- Nessun parametro. Legge `Auth::user()` (guard di default).

## Output

- `UserData|null`: `null` se nessuno è autenticato o se l'autenticato non implementa `Modules\Xot\Contracts\UserContract`.
- Altrimenti `id`, `name`, `email` (`getAttribute`, `''` se non stringa), `avatar` (URL del profilo caricato, poi
  `profile_photo_path`, poi `null`), `role` (il **primo** nome di ruolo), `permissions` (nomi di tutti i permessi,
  anche via ruolo), `settings` (`profile.extra` se array).

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| UI-USERDATA-INV-1 | Senza utente autenticato del dominio (`UserContract`) ritorna `null`, mai dati parziali. | `UI-USERDATA-INV-1` |
| UI-USERDATA-INV-2 | Descrive solo l'utente autenticato: id, nome ed email sono i suoi attributi, non di altri. | `UI-USERDATA-INV-2` |
| UI-USERDATA-INV-3 | Non carica relazioni: il profilo si usa solo se già caricato (`relationLoaded('profile')`), altrimenti `settings = []`. | `UI-USERDATA-INV-3` |
| UI-USERDATA-INV-4 | `role` è il primo ruolo, `permissions` sono nomi (stringhe). | — |

## Effetti collaterali

- Nessuna scrittura. Legge ruoli e permessi tramite Spatie Permission (`getRoleNames()`, `getAllPermissions()`), che
  può interrogare il database se le relazioni non sono caricate.

## Errori

- Nessuna eccezione propria; errori del database su ruoli/permessi risalgono.

## Non fa

- Non accetta un utente come parametro: non usarla per descrivere un utente diverso da quello autenticato.
- Non filtra i dati per destinatario: il risultato contiene email, permessi e `profile.extra`; non va serializzato
  verso il browser o un'API pubblica senza scegliere i campi.
- Non mette in cache.
- Debito: i test `prende il primo ruolo, non tutti` e `elenca i permessi per nome` di `tests/Unit/GetUserDataActionTest.php`
  falliscono nel checkout attuale (ruolo `null`, permessi vuoti con relazioni impostate via `setRelation`): per questo
  UI-USERDATA-INV-4 non ha group.
