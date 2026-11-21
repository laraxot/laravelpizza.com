---
title: "Installazione setup automazioni per Codex"
type: story
module: Xot
epic: quality
status: in-progress
created: 2026-10-05
updated: 2026-10-05
tags: [codex, skills, automation, second-brain]
related:
  - ./project-quality-audit.story.md
---

# Installazione setup automazioni per Codex

## Richiesta

Studiare e installare `anthropics/claude-plugins-official/plugins/claude-code-setup`
oppure la versione più adatta a Codex. Il lavoro prosegue insieme agli interventi
qualità e UX già autorizzati.

## Acceptance criteria e task

- [ ] Leggere sorgente, licenza e documentazione ufficiale Codex.
- [ ] Installare una skill locale adatta al runtime Codex, senza comandi Claude ineseguibili.
- [ ] Conservare provenienza e licenza; validare struttura e riferimenti.
- [ ] Verificare il comportamento su PTVX e registrare limiti e risultati.

## Coordinamento e decisione

Owner: Codex coordinatore; agenti esistenti continuano su password Xot e login User.
Originale Anthropic v1.0.0: singola skill di raccomandazioni in sola lettura, senza MCP
o hook propri. I comandi e i percorsi Claude richiedono adattamento al runtime Codex.
Applicare Ponytail: riusare BMAD, QMD, lock e gate già presenti; nessuna nuova
dipendenza applicativa o autorizzazione globale.

## Riferimenti

- https://github.com/anthropics/claude-plugins-official/tree/main/plugins/claude-code-setup
- https://learn.chatgpt.com/docs/build-skills
- https://developers.openai.com/plugins/guides/submit-claude-plugin
