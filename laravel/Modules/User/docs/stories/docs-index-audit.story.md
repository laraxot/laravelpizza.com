---
status: done
scope: module:User
type: docs
updated: 2026-09-03
qmd: "user docs index audit duplicati storico"
---

# Story: audit indice documentazione (Modules/User/docs)

## User story

Come manutentore del modulo User, voglio un `docs/index.md` organizzato per argomento su tutti i ~3238 file `.md` presenti, cosi' da poter trovare la documentazione corrente senza scorrere manualmente le cartelle `archive/`, `legacy/`, `wiki-archive/` e le decine di varianti duplicate (`-1`, `_underscore`, `.deprecated`, snapshot datati).

## Acceptance criteria

- [x] `docs/index.md` creato/aggiornato con 26 sezioni tematiche e link relativi a 1170 file attivi (root + sottocartelle)
- [x] Nessun file `.md` esistente rinominato, spostato o cancellato
- [x] Duplicati e contenuto storico raggruppati sotto "Storico / da consolidare" (cartelle di archivio in blocco con conteggio, varianti root/sottocartella per cluster, nomi anomali, snapshot datati/deprecati)
- [x] Tutti i link verificati puntare a file realmente esistenti (0 link rotti su 1170 univoci)

## Riferimenti

- [../index.md](../index.md)
