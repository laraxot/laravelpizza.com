---
title: Skeleton nwidart modulo
type: concept
module: Xot
tags: [nwidart, skeleton, module, guardrail]
created: 2026-07-01
updated: 2026-07-01
related:
  - ../../../../docs/wiki/concepts/nwidart-module-skeleton-contract.md
  - ./sacred-artifacts-never-delete.md
---

# Skeleton nwidart modulo

Xot è il modulo base Laraxot: la regola skeleton vale per **tutti** i moduli, non solo Xot.

## File non negoziabili

Vedi hub repo: [nwidart-module-skeleton-contract.md](../../../../docs/wiki/concepts/nwidart-module-skeleton-contract.md)

## Ripristino (forward-only)

```bash
bash bashscripts/tools/study-nwidart-missing-files.sh Xot
# git show HEAD:laravel/Modules/Xot/... → riscrivi versione migliorata
bash bashscripts/tools/guard-nwidart-module-skeleton.sh
```

**Vietato:** `git restore`, `git checkout HEAD --`, script `restore-nwidart-deleted-files.sh`.

Incidente 2026-07-01: provider e `.github` eliminati per errore → recuperati studiando storico e riscrivendo, non con restore.

Hub: [git-forward-only-study-old-version.md](../../../../docs/wiki/concepts/git-forward-only-study-old-version.md)
