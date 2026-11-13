---
epic: code-quality
type: story
status: done
repository: laraxot
created: 2026-11-11
updated: 2026-11-11
---

# PHPStan wave 2 — bleedingEdge constant types + Safe functions + Pest/Mockery typing

## Contesto

`phpstan analyse Modules` (bleedingEdge, level max) riporta 88 errori nuovi
su file toccati da lavoro concorrente dopo la wave 1 (che era a 0 errori):

1. **User** (3 file): `typeCoverage.constantTypeCoverage` — costanti di classe
   senza type nativo (PHP 8.3+ li supporta; bleedingEdge esige >99% coverage).
2. **Xot** (6 file): `theCodingMachineSafe.function` — `symlink`, `realpath`,
   `readlink`, `exec`, `preg_split` non-Safe.
3. **Tenant tests** (~10 file): Pest `beforeEach()->afterEach()` inesistente e
   Mockery `ExpectationInterface` senza `once()/with()/andReturnUsing()/andReturn()/andThrow()`
   (metodi su `Expectation` concreto o another type).

## Scope e owner

- User constants → agente principale (file appena creati da lui).
- Xot Safe functions → subagent A.
- Tenant tests → subagent B.

## Fix

- Costanti: `private const string|int|array NOME = ...`.
- Safe: `use function Safe\<fn>;` + eventuali fix di signature (Safe lancia eccezioni).
- Pest: `afterEach()` come funzione globale separata, non metodo di `beforeEach()`.
- Mockery: allineare ai tipi reali del vendor (verificare `Expectation` vs
  `ExpectationInterface` in `vendor/mockery`).

## Esito

- `phpstan analyse Modules` → **0 errori** (10639 file, exit 0).
- User: costanti tipizzate PHP 8.3 (`private const string|int|array`) in
  `BackfillLoginPulseCommand`, `GetLoginHistoryAction`, `LoginWidget`.
- Xot: `Safe\*` functions + helper `realpathOrFalse()` per semantica
  `false`-su-mancato-file; Pest Xot File actions: 30 passed.
- Tenant: `beforeEach()->afterEach()` → `afterEach()` top-level; Mockery
  `TestCase::expectMockery()` → `shouldReceive()` diretto (ritorno tipizzato
  `Expectation`). I file erano divergenze working-tree da HEAD; allineati.
- Pest Tenant: fix type-level ok; failure residue pre-esistenti a HEAD
  (fixture mancanti, DB test non migrato, timing flaky) — non correlate.
- Debito: `TestCase::expectMockery()` return type `ExpectationInterface` è
  trappola latente (widen a `Expectation` in follow-up); failure Pest
  pre-esistenti Tenant da valutare in story separata.

## Verifica

- `phpstan analyse` sugli scope toccati → 0.
- `phpstan analyse Modules` completo → 0.
