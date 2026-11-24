---
title: "Socialite provider boundary — architecture"
type: architecture
module: User
status: done
created: 2026-10-05
updated: 2026-10-05
related:
  - ./socialite-provider-boundary-product-brief.md
  - ./socialite-provider-boundary-prd.md
  - ./stories/socialite-provider-boundary.story.md
---

# Socialite provider boundary — architecture

## Stato verificato

`module.json` registra sia `Modules\\User\\Providers\\UserServiceProvider` sia `Modules\\User\\Providers\\SocialiteServiceProvider`.

`UserServiceProvider` gestisce bootstrap generale: widget Livewire auth, password rules, Pulse, notifiche mail e policy.

`SocialiteServiceProvider` estende `SocialiteProviders\\Manager\\ServiceProvider` e registra l'estensione Microsoft tramite `SocialiteWasCalled`.

## Decisione

Tutta la logica legata a provider Socialite/OAuth vive in `SocialiteServiceProvider`:

- admin config privata: `loadAdminSocialiteConfig()`;
- copia credenziali `services.*` verso `user.social-providers.*`;
- registrazione estensioni `SocialiteWasCalled`.

`UserServiceProvider` non deve conoscere l'elenco provider (`facebook`, `twitter`, `google`, ecc.) né manipolare `user.social-providers.*`.

## Impatto

La sequenza provider resta quella definita da `module.json`: `UserServiceProvider` viene registrato prima, ma la configurazione Socialite viene applicata quando Laravel registra `SocialiteServiceProvider`. Questo è sufficiente perché i consumer leggono `config()` a runtime dopo il bootstrap dei provider.

## Verifica

Comandi minimi:

```bash
cd laravel && php artisan package:discover --ansi
cd laravel && php artisan --version
cd laravel && ./vendor/bin/phpstan analyse Modules/User/app/Providers/UserServiceProvider.php Modules/User/app/Providers/SocialiteServiceProvider.php --no-progress --memory-limit=-1
```

Esito verificato: package discovery, `php artisan --version` e PHPStan sui due
provider completano con successo.
