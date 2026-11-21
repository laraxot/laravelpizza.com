---
title: "PHPStan — stato modulo User (2026-07-08)"
type: concept
tags: [phpstan, syntax, blockers]
created: 2026-07-14
updated: 2026-07-14
qmd: "phpstan-syntax-blockers phpstan — stato modulo user (2026-07-08)"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# PHPStan — stato modulo User (2026-07-08)

## Stato attuale: risolto

Il cluster di **syntax error** da merge conflict e factory corrotte è stato eliminato.

Verifica:

```bash
cd laravel
XDEBUG_MODE=off ./vendor/bin/phpstan analyse Modules/User/app --level=10
```

Esito atteso: `[OK] No errors`.

## Storia (archivio)

### 1. Factory OAuth corrotte (risolto)

Pattern corretti: `$this->faker`, array e closure `state()` integre.

File ripristinati:

- `database/factories/OauthClientFactory.php`
- `database/factories/OauthAccessTokenFactory.php`
- `database/factories/OauthAuthCodeFactory.php`
- `database/factories/OauthRefreshTokenFactory.php`

### 2. Migration con marker di merge (risolto)

Le migration in `database/migrations/` non contengono più marker `<<<<<<<`, `=======`, `>>>>>>>`.

Protezione: `tests/Feature/Database/Migrations/UserMigrationSyntaxTest.php`.

## Residui type-level (non bloccanti)

Wrapper Passport e risorse Filament possono ancora generare warning PHPStan su scope globale `Modules/`; su scope `Modules/User/app` il livello 10 è pulito.

## Collegamenti

- [quality-status-2.md](../quality-status-2.md)
- [module-commit-push-after-change](wiki/rules/module-commit-push-after-change.md)
