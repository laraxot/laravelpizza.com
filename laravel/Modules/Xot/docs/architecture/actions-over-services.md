# Actions Over Services

Regola architetturale canonica del progetto:

- **non usiamo Services**
- usiamo **Actions**
- quando un'azione deve essere invocabile, queueable o riusabile come job applicativo, usiamo **`spatie/laravel-queueable-action`**

## Motivazione

- riduce la proliferazione di classi generiche `*Service`
- rende ogni unita' di business piu' piccola, esplicita e testabile
- si integra bene con container, queue e job orchestration
- mantiene il codice piu' DRY e piu' KISS del classico service layer indefinito

## Regole operative

- niente nuove cartelle `Services/` per logica applicativa di dominio
- le vecchie classi in `app/Services` sono debito legacy da convergere
- la business logic vive in `app/Actions`
- le action devono avere input/output chiari e testabili
- se l'azione deve essere dispatchabile o asincrona, preferire `QueueableAction`

## Impatto sui documenti prodotto

- nei PRD non va richiesto un `service layer`
- roadmap e sprint devono parlare di action, queueable action, contract e test
- se un documento legacy menziona `Services` come obiettivo, va corretto

## Riferimenti

- [product-docs-governance.md](../product-docs-governance.md)
- [PRODUCT_DOCS_INDEX_2026_03_12.md](../../../../docs/project/PRODUCT_DOCS_INDEX_2026_03_12.md)
