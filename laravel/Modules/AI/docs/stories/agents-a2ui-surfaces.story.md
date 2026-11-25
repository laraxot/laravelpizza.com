---
title: Interfacce generate A2UI per gli agenti
status: done
date: 2026-11-19
epic: integrazione laravelday-2026 (Passaparola epic 2)
---

# Story: interfacce generate A2UI per gli agenti

## Contesto

Fase C dell'integrazione di datomatic/laravelday-2026 (issue #11 di base_passaparola_fila5): l'agente
mostra KPI, grafici e tabelle invece di elenchi di numeri. Parte agnostica nel modulo AI, usata
dall'assistente operatore di Passaparola (story 2.4).

## Criteri di accettazione

- [x] `ValidateA2uiComponentsAction`: componenti ammessi, proprietà dei componenti del pannello, un valore per etichetta, una cella per colonna, figli esistenti, un solo genitore, niente cicli sulla radice.
- [x] `BuildA2uiSurfaceAction`: `createSurface` A2UI 1.0 sul catalogo `urn:laraxot:a2ui:panel`.
- [x] `RenderSurfaceTool` con `GUIDE` per le istruzioni; JSON non valido ed errori restituiti al modello.
- [x] Catalogo JS (Stat, Chart, DataTable, `weight` applicato) e renderer caricabile a richiesta.
- [x] Test Pest in `tests/Unit/A2ui`.
- [x] Verificato fuori da Pest: validatore e tool eseguiti col sorgente di laravel/framework 13.x e neuron-ai (13 controlli superati); rendering verificato in Chrome (KPI, grafico, tabella).
