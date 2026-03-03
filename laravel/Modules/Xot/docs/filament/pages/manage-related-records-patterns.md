# Sexy UI Patterns for ManageRelatedRecords

## Advanced Column Presentation
To make related record tables more visually appealing and information-rich:

### 1. The ID Column
Instead of just a number, use an icon and secondary styling.
```php
TextColumn::make('id')
    ->icon('heroicon-o-hashtag')
    ->iconColor('gray')
    ->sortable();
```

### 2. Status & Enums
Never use plain text for statuses. Use badges with dynamic colors.
```php
TextColumn::make('status')
    ->badge()
    ->color(fn (string $state): string => match ($state) {
        'active' => 'success',
        'pending' => 'warning',
        'inactive' => 'danger',
        default => 'gray',
    });
```

### 3. Temporal Awareness
Use relative time for audit trails.
```php
TextColumn::make('created_at')
    ->dateTime('d/m/Y H:i')
    ->since()
    ->description(fn (Model $record): string => $record->created_at->format('d/m/Y H:i'))
    ->sortable();
```

## Action Beautification
Actions should feel interactive and tactile.

### 1. The Call-to-Action (CTA)
The primary header action should stand out.
```php
CreateAction::make()
    ->icon('heroicon-o-plus-circle')
    ->button()
    ->color('primary')
    ->size('lg');
```

### 2. Inline Actions
Use tooltips and icon buttons to keep the table clean.
```php
ViewAction::make()
    ->iconButton()
    ->tooltip(static::trans('actions.view')),
EditAction::make()
    ->iconButton()
    ->color('warning')
    ->tooltip(static::trans('actions.edit')),
```

## Transitions and Micro-interactions
The "One" theme focuses on smooth UI transitions.
- **Empty State**: Use a visual illustration or a clean icon.
- **Zero-Config Localization**: Labels, placeholders, and helper texts must NEVER be set via `->label()`, `->placeholder()`, or `->helperText()`. The system handles them automatically if the key exists in the `lang` files.
- **Loading State**: Configure skeleton loaders for heavy relational queries.
- **Modals**: Use slide-overs for creating/editing related records to maintain page context.
