---
title: "Composer Dependencies - Modulo User"
type: concept
tags: [composer, dependencies]
created: 2026-07-14
updated: 2026-07-14
qmd: "composer-dependencies composer dependencies - modulo user"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
status: draft
---

# Composer Dependencies - Modulo User

## Regola Fondamentale

**Le dipendenze specifiche del modulo User (auth, login, OAuth, Socialite) vanno in `Modules/User/composer.json`, MAI nel root `laravel/composer.json`.**

## Motivazione

- **Encapsulation**: Il modulo User è responsabile della propria logica di autenticazione
- **Modularità**: Il root composer.json gestisce solo dipendenze core (Laravel, Filament, nwidart)
- **wikimedia/composer-merge-plugin**: Merge automatico dei composer.json dei moduli

## Package che Appartengono al Modulo User

| Package | Motivo |
|---------|--------|
| `socialiteproviders/microsoft` | OAuth Microsoft per login |
| `socialiteproviders/auth0` | OAuth Auth0 per login |
| `laravel/passport` | API OAuth |
| `jenssegers/agent` | User agent per auth |
| `spatie/laravel-personal-data-export` | Export dati utente |

## Workflow Corretto

1. Modificare `Modules/User/composer.json` aggiungendo il package in `require`
2. Dalla root Laravel: `cd laravel && composer go`

## Anti-pattern

```bash
# ERRATO: installa nel root
cd laravel && composer require socialiteproviders/microsoft
```

## Collegamenti

- [Composer Module Dependency Management](../../Xot/docs/composer-module-dependency-management.md)
- [Socialite Microsoft Integration](socialite-microsoft-integration.md)
