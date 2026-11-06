---
title: "Struttura dei metodi del modello Post"
type: architecture
module: Lang
status: active
created: 2026-11-05
updated: 2026-11-05
tags: [lang, eloquent, model, traits, architecture]
qmd: "Lang Post model mutators accessor gemelli relation trait PostMutators PostRelations"
related:
  - ../index.md
---

# Struttura dei metodi del modello Post

`Post` compone i metodi Eloquent locali tramite trait dedicati in
`app/Models/Traits/`. La classe mantiene nome, firma e comportamento dei metodi
pubblici; i chiamanti e l'accessor Eloquent continuano a usare gli stessi nomi.

| Trait | Metodi spostati |
|---|---|
| [PostMutators](../../../app/Models/Traits/PostMutators.php) | `setTitleAttribute`, `getTitleAttribute`/`getTitle`, `getGuidAttribute`/`getGuid`, `getTxtAttribute`/`getTxt` |
| [PostRelations](../../../app/Models/Traits/PostRelations.php) | `linkable` |

La coppia accessor/helper resta nello stesso file del trait, compresi il calcolo
del titolo e lo slug del guid. La persistenza lazy di titolo e guid rimane
nell'accessor.
