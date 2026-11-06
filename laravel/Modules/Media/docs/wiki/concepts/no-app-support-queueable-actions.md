---
title: "no app/Support — business logic in QueueableAction"
type: concept
tags: [media, actions, queueable-action, support, refactor]
created: 2026-07-12
updated: 2026-10-23
qmd: "Media module no app Support TemporaryUploadPathGenerator MediaExporter QueueableAction"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/372"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/273"
related:
  - ../../../../../../docs/second-brain/process/no-app-support-queueable-actions.md
  - ../../../../../../docs/wiki/rules/queueable-action-trait-mandatory.md
status: draft
---

# no `app/Support/` — business logic in QueueableAction

## Scopo

Nel modulo Media **non** esiste più `app/Support/` (verificato 2026-10-23). Le use-case stanno in `app/Actions/` e usano `Spatie\QueueableAction\QueueableAction`.

## Migrazione (2026-07-12)

| Legacy `app/Support/` | Action |
|-----------------------|--------|
| `TemporaryUploadPathGenerator` (`TemporaryUploadPathGeneratorContract`) | `GenerateTemporaryUploadPathAction` (`purpose`: `original`, `conversion`, `responsive`) |
| `Ffmpeg/MediaExporterResolver` | `Ffmpeg/ResolveMediaExporterAction` (`from()` → `execute()`) |

## Note

- Nessun consumer PHP attivo al momento della migrazione; path generator pronto per binding Spatie MediaLibrary.
- `ResolveMediaExporterAction` normalizza il ritorno della fluent API FFmpeg.
- `StreamVideoAction` resta un'Action: range headers e gestione dello stream HTTP sono parte dell'operazione invocabile e non un servizio separato.

## Collegamenti

- [queueable-action-trait-mandatory](../../../../../../docs/wiki/rules/queueable-action-trait-mandatory.md)

## Wave 2026-10-22

| Legacy | Action |
|--------|--------|
| `TemporaryUploadPathGenerator` | `GenerateTemporaryUploadPathAction` |
| `MediaExporterResolver` | `Actions/Ffmpeg/ResolveMediaExporterAction` |
| Diagnostic AWS Support/* | `Actions/Diagnostic/Aws/*Action` |
