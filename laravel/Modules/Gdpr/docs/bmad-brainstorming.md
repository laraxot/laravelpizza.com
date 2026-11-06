---
title: "BMAD Brainstorming — Gdpr"
type: bmad-brainstorming
status: synthesized
module: Gdpr
track: bmad-method
created: 2026-10-16
updated: 2026-10-16
tags: [bmad, brainstorming, scamper, starbursting, second-brain, gdpr]
qmd: "bmad brainstorming gdpr perche insight rischi"
related:
  - ./bmad/bmad-dossier.md
  - ./bmad-planning.md
  - ./bmad/filament-blueprint.md
---

# Domanda guida

Come separare evidenza tecnica e significato legale senza hardcodare testi giuridici nel codice?

## 5 Whys (sintesi)

1. L'utente sente frizione o opacita sul valore di **Gdpr**.
2. La frizione nasce da confini poco chiari tra owner e consumer.
3. I confini si offuscano quando UI, persistenza e policy vivono nello stesso file "comodo".
4. Senza contratto, ogni fix locale crea una seconda verita.
5. Serve planning BMAD + blueprint Filament + docs owner come unica memoria operativa.

## Starbursting

- **Chi:** cittadino interessato, DPO/tenant admin, operatore
- **Cosa:** Rendere consenso, trattamenti, revoca, export e cancellazione evidenze comprensibili e tenant-owned.
- **Quando:** a ogni incremento che tocca questo owner; decisioni in decision-log.
- **Dove:** `laravel/Modules/Gdpr/docs/` (+ `docs/bmad/`).
- **Perché:** parallelismo sicuro, DRY, auditabilita, nessun `bmad-output/`.
- **Come:** track `bmad-method` -> planning -> (architecture/UX se serve) -> stories ready-for-dev.

## SCAMPER

| Leva | Idea | Impatto | Fattibilita |
|---|---|---:|---:|
| Substitute | Servizi ad-hoc -> Actions + XotBase Filament in Gdpr | H | H |
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

1. Lo scopo di **Gdpr** e: Rendere consenso, trattamenti, revoca, export e cancellazione evidenze comprensibili e tenant-owned.
2. Tutto cio che e in **Out** va linkato all'owner vero, non reimplementato.
3. Filament e chrome/admin o widget FO montato: non e il dominio.
4. Il second brain vive accanto al codice owner; QMD trova, non possiede.

## Prossimo step BMAD

Vedi [bmad-planning.md](./bmad-planning.md) — eseguire la Wave 1 e aggiornare il decision-log owner.
