---
id: IM-MEETUP-001
title: "Presentazione evento nel tema Meetup"
type: story
theme: Meetup
epic: "II Contenuti pilota"
status: backlog
priority: P2
owner: theme:Meetup
scope: "laravel/Themes/Meetup/resources/views/, laravel/Themes/Meetup/docs/"
created: 2026-10-15
updated: 2026-10-15
tags: [bmad, meetup, event, wcag]
qmd: "Meetup tema presentazione evento programma iscrizione follow-up"
related: [IM-BLOG-003, IM-GDPR-001]
issues: []
discussions: []
---
# Presentazione evento nel tema Meetup

## Richiesta / scopo
Come partecipante voglio leggere programma, data, luogo/online, accessibilità e azione di iscrizione senza ambiguità.

## Acceptance Criteria
- [ ] Meetup riceve dati dall'`Article` event e non possiede persistenza propria.
- [ ] L'iscrizione collega il contratto Gdpr e mostra stato/errore comprensibile.
- [ ] La presentazione è usabile da tastiera, mobile e screen reader.
- [ ] È documentato se il tema è produzione, demo o archivio prima del go-live.

## Tasks / Subtasks
- [ ] Definire support matrix rispetto a Sixteen.
- [ ] Riutilizzare componenti e route canoniche.
- [ ] Validare programma e CTA con un evento pilota.

## Owned File / Module Scope
Solo tema Meetup e docs.

## Testing / Verifica
Browser smoke, WCAG, `view:cache`; nessuna modifica a Blog/Gdpr.

## Dipendenze
IM-BLOG-003, IM-GDPR-001.
