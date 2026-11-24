---
title: "Socialite provider boundary — product brief"
type: product-brief
module: User
status: done
created: 2026-10-05
updated: 2026-10-05
related:
  - ./socialite-provider-boundary-prd.md
  - ./socialite-provider-boundary-architecture.md
  - ./stories/socialite-provider-boundary.story.md
---

# Socialite provider boundary — product brief

## Problema

`UserServiceProvider` contiene bootstrap Socialite (`mergeSocialProviderCredentialsFromEnv()`), anche se il modulo ha già `SocialiteServiceProvider` registrato in `module.json` per gestire l'integrazione OAuth/social login.

## Obiettivo

Spostare tutta la configurazione Socialite/OAuth provider-specifica in `SocialiteServiceProvider`, lasciando `UserServiceProvider` come bootstrap identità generale: widget auth, password rules, mail notifications, Pulse e policy.

## Valore

- Responsabilità più chiare tra provider.
- Meno accoppiamento nel provider generale del modulo User.
- Configurazione social centralizzata nello stesso punto che registra `SocialiteProviders`.

## Non-obiettivi

- Non cambiare nomi o formato delle chiavi `services.*` e `user.social-providers.*`.
- Non cambiare route, controller o azioni Socialite.
- Non spostare segreti o riscrivere storage admin `storage/app/private/socialite-config.php`.
