---
title: "UI wiki log"
type: log
status: active
created: 2026-10-14
updated: 2026-10-14
module: UI
tags: [ui, log, docs]
qmd: "ui wiki log docs studio ingressi"
---

# UI wiki log

Registro cronologico inverso. Esisteva solo come riferimento (`./log.md`) da `INDEX.md`, `overview.md` e `readme.md` di questa cartella,
senza il file. Le decisioni stanno in [decision-log](../decision-log.md).

## 2026-10-14

Studio del modulo contro i docs (story [2026-10-14-docs-ui-studio-e-ingressi](../stories/docs-ui-studio-e-ingressi.story.md)).

- `README.md` e `00-INDEX.md` riscritti con percorsi e conteggi verificati sul codice; il link a `schema/` (cartella inesistente alla
  radice di `docs/`) e' stato tolto.
- Codice: 17 colonne, 19 campi form, 14 blocchi, 12 widget, 6 Actions, 3 modelli piu' `BaseModel`; nessuna Resource CRUD; rotte vuote.
- PHPStan `Modules/UI` exit 0. Pest `Modules/UI/tests`: 218 passati, 16 falliti, 1 risky, 109 saltati (sqlite in memoria, 99 s).
- Link non risolti nel perimetro: 1522 eventi in 159 file (misura con `--busy-minutes 0`); 891 vengono da `_archive/INDEX.md`, un elenco
  generato che punta a sottocartelle che non esistono piu'.
- `bmad/architecture.md` e `wiki/purpose.md`: aggiunta in coda una verifica datata (la mappa del codice conteneva numeri e percorsi superati).
- `bmad/purpose.md` e `wiki/purpose.md` hanno lo stesso corpo (diff vuoto): il canonico e' quello in `wiki/`.
- Segnalato fuori perimetro: `laravel/Modules/UI/README.md` contiene marker di merge non risolti.
