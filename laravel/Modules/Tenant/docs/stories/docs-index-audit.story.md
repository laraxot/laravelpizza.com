---
tags: [documentation]
qmd: "docs index audit.story"
issues: []
discussions: []
title: "Tenant: audit e riorganizzazione indice docs/"
type: story
module: Tenant
slug: docs-index-audit
status: done
created: 2026-09-03
updated: 2026-09-03
owned_scope:
  - "laravel/Modules/Tenant/docs/index.md"
---

# Tenant: audit e riorganizzazione indice docs/

Audit di tutti i 426 file `.md` sotto `Modules/Tenant/docs/` e riscrittura di `index.md` come
indice organizzato per argomento (panoramica, architettura, config, filament, api, testing,
phpstan, conflitti/git, regole, roadmap, tasks, stories, wiki, llm-wiki, html2pdf, staging).

Nessun file esistente e' stato rinominato o cancellato. 115 doppioni/varianti case-sensitive,
typo o file superati (es. `API.md` vs `api.md`, `roadmap/` sequenza numerata vs nomi piatti,
`root-md-files/`/`root-txt-files/`/`raw/root-import/` come mirror ridondanti tra loro) sono
raggruppati nella sezione "Storico / da consolidare" di `index.md` con nota sul file canonico,
senza azione distruttiva in questo task.
