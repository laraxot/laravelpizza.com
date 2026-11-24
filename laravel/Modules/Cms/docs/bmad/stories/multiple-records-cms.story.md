---
title: CMS Duplicate Slug Error Fix
document_type: story
status: done
date: 2026-10-06
---

# CMS MultipleRecordsFoundException Fix

Root cause: `HasBlocks::getBlocksBySlug()` used `sole()` without catching
`MultipleRecordsFoundException`; 2 DB records matched slug.

Fix: try/catch around `sole()`; throws `RuntimeException` with ids/slugs
listed; `ModelNotFoundException` returns `[]`.

Source: `Modules/Cms/app/Models/Traits/HasBlocks.php:124`

Second Brain: document in docs/bmad/stories/ + log to wiki.
