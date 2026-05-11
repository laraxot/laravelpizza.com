---
title: "XotBaseResourceTable Columns Enforcement — Media Module"
type: concept
sources: []
confidence: high
created: 2026-05-07
updated: 2026-05-07
tags: [xotbase, filament, tables, enforcement]
related:
  - ../../../../../../docs/wiki/concepts/xotbase-table-columns-enforcement.md
---

# Media Module: XotBaseResourceTable Columns

3 Table files populated with columns from Spatie Media Library models and temporary uploads.

Resources: MediaConvert, Media, TemporaryUpload

- **MediaTable**: id, model_type, model_id, uuid, collection_name, name, file_name, mime_type, disk, size, order_column (Spatie Media Library schema)
- **MediaConvertsTable**: id, media_id, format, codec_video, codec_audio, preset, bitrate, width, height, percentage
- **TemporaryUploadsTable**: id, session_id, created_at, updated_at
