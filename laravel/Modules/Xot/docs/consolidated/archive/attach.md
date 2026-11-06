---
title: "attach"
type: note
status: draft
updated: 2026-10-18
tags: [docs, xot, consolidated]
qmd: "attach xot"
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
