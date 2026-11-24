---
title: "Xot Memories Index"
type: index
module: Xot
tags: [xot, memories, testcase, phpstan]
created: 2026-05-11
updated: 2026-06-10
qmd: "Xot memories index testcase hierarchy nwidart dev-only"
issues:
  - "https://github.com/laraxot/module_xot_fila5/issues/33"
discussions:
  - "https://github.com/laraxot/module_xot_fila5/discussions/34"
---

# Xot Module - memories Index

## Purpose
Index for Xot module memories.

## On-Demand Loading

```bash
qmd search "Xot memories" --limit 5
```

## Memories

- [testcase-hierarchy-nwidart-dev-only](./testcase-hierarchy-nwidart-dev-only.md) — `Nwidart\Modules\Tests\BaseTestCase` non e' disponibile nel package installato; usare `XotBaseTestCase`.
- [module-app-only-directory-structure](./module-app-only-directory-structure.md) — cartelle root modulo vietate; tutto il PHP sotto `app/`.
- [phpstan-single-neon-config](./phpstan-single-neon-config.md) — solo `laravel/phpstan.neon`, mai altri `.neon`.
- [phpstan-remediation-swarm](./phpstan-remediation-swarm.md) — memoria remediation PHPStan multi-agente.
- [tabella-appartiene-alla-resource-non-alla-pagina](./tabella-appartiene-alla-resource-non-alla-pagina.md) — la tabella la costruisce la Resource; `getTable*` su una List page e' fatal o silenziosamente morto.
- [header-actions-doppi-filament-5](./header-actions-doppi-filament.md) — page header e table header sono due barre distinte: da qui il doppio pulsante "Crea".
- [traduzioni-placeholder-navigation](./traduzioni-placeholder-navigation.md) — i placeholder nascono da `persistGeneratedTransFuncLabel()`, non da una svista: e' un difetto permanente e silenzioso.
- [merge-marker-spazzatura-worktree](./merge-marker-spazzatura-worktree.md) — i marker di merge possono essere spazzatura del worktree, non contenuto di HEAD.
<<<<<<< HEAD
=======
- [phpstan-modules-zero-standing-order](./phpstan-modules-zero-standing-order.md) — ordine permanente: parse→flock→tipi; vittoria = JSON 0 + banner OK + exit 0; dopo lo zero continua boy scout.
>>>>>>> laraxot/dev

## See Also
- [Root Trigger Map](../../../../../../docs/wiki/rules/00-TRIGGER_MAP.md)
- [Root Wiki](../../../docs/wiki/)

---
*Updated: 2026-06-10*
