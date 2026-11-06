---
title: "Critical Filament Rule: getInfolistSchema String Keys"
type: rule
tags: [critical, filament, rule, getinfolistschema]
created: 2026-07-14
updated: 2026-07-14
qmd: "critical-filament-rule-getinfolistschema-string-keys critical filament rule: getinfolistschema string keys"
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

# Critical Filament Rule: getInfolistSchema String Keys

## The Rule
The `getInfolistSchema()` method must ALWAYS return an array with string keys. This is a fundamental requirement in the Filament + Laraxot architecture.

## Why This Rule Exists
- Filament's schema processing expects named components with string keys
- Component identification and lifecycle management depend on named keys
- Proper rendering and functionality require string-keyed arrays
- The XotBase architecture enforces this pattern for consistency

## Correct Implementation Pattern
```php
protected function getInfolistSchema(): array
{
    return [
        // String keys for sections
        'section_name' => Section::make('Section Title')
            ->schema([
                // String keys for fields within sections
                'field_name' => TextEntry::make('field')
                    ->copyable(),
            ]),
    ];
}
```

## Incorrect Implementation
```php
protected function getInfolistSchema(): array
{
    return [
        // WRONG: No string keys (numeric indices)
        Section::make('Section Title')  // This will cause issues
            ->schema([
                TextEntry::make('field')  // No named key
            ]),
    ];
}
```

## Architecture Context
This rule applies to all `getInfolistSchema()` implementations throughout the Laraxot architecture, including:
- XotBaseViewRecord implementations
- Resource classes that define infolist schemas
- Any custom infolist schema methods

## Impact
Following this rule ensures:
- Proper component rendering in Filament views
- Correct functionality of infolist features
- Consistency with Laraxot architectural patterns
- Compatibility with future updates
