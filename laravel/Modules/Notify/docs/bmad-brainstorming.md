---
title: "BMAD Brainstorming: Notify"
type: bmad-brainstorming
status: synthesized
module: Notify
track: bmad-method
created: 2026-10-16
updated: 2026-10-16
tags: [bmad, brainstorming, scamper, starbursting, second-brain, notify]
qmd: "bmad brainstorming notify perche insight rischi"
related:
  - ./bmad/bmad-dossier.md
  - ./bmad/brainstorming.md
  - ../../Fixcity/docs/bmad/ticket-lifecycle-planning.md
  - ./bmad-planning.md
  - ./bmad/filament-blueprint.md
---

# Domanda guida

Come tracciare invio/retry/sollecito come eventi Fixcity senza far conoscere a Notify il dominio Ticket?

## 5 Whys (sintesi)

1. L'utente sente frizione o opacita sul valore di **Notify**.
2. La frizione nasce da confini poco chiari tra owner e consumer.
3. I confini si offuscano quando UI, persistenza e policy vivono nello stesso file "comodo".
4. Senza contratto, ogni fix locale crea una seconda verita.
5. Serve planning BMAD + blueprint Filament + docs owner come unica memoria operativa.

## Starbursting

- **Chi:** cittadino destinatario, operatore mittente, supervisor delivery
- **Cosa:** Consegnare messaggi multi-canale preference-aware con esiti osservabili.
- **Quando:** a ogni incremento che tocca questo owner; decisioni in decision-log.
- **Dove:** `laravel/Modules/Notify/docs/` (+ `docs/bmad/`).
- **Perché:** parallelismo sicuro, DRY, auditabilita, nessun `bmad-output/`.
- **Come:** track `bmad-method` -> planning -> (architecture/UX se serve) -> stories ready-for-dev.

## SCAMPER

| Leva | Idea | Impatto | Fattibilita |
|---|---|---:|---:|
| Substitute | Servizi ad-hoc -> Actions + XotBase Filament in Notify | H | H |
| Combine | Planning BMAD + second brain docs owner + blueprint Filament | H | H |
| Adapt | Pattern Fixcity (policy, ledger, tenant) dove il modulo tocca dati civici | H | M |
| Modify | Ridurre superficie API pubblica ai contratti consumer | H | M |
| Eliminate | Duplicazioni di verita (second store, Livewire legacy, Controllers) | H | H |
| Reverse | Progettare dai failure mode privacy/authz prima delle feature | H | H |

## Reverse brainstorming: come romperlo

- Copiare planning Ticket in questo owner (gia successo: stub da correggere).
- Mettere business rules nel tema o Controllers.
- Inventare store paralleli (es. timeline duplicata).
- Estendere Filament core invece di `XotBase*`.
- Scrivere docs in `bmad-output/`.

## Insight selezionati

1. Lo scopo di **Notify** e: Consegnare messaggi multi-canale preference-aware con esiti osservabili.
2. Tutto cio che e in **Out** va linkato all'owner vero, non reimplementato.
3. Filament e chrome/admin o widget FO montato: non e il dominio.
4. Il second brain vive accanto al codice owner; QMD trova, non possiede.

## Prossimo step BMAD

Vedi [bmad-planning.md](./bmad-planning.md): eseguire la Wave 1 e aggiornare il decision-log owner.
