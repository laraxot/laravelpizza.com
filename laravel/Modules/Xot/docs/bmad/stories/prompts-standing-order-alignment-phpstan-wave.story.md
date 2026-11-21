---
title: "Prompt bashscripts — allineamento standing order (wave PHPStan)"
type: story
module: Xot
status: review
created: 2026-11-16
updated: 2026-11-16
tags: [bmad, prompts, standing-order, phpstan, pest, public_html, second-brain]
qmd: "prompts standing order alignment phpstan wave BMAD second brain swarm pest public_html mixed"
related:
  - ./operational-prompts-standing-order-alignment.story.md
  - ./docs-prompts-reorganization.story.md
---

# prompts-standing-order-alignment-phpstan-wave

## Scopo

Rimuovere residui di merge nei prompt e allinearli allo standing order (BMAD, second brain, swarm random, Pest gate, mixed ultima spiaggia, docs kebab senza date, public_html, dati sacri) senza ridondanza.

## Fase

`review`

## Lock

`prompts-standing`

## File toccati

| File | Azione |
|---|---|
| `00-master-prompt.md` | Pest gate + public_html + host prod nei vincoli |
| `00-start.md` | router snello, punta al master |
| `11-phpstan.md` | junk merge rimosso |
| `15-bmad.md` | canonico unico |
| `17-ponytail.md` / `19-docs-second-brain.md` | alias puliti |
| `10-ponytail-audit.md` | corpo canonico senza junk |

## Criteri

- [x] Un corpo per i prompt prioritari
- [x] Master espone Pest / public_html / mixed / dati sacri / swarm
- [ ] Pest: skip — solo markdown prompts
- [ ] `qmd update`: coordinatore a wave ferma

## Lane C

`Themes/Zero/.../f1-world-champion-2026-theme-analysis.md` → alias verso nome senza data.

## Coordinamento

| Quando | Agente | Scope | Nota |
|---|---|---|---|
| 2026-11-16 | fila5-lane-B | prompts 00/11/15/17/19 | lock `prompts-standing` |
---
