---
title: "translation file merge function"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "translation file merge function"
issues: []
discussions: []
---

# Translation File Merge Function

## Purpose
The `merge_translation_files` function was intended to combine multiple PHP translation files into a single array for the Lang module's `TranslationFile` model. This is critical for efficient UI rendering of translated content through Filament.

## Root Cause
The function existed only as a PHPStan stub (`merge_translation_files.stub.php`) but was missing from `Helper.php`. The IDE Helper's analysis triggered a fatal error when processing translation files that use this function.

## Solution
1. Implement `merge_translation_files` in `Helper.php`:
```php
function merge_translation_files(string $first, string ...$rest): array {
    $result = (array) require $first;
    foreach ($rest as $file) {
        $result = array_replace_recursive($result, (array) require $file);
    }
    return $result;
}
```
2. Verify correct inclusion order in `TranslatorFile::getRows()`

## Philosophy
This fix aligns with the "ponytail" philosophy of addressing root causes (missing runtime function) rather than symptoms (IDE error). The documentation follows the module's Markdown standard with clear rationale for maintainability.

## Documentation Context
Added to `Modules/Lang/docs` to fulfill user requirement: "documentare tutto dentro le cartelle docs dentro i moduli".