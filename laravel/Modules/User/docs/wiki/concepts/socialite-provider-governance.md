---
type: concept
module: User
confidence: high
updated: 2026-04-20
sources:
  - ../../../app/Models/SocialiteUser.php
  - ../../../app/Models/SocialProvider.php
  - ../../../app/Models/SsoProvider.php
  - ../../../app/Http/Controllers/Socialite/RedirectToProviderController.php
  - ../../../app/Http/Controllers/Socialite/ProcessCallbackController.php
  - ../../../routes/socialite.php
---

# socialite provider governance

## regola di dominio

Nel modulo `User` **non si aggiungono colonne provider-specific** (es. `google_id`, `facebook_id`) nella tabella utenti.

L’identita federata viene modellata con:

- `SocialiteUser`: relazione utente <-> provider esterno
- `SocialProvider`: configurazione provider social
- `SsoProvider`: configurazioni SSO/OIDC/SAML piu avanzate

Questa scelta evita coupling dello schema `users` con singoli vendor OAuth e mantiene il sistema estensibile.

## flusso tecnico attuale

1. il pulsante social punta a `socialite.oauth.redirect`
2. `RedirectToProviderController` valida provider + scopes e invia redirect OAuth
3. callback su `socialite.oauth.callback`
4. `ProcessCallbackController` recupera oauth user, collega o registra `SocialiteUser`, applica ruoli default e fa login

Route:

- `/admin/login/{provider}` (`socialite.oauth.redirect`)
- `/sso/{provider}/callback` (`socialite.oauth.callback`)

## confini dei modelli

### `SocialiteUser`

Contiene il legame operativo col provider:

- `provider`
- `provider_id`
- `token` (se salvato)
- `email`, `name`, `avatar` snapshot
- `user_id` FK applicativa

### `SocialProvider`

Contiene la configurazione funzionale del login social:

- `name`
- `scopes`
- `parameters`
- `stateless`
- `active`
- `socialite`
- `client_id`
- `client_secret`
- `svg`

### `SsoProvider`

Contiene configurazioni enterprise/SSO piu complete:

- `type` (`oauth`, `saml`, `oidc`)
- `client_id`, `client_secret`
- `redirect_url`, `metadata_url`
- `domain_whitelist`, `role_mapping`
- `settings`, `is_active`

## decisione architetturale

Per Google login standard nel contesto corrente, il modello primario da amministrare e `SocialProvider`.

`SsoProvider` resta utile per scenari federati avanzati (OIDC/SAML, mapping ruoli enterprise), ma non e necessario per il primo onboarding Google.

## guardrail dry + kiss

- non duplicare credenziali in piu modelli senza motivo
- tenere il mapping utente-provider in `SocialiteUser`
- tenere i dati sensibili provider in una sola entita amministrabile
- evitare logica OAuth in Blade/theme: resta nel modulo `User`

## riferimenti correlati

- [socialite-backoffice-google-setup](./socialite-backoffice-google-setup.md)
- [../overviews/user-module](../overviews/user-module.md)
