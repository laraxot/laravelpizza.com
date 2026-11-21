---
issues: []
discussions: []
title: "Model/Factory/Seeder Audit"
module: "Media"
type: concept
tags: [model, factory, seeder, audit]
created: 2026-07-14
updated: 2026-07-14
qmd: "model factory seeder audit"
related:
  - "./webm.md"
---
# Model/Factory/Seeder Audit

Generated: [DATE] 16:29

## Coverage
| Model | Factory | Seeded |
|---|---|---|
| Media | yes | no |
| MediaConvert | yes | no |
| TemporaryUpload | yes | no |

Seeder: `database/seeders/MediaDatabaseSeeder.php`

## Missing / Actions
- Add exemplar seeding for Media, TemporaryUpload (small count) in `MediaDatabaseSeeder` or dedicated seeders.

## Likely non-business-critical
- None; all three are concrete but can be optionally seeded for demos/tests.