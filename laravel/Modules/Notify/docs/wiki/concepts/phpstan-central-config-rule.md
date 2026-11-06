---
qmd: "phpstan central config rule single neon immutabile legacy neon dist"
issues: []
discussions: []
title: PHPStan Central Config Rule
type: concept
tags: [phpstan, quality, workflow, governance]
sources: [AGENTS.md]
created: 2026-04-16
updated: 2026-10-20
related:
  - llm-wiki-governance.md
  - ../../project/qmd-local-docs-search.md
  - ../../../../Xot/docs/wiki/memories/phpstan-single-neon-config.md
  - ../../00-index.md
status: active
---

<!--
GateGuard facts:
1. Supersedes soft "neon.dist not default" wording in this same concept page; aligns to Xot single-neon memory.
2. Linked from Notify 00-INDEX gate line and wiki concepts.
3. Edit existing concept: same topic, no new story/file.
4. User: "devi utilizzare laravel/phpstan.neon e solo io posso modificarlo, non puoi creare altri .neon"
-->

# PHPStan Central Config Rule

## Rule

Gate unico: **solo** `laravel/phpstan.neon`. Solo l'umano lo modifica. Agenti: mai edit/creazione/restore di `.neon`, mai `-c` / `--configuration` / `--level`. Canon: [phpstan-single-neon-config](../../../../Xot/docs/wiki/memories/phpstan-single-neon-config.md).

```bash
cd laravel
./vendor/bin/phpstan analyse Modules
# oppure, per ridurre rumore dopo il run completo:
./vendor/bin/phpstan analyse Modules/<ModuleName>
```

`Modules/*/phpstan.neon.dist` (e ogni altro neon sotto moduli/docs/tmp) = **legacy/archivio**, non gate: non usarli, non moltiplicarli.

## Reason

- Un solo misuratore: verde locale = verde CI/swarm/umano.
- Il codice si adatta al gate; il gate non si spezza per il codice.
- Richiesta utente: usare `laravel/phpstan.neon` e non creare altri `.neon`.

## Operational Notes

- Se PHPStan fallisce su un modulo: correggi codice/test sotto il neon root, non cambiare config.
- Eccezioni di config: solo l'umano le decide nel neon root; gli agenti segnalano.
