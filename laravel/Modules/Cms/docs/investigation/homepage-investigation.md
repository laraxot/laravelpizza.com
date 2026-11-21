---
type: investigation
title: "Investigation Homepage Audit & Feature Gap Analysis"
links: {github_issue: #500}
---
# Investigation: Homepage Audit

## Problem Statement
La homepage attuale (public_html/index.php) è un semplice reindirizzamento a Laravel e non presenta contenuti statici significativi. Il vero contenuto della homepage è gestito dal modulo Cms tramite le pagine Folio.

## Current State
- Il modulo Cms ha già diverse documentazioni sulla homepage (vedi homepage-*.md in docs/)
- Mancano però:
  - Uno story BMAD che definisca il lavoro da fare per l'audit e il miglioramento della homepage
  - Un'analisi delle lacune di funzionalità rispetto ai competitor (Decoro Urbano, SeeClickFix, etc.)
  - Una proposta di design basata sui token DESIGN.md e sulla direzione breve

## Proposed Solution
1. Definire uno story BMAD per l'audit della homepage (già fatto)
2. Eseguire un'analisi delle lacune (investigation) - questo documento
3. Prendere una decisione sui cambiamenti da apportare (decision-log)
4. Implementare i cambiamenti in linea con le regole architetturali (no controller, no service, etc.)

## Evidence
- Documentazione esistente in laravel/Modules/Cms/docs/homepage-*.md
- Analisi dei competitor effettuata nello story
- Regole di progettazione antitraslopo (UX Discipline) e metodo Constraint-First

## Next Steps
- Completare il decision-log
- Implementare i cambiamenti nella homepage del modulo Cms (probabilmente tramite una Folio page e relativo Action)
- Verificare con ux_audit e PHPStan
