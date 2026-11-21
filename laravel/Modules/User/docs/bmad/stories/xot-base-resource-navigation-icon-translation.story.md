---
title: "Resource User con navigazione tradotta"
status: ready-for-dev
epic: code-quality
related:
  - ../../../../Xot/docs/bmad/stories/xot-base-resource-navigation-icon-translation.story.md
  - ../../../../Ptv/docs/bmad/stories/xot-base-resource-navigation-icon-translation.story.md
  - ../../../../IndennitaResponsabilita/docs/bmad/stories/xot-base-resource-navigation-icon-translation.story.md
---

# Story

Come utente del modulo User, voglio che le Resource basate su `XotBaseResource` usino la navigazione centralizzata e tradotta, senza dichiarazioni statiche `navigationIcon` ridondanti.

## Acceptance criteria

- [ ] Censire le Resource del modulo che estendono direttamente o indirettamente `XotBaseResource` e verificare ogni `navigationIcon` rispetto alla configurazione tradotta.
- [ ] Rimuovere solo le dichiarazioni ridondanti, preservando le voci e il comportamento della navigazione.
- [ ] Validare il modulo con PHPStan e test mirati; aggiornare la documentazione tematica con l’esito.

## Dipendenza

La regola comune e il censimento fleet sono definiti in `laravel/Modules/Xot/docs/bmad/stories/xot-base-resource-navigation-icon-translation.story.md`.
