---
title: "Commit & push dopo modifiche al modulo"
type: rule
tags: [git, workflow, media]
created: 2026-07-08
updated: 2026-07-08
qmd: "Media git commit push dopo modifiche regola"
related:
  - index.md
---

# Commit & push dopo modifiche al modulo

## Regola

Quando modifichi file dentro `laravel/Modules/Media/` devi:

1. Entrare nella cartella del modulo
2. Fare `git commit`
3. Fare `git push` sul remote del modulo

## Perché

`Modules/Media` è un repo separato: lasciare modifiche non committate rompe tracciabilità e sincronizzazione con gli altri ambienti.

