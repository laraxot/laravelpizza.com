# Geo Wiki Troubleshooting

Bucket canonico per runbook di troubleshooting del modulo Geo.
<<<<<<< HEAD
# $(basename "$d")

This directory is part of the Geo module LLM wiki.

- concepts: distilled conceptual pages and patterns.
- entities: reference pages for models, components, classes.
- sources: raw sources and original documents (mirrors of docs/raw when needed).
- comparisons: side-by-side comparisons, decisions, diffs.
- decisions: ADRs and architecture choices.
- troubleshooting: operational runbooks and troubleshooting guides.
- _archive: historical content (not used for ingestion).
- _templates: templates & skeletons for wiki pages.
=======

## Runbook

- [geo-map-fixes-registry.md](../concepts/geo-map-fixes-registry.md) — tabella correzioni INC-1…8 + ordine rebuild.
- [map-lit-it-incidents-2026-06](./map-lit-it-incidents-2026-06.md) — indice incidenti mappa `/it` (bundle, GPS, cluster, popup, marker).
- [map-popup-header-whitespace-fix](./map-popup-header-whitespace-fix.md) — fascia bianca nel popup: `header { min-height: 222px }` e fix.
- [map-lit-cluster-hover-escape-fix](./map-lit-cluster-hover-escape-fix.md) — cluster "scappano" al hover: no `transform` su `.leaflet-marker-icon` (STORY-123).
- [map-current-position-bug-fix](./map-current-position-bug-fix.md) — pulsante posizione corrente, fullscreen e search control.
- [ui-ai-mcp-verification-2026-06](./ui-ai-mcp-verification-2026-06.md) — timeout, porte MCP e autenticazione strumenti UI/AI.

Ricostruzione mappa da zero: [geo-map-lit-reconstruction-guide.md](../concepts/geo-map-lit-reconstruction-guide.md).
>>>>>>> 40b96bcd6 (.)
