# Product Docs Governance

Regola operativa per questo repository:

- ogni modulo e ogni tema deve avere nel proprio `docs/` sei documenti prodotto canonici
- i sei documenti sono: `prd.md`, `product-roadmap.md`, `product-launch-plan.md`, `product-strategy.md`, `user-research.md`, `sprint-planning-meeting.md`
- se esiste un naming legacy come `PRD.md`, va mantenuto per compatibilita' ma va prevista convergenza verso `prd.md`
- i documenti prodotto devono rimanere aderenti al codice reale, con percentuali esplicite quando possibile
- i documenti prodotto sono anche il punto di interscambio tra agenti AI, quindi devono essere sintetici, aggiornabili e referenziabili

## Regole di qualita'

- niente marketing vuoto
- niente feature dichiarate senza supporto nel codice
- backlog, issue, discussion e test devono rimanere collegati ai documenti prodotto
- il PRD e' il punto di verita' del perimetro; roadmap, launch, strategy, research e sprint ne derivano
- non usare `Services` come pattern architetturale di progetto
- usare `Actions` e, quando serve esecuzione asincrona o riutilizzo invocabile, `spatie/laravel-queueable-action`

## Indice centrale

- [PRODUCT_DOCS_INDEX_2026_03_12.md](../../../../docs/project/PRODUCT_DOCS_INDEX_2026_03_12.md)
