---
title: "deferred operator assistant agent"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "deferred operator assistant agent"
issues: []
discussions: []
status: draft
---

# Deferred: OperatorAssistantAgent domain tool-calling

Il modulo `AiAssistant` di `gestionale_commesse` include `Application/Neuron/OperatorAssistantAgent.php`
(~1575 righe), un agente `NeuronAI\Agent\Agent` con tool-calling hardcoded verso i moduli di dominio
`Bom`, `Product`, `Customer`, `CustomerSite`, `EnergyBrokerDocument`, `Intervention`,
`Warehouse`/stock, `ProductionPhase`, `WorkOrder`.

Questo componente **non è stato portato** in questa sessione, per scelta esplicita: i moduli di
dominio omologhi (`WorkOrder`, `Inventory`, `Bom`, `Production`) in questo repository non hanno
ancora la stessa maturità/interfaccia di quelli di `gestionale_commesse` (vedi
`docs/gestionale-commesse-comparison/module-mapping.md`), quindi portare l'agente 1:1 avrebbe
significato reimplementare tool-calling contro modelli che potrebbero non esistere o avere schema
diverso.

Quello che è stato portato in questa sessione è solo l'infrastruttura di persistenza e il pattern
"AI propone, umano conferma, sistema esegue":

- Modelli `AiThread`, `AiMessage`, `AiActionProposal`, `AiToolLog`
- `Contracts\AiActionHandlerContract` + `Support\AiActionHandlerRegistry` (singleton)
- Actions `CreateAiActionProposalAction`, `ConfirmAiActionProposalAction`, `CancelAiActionProposalAction`
- Filament `AiActionProposalResource` con azioni Confirm/Cancel

Quando i moduli di dominio saranno pronti, l'integrazione andrà fatta registrando handler
`AiActionHandlerContract` specifici per tipo di proposta (es. `start_time_punch`,
`change_work_order_status`) nella `AiActionHandlerRegistry`, senza che il modulo AI debba conoscere
direttamente i moduli di dominio — è il registry a fare da punto di disaccoppiamento.

Non riprodurre `OperatorAssistantAgent` finché questo lavoro propedeutico non è pianificato in una
issue/story dedicata.
