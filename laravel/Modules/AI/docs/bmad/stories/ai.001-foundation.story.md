---
title: "AI — Fondazione BMAD: PRD, architettura e stories"
id: "ai.001-foundation"
module: AI
type: story
status: todo
priority: high
created: 2026-11-04
---

# AI.001 — Fondazione BMAD

## Contesto

Il modulo AI ha test unitari presenti ma zero stories BMAD. Le Actions
(CompletionAction, ContextCompressorAction, GeneratePredictionDraftsAction,
AiActionHandlerRegistry) esistono e passano i test ma non hanno una
documentazione BMAD strutturata né un PRD ufficiale.

## Obiettivo

Creare il set minimo di artefatti BMAD per il modulo AI:
1. PRD ufficiale con requisiti funzionali e non funzionali
2. Architecture document
3. Epics e stories per le funzionalità principali

## Acceptance criteria

- [ ] `docs/bmad/prd.md` creato con requisiti F e NF
- [ ] `docs/bmad/architecture.md` creato con diagramma Actions→OpenAI
- [ ] `docs/bmad/epics.md` creato con almeno 3 epics
- [ ] Almeno 3 stories create in `docs/bmad/stories/`
- [ ] `docs/wiki/index.md` aggiornato con link ai nuovi artefatti

## Note tecniche

- Usare `XotBaseActions` e contratti per OpenAI, mai chiamate dirette al client
- `Http::fake()` obbligatorio in tutti i test che coinvolgono OpenAI
- Non duplicare scope dei moduli Trade/Cms/Seo
