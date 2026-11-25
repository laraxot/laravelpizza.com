---
title: "conflicts"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-11-24
qmd: "conflicts"
issues: []
discussions: []
---

# Risoluzione Conflitti - Job

## File modificati

## Decisioni adottate

## Marcatori di conflitto nel codice dopo il sync del 24/11/2026

`merge_remote_repo_2.sh` ha committato marcatori in `tests/Unit/Services/ScheduleServiceTest.php`: i due lati erano lo stesso test,
uno con `use Modules\Job\Tests\TestCase` e `uses(TestCase::class)`, l'altro con `uses(\Modules\Job\Tests\TestCase::class)`.
Tenuta la forma con l'import (stesso comportamento, nessun test perso). Il test verifica che `Modules\Job\Services\ScheduleService`
esista ancora (vedi `scopo.md`). Storia: `stories/12.5.job-sync-marker-repair.story.md`.
