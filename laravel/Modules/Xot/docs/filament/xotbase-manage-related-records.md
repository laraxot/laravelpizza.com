# XotBaseManageRelatedRecords — Reference

`Modules\Xot\Filament\Resources\Pages\XotBaseManageRelatedRecords`

Base class for all Filament pages that manage a HasMany/BelongsToMany relationship
inline within a parent resource (replaces RelationManagers).

## Inheritance chain

```
FilamentManageRelatedRecords (vendor Filament)
  └── XotBaseManageRelatedRecords (Xot)
        uses HasXotTable         ← full table scaffolding (columns, actions, table())
        uses InteractsWithForms  ← form handling
        uses NavigationLabelTrait
          └── ManageCharts, ManageSurveyPdfQuestionCharts, etc.
```

## What the base class provides automatically

| Method | Default behaviour | Override to change |
|--------|------------------|--------------------|
| `table()` | Full table: columns, header actions, record actions, bulk actions, filters, layout toggle | Rarely needed |
| `getTableColumns()` | `id`, `name`, `created_at` text columns | Always override |
| `getTableHeaderActions()` | `create` + optionally `associate` (see below) | Override `shouldShowAssociateAction()` |
| `getTableActions()` | `view`, `edit`, `delete` (based on resource can*) + optional `detach` | `array_merge(parent::getTableActions(), [...])` to extend |
| `getTableBulkActions()` | `DeleteBulkAction` | Override to replace |
| `getTableFilters()` | Empty | Override to add filters |
| `getHeaderActions()` | `create` (page-level top button) | Return `[]` to suppress |
| `getTableHeading()` | Translation key lookup | Override for custom heading |
| `getDefaultTableSortColumn()` | `<table>.id` | Override |
| `getDefaultTableSortDirection()` | `desc` | Override |

## Semantic feature flags (override instead of duplicating action code)

```php
// Show AssociateAction in table header
protected function shouldShowAssociateAction(): bool { return true; }

// Show AttachAction in table header (auto-true when getRelationship() exists)
protected function shouldShowAttachAction(): bool { return true; }

// Show DetachAction per row (auto-true when getRelationship() exists)
protected function shouldShowDetachAction(): bool { return true; }

// Show ReplicateAction per row
protected function shouldShowReplicateAction(): bool { return true; }
```

## Pattern: extend parent actions instead of replacing them

```php
// WRONG: hides base view/edit/delete
public function getTableActions(): array
{
    return [
        'view' => ViewAction::make(),
        'edit' => EditAction::make(),
        'dissociate' => DissociateAction::make(),
        'delete' => DeleteAction::make(),
    ];
}

// CORRECT: extends base (view/edit/delete come from parent)
public function getTableActions(): array
{
    return array_merge(parent::getTableActions(), [
        'dissociate' => DissociateAction::make(),
        'force_delete' => ForceDeleteAction::make(),
        'restore' => RestoreAction::make(),
    ]);
}
```

## Pattern: reuse another resource's column definition

```php
// CORRECT: use app() to call the standard instance method
public function getTableColumns(): array
{
    return app(ListCharts::class)->getTableColumns();
}

// WRONG: static wrapper adds a redundant indirection layer
public function getTableColumns(): array
{
    return ListCharts::getChartTableColumns(); // pointless static wrapper
}
```

`getTableColumns()` is always pure (no $this->record, no state), so instantiating
via `app()` is safe and lightweight. The static wrapper `getSomethingColumns()` exists
only to bypass instance access — `app()` solves this more cleanly.

## Pattern: suppress page-level create button

When create lives in the table header, suppress the redundant page-level button:

```php
public function getHeaderActions(): array
{
    return []; // suppresses base HasXotTable::getHeaderActions() create button
}
```

## Dead code trap: overriding getTableActions() when table() is also overridden

If `table()` is fully overridden (e.g. delegating to another resource's table), the
`getTableActions()` method is NEVER called because `HasXotTable::table()` is bypassed.

```php
// getTableActions() defined here is DEAD CODE:
public function table(Table $table): Table
{
    return app(OtherResource::class)->table($table); // bypasses HasXotTable::table()
}
```

Use `getTableColumns()` + `shouldShow*Action()` flags instead so `HasXotTable::table()`
does the assembly.

## Minimum viable subclass

```php
class ManageFoo extends XotBaseManageRelatedRecords
{
    protected static string $resource = FooResource::class;
    protected static string $relationship = 'bars';

    public function getTableColumns(): array
    {
        return [
            'name' => TextColumn::make('name')->searchable()->sortable(),
        ];
    }
}
```

With `shouldShowAssociateAction()` returning `true`, the associate button appears
automatically — no need to override `getTableHeaderActions()`.

## Trap: standalone edit page for nested resource has empty form

### The problem

A nested resource (`$parentResource = SurveyPdfResource::class`) registers a standalone
Edit page that extends `XotBaseEditRecord`. When the user navigates to that edit URL, the
form renders with no fields.

The cause is always the same:

- `XotBaseEditRecord::getFormSchema()` returns `[]` by default.
- `Resource::getFormSchema()` is `static` — it cannot access the record instance.
- The standalone Edit page never overrides `getFormSchema()` as an instance method.

### Why it happens in nested resources specifically

In an inline `ManageRelatedRecords` page, `$this->record` IS the parent record. The form
schema can call `$this->record->survey_id` (or any parent attribute) directly.

In the standalone Edit page, `$this->record` IS the child record. The parent is one
relationship hop away: `$this->record->surveyPdf->survey_id`. The static `Resource::getFormSchema()`
has no mechanism to traverse that hop.

### The pattern that works

Override `getFormSchema()` in the Edit page as an instance method. Navigate to the parent
record through the relationship chain to retrieve whatever context the form schema needs.

```php
// WRONG: form is empty — static Resource::getFormSchema() returns []
class EditQuestionChart extends XotBaseEditRecord
{
    // getFormSchema() not overridden — inherits return []
}

// CORRECT: instance method accesses $this->record to reach parent context
class EditQuestionChart extends XotBaseEditRecord
{
    public function getFormSchema(): array
    {
        $record = $this->getRecord();
        if (! $record instanceof QuestionChart) {
            return [];
        }
        $surveyId = $record->surveyPdf?->survey_id ?? '';
        if ($surveyId === '') {
            return [];
        }
        return QuestionChartResource::getFormSchemaBySurveyId($surveyId);
    }
}
```

### Contrast: inline ManageRelatedRecords vs standalone Edit

| Context | `$this->record` | How to reach parent `survey_id` |
|---------|-----------------|--------------------------------|
| `ManageQuestionCharts` (inline) | SurveyPdf (the parent) | `$this->record->survey_id` |
| `EditQuestionChart` (standalone) | QuestionChart (the child) | `$this->record->surveyPdf->survey_id` |

### Rule

Any time a child resource's form schema depends on data from the parent record, the
standalone Edit page MUST override `getFormSchema()` as an instance method. Static
methods on the resource class cannot substitute for this.

### Real-world case

`QuestionChartResource` has `getFormSchemaBySurveyId(string $survey_id)` with all the
real fields, and `getFormSchema()` returns `[]`. The inline page `ManageQuestionCharts`
calls `getFormSchemaBySurveyId()` correctly. The standalone page `EditQuestionChart` did
not implement `getFormSchema()`, so the edit form was empty.

See `laravel/Modules/Quaeris/docs/nested-resource-form-trap.md` for full analysis.
