---
title: PHPStan Tenant — asserzioni ridondanti dopo assertSame sull'intero metadata (alreadyNarrowedType)
type: story
module: Tenant
status: done
created: 2026-11-10
updated: 2026-11-10
qmd: "phpstan tenant alreadyNarrowedType assertSame narrowing metadata nested SushiToJsonIntegrationTest complex data structures"
related:
  - ./phpstan-tenant-test-assertions.story.md
  - ./sushitojson-test-fixtures.story.md
  - ../../../../../bashscripts/ai/wiki/memories/phpstan-impure-tag-insufficient-for-repeated-call-narrowing.md
---

# PHPStan Tenant: asserzioni ridondanti in `handles complex data structures`

## Scopo

Il test verifica che `SushiToJson` salvi gli array nidificati di una riga come stringa JSON e che, decodificati, tornino identici all'originale.

## Causa

Errori emersi dopo il pull dei moduli (2026-11-10). Il commit `f0eb781` del repo Tenant ha aggiunto `Assert::assertSame($testData['1']['metadata'], $decodedMetadata)` e ha lasciato sotto le verifiche puntuali su `tags` e `nested.level1.level2.level3`:

| Riga | Identifier | Messaggio |
|---|---|---|
| `SushiToJsonIntegrationTest.php:145` | `staticMethod.alreadyNarrowedType` | `assertSame(['tag1','tag2','tag3'], ...)` sarà sempre vero. |
| `SushiToJsonIntegrationTest.php:149` | `staticMethod.alreadyNarrowedType` | `assertSame('deep_value', ...)` sarà sempre vero. |

Dopo un `assertSame` strict con un letterale, PHPStan restringe `$decodedMetadata` a quella forma esatta, quindi ogni verifica successiva sui suoi sotto-valori è una tautologia.

## Modifica

Rimosse le due asserzioni puntuali e le tre variabili intermedie. Resta l'`assertSame` strict sull'intero array, che controlla già `tags` e il valore annidato. Il test non perde copertura. Stesso criterio di `BaseModelTest` in [phpstan-tenant-test-assertions](./phpstan-tenant-test-assertions.story.md).

## Verifica

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules/Tenant   # [OK] No errors
vendor/bin/pint --test Modules/Tenant/tests/Integration/Traits/SushiToJsonIntegrationTest.php   # passed
```

Pest non è eseguibile in questo ambiente: `TestDatabaseGuard` blocca il bootstrap perché la connessione `user_mysql` punta a `fixcity_user`, che non termina con `_test` (senza override: `Access denied for user`). Da rieseguire con un DB di test configurato.
