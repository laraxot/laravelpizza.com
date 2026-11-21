---
title: "ECC — workflow operativo Xot"
type: workflow
status: active
updated: 2026-11-17
module: Xot
qmd: "ECC workflow Xot BMAD lock PHPStan saturazione max 3 Pest docs"
---

# ECC — workflow operativo

1. **BMAD** — story owner in `docs/bmad/` del modulo, claim, lock (`bashscripts/lock/`).
2. **Second brain** — `qmd` / memorie prima del fix; dopo: write-back mirato.
3. **Fix** — causa radice / scopo; niente baseline o ignore cosmetici.
4. **PHPStan** — saturazione HARD: `pgrep`/`free`, max 3 lane, STOP se saturo
   ([11-phpstan](../../../../../bashscripts/docs/prompts/11-phpstan.md),
   [46-swarm](../../../../../bashscripts/docs/prompts/46-multi-agent-module-swarm.md),
   [memoria](../../../../../bashscripts/ai/wiki/memories/phpstan-host-saturation-max-three.md),
   [STOP](../../../../../docs/chat/STOP-phpstan-process-thrashing.md)).
5. **Pest** — gate obbligatorio o skip documentato (host/DB).
6. **Docs** — aggiorna pack modulo; indice: [00-index.md](./00-index.md); esito: [xot-ecc-audit.md](./xot-ecc-audit.md).
