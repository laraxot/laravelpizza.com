---
title: "BMAD Brainstorming — Meetup"
type: bmad-brainstorming
status: synthesized
theme: Meetup
track: quick-flow
created: 2026-10-16
updated: 2026-10-16
tags: [bmad, brainstorming, scamper, starbursting, second-brain, meetup]
qmd: "bmad brainstorming meetup perche insight rischi"
related:
  - ./bmad/bmad-dossier.md
  - ./bmad/README.md
  - ./bmad-planning.md
  - ./bmad/filament-blueprint.md
---

# Domanda guida

Quali journey Meetup possono restare demo senza confondere il FO civico Sixteen?

## 5 Whys (sintesi)

1. L'utente sente frizione o opacita sul valore di **Meetup**.
2. La frizione nasce da confini poco chiari tra owner e consumer.
3. I confini si offuscano quando UI, persistenza e policy vivono nello stesso file "comodo".
4. Senza contratto, ogni fix locale crea una seconda verita.
5. Serve planning BMAD + blueprint Filament + docs owner come unica memoria operativa.

## Starbursting

- **Chi:** partecipante demo
- **Cosa:** Superficie demo/meetup: Actions dei moduli restano unica fonte di comportamento.
- **Quando:** a ogni incremento che tocca questo owner; decisioni in decision-log.
- **Dove:** `laravel/Themes/Meetup/docs/` (+ `docs/bmad/`).
- **Perché:** parallelismo sicuro, DRY, auditabilita, nessun `bmad-output/`.
- **Come:** track `quick-flow` -> planning -> (architecture/UX se serve) -> stories ready-for-dev.

## SCAMPER

| Leva | Idea | Impatto | Fattibilita |
|---|---|---:|---:|
| Substitute | Bootstrap -> Tailwind/DaisyUI/Lit senza cambiare contratto dati | H | M |
| Combine | Header/footer/blocks CMS + pagine Folio in una composizione | H | H |
| Adapt | Pattern Design Comuni (conferma, passaggi, prossimi passi) come UI only | H | H |
| Modify | Ridurre clutter hero/first viewport restando brand-first | M | H |
| Eliminate | Logica dominio e Controllers dal tema | H | H |
| Reverse | Partire dai dati che non devono mai comparire in FO | H | H |

## Reverse brainstorming — come romperlo

- Copiare planning Ticket in questo owner (gia successo: stub da correggere).
- Mettere business rules nel tema o Controllers.
- Inventare store paralleli (es. timeline duplicata).
- Estendere Filament core invece di `XotBase*`.
- Scrivere docs in `bmad-output/`.

## Insight selezionati

1. Lo scopo di **Meetup** e: Superficie demo/meetup: Actions dei moduli restano unica fonte di comportamento.
2. Tutto cio che e in **Out** va linkato all'owner vero, non reimplementato.
3. Filament e chrome/admin o widget FO montato: non e il dominio.
4. Il second brain vive accanto al codice owner; QMD trova, non possiede.

## Prossimo step BMAD

Vedi [bmad-planning.md](./bmad-planning.md) — eseguire la Wave 1 e aggiornare il decision-log owner.
