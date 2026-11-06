---
id: xot-export-lazy-action-label-consistency
title: "Allineare ExportXlsLazyAction ai bottoni export dell'header"
type: story
status: open
priority: P2
owner: module:Xot
module: Xot
tags: [filament, header-action, ui, coerenza]
related: [fix-xot-unit-misc-tests]
---

# Allineare ExportXlsLazyAction ai bottoni export dell'header

Fase BMAD: Dev.

## Stato
- `ExportPdfAction` e `ExportXlsAction` usano `label(fn () => $this->getTooltip())` con `hiddenLabel()`, dopo la risoluzione dei marcatori di merge.
- `ExportXlsLazyAction` usa ancora `label('')` con `iconButton()`, la forma che i commenti dei fratelli dichiarano abbandonata (glifo senza area cliccabile).

## Azioni
1. Verificare nella UI quale forma appare nell'header di una lista con export lazy.
2. Allineare `ExportXlsLazyAction` alla forma scelta e aggiornare il commento se la scelta cambia.
3. Coprire con un test di header che il bottone abbia etichetta per screen reader.

## Verifica
- Test Pest dell'action verde, PHPStan `analyse Modules/Xot` pulito.
