---
title: "Documentazione: Policy Posizione Docs (Modulo User)"
type: concept
tags: [docs, location, policy]
created: 2026-07-14
updated: 2026-07-14
qmd: "docs-location-policy documentazione: policy posizione docs (modulo user)"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
status: draft
---

# Documentazione: Policy Posizione Docs (Modulo User)

## Regola
- Vietato usare `/docs` in root del repository.
- Usare esclusivamente `laravel/Modules/<ModuleName>/docs/` per la documentazione.

## Motivazioni
- Evita duplicazioni e inconsistenze.
- Facilita responsabilità e reperibilità per modulo.

## Azioni Esecutive
- Aggiunta regola in `.cursor/rules/docs-location-policy.mdc` che blocca la root `docs`.
- Verificare PR che includano solo file in `Modules/*/docs`.

## Come Migrare
1. Identifica file sotto `/docs` root.
2. Spostali nel modulo pertinente in `laravel/Modules/<Module>/docs/`.
3. Aggiorna backlink tra moduli se necessario.

## Checklist
- [ ] Nessun nuovo file in `/docs` root
- [ ] Nuovi documenti solo in `Modules/*/docs`
- [ ] Backlink corretti tra documentazioni
