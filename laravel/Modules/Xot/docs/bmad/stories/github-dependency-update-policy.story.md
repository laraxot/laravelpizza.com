---
title: "Valutare la policy degli aggiornamenti dipendenze GitHub"
type: story
module: Xot
status: analysis-and-design
created: 2026-10-28
updated: 2026-10-28
tags: [ecc, github, dependencies, governance]
qmd: "ECC GitHub Dependabot Renovate dependency updates policy security review"
related:
  - codex-harness-audit-readiness.story.md
  - ../../ecc/ptvx-integration.md
---
# Valutare la policy degli aggiornamenti dipendenze GitHub

## Contesto

Tra le azioni suggerite dall'audit ECC figurano Dependabot o Renovate. PTVX usa Composer, npm e repository/moduli multipli: prima di attivare bot occorre verificare hosting, manifest, automazioni già presenti e capacità di gestire PR in modo sicuro.

## User story

Come manutentore, voglio una policy di aggiornamento dipendenze coerente con i repository PTVX così da ricevere aggiornamenti controllabili e convalidabili.

## Criteri di accettazione

- [ ] Inventariare repository e manifest effettivamente ospitati su GitHub.
- [ ] Verificare automazioni Dependabot/Renovate già configurate e regole di sicurezza.
- [ ] Definire frequenza, gruppi, limiti PR e gate richiesti per Composer e npm.
- [ ] Evitare configurazioni duplicate o file bot in repository non gestiti da GitHub.
- [ ] Documentare una raccomandazione con evidenze e owner.

## Task

- [ ] Consultare configurazione repository, workflow CI e policy esistenti.
- [ ] Confrontare l'impatto per root e repository annidati senza modificare workflow altrui.
- [ ] Produrre la decisione e, solo se supportata, una story d'implementazione dedicata.

## Riferimenti

- `AGENTS.md`
- `laravel/Modules/Xot/docs/ecc/00-index.md`
- `laravel/Modules/Xot/docs/ecc/ptvx-integration.md`
