---
title: "Socialite provider boundary — PRD"
type: prd
module: User
status: done
created: 2026-10-05
updated: 2026-10-05
related:
  - ./socialite-provider-boundary-product-brief.md
  - ./socialite-provider-boundary-architecture.md
  - ./stories/socialite-provider-boundary.story.md
---

# Socialite provider boundary — PRD

## Requisiti funzionali

1. `SocialiteServiceProvider` deve caricare le configurazioni admin da `storage/app/private/socialite-config.php` come oggi.
2. `SocialiteServiceProvider` deve fondere le credenziali OAuth presenti in `config/services.php` dentro `user.social-providers.*`.
3. `UserServiceProvider` non deve contenere metodi o chiamate dedicati alla configurazione dei provider Socialite.
4. La registrazione del provider Microsoft tramite `SocialiteWasCalled` deve restare in `SocialiteServiceProvider`.

## Requisiti non funzionali

- Nessun cambio schema database.
- Nessun cambio di route pubbliche o admin.
- Nessun nuovo package.
- Fix forward-only: non cancellare configurazioni esistenti, solo spostare responsabilità.

## Acceptance criteria

- [x] `UserServiceProvider::register()` non chiama configurazione Socialite.
- [x] Il metodo che copia `services.<provider>.client_id/client_secret` in `user.social-providers.<provider>` vive in `SocialiteServiceProvider`.
- [x] `php artisan package:discover --ansi` termina con exit code 0.
- [x] `php artisan --version` termina con exit code 0.
