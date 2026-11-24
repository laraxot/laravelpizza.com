---
title: "RedirectToLoginAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Socialite\\RedirectToLoginAction"
qmd: "RedirectToLoginAction redirect login messaggio errore notifica Filament traduzione lingua corrente"
---

# RedirectToLoginAction

Riporta l'utente alla pagina di login FO con un messaggio di errore, mostrato sia come notifica Filament sia come errore sul campo `email`. Codice: `app/Actions/Socialite/RedirectToLoginAction.php`.

## Input

- `string $message`: chiave di traduzione relativa a `user::`.
- `array<string, string> $replace = []`: segnaposto `:chiave`.

## Output

- `RedirectResponse` verso `/{lang}/auth/login` con `withErrors(['email' => [testo]])`.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SOCIALITE-REDIRECT-LOGIN-INV-1` | L'URL di login è localizzato nella lingua corrente. | `execute()`, `localizeURL` | `tests/Unit/Actions/Socialite/SocialiteUtilityActionsTest.php:166` (chiamata) |
| `SOCIALITE-REDIRECT-LOGIN-INV-2` | Il testo ha i segnaposti sostituiti e i bordi tagliati. | `execute()`, `strtr` | nessuno |
| `SOCIALITE-REDIRECT-LOGIN-INV-3` | Ogni chiamata invia una notifica persistente di tipo danger. | `Notification::make()` | nessuno |

## Effetti collaterali

Notifica Filament inviata (persistente, in sessione) e redirect con error bag. Nessun evento, nessuna scrittura su database.

## Errori

- `Assert` se l'URL o la traduzione non sono stringhe.
- Una chiave mancante non lancia eccezione: `__()` restituisce la chiave stessa, che finisce nell'interfaccia.

## Non fa

- Non registra log del motivo del rifiuto.
- Chiamanti in produzione: 4 riferimenti nel perimetro cercato (`ProcessCallbackAction`, `LoginUserAction` e altri).
