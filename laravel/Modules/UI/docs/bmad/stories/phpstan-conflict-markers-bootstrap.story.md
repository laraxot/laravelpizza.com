---
title: "UI — conflict markers bootstrap e gate PHPStan"
type: story
module: UI
status: review
created: 2026-11-16
updated: 2026-11-16
tags: [bmad, ui, merge-markers, phpstan, bootstrap, public_html]
qmd: "ui conflict markers bootstrap phpstan php -l gitattributes theme-build public_html"
related:
  - ./git-status-fleet-merge-markers-ui.story.md
  - ../../../../Media/docs/bmad/stories/phpstan-conflict-markers-bootstrap.story.md
---

# phpstan-conflict-markers-bootstrap (UI)

## Scopo

Pulire marker di merge in config/docs UI e verificare sintassi PHP + misura PHPStan.

## Fase

`review`

## Lock

`ui-conflict`

## Criteri di accettazione

- [x] Zero marker nei `.php`
- [x] `.gitattributes` da prototipo no-LFS
- [x] `docs/theme-build.md` / `docs/graphify/README.md` senza marker; theme-build → symlink `public_html`
- [x] `php -l` verde
- [x] PHPStan `Modules/UI`: **111 file_errors** (famiglia dominante `staticMethod.notFound` 74) — debito preesistente, fuori scope marker
- [ ] Pest: skip — nessun comportamento PHP modificato

## Coordinamento

| Quando | Agente | Scope | Nota |
|---|---|---|---|
| 2026-11-16 | fila5-lane-A | UI markers + phpstan | lock `ui-conflict` |
---
