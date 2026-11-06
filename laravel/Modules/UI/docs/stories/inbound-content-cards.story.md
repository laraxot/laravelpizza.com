---
id: IM-UI-001
title: "Componenti riusabili per card contenuti"
type: story
module: UI
epic: "II Contenuti pilota"
status: backlog
priority: P1
owner: module:UI
scope: "laravel/Modules/UI/docs/"
created: 2026-10-15
updated: 2026-10-15
tags: [bmad, ui, card, wcag]
qmd: "card articolo evento CTA accessibile riuso UI"
related: [IM-BLOG-004, IM-CMS-001, IM-SIXTEEN-001]
issues: []
discussions: []
---
# Componenti riusabili per card contenuti

## Richiesta / scopo
Come lettore voglio distinguere rapidamente articolo, evento, data, stato e azione primaria in una card accessibile.

## Acceptance Criteria
- [ ] La card riusa dati Article e non contiene query o regole dominio.
- [ ] Il link ha nome accessibile, focus visibile e target prevedibile.
- [ ] La resa non dipende da font pesanti, colore solo o animazioni.
- [ ] Il componente funziona nei temi owner senza duplicare markup inutilmente.

## Tasks / Subtasks
- [ ] Verificare componenti UI esistenti prima di aggiungere codice.
- [ ] Documentare contratto dati minimo.
- [ ] Coprire mobile, zoom e prefers-reduced-motion.

## Owned File / Module Scope
UI docs/componenti riusabili; nessun dominio Blog.

## Testing / Verifica
Blade/view cache, audit WCAG manuale e snapshot solo se già convenzionale.

## Dipendenze
IM-BLOG-002.
