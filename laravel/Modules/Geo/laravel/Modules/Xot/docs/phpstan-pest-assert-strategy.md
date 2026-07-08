---
title: PHPStan + Pest→Assert Migration Strategy
type: rule
tags: [phpstan, pest, assert, testing, quality-gate]
created_at: 2026-06-10
updated_at: 2026-06-10
---

# PHPStan + Pest→Assert Migration Strategy

## Regola critica
**SOLO l'utente modifica `phpstan.neon`** — fix code, not config.

## Problema: `method.internalClass` (23k errori)

PHPStan flags `expect()->toBe()` chains as calls on Pest internal classes.

**Fix**: Convertire `expect()` → `PHPUnit\Framework\Assert::assert*()`.

Script: `Modules/Activity/tools/convert-pest-to-assert.php`

**Runner per tutti i moduli:**
```bash
for mod in Cms Fixcity Gdpr Geo Job Notify Tenant UI User Xot; do
  php -r "\$root='Modules/$mod/tests'; ..."
done
```

## Pattern conversione (singola riga)

| Pest | PHPUnit Assert |
|------|---------------|
| `expect($x)->toBeTrue()` | `Assert::assertTrue($x)` |
| `expect($x)->toBeFalse()` | `Assert::assertFalse($x)` |
| `expect($x)->toBeNull()` | `Assert::assertNull($x)` |
| `expect($x)->not->toBeNull()` | `Assert::assertNotNull($x)` |
| `expect($x)->toBe($v)` | `Assert::assertSame($v, $x)` |
| `expect($x)->toEqual($v)` | `Assert::assertEquals($v, $x)` |
| `expect($x)->toBeInstanceOf(C::class)` | `Assert::assertInstanceOf(C::class, $x)` |
| `expect($x)->toHaveCount($n)` | `Assert::assertCount($n, $x)` |
| `expect($x)->toBeString()` | `Assert::assertIsString($x)` |
| `expect($x)->toBeFloat()` | `Assert::assertIsFloat($x)` |
| `expect($x)->toBeEmpty()` | `Assert::assertEmpty($x)` |
| `expect($x)->not->toBeEmpty()` | `Assert::assertNotEmpty($x)` |
| `expect($x)->toContain($s)` | `Assert::assertStringContainsString($s, $x)` |

## Catene multiriga — fix manuale

Se la conversione genera `Assert::assertSame(val)->toBeFloat(, $result)`:
```php
// BROKEN (da regex incompleta):
Assert::assertSame(123.45)->toBeFloat(, $result);

// CORRETTO:
Assert::assertSame(123.45, $result);
Assert::assertIsFloat($result);
```

## Conflict Webmozart vs PHPUnit Assert

Se un file usa `Webmozart\Assert\Assert` + PHPUnit Assert:
```php
use PHPUnit\Framework\Assert as PhpunitAssert;
use Webmozart\Assert\Assert; // runtime assertions

PhpunitAssert::assertTrue($result);
Assert::notNull($value); // webmozart runtime
```

## File non convertibili

- `.pest.php` — Pest DSL nativo, non convertibile
- `->with()` chains — dataset providers Pest, non convertibili
- Entrambi richiedono `phpstan.neon ignoreErrors: [identifier: method.internalClass]`

## Trait errors in test-stub context

Errori come `Method TestStub::foo() return type does not specify generics`:
- Il trait viene analizzato nel contesto dello stub → errori appaiono nel file del trait
- Fix: inline `// @phpstan-ignore missingType.generics` sulla firma del metodo nel trait

## Risultato Jun 2026
- Da 24,494 a **0 pure production errors**
- 503 file convertiti su 10 moduli
- 19 test-stub context errors residui (accettabili)
