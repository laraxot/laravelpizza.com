---
title: "no app/Support — business logic in QueueableAction"
type: concept
tags: [media, actions, queueable-action, support, refactor]
created: 2026-07-12
updated: 2026-07-12
qmd: "Media module no app Support TemporaryUploadPathGenerator MediaExporter QueueableAction"
issues:
  - "https://github.com/laraxot/platform/issues/372"
discussions:
  - "https://github.com/laraxot/platform/discussions/273"
related:
  - ../../../../docs/wiki/rules/queueable-action-trait-mandatory.md
---

# no `app/Support/` — business logic in QueueableAction

## Scopo

Nel modulo Media **non** esiste più `app/Support/`.

## Migrazione (2026-07-12)

| Legacy `app/Support/` | Action |
|-----------------------|--------|
| `TemporaryUploadPathGenerator` (`TemporaryUploadPathGeneratorContract`) | `GenerateTemporaryUploadPathAction` (`purpose`: `original`, `conversion`, `responsive`) |
| `Ffmpeg/MediaExporterResolver` | `Ffmpeg/ResolveMediaExporterAction` (`from()` → `execute()`) |

## Note

- Nessun consumer PHP attivo al momento della migrazione; path generator pronto per binding Spatie MediaLibrary.
- `ResolveMediaExporterAction` normalizza il ritorno della fluent API FFmpeg.

## Collegamenti

- [queueable-action-trait-mandatory](../../../../docs/wiki/rules/queueable-action-trait-mandatory.md)
