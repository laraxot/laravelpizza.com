---
title: "Normalizzazione README root dei moduli"
type: story
status: review
epic: "DOCUMENTATION-2026"
module: Xot
created: 2026-09-28
updated: 2026-09-28
---

# Story — README root dei moduli

## Obiettivo

Rendere i 18 `laravel/Modules/*/README.md` ingressi affidabili: frontmatter
uniforme, confini dichiarati, inventario verificabile e collegamento agli artefatti
BMAD locali.

## Acceptance criteria

- [x] Tutti i 18 moduli con `module.json` hanno README root aggiornato.
- [x] Ogni README indica responsabilità, SSoT locale e gate verificabili.
- [x] Inventario statico per modulo: PHP, test, aree `app/`, migrazioni.
- [x] Marker di merge rimossi dai README toccati.
- [x] Nessun badge nuovo dichiara metriche non misurate.
- [ ] Eseguire i gate applicativi completi dopo la stabilizzazione del tree condiviso.

## Evidenze e metodo

Inventario generato da `module.json` e scansione filesystem con
`bashscripts/tools/normalize-module-readmes.py`. La scheda non sostituisce PHPStan,
Pest o una revisione del dominio. I dettagli architetturali restano nei README
specifici e in `docs/bmad/` di ciascun modulo.

## Rischi residui

Il working tree contiene artefatti BMAD concorrenti preesistenti; non sono stati
riscritti. I README già ricchi sono stati preservati e solo integrati. La story resta
in `review` finché non vengono eseguiti i gate richiesti dal standing order.
