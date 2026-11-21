---
title: "metrics"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "metrics"
issues: []
discussions: []
---

# Metriche Modulo Geo

| Metrica | Obiettivo | Verifica |
|--------|-----------|----------|
| PHPStan Level 10 | 0 errori | `./vendor/bin/phpstan analyse Modules/Geo --memory-limit=-1` |
| Geocoding (con cache) | Tempo risposta sotto soglia progetto | Test o monitoraggio |
| Query GIS | Uso indici e funzioni spatial corretto | Review migrazioni e query |
| Traduzioni entità geo | Chiavi presenti in lang/it (e en) | Nessun placeholder |
| Provider multipli | Almeno 2 configurabili | Config/documentazione |
