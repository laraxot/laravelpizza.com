---
title: "BMAD Brainstorming — Geo"
type: bmad-brainstorming
status: synthesized
module: Geo
track: quick-flow
created: 2026-10-16
updated: 2026-10-16
tags: [bmad, brainstorming, scamper, starbursting, second-brain, geo]
qmd: "bmad brainstorming geo perche insight rischi"
related:
  - ./bmad/bmad-dossier.md
  - ./bmad-planning.md
  - ./bmad/filament-blueprint.md
---

# Domanda guida

Qual e il minimo contratto Geo che Fixcity/Mobile possono consumare senza conoscere i provider?

## 5 Whys (sintesi)

1. L'utente sente frizione o opacita sul valore di **Geo**.
2. La frizione nasce da confini poco chiari tra owner e consumer.
3. I confini si offuscano quando UI, persistenza e policy vivono nello stesso file "comodo".
4. Senza contratto, ogni fix locale crea una seconda verita.
5. Serve planning BMAD + blueprint Filament + docs owner come unica memoria operativa.

## Starbursting

- **Chi:** cittadino, operatore mappa, Mobile host
- **Cosa:** Catturare posizione affidabile anche quando il cittadino nega il GPS o serve inserimento manuale.
- **Quando:** a ogni incremento che tocca questo owner; decisioni in decision-log.
- **Dove:** `laravel/Modules/Geo/docs/` (+ `docs/bmad/`).
- **Perché:** parallelismo sicuro, DRY, auditabilita, nessun `bmad-output/`.
- **Come:** track `quick-flow` -> planning -> (architecture/UX se serve) -> stories ready-for-dev.

## SCAMPER

| Leva | Idea | Impatto | Fattibilita |
|---|---|---:|---:|
| Substitute | Servizi ad-hoc -> Actions + XotBase Filament in Geo | H | H |
| Combine | Planning BMAD + second brain docs owner + blueprint Filament | H | H |
| Adapt | Pattern Fixcity (policy, ledger, tenant) dove il modulo tocca dati civici | H | M |
| Modify | Ridurre superficie API pubblica ai contratti consumer | H | M |
| Eliminate | Duplicazioni di verita (second store, Livewire legacy, Controllers) | H | H |
| Reverse | Progettare dai failure mode privacy/authz prima delle feature | H | H |

## Reverse brainstorming — come romperlo

- Copiare planning Ticket in questo owner (gia successo: stub da correggere).
- Mettere business rules nel tema o Controllers.
- Inventare store paralleli (es. timeline duplicata).
- Estendere Filament core invece di `XotBase*`.
- Scrivere docs in `bmad-output/`.

## Insight selezionati

1. Lo scopo di **Geo** e: Catturare posizione affidabile anche quando il cittadino nega il GPS o serve inserimento manuale.
2. Tutto cio che e in **Out** va linkato all'owner vero, non reimplementato.
3. Filament e chrome/admin o widget FO montato: non e il dominio.
4. Il second brain vive accanto al codice owner; QMD trova, non possiede.

## Prossimo step BMAD

Vedi [bmad-planning.md](./bmad-planning.md) — eseguire la Wave 1 e aggiornare il decision-log owner.
