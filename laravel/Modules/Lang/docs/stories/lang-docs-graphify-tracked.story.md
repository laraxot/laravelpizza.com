---
id: lang-docs-graphify-tracked
title: "Decidere il destino di docs/graphify e resources/lang tracciati in Lang"
type: story
status: open
priority: P2
owner: module:Lang
module: Lang
tags: [git, igiene, graphify, lang]
related: [notify-tracked-github-skills-hygiene, rating-docs-graphify-tracked]
---

# Decidere il destino di docs/graphify e resources/lang in Lang

Fase BMAD: Planning (decisione, serve conferma).

## Stato misurato
- `docs/graphify` è tracciato in Lang, Notify e Rating: output generato di un tool, non documentazione.
- `resources/lang` è tracciato in Lang e Notify, ma le traduzioni del modulo stanno in `Modules/<Mod>/lang`.

## Decisione da prendere
Per `docs/graphify`: rimuovere dal tracciamento e aggiungere a `.gitignore`. Per `resources/lang`: confermare che sia obsoleto, poi rimuovere.

## Azioni
1. Verificare che nessun codice carichi `resources/lang` del modulo.
2. Commit separato per ogni rimozione dal tracciamento.

## Verifica
- `ModuleRootHygieneTest` verde per Lang.
