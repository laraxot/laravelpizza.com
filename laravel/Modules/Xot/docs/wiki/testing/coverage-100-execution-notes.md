---
title: "coverage 100 execution notes"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "coverage 100 execution notes"
issues: []
discussions: []
---

# Coverage 100 - Execution Notes

Updated: 2026-03-04

## Scope

Questo documento traccia le decisioni operative per convergere al 100% Pest coverage nel monolite.

## Decisioni attive

1. Test con skip legacy non recuperabili nel ciclo corrente sono rinominati in `.old`.
2. I warning sono trattati come blocker (uso di `--stop-on-warning`).
3. Le assertion fragili basate su conteggi globali vengono riscritte su invarianti funzionali.

## Riferimenti

- https://pestphp.com/docs/test-coverage
- https://pestphp.com/docs/type-coverage
- https://laravelmodules.com/docs/12/advanced/tests
