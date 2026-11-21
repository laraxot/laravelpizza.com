---
title: "php array one key per line"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "php array one key per line"
issues: []
discussions: []
name: php-array-one-key-per-line
description: "Nei file lang/PHP ogni chiave di array sta su una riga; SavePhpArrayAction non deve usare VarExporter raw"
metadata:
  type: lesson-learned
  created: 2026-09-16
---

# Array lang: una chiave per riga

## Errore

File `lang/**/*.php` con nested inline:

```php
'navigation' => ['label' => 'Dipendenti', 'icon' => 'heroicon-o-user'],
```

## Causa

`SaveTransAction` → `SavePhpArrayAction` usava `VarExporter::export()`, che compatta.

## Fix

Exporter custom in `Modules\Xot\Actions\Arr\SavePhpArrayAction`.  
Tool: `bashscripts/tools/expand-lang-arrays-one-key-per-line.php`.  
Always-on: `.cursor/rules/php-array-one-key-per-line.mdc`.  
Story: `Xot/docs/bmad/stories/5.155-php-array-one-key-per-line.story.md`.
