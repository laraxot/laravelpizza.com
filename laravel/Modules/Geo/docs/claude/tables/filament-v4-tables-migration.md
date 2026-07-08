# Filament v4 Tables Migration Guide

## Breaking Changes

### 1. Deferred Filters (Default Behavior)
Filters now require user interaction before applying.

**Impact:** Users must click "Apply filters" button

**Disable Globally:**
```php
// In AppServiceProvider boot()
use Filament\Tables\Table;
Table::configureUsing(fn (Table $table) => $table
    ->deferFilters(false));
```

**Disable Per Table:**
```php
public function table(Table $table): Table
{
    return $table
        ->deferFilters(false);
}
```

### 2. Primary Key Sorting (Default Behavior)
Tables now sort by primary key by default.

**Disable Globally:**
```php
// In AppServiceProvider boot()
Table::configureUsing(fn (Table $table) => $table
    ->defaultKeySort(false));
```

**Disable Per Table:**
```php
public function table(Table $table): Table
{
    return $table
        ->defaultKeySort(false);
}
```

### 3. Pagination Page Options
The 'all' option is not available by default.

**Restore Globally:**
```php
// In AppServiceProvider boot()
Table::configureUsing(fn (Table $table) => $table
    ->paginationPageOptions([5, 10, 25, 50, 'all']));
```

**Set Per Table:**
```php
public function table(Table $table): Table
{
    return $table
        ->paginationPageOptions([5, 10, 25, 50, 'all']);
}
```

## URL Parameter Changes

| Old Parameter | New Parameter | Usage |
|---------------|-------------|-------|
| `activeRelationManager` | `relation` | Edit/View pages |
| `activeTab` | `tab` | List/Manage pages |
| `isTableReordering` | `reordering` | List/Manage pages |
| `tableFilters` | `filters` | List/Manage pages |
| `tableGrouping` | `grouping` | List/Manage pages |
| `tableGroupingDirection` | `groupingDirection` | List/Manage pages |
| `tableSearch` | `search` | List/Manage pages |
| `tableSort` | `sort` | List/Migration pages |

## Table Method Updates

### Bulk Actions
```php
// Before v3
protected function getTableBulkActions(): array
{
    return [
        DeleteBulkAction::make(),
    ];
}

// v4 (same but check for deprecations)
protected function getTableBulkActions(): array
{
    return [
        Tables\Actions\DeleteBulkAction::make(),
    ];
}
```

### Table Columns
```php
// Before v3
protected function getTableColumns(): array
{
    return [
        BadgeColumn::make('status'), // Deprecated
    ];
}

// v4
protected function getTableColumns(): array
{
    return [
        TextColumn::make('status')->badge(), // Correct
    ];
}
```

## Advanced Features

### 1. Table Actions
```php
public function getTableActions(): array
{
    return [
        Tables\Actions\ViewAction::make(),
        Tables\Actions\EditAction::make(),
        Tables\Actions\DeleteAction::make()
            ->requiresConfirmation(),
    ];
}
```

### 2. Custom Filters
```php
public function getTableFilters(): array
{
    return [
        SelectFilter::make('status')
            ->options([
                'active' => 'Active',
                'inactive' => 'Inactive',
            ]),
            
        Tables\Filters\Filter::make('created_at')
            ->form([
                Forms\Components\DatePicker::make('from'),
                Forms\Components\DatePicker::make('until'),
            ])
            ->query(function (array $data): Builder {
                return $query
                    ->whereBetween('created_at', $data['from'], $data['until']);
            }),
    ];
}
```

### 3. Searching
```php
public function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('name')
                ->searchable(),
            TextColumn::make('email')
                ->searchable(),
        ])
        ->searchPlaceholder('Search users...');
}
```

## Common Patterns

### 1. Conditional Actions
```php
public function getTableActions(): array
{
    return [
        Tables\Actions\EditAction::make()
            ->visible(fn ($record): bool => $record->canEdit()),
            
        Tables\Actions\DeleteAction::make()
            ->visible(fn ($record): bool => $record->canDelete()),
    ];
}
```

### 2. Custom Sorting
```php
public function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('name')
                ->sortable()
                ->defaultSort('asc'),
            
            TextColumn::make('created_at')
                ->sortable()
                ->defaultSort('desc'),
        ])
        ->defaultSort('created_at', 'desc');
}
```

### 3. Export Functionality
```php
public function getTableBulkActions(): array
{
    return [
        Tables\Actions\ExportBulkAction::make()
            ->exportable()
            ->exporter(new MyTableExporter),
    ];
}
```

## Testing Tables

### 1. Table Rendering Test
```php
test('renders table with correct columns', function () {
    Livewire::test(ListUsers::class)
        ->assertSuccessful()
        ->assertSeeText('Name')
        ->assertSeeText('Email');
});
```

### 2. Filter Test
```php
test('table filters work correctly', function () {
    Livewire::test(ListUsers::class)
        ->filterTable('status', 'active')
        ->assertSee('John Doe')
        ->assertDontSee('Jane Smith');
});
```

### 3. Action Test
```php
test('table actions are visible based on permissions', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $record = Post::factory()->create();
    
    Livewire::actingAs($user)
        ->test(ListPosts::class)
        ->assertTableActionExists('edit')
        ->assertTableActionExists('delete');
});
```