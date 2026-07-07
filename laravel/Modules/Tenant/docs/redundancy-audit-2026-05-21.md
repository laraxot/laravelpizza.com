---
title: "Tenant redundancy audit 2026-05-21"
type: audit
module: Tenant
tags: [redundancy, factories, seeders, casing]
created: 2026-05-21
related:
  - https://github.com/laraxot/base_fixcity_fila5/issues/89
---

# Tenant redundancy audit 2026-05-21

High-risk findings:
- Duplicate FQCNs caused by case-only directories:
  - `database/Factories/TenantFactory.php` vs `database/factories/TenantFactory.php`
  - `database/Factories/DomainFactory.php` vs `database/factories/DomainFactory.php`
  - `database/Factories/TestSushiModelFactory.php` vs `database/factories/TestSushiModelFactory.php`
  - `database/Seeders/DomainsSeeder.php` vs `database/seeders/DomainsSeeder.php`
  - `database/Seeders/TestSushiSeeder.php` vs `database/seeders/TestSushiSeeder.php`
- Docs contain case-only duplicates and `docs/archive` variants.

Risk:
- Linux may load one path while WSL/Windows package sync sees another.
- Composer classmap and IDE indexes can disagree on the same class.

Suggested cleanup order:
1. Keep Laravel-standard lowercase `database/factories` and `database/seeders`.
2. Remove uppercase mirrors only in a dedicated code cleanup task with Composer dump-autoload and tests.
3. Normalize docs archive/case variants after code casing is stable.
