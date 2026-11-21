---
type: note
tags: [documentation]
updated: 2026-09-26
qmd: "docs frontmatter batch enrichment.story"
issues: []
discussions: []
title: "Notify docs/ frontmatter batch enrichment (pattern riusato da Xot)"
status: backlog
module: Notify
created: 2026-09-16
related: []
---

## Contesto

Ricognizione di sessione (2026-09-15): modulo Notify ha 4692 file `.md` in `docs/`, di cui
solo il 50.3% (2362/4692) con frontmatter YAML. Stesso pattern di degrado trovato in Xot
(7207 file, 34.5% frontmatter), già affrontato con un batch enrichment parziale (1785/2877
file committati, vedi `docs-frontmatter-batch-enrichment-pattern.story.md` in Xot).

## Non ancora iniziato

Nessun lavoro eseguito su Notify in questa sessione — solo la ricognizione. Il pattern/script
usato per Xot è documentato e riutilizzabile:
`Modules/Xot/docs/stories/docs-frontmatter-batch-enrichment-pattern.story.md`

## Note dal batch Xot (da tenere presente)

- Escludere cartelle archivio (`_archive/`, `legacy/`, `historical/`, `wiki-archive/`,
  `old_tasks/`) — non curare quei file
- Se ci sono altre fork concorrenti attive sullo stesso repo, isolare i commit per hunk
  singolo/firma esatta — NON usare `git diff` grezzo che mescolerebbe commit altrui
- Evitare `git reset` durante l'investigazione — può fare unstage di file che altre fork
  hanno in index (incidente documentato nel batch Xot)
- Verificare Notify per lo stesso pattern anti-pattern di scaffold vuoti trovato in Xot
  (regola `docs/no-ai-tool-scaffold-dirs.md`) prima di aggiungere frontmatter a file che
  andrebbero invece eliminati

## Criteri di accettazione

- [ ] Audit preciso: quanti file candidati reali (esclusi archivio)
- [ ] Script/pattern riusato da Xot applicato
- [ ] Commit incrementali (batch da ~450 file, come Xot)
- [ ] GitHub issue nella repo Notify (`cd Modules/Notify && git remote -v`)
- [ ] Story aggiornata con esito reale
