---
title: "LoginUserAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Socialite\\LoginUserAction"
qmd: "LoginUserAction login SSO Filament auth utente collegato evento SocialiteUserConnected deleted_at redirect"
---

# LoginUserAction

Accede al pannello con l'utente collegato all'identità SSO, dopo aver scartato gli account eliminati. Codice: `app/Actions/Socialite/LoginUserAction.php`.

## Input

- `SocialiteUser $socialiteUser`: la relazione `user` è usata se caricata, altrimenti letta dal database.

## Output

- `RedirectResponse`: `redirect()->intended('/')` in caso di successo; redirect al login con messaggio `auth.user-not-allowed` se l'account ha `deleted_at`.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SOCIALITE-LOGIN-INV-1` | Senza utente collegato: `InvalidArgumentException`. | `execute()` | nessuno |
| `SOCIALITE-LOGIN-INV-2` | Utente non `Authenticatable` né `UserContract`: `LogicException`. | `execute()` | nessuno |
| `SOCIALITE-LOGIN-INV-3` | Account con `deleted_at` valorizzato non viene autenticato. Il controllo legge gli attributi grezzi. | `execute()` | `tests/Feature/Actions/Socialite/LoginUserActionTest.php` (file presente, asserzioni non verificate qui) |

## Effetti collaterali

Ordine: evento `SocialiteUserConnected` (solo nel percorso di successo), `Filament::auth()->login()`, redirect. Nessuna transazione. In caso di account eliminato: nessun evento e nessun login.

## Errori

- `InvalidArgumentException`, `LogicException` come sopra.

## Non fa

- Il fallback `redirect()->intended('/')` è un percorso fisso, non localizzato.
- Lo stesso evento `SocialiteUserConnected` può essere dispatchato due volte nel flusso di `ProcessCallbackAction` (vedi quel contract).
