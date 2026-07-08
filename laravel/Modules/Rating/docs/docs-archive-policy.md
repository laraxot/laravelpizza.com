# Docs archive policy

`docs/archive/` is local-only scratch/history and must not be used as a canonical module documentation source.

Active module knowledge belongs in normal `docs/*.md`, `docs/wiki/**`, or a precise topical subdirectory. This keeps QMD ingestion deterministic and prevents stale duplicate notes from being treated as current architecture guidance.

The module `.gitignore` ignores `docs/archive/`; when a useful archived note is still valid, promote it into a live document outside `archive` and link it from the local docs index.
