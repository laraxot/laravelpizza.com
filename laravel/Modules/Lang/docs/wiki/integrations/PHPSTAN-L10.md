---
tags: [documentation]
updated: 2026-09-26
qmd: "PHPSTAN L10"
issues: []
discussions: []
title: PHPStan Level 10 Compliance — Lang Module
module: Lang
type: quality-gate
status: complete
created: 2026-08-02
---

# PHPStan Level 10 Compliance — Lang Module

## Summary

| Aspect | Value |
|--------|-------|
| **PHPStan L10** | ✅ 0 errors |
| **Status** | Complete |
| **Last verified** | 2026-08-02 |

## Patterns Applied

### 1. Language Line Types
```php
/**
 * @return Collection<LanguageLine>
 */
public function getLanguageLines(): Collection { }

/** @return LanguageLine|null */
public function getLine(string $key): ?LanguageLine { }
```

### 2. Translation Arrays
```php
/**
 * @return array<string, string>
 */
public function getTranslations(string $locale): array { }

/**
 * @param array<string, mixed> $data
 * @return void
 */
public function syncTranslations(array $data): void { }
```

### 3. Type Narrowing in i18n
```php
if (!is_string($translation)) {
    throw new InvalidArgumentException('Translation must be string');
}
// PHPStan knows $translation is string here
```

## Verification

```bash
cd laravel/Modules/Lang
phpstan analyse app --level=10
# Expected: 0 errors found
```

## Related Docs

- [`phpstan-l10-compliance.md`](../../../docs/wiki/rules/phpstan-l10-compliance.md)
- [GitHub Repo](https://github.com/laraxot/module_lang_fila5)

**Status:** ✅ Compliant (2026-08-02)
