---
issues: []
discussions: []
title: "Task: Ridurre Suppressioni PHPStan nei Test - Tenant"
module: "Tenant"
type: concept
tags: [task, ridurre, phpstan, test]
created: 2026-07-14
updated: 2026-07-14
qmd: "task ridurre phpstan test"
related:
  - "./phpstan-corrections-january.md"
---
# Task: Ridurre Suppressioni PHPStan nei Test - Tenant

**Modulo**: Tenant
**Priorita'**: Media
**Completamento**: 0%

---

## Descrizione

73 suppressioni in `tests/Unit/SushiToJsonTraitTest.php`. Problemi Pest/PHPStan integration.

## Criteri di Completamento

- [ ] Analizzate tutte le 73 suppressioni
- [ ] Risolte quelle non dovute a limiti Pest
