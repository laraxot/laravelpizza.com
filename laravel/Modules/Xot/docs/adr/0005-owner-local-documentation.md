---
title: "Le decisioni vivono nella documentazione dell'owner"
type: decision
status: accepted
created: 2026-11-23
updated: 2026-11-23
decision-makers: [team Laraxot]
issues: []
---

# Le decisioni vivono nella documentazione dell'owner

## Contesto

Moduli e temi sono pacchetti autonomi e possono essere sincronizzati
indipendentemente. Un ADR o un manuale scritto in una cartella globale perde il
rapporto con il codice che deve rispettarlo e può essere sovrascritto da un
mirror.

## Driver della decisione

- ownership chiara;
- documentazione recuperabile insieme al pacchetto;
- aggiornamento coordinato con codice, test e contratti;
- niente duplicazione fra root, moduli e temi.

## Alternative scartate

- conservare le decisioni soltanto in `bmad-output/`;
- mettere un unico manuale globale al posto dei manuali owner;
- copiare lo stesso ADR in ogni modulo senza adattarlo al codice reale.

## Decisione

Ogni modulo e tema mantiene `docs/adr/`, `docs/contracts/`, `docs/stories/`
e i manuali operativi pertinenti. Un ADR descrive una decisione del proprio
owner; le regole condivise vengono referenziate da Xot e applicate localmente
solo quando sono dimostrate dal codice e dai test.

## Conseguenze

- Buono: una modifica al pacchetto porta con sé il perché e il contratto.
- Buono: i link owner riducono la documentazione generica e obsoleta.
- Cattivo: una decisione trasversale richiede aggiornare più owner, senza duplicarne il testo integralmente.

## Conferma

- il test documentale verifica cartelle e ADR sostanziali per ogni pacchetto;
- i nuovi documenti usano nomi senza date o timestamp;
- il lavoro BMAD resta nella story del modulo/tema owner.
