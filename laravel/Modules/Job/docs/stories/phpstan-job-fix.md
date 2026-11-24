---
id: phpstan-job-fix
slug: phpstan-job
scope: [module:Job, project:base_workorder_fila5]
status: Done
priority: High
created: 2026-09-06
updated: 2026-09-06
superseded_by: "./01.Job-phpstan-fix.story.md"
---

## Problema
PHPStan errors in Modules/Job

## Errori Stimati
~30 errori

## Solution
1. Analyze with phpstan
2. Fix pattern errors
3. Verify with phpmd + phpinsights + pest
4. Git sync

## Esito (2026-09-06)
15 -> 0 errori. Dettaglio completo in `./01.Job-phpstan-fix.story.md` (story canonica
per questo fix, questo file resta come traccia storica/dedupe).
