---
title: "[DEV] PHPStan zero errori Notify: param type mancanti nei test"
type: dev
module: Notify
status: done-pending-commit
created: 2026-10-28
updated: 2026-10-28
tags: [phpstan, typeCoverage, notify, tests, bmad]
related:
  - ./notify-phpstan-zero-errors.story.md
---

# [DEV] PHPStan zero errori Notify

File: `tests/TestCase.php`, `tests/Unit/Enums/MediaTypeEnumTest.php`, `tests/Unit/Enums/WhatsAppDriverEnumTest.php`.

Verifica: `cd laravel && ./vendor/bin/phpstan analyse Modules --memory-limit=-1 --no-progress --error-format=raw | grep Modules/Notify/` (vuoto).
La soglia `paramTypeCoverage` e' full-tree: `analyse Modules/Notify` da solo non basta.
