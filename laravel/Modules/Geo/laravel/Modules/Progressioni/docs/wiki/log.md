---
title: "Activity Log"
module: "Progressioni"
---

# Activity Log — Progressioni

> **Purpose:** Append-only chronological activity record tracking ingests, queries, and lint passes.

## Log Entries

[2026-06-18] [DOC] Trova esclusi UI: stub [trova-esclusi-ui-cascade](./concepts/trova-esclusi-ui-cascade.md) → cascata Ptv/Sigma. Pattern agente root: [bugfix-business-logic-before-type](../../../../../docs/wiki/patterns/bugfix-business-logic-before-type.md).

[2026-06-15] [UPDATE] Allineato [contract-aggregation-pattern](./rules/contract-aggregation-pattern.md): owner Ptv (`SchedaContract`/`BaseScheda`), Progressioni `extends` solo. Rimossi riferimenti obsoleti `Sigma*Fields`.

[2026-06-15] [UPDATE] Gate PHPStan: 34→0 errori; doc [phpstan-progressioni-gate](./concepts/phpstan-progressioni-gate.md); helper `getRouteParameters` in Xot

[2026-06-15] [LINT] `php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules` → OK

### Format

```
[YYYY-MM-DD HH:MM:SS UTC] [OPERATION] Description
```

**Operations:**
- `INGEST` — Added raw document to wiki
- `QUERY` — Answered question from wiki
- `LINT` — Maintained wiki quality
- `UPDATE` — Modified existing wiki page

---

**Last Activity:** 2026-06-15  
**Total Operations:** 2
