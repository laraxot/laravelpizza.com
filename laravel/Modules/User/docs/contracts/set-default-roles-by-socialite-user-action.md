---
title: "SetDefaultRolesBySocialiteUserAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Socialite\\SetDefaultRolesBySocialiteUserAction"
qmd: "SetDefaultRolesBySocialiteUserAction ruoli di default socialite dominio email role_names_search first_party client"
---

# SetDefaultRolesBySocialiteUserAction

Assegna ruoli iniziali a un utente SSO in base al dominio della sua email, se non ha già ruoli e il dominio è riconosciuto. Codice: `app/Actions/Socialite/SetDefaultRolesBySocialiteUserAction.php`.

## Input

- `string $provider`, `UserContract $userModel`, `SocialiteUserContract $oauthUser`.

## Output

- `void`.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SOCIALITE-DEFAULT-ROLES-INV-1` | Se l'utente ha già almeno un ruolo, nessuna modifica. | `execute()`, `roles()->count()` | `tests/Feature/Actions/Socialite/SetDefaultRolesBySocialiteUserActionTest.php:33,45` |
| `SOCIALITE-DEFAULT-ROLES-INV-2` | Dominio non riconosciuto (né first party né client): nessun ruolo assegnato. | `execute()`, `hasUnrecognizedDomain()` | stesso file |
| `SOCIALITE-DEFAULT-ROLES-INV-3` | I ruoli sono cercati per nome con `LIKE` su `services.<provider>.email_domains.{first_party,client}.role_names_search`, limitati alla guard di default della classe utente. | `execute()`, closure `where` | stesso file |

## Effetti collaterali

`assignRole()` con una Collection di ruoli: scrittura sulla tabella pivot. Nessun evento o notifica dall'Action.

## Errori

- Nessuna eccezione propria.

## Non fa

- Non crea né rimuove ruoli.
- Se `role_names_search` è vuoto, la closure non aggiunge condizioni e la query prende tutti i ruoli della guard: da verificare con un test sulla configurazione vuota.
- Il pattern di `LIKE` non è escapato: `%` e `_` nella configurazione agiscono da jolly.
- Un commento a metà metodo riporta un errore PHPStan ancora aperto su `assignRole()` (si passa una Collection dove la firma attende un array).
- Chiamanti in produzione: `CreateUserAction` (Socialite) e `RegisterSocialiteUserAction`.
