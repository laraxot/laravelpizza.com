---
title: "Assistente clienti agnostico: base di conoscenza, passaggio a una persona, report"
type: story
module: AI
slug: assistant-knowledge-base
status: review
phase: DEVELOPMENT
owner: AI
created: 2026-11-16
updated: 2026-11-16
depends_on: []
qmd: "assistant knowledge base story"
issues: [25, 26]
discussions: []
related:
  - ../assistant.md
---

# Story: assistente clienti agnostico nel modulo AI

## Contesto

Molti progetti (portali PA, gestionali, e-commerce) ricevono sempre le stesse domande.
Serve un assistente che risponda con le risposte ufficiali e passi a una persona il resto.
Il modulo AI è condiviso da tutti i progetti: deve offrire solo mattoni **agnostici**;
il modulo principale di ogni progetto li chiama.

## Criteri di accettazione

- [x] Base di conoscenza separata per `collection`, gestibile da Filament
- [x] L'assistente risponde solo con le voci trovate; senza voci → passaggio a una persona
- [x] Parole sensibili configurabili dal progetto (default vuoto) → passaggio immediato
- [x] Modello non raggiungibile o risposta non valida → passaggio, mai errore al cliente
- [x] Il passaggio crea una `AiActionProposal` `assistant_handoff`, confermabile dalla coda esistente
- [x] Domande e risposte salvate in `AiThread`/`AiMessage`
- [x] Report per periodo: domande, risolte, passaggi per motivo, voci più usate, domande senza risposta
- [x] Nessuna firma pubblica esistente rotta (`MakeAIRequestAction` ha solo un parametro opzionale in più)
- [x] Test Pest per tokenizzazione, ranking, guardrail, prompt, decodifica, report, wiring
- [ ] Test eseguiti nell'app host (non possibile nell'ambiente di sviluppo di questa story)
- [ ] Primo progetto che lo adotta (proposta: Fixcity)

## Note tecniche

- Migrazione additiva `ai_knowledge_entries`; nessuna modifica alle tabelle esistenti.
- `AiJsonResponseDecoderAction::decodeObject` ora accetta JSON racchiuso in blocchi markdown
  (prima restituiva `[]`): miglioramento retrocompatibile per tutti i chiamanti.
- Documentazione: [assistant.md](../assistant.md).
