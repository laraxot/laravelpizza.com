---
id: IM-NOTIFY-001
title: "Nurture editoriale post-evento (deferred)"
type: story
module: Notify
epic: "IV Nurture"
status: deferred
priority: P2
owner: module:Notify
scope: "laravel/Modules/Notify/docs/"
created: 2026-10-15
updated: 2026-10-15
tags: [bmad, notify, nurture, deferred]
qmd: "email briefing follow-up evento consenso unsubscribe"
related: [IM-GDPR-001, IM-BLOG-004]
issues: []
discussions: []
---
# Nurture editoriale post-evento (deferred)

## Richiesta / scopo
Come partecipante consenziente potrei ricevere un follow-up utile dopo un evento, senza spam né profilazione sproporzionata.

## Perché è deferred
Il valore del briefing AFC non giustifica ancora una nuova automazione: prima servono consenso, owner, contenuti e prova di utilità.

## Acceptance Criteria
- [ ] Nessun invio viene sviluppato finché IM-GDPR-001 non è done.
- [ ] Ogni messaggio ha finalità, frequenza, unsubscribe e contenuto utile.
- [ ] Retry, bounce, audit e tenant isolation riusano Notify esistente.

## Tasks / Subtasks
- [ ] Redigere solo contratto e decisione go/no-go.
- [ ] Verificare canali e template già presenti.

## Testing / Verifica
Solo review documentale in questa fase; test runtime alla riapertura.

## Dipendenze
IM-GDPR-001, IM-BLOG-004, owner editoriale.

## Go/no-go (documentale)

Riaprire solo se: (1) IM-GDPR-001 done, (2) owner editoriale nominato,
(3) almeno un evergreen + evento pilota pubblicati, (4) prova che il follow-up
riduce no-show o aumenta partecipazione: non vanity open-rate.
