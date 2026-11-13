---
type: story
slug: phpstan-safe-preg-stringable
title: "PHPStan: Safe\\preg_replace sostituito da Str::of()->replaceMatches()"
status: done
phase: DONE
owner: Cms
related:
  - "../../../Xot/docs/stories/phpstan-safe-preg-stringable.story.md"
created: 2026-11-12
updated: 2026-11-12
---

# PHPStan: Safe\preg_replace e stringhe

`Safe\preg_replace` dichiara `string|array` anche per un input stringa. I punti del modulo che subito dopo usavano il risultato come stringa
ora passano da `Str::of(...)->replaceMatches(...)->toString()`. Motivazione e elenco completo sono nella story omonima di Xot.
