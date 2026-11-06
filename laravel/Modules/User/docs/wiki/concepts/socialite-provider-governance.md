---
type: concept
module: User
confidence: high
updated: 2026-10-27
sources:
related:
  - "./ai-harness-user-discipline.md"
  - "./baseuser-hierarchy.md"
  - "./code-redundancy-user.md"
  - "./context-mode-user-discipline.md"
  - "./context-overflow-prevention.md"
  - "./filament-langserviceprovider-governance.md"
  - "./filament-widget-linear-crud-model-create.md"
  - "./filament-widget-resource-form-delegation.md"
title: "socialite provider governance"
status: draft
tags: [docs, user, wiki]
qmd: "socialite provider governance user"
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

1. il pulsante social punta alla route localizzata di redirect del front office
2. `RedirectToProviderController` valida provider + scopes e invia redirect OAuth
3. il callback arriva alla pagina Folio+Volt del tema Sixteen
4. `ProcessCallbackAction` recupera l'utente OAuth, collega o registra `SocialiteUser`, applica i ruoli predefiniti e fa login

Route:

- `/{lang}/auth/login/{provider}` (`oauth.redirect`): entrypoint FO localizzato
- `/{lang}/auth/login/{provider}/callback` (`oauth.callback`): pagina Folio+Volt redirect-only

Il modulo `User` mantiene la policy OAuth nelle Action; il tema possiede il guscio HTTP della callback. Non esistono una route callback
classica in `routes/socialite.php`, né un `ProcessCallbackController`.

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
