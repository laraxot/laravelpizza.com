---
title: "[STORY] PHPStan Tenant: categoria nei benchmark Sushi"
type: story
status: done
priority: low
created: 2026-10-08
updated: 2026-10-08
module: Tenant
tags: [phpstan, tenant, pest, performance, sushi, swarm]
---

# PHPStan Tenant: categoria nei benchmark Sushi

Fase BMAD: Dev + Docs.

## Richiesta

Azzerare gli errori PHPStan guardando lo scopo. Perimetro: `foreach.unusedKey` a `SushiToJsonPerformanceTest.php:393`.

## Analisi

Il test `meets performance benchmarks` misura salvataggio e caricamento per quattro categorie (`small`, `medium`, `large`, `xlarge`). La chiave `$category` doveva comparire nel messaggio d'errore: lo dicevano i commenti accanto alle asserzioni ("Salvataggio $category dataset deve rispettare il benchmark"), ma i commenti non sono messaggi e il valore non veniva mai letto. Senza categoria, un fallimento diceva solo "X non e' minore di 5" senza indicare quale dataset.

## Modifiche

- `toBeLessThan()` e `toHaveCount()` di Pest accettano `string $message` (verificato in `vendor/pestphp/pest/src/Mixins/Expectation.php`): la categoria entra nei tre messaggi e i due commenti sostitutivi sono spariti. Soglie e logica invariate.

## Verifica

- `php -l`: nessun errore.
- `phpstan analyse` sul file (con gli altri 6 dello swarm `small-modules`): `[OK] No errors`.
- Pest: non eseguito (MySQL di test irraggiungibile, rc=124; il test e' di performance e sensibile al carico, la macchina ha load > 100).
