---
title: Docs spine wave2: Activity UPPERCASE e date nei nomi
type: story
module: Activity
status: ready-for-dev
priority: P2
created: 2026-10-20
updated: 2026-10-20
tags: [bmad, docs, activity, naming, spine]
qmd: "docs spine wave2 activity uppercase kebab no dates readme organization"
related:
  - ./tomorrow-handoff.story.md
  - ./docs-organization-xot.story.md
  - ../conventions/docs-organization.md
---

<!--
GateGuard facts:
1. Supersedes docs wave1 "no mass rename" deferral with a scoped Activity lot + link map.
2. Linked from tomorrow-handoff.story.md row 3 and docs-organization.md.
3. New story in Xot docs/stories; owns Modules/Activity/docs only.
4. User verbatim: "fa tutte le bmad stories per continuare domani"
-->

# Docs spine wave2: Activity

## Perche'

Wave1 ha chiuso `readme.md` duplex e Geo kebab. Activity ha molti `SCREAMING`
e nomi con date che spezzano retrieval. Serve **mappa link prima di ogni rename**.

## Owned scope

- Solo `Modules/Activity/docs/**/*.md`
- Convenzione: [docs-organization](../conventions/docs-organization.md)

**Non toccare:** PHP, altri moduli docs, Theme Zero (lotto successivo).

## Tasks

1. Inventario: `find Modules/Activity/docs -name '*[A-Z]*' ! -name 'README.md' ! -name 'CHANGELOG.md'` + nomi `*202*`.
2. Per ogni candidato: stub alias kebab → canon **oppure** `git mv` solo se link map aggiornata e conteggio link rotti non aumenta (script come docs-organization-xot).
3. Aggiornare `Modules/Activity/docs/INDEX.md` / `README.md` spine.
4. Nessuna cancellazione di storia senza stub.

## Acceptance

- [ ] Mappa before/after (conteggio UPPERCASE e dated)
- [ ] Link rotti non aumentati
- [ ] README ingresso; INDEX aggiornato
- [ ] Handoff segnato

## Testing strategy

Script link-check read-only (stesso approccio story docs-organization-xot).
