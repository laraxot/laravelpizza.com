---
title: "attach"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "attach"
issues: []
discussions: []
---

```php
AttachAction::make()->modifyRecordSelectUsing(
fn ($select) => $select->getOptionLabelFromRecordUsing(fn ($record) => $record->name . ' ' . $record->organization)
);
```

```php
AttachAction::make()
    ->recordTitle(fn (Model $record) => "{$record->name} ({$record->organisation->name})")
```