---
qmd: "TECH SPEC"
issues: []
discussions: []
title: "Technical Specification - Lang Module"
type: technical_spec
tags: [tech spec, lang, implementation]
created: 2026-08-04
updated: 2026-08-04
---
# Technical Specification - Lang Module

## Overview
Detailed technical implementation for the Lang module, covering models, actions, Filament resources, and integration touchpoints.

## Models

### Core Models
### `BaseModelLang`$
### `LanguageLine`$
### `Translation`$

Each model extends `XotBaseModel` and follows Laraxot conventions:
- UUID primary key
- Timestamps (created_at, updated_at)
- Soft deletes where applicable
- Cast attributes for JSON fields

## Actions

### Core Actions
### `SyncTranslationsAction`$
### `ValidateTranslationsAction`$

Each action follows the Laraxot action pattern:
- Invokable class in `app/Actions/`
- Type-hinted dependencies
- Returns result object or collection
- Uses database transactions for write operations

## Filament Resources

### LangResource
- **Schema**: Form with relevant fields (name, description, status)
- **Table**: Columns for key attributes, filters by status/type
- **Relation Managers**: As needed per module

## API Endpoints
| Method | URI | Description | Auth |
|--------|-----|-------------|------|
| GET | `/api/lang` | List records | Sanctum |
| POST | `/api/lang` | Create record | Sanctum |
| GET | `/api/lang/{id}` | Show record | Sanctum |
| PUT | `/api/lang/{id}` | Update record | Sanctum |
| DELETE | `/api/lang/{id}` | Delete record | Sanctum |

## Testing Strategy (Laraxot Standard)
- **Framework**: Pest PHP v4
- **Isolation**: DatabaseTransactions
- **Database**: MySQL `_test` suffixed
- **Coverage Target**: 90%+
- **Test Files**:
  - `tests/Feature/Http/Controllers/langControllerTest.php`
  - `tests/Unit/Actions/CalculateLangActionTest.php`
  - `tests/Unit/Models/LangModelTest.php`

## Quality Gates
1. PHPStan Level 10: 0 errors
2. Pint: PSR-12 compliant
3. Pest: 90%+ coverage
4. PHPMD: 0 violations
