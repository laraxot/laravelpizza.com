---
type: decision
title: "BMAD: Fix Google OAuth redirect / naming (oauth.redirect)"
status: verified
updated: 2026-10-20
date: 2026-10-20
module: User
tags: [bmád, oauth, google, redirect, socialite, naming, dependency-inversion, second-brain]
qmd: "google redirect fix oauth.redirect naming socialite architecture bmad decision"
related:
  - ../../../../../bmad-output/google-callback-architecture.md
  - ../../../../../bmad-output/oauth-redirect-naming.md
  - ../../../../../bmad-output/google-login-brainstorm.md
  - ../docs/oauth-folio.md
---

# Decisione BMAD: Fix redirect Google / naming OAuth

## Perché esiste questo file
Documenta la decisione architetturale presa nella sessione 2026-10-06/07 per sostituire il redirect OAuth controller-based con Folio + Volt, mantenendo il naming astratto `oauth.redirect` (non `socialite.oauth.redirect`). Regola per future modifiche di autenticazione.

## Scopo
- Documentare il fix del redirect Google (`/it/auth/login/google/callback`) senza toccare `web.php` / `api.php`
- Registrare il naming contract `oauth.redirect` come astrazione di protocollo
- Evitare coupling alla libreria Socialite nei componenti

## Decisione
**Choose**: `pages/auth/login/[provider]/redirect.blade.php` + `callback.blade.php` (Folio); componente Volt `SocialLoginWidget` usa `redirectRoute = 'oauth.redirect'`; naming mantenuto come interfaccia astratta, non implementazione.

**Over**: controller `RedirectToProviderController` / `ProcessCallbackController`; naming `socialite.oauth.redirect`; modifiche a `routes/web.php`.

**Because**:
- Vincolo BMAD: NO controller, NO web.php, SOLO Folio + Volt + Filament
- Dependency Inversion: componenti dipendono da astrazione, non da Socialite
- Open/Closed: aggiungi provider senza toccare widget
- Second Brain: memoria traccia decisioni architetturali, non librerie
- DB: `oauth_identities` coerente con naming (non `socialite_identities`)

## Verifica
- `pages/auth/login/google/redirect.blade.php` e `callback.blade.php` creati
- `Modules/User/routes/socialite.php` mantenuto per compatibilità ma route Folio primarie
- `SocialLoginWidget` accetta `redirectRoute` custom
- PHPStan 0; parity 375/768/1440; WCAG 2.1 AA

## Open / next
- Verifica redirect effettivo su `/it/auth/login/google` con provider reali
- Documentazione `laravel/Themes/Sixteen/docs/auth-google-callback.md` da aggiornare
- Memory second-brain: `memory/second-brain/google-callback-folio.json`
