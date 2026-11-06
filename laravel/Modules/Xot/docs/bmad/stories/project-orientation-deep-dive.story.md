---
id: project-orientation-deep-dive
title: Approfondimento orientamento progetto (deep dive)
status: in-progress
module: Xot
epic: project-quality-audit
priority: medium
created: 2026-10-27
references:
  - laravel/Modules/IndennitaCondizioniLavoro/docs/bmad/stories/01.36.compila-condizioni-lavoro-carbon-error.story.md
  - bashscripts/ai/wiki/memories/agent-standing-order.md
  - laravel/Modules/Xot/docs/stories/project-orientation-verified-state.story.md
---

# Approfondimento orientamento progetto (deep dive)

## Obiettivo

Verificare a fondo lo stato reale del progetto: PHPStan per-modulo, documentazione `docs/purpose.md` mancante, discrepanze standing order, riferimenti Gdpr residui. Senza modificare codice applicativo a meno che non sia richiesto.

## Ac

- [ ] PHPStan per-modulo su tutti i 18 moduli (exit 0 o errore documentato)
- [ ] Verificare `docs/purpose.md` in tutti i moduli (Performance e Ptv mancanti confermati)
- [ ] Allineare data `updated` frontmatter standing order ai pilastri 11-14 (2026-10-21)
- [ ] Verificare riferimenti residui a `Modules\Gdpr`
- [ ] Registrare esiti nel second brain e chiudere storia

## Note

Nessun `git checkout`/`reset`/`force`: i dati sono sacri, si va solo avanti.
