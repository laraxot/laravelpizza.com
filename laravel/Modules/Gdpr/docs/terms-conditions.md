---
title: "Condizioni d'uso"
type: note
tags: [documentation, legal, terms, registration]
created: 2026-09-26
updated: 2026-10-14
qmd: "condizioni d'uso termini e condizioni terms.md terms.index legal-document registrazione gate LEG-04"
issues: []
discussions: []
status: draft
related:
  - ./register-widget.md
  - ./stories/dcp-178-registrazione-e-disiscrizione-a-norma.story.md
---

# Condizioni d'uso

La registrazione fa accettare le condizioni d'uso (`terms_accepted`, trattamento `terms_conditions`) e rimanda a `/{lang}/terms`. Il testo e' dell'ente, non del codice.

## Dove vive il testo
- Tenant: `laravel/config/<tenant>/terms.md` e `lang/<lingua>/terms.md` (per FixCity locale `config/local/fixcity`). Oggi contengono il segnaposto di 88 byte «Edit this file to define the terms of service for your application».
- Pagina: JSON `terms.index.json` con un blocco `legal_document` (`document: terms_disclaimer`, `markdown: terms.md`), reso da `pub_theme::components.blocks.legal-document.design-comuni`.
- Se il testo manca o e' incompleto la pagina mostra l'avviso «Testo non ancora completo» (`data-element="legal-incomplete"`) invece di inventare un contenuto.

## Stato
`/it/terms`, `/en/terms`, `/de/terms`, `/es/terms` rispondono 200 con l'avviso: la registrazione fa accettare un testo che non esiste ancora. Il gate `bashscripts/tools/release/go-live-gate.py` lo segnala con `LEG-04` (bloccante). Non c'e' ancora una guardia Pest come per informativa, accessibilita' e note legali.

## Da fornire dall'ente
Titolare, oggetto del servizio, regole di uso e contenuti inviati (cfr. note legali, DCP-162), limiti di responsabilita', legge applicabile e foro, modifiche, contatti. La formula con cui il cittadino accetta (presa visione dell'informativa piu' accettazione delle condizioni, senza consenso al trattamento come base giuridica) e' una decisione del DPO: vedi la story DCP-178.
