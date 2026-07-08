# Filament v4 Actions Migration Guide

## Breaking Changes

### 1. Import Changes
Some action classes have moved.

**Before v3:**
```php
use Filament\Tables\Actions\Action as FilamentAction;
use Filament\Tables\Actions\BulkAction;
```

**After v4:**
```php
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
```

### 2. Action Naming
Action names should be descriptive and use kebab-case.

## Action Types

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

### 2. Bulk Actions
```php
public function getTableBulkActions(): array
{
    return [
        Tables\Actions\DeleteBulkAction::make(),
        Tables\Actions\BulkActionGroup::make([
            Tables\Actions\BulkAction::make('publish')
                ->label('Publish'),
                ->action('publish'),
                ->icon('heroicon-o-document-arrow-up'),
                ->color('success'),
            ]),
            Tables\Actions\BulkAction::make('unpublish')
                ->label('Unpublish')
                ->action('unpublish')
                ->icon('heroicon-o-document-x-mark')
                ->color('danger'),
        ]),
    ];
}
```

### 3. Header Actions
```php
protected function getHeaderActions(): array
{
    return [
        Actions\Action::make('export')
            ->label('Export')
            ->icon('heroicon-o-arrow-down-tray')
            ->action('export')
            ->color('primary'),
    ];
}
```

### 4. Form Actions
```php
protected function getFormActions(): array
{
    return [
        Actions\Action::make('save')
            ->label('Save')
            ->action('save')
            ->color('primary'),
    ];
}
```

## Custom Actions

### 1. Simple Action
```php
public function getTableActions(): array
{
    return [
        Tables\Actions\Action::make('approve')
            ->label('Approve')
            ->icon('heroicon-o-check')
            ->color('success')
            ->action('approve')
            ->requiresConfirmation()
            ->visible(fn ($record): bool => $record->canApprove()),
    ];
}
```

### 2. Action with Custom Logic
```php
public function getTableActions(): array
{
    return [
        Tables\Actions\Action::make('send_notification')
            ->label('Send Notification')
            ->icon('heroicon-o-bell')
            ->action(function ($record) {
                $record->notifyUser();
                Notification::make('Notification sent successfully');
            })
            ->visible(fn ($record): bool => $record->hasNotificationPermission()),
    ];
}
```

### 3. Action with Modal
```php
public function getTableActions(): array
    {
        return [
            Tables\Actions\Action::make('details')
                ->label('View Details')
                ->modalContent(fn ($record): View/ViewDetails.blade.php)
                ->visible(fn ($record): bool => $record->hasDetails()),
        ];
    }
```

## Action Configuration

### 1. Color Configuration
```php
Tables\Actions\Action::make('delete')
    ->color('danger')
    ->icon('heroicon-o-trash'),
```

### 2. Icon Configuration
```php
Tables\Actions\Action::make('edit')
    ->icon('heroicon-o-pencil')
    ->label('Edit')
```

### 3. Confirmation Dialog
```php
Tables\Actions\DeleteAction::make()
    ->requiresConfirmation()
    ->modalDescription('Are you sure you want to delete this item?'),
```

### 4. Disabled State
```php
Tables\Actions\Action::make('edit')
    ->disabled(fn ($record): bool => ! $record->canEdit()),
```

## Action Groups

### 1. Bulk Action Group
```php
public function getTableBulkActions(): array
{
    return [
        Tables\Actions\BulkActionGroup::make([
            Tables\Actions\BulkAction::make('activate')
                ->label('Activate')
                ->action('activate'),
                ->icon('heroicon-o-check-circle'),
                ->color('success'),
            ],
            Tables\Actions\BulkAction::make('deactivate')
                ->label('deactivate')
                ->action('deactivate')
                ->icon('heroicon-o-x-circle')
                ->color('warning'),
        ]),
    ];
}
```

### 2. Dropdown Actions
```php
public function getTableActions(): array
{
    return [
        Tables\Actions\ActionGroup::make([
            Tables\Actions\Action::make('edit')
                ->label('Edit'),
            Tables\Actions\Action::make('duplicate')
                ->label('Duplicate'),
            Tables\Actions\Action::make('delete')
                ->label('Delete')
                ->requiresConfirmation(),
        ]),
    ];
}
```

## Action Best Practices

### 1. Permission Checks
```php
Tables\Actions\EditAction::make()
    ->visible(fn ($record): bool => $record->canEdit()),
```

### 2. Loading State
```php
Tables\Actions\Action::make('process')
    ->action('process')
    ->loadingWhen('processing'),
```

### 3. Success Notifications
```php
Tables\Actions\Action::make('save')
    ->successNotification()
    ->after(fn () => $this->success()),
```

### 4. Error Handling
```php
Tables\Actions\Action::make('delete')
    ->failureNotification()
    ->after(fn () => $this->failure()),
```

## Testing Actions

### 1. Action Visibility Test
```php
test('edit action only visible to authorized users', function () {
    $user = User::factory()->create();
    $record = Post::factory()->create();
    
    Livewire::actingAs($user)
        ->test(ListPosts::class)
        ->assertTableActionExists('edit')
        ->call('table')
        ->assertDontSeeTableAction('delete');
    
    $admin = User::factory()->create(['role' => 'admin']);
    
    Livewire::actingAs($admin)
        ->test(ListPosts::class)
        ->assertTableActionExists('delete')
        ->assertTableActionExists('edit');
});
```

### 2. Modal Action Test
```php
test('details action opens modal', function () {
    $record = Post::factory()->create();
    
    Livewire::test(ListPosts::class)
        ->assertTableActionExists('details')
        ->call('getTableAction', 'details', function ($action) {
            $action->assertSee('modal');
        });
})
```

### 3. Bulk Action Test
```php
test('bulk actions work correctly', function () {
    $records = Post::factory()->count(3)->create();
    
    Livewire::test(ListPosts::class)
        ->call('getTableBulkAction', 'activate', function ($action) {
            $action->assertSee('modal');
        })
        ->call('callTableBulkAction', 'activate')
        ->assertNotified('Posts activated successfully');
})
```