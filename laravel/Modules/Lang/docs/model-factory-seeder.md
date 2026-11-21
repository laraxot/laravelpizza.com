---
issues: []
discussions: []
title: "Model/Factory/Seeder Audit"
module: "Lang"
type: concept
tags: [REDUNDANCY, ANALYSIS]
created: 2026-07-14
updated: 2026-07-14
qmd: "redundancy analysis"
related:
  - "./italian-text-refined-audit-report.md"
---
# Model/Factory/Seeder Audit

Generated: [DATE] 16:29

## Coverage
| Model | Factory | Seeded |
|---|---|---|
| Translation | yes | no |
| TranslationFile | yes | no |
| Post | yes | no |
| LinkedTrait | n/a | n/a |
| HasStrictTranslations | n/a | n/a |
| HasTranslationsContract | n/a | n/a |

Seeder: `database/seeders/LangDatabaseSeeder.php`

## Missing / Actions
- Add exemplar seeding for `Translation`/`TranslationFile`/`Post` if needed for demos/tests.
- Traits/contracts are infra; exclude from factories/seeders.

## Likely non-business-critical
- All trait/contract entries (infra-only).
