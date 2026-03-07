# Planning dual-track alignment memory

## Data

2026-03-06

## Decisione

Allineamento operativo in modalita dual-track:

- Track A: requisiti prodotto (`.planning/REQUIREMENTS.md`)
- Track B: coverage/type coverage (`.planning/ROADMAP.md` + issue coverage)

## Motivazione

Evitare conflitto tra roadmap prodotto e roadmap quality-only, mantenendo tracciabilita chiara e capacity esplicita.

## Impatto operativo

- `PROJECT.md` aggiornato come single source of truth a livello programma.
- `ROADMAP.md` mantiene le fasi coverage ma sotto governance dual-track.
- `REQUIREMENTS.md` resta sorgente per requisiti prodotto v1/v2.
- Policy coverage ufficiale consolidata in `docs/testing/coverage-100-plan.md`.

## Governance collegata

- Issue: #219, #216, #211
- Discussion: #229, #213

## Nota

Ogni modifica futura a `.planning/*` deve dichiarare esplicitamente track di appartenenza (A o B).
