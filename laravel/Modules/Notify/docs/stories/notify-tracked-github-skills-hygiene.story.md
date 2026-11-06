---
id: notify-tracked-github-skills-hygiene
title: "Decidere il destino di Notify/.github/skills, 1846 file tracciati"
type: story
status: open
priority: P2
owner: module:Notify
module: Notify
tags: [git, igiene, repo-annidato, decisione]
related: [rating-docs-graphify-tracked, lang-docs-graphify-tracked]
---

# Decidere il destino di Notify/.github/skills

Fase BMAD: Planning (decisione distruttiva, serve conferma).

## Stato misurato
- `Notify/.github/skills` contiene 1846 file tracciati nel repo annidato del modulo.
- La hygiene segnala la cartella come fuori posto. Rimuoverla cancella contenuto tracciato.

## Decisione da prendere
(a) Tenere la cartella e documentare la sua origine, (b) spostarla nel repo degli skill condivisi, (c) rimuoverla dopo backup in git.

## Azioni
1. Confermare con il proprietario quale delle tre.
2. Applicare la scelta con un commit separato, senza mescolare altre modifiche.

## Verifica
- Test `ModuleRootHygieneTest` per Notify verde dopo la scelta.
