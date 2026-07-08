---
title: Socialite Architecture — No google_id Column Rule
type: concept
module: User
updated: 2026-04-20
---

# Socialite Architecture

## Regola fondamentale: nessuna colonna `google_id` o `facebook_id`

**NON** aggiungiamo colonne `google_id`, `facebook_id`, `github_id` ecc. alla tabella `users`.

**Perché**: con molti provider OAuth la tabella si sporca (N colonne per N provider). Ogni provider aggiunto richiede una migration.

**Soluzione**: tabella separata `socialite_users` tramite il modello `SocialiteUser`.

---

## Modelli coinvolti

### `SocialiteUser` (tabella `socialite_users`)

```
user_id      → FK → users.id
provider     → 'google' | 'facebook' | 'github' | ...
provider_id  → ID utente sul provider OAuth
token        → OAuth token
name, email, avatar → dati profilo dal provider
```

Un utente può avere **N** righe in `socialite_users` (uno per provider collegato).

### `SocialProvider` (Sushi — da `config/social-providers.php`)

Modello **senza tabella DB** (usa Sushi/`SushiToPhpArray`). Legge la configurazione da `config/social-providers.php`.

Campi: `name`, `client_id`, `client_secret`, `scopes`, `stateless`, `active`, `socialite`, `svg`.

I `client_id`/`client_secret` vengono da variabili env (`GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`, ecc.).

---

## Flusso OAuth (Login con Google)

```
1. Utente clicca "Login con Google"
2. RedirectToProviderController → Socialite::driver('google')->redirect()
3. Google autentica → callback URL
4. ProcessCallbackController → Socialite::driver('google')->user()
5. RetrieveOauthUserAction → cerca SocialiteUser per (provider, provider_id)
6. Se esiste → LoginUserAction (login diretto)
7. Se non esiste → RegisterSocialiteUserAction → CreateUserAction + CreateSocialiteUserAction
8. Redirect a login_redirect_route
```

---

## Action Layer (Queueable Actions)

Tutte le azioni si trovano in `Modules/User/app/Actions/Socialite/`:

| Action | Responsabilità |
|--------|---------------|
| `RetrieveOauthUserAction` | Recupera dati OAuth da Socialite |
| `RetrieveSocialiteUserAction` | Cerca SocialiteUser per (provider, provider_id) |
| `CreateSocialiteUserAction` | Crea SocialiteUser (NON modifica users) |
| `CreateUserAction` | Crea User da dati OAuth |
| `RegisterSocialiteUserAction` | Orchestra registrazione nuovo utente OAuth |
| `LoginUserAction` | Esegue il login Laravel |
| `IsProviderConfiguredAction` | Verifica GOOGLE_CLIENT_ID/SECRET in env |
| `IsRegistrationEnabledAction` | Verifica config `socialite.registration` |
| `ValidateProviderAction` | Verifica provider è attivo e configurato |
| `GetProviderButtonsAction` | Ritorna lista pulsanti provider attivi |

---

## Configurazione Provider

### `config/social-providers.php`

Fonte di verità per tutti i provider. Ogni provider ha:
- `active: false` per default (va attivato manualmente o da admin)
- `client_id` e `client_secret` da env variable

### Aggiungere Google

In `.env`:
```env
GOOGLE_CLIENT_ID=xxxxxxx.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=GOCSPX-xxxxxxx
```

In `config/services.php` (già gestito dal modulo):
```php
'google' => [
    'client_id' => env('GOOGLE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'redirect' => env('GOOGLE_REDIRECT_URL', url('/auth/google/callback')),
],
```

Per attivare il provider: impostare `active: true` in `social-providers.php` oppure via backoffice.

---

## Backoffice Admin — Cluster Socialite

Il backoffice Filament ha un **Cluster** dedicato:
`Modules/User/app/Filament/Clusters/Socialite/`

Contiene:
- `SocialProviderResource` — gestione provider (client_id, client_secret, active)
- `SocialiteUserResource` — lista utenti OAuth connessi

**→ Vedi tutorial**: `docs/wiki/concepts/socialite-admin-tutorial.md`

---

## Ispirazione

Ispirato a [DutchCodingCompany/filament-socialite](https://github.com/DutchCodingCompany/filament-socialite) ma con architettura custom:
- Nessun pacchetto esterno installato (implementazione proprietaria)
- `SocialProvider` usa Sushi (config → modello, no DB)
- Actions pattern (Spatie QueueableAction) invece di service classes

---

## Link correlati

- [SocialiteUser model](../entities/socialite-user.md)
- [Admin tutorial Google OAuth](./socialite-admin-tutorial.md)
- [Rule: no google_id column](../../../../../../bashscripts/ai/.claude/rules/socialite-no-column.md)
