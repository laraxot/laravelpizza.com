---
title: "ProcessCallbackAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Socialite\\ProcessCallbackAction"
qmd: "ProcessCallbackAction callback OAuth socialite flusso login registrazione lingua sessione redirect eventi"
---

# ProcessCallbackAction

Gestisce il ritorno dal provider OAuth: valida il provider, recupera l'utente, applica le regole di accesso e registrazione, poi autentica. È la logica dietro la pagina Folio del callback. Codice: `app/Actions/Socialite/ProcessCallbackAction.php`.

## Input

- `string $lang`: lingua della pagina di ingresso (fallback).
- `string $provider`.

## Output

- `RedirectResponse`: verso il dashboard, o verso il login con un messaggio di errore.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SOCIALITE-CALLBACK-INV-1` | La lingua è quella salvata in sessione (`ProcessCallbackSession::KEY`) se supportata, altrimenti `$lang`. | `execute()`, `session()->pull` | `tests/Feature/Socialite/OauthCallbackFolioPageTest.php:35` (solo `class_exists`) |
| `SOCIALITE-CALLBACK-INV-2` | Provider non configurato: l'eccezione `ProviderNotConfigured` si propaga (non è un redirect). | `ValidateProviderAction` | nessuno |
| `SOCIALITE-CALLBACK-INV-3` | Utente non ammesso dal dominio: evento `UserNotAllowed`, redirect `auth.user-not-allowed`. | `execute()` | nessuno |
| `SOCIALITE-CALLBACK-INV-4` | Registrazione disabilitata per un utente sconosciuto: evento `RegistrationNotEnabled`, redirect `auth.registration-not-enabled`. | `execute()` | nessuno |
| `SOCIALITE-CALLBACK-INV-5` | Utente con `canAccessSocialite()` falso: nessun login. | `execute()` | nessuno |

## Effetti collaterali

Ordine: `session()->pull`, `setLocale` globale, validazione provider, scambio del codice OAuth (in `RetrieveOauthUserAction`), eventuali eventi di rifiuto, creazione di `User` e `SocialiteUser` (via `RegisterSocialiteUserAction` o `RegisterOauthUserAction`), login tramite `LoginUserAction`. Nessuna transazione a questo livello.

## Errori

- `ProviderNotConfigured` non è catturata: la richiesta fallisce con eccezione.
- Ogni rifiuto previsto è un redirect con messaggio, non un'eccezione.

## Non fa

- Sul percorso "utente esistente senza collegamento", `RegisterSocialiteUserAction` dispatcha `SocialiteUserConnected` e poi `LoginUserAction` lo dispatcha di nuovo: evento doppio, da verificare con un test.
- Il controllo `Auth::user()` in fondo è rilevante solo per un utente già autenticato.
- Chiamante in produzione: `app/Http/Controllers/Socialite/RedirectToProviderController.php`.
