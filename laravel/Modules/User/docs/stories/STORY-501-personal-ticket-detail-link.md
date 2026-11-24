---
qmd: "STORY 501 personal ticket detail link"
title: "STORY-501 — Aprire il dettaglio delle proprie segnalazioni"
type: story
status: in_progress
tags: [user, area-personale, fixcity, ticket, folio, bmad]
created: 2026-09-26
updated: 2026-09-26
issues:
  - "https://github.com/laraxot/module_user_fila5/issues/38"
discussions:
  - "https://github.com/laraxot/module_user_fila5/discussions/37"
related:
  - ../wiki/concepts/folio-app-pages-owner.md
  - ../../Fixcity/docs/stories/STORY-500-ticket-status-audit-timeline.md
---

# STORY-501 — Dettaglio dalla lista “Le mie pratiche”

## User story

Come cittadino autenticato voglio aprire il dettaglio di una mia segnalazione dall'area
personale, anche se lo stato non è ancora pubblico, così posso consultare i dati e seguire gli
aggiornamenti senza cercare un link esterno.

## Stato verificato

La pagina `area-personale/pratiche.blade.php` già interroga
`BuildAuthenticatedUserTicketsQueryAction` e mostra titolo, data e stato. Il titolo non è un
link e non c'è un'azione esplicita per aprire `/tickets/{id}`. Il dettaglio Fixcity già consente
la visibilità al proprietario autenticato tramite `isVisibleOnPublicFrontoffice()`.

## Acceptance criteria

- [ ] Ogni pratica ha un link localizzato al dettaglio della stessa pratica.
- [ ] Il proprietario può aprire il proprio ticket anche con stato non pubblico.
- [ ] Un altro utente non ottiene i dati di un ticket non pubblico cambiando l'ID URL.
- [ ] Stato e contenuto del link sono accessibili da tastiera e hanno testo/label comprensibili.
- [ ] Il percorso mantiene la struttura Folio/CMS del progetto e non introduce Controller.

## Piano tecnico

Modificare solo la pagina owner User e usare URL localizzato `/tickets/{id}`. Il controllo di
ownership resta nel modulo Fixcity; non duplicarlo nella view User.
