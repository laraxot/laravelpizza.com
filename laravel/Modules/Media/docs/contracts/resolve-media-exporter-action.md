---
title: "ResolveMediaExporterAction — contratto"
type: contract
owner: Media
status: accepted
updated: 2026-11-24
action: "Modules\\Media\\Actions\\Ffmpeg\\ResolveMediaExporterAction"
qmd: "ResolveMediaExporterAction FFmpeg MediaExporter normalizza catena fluent eccezione RuntimeException"
---

# ResolveMediaExporterAction

Verifica che il valore prodotto da una catena fluent FFmpeg sia un `MediaExporter` e lo restituisce invariato. Codice: `app/Actions/Ffmpeg/ResolveMediaExporterAction.php:18-29`.

## Input

- `mixed $value`: risultato della catena fluent.

## Output

- `MediaExporter`: lo stesso oggetto ricevuto.

## Invarianti

- **RESOLVE-MEDIA-EXPORTER-INV-1** — Un `MediaExporter` è restituito senza modifiche (stessa istanza).
  Test: `tests/Unit/MediaGapCloserCoverageTest.php:82-85` (istanza del resolver, non il caso di input sbagliato).
- **RESOLVE-MEDIA-EXPORTER-INV-2** — Ogni altro valore lancia `RuntimeException` con il tipo ricevuto nel messaggio.
  Test: nessuno esplicito.

## Effetti collaterali

- Nessuno.

## Errori

- `RuntimeException`: «La catena FFmpeg deve restituire un MediaExporter; ricevuto: <tipo>.»

## Non fa

- Non esegue FFmpeg né converte il valore.
