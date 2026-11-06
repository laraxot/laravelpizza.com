---
title: "attach"
type: note
created: 2026-09-24
updated: 2026-10-20
module: Xot
tags: [xot, filament]
qmd: "attach"
status: superseded
superseded_by: ../../consolidated/archive/attach.md
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