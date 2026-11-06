---
title: "[STORY] PHPStan zero errori Notify: param type mancanti nei test"
type: story
module: Notify
status: done-pending-commit
priority: medium
created: 2026-10-28
updated: 2026-10-28
tags: [phpstan, typeCoverage, paramTypeCoverage, notify, tests, bmad]
related:
  - ./notify-phpstan-zero-errors.dev.md
  - ../wiki/concepts/phpstan-pest-test-doubles.md
---

# [STORY] PHPStan zero errori Notify: param type mancanti nei test

## User Request

Swarm PHPStan: zero errori nel modulo Notify risolvendo la causa, non l'errore. Elenco: 3 segnalazioni
`typeCoverage.paramTypeCoverage`, tutte in `tests/`.

## Analysis

Causa unica: parametri senza tipo nativo in codice di test, con tipo reale noto.

- `tests/Unit/Enums/MediaTypeEnumTest.php`, `WhatsAppDriverEnumTest.php`: `array_map(fn ($case) => $case->value, XEnum::cases())`.
  Scopo: verificare che i valori dell'enum siano univoci. `cases()` restituisce `list<XEnum>`: ora `fn (MediaTypeEnum $case)` / `fn (WhatsAppDriverEnum $case)`.
- `tests/TestCase.php::getPackageProviders($app)`: scopo, registrare il provider del modulo. La classe estende
  `Illuminate\Foundation\Testing\TestCase` (non Orchestra), quindi il metodo non sovrascrive un parent: nessun vincolo LSP,
  tipizzato `Application $app` (import `Illuminate\Foundation\Application` gia' presente, docblock gia' diceva `Application`).
  Nessun chiamante nel modulo (`grep getPackageProviders`).

Fuori scope, non toccati: `NotificationStatusEnum` vs `NotificationLogStatusEnum` e `.php.up` orfani (nota 2026-10-06).

## Result

- `paramTypeCoverage` su Notify: **3 -> 0** (run full-tree `phpstan analyse Modules --memory-limit=-1`, 2026-10-28; nessuna riga su `Modules/Notify/`).
- 3 file di test modificati. `php -l` ok.
- Non eseguito: Pest (`.env.testing` punta a MySQL; i due test enum sono puri ma non lanciati). Nessun commit.

## Acceptance Criteria

- [x] I 3 parametri hanno tipo nativo
- [x] Nessun `@phpstan-ignore`, nessun `.neon` toccato
- [x] PHPStan full-tree: 0 righe su `Modules/Notify/`
- [ ] Pest sul modulo (non eseguito)

## GitHub (tracciamento)

- Issue: TODO (gh non installato su questa macchina)
- Discussion: TODO
