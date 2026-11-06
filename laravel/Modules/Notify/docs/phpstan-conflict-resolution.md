---
title: "phpstan conflict resolution"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "phpstan conflict resolution"
issues: []
discussions: []
status: superseded
superseded_by: phpstan-resolution.md
---

# Risoluzione conflitto SmsService.php

## Motivazione
Il conflitto è stato risolto mantenendo:
- Una sola dichiarazione per ogni variabile pubblica
- Documentazione in italiano per chiarezza
- Factory method `make()` come alias di `getInstance()`
- Costruzione dinamica del driver SMS tramite backslash singolo, in linea con PSR-12

## Impatto
La soluzione garantisce compatibilità con l'architettura a servizi, estendibilità e coerenza di stile.

## Collegamento alla doc root
Vedi `/docs/notify_conflict_links.md` per la mappatura dei file documentati localmente e i riferimenti incrociati.
