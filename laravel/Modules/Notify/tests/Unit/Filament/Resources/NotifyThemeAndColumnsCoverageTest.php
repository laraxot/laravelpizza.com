<?php

declare(strict_types=1);

use Filament\Actions\DeleteAction;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Filters\SelectFilter;
use Modules\Notify\Filament\Resources\NotificationTemplateResource\Pages\ListNotificationTemplates;
use Modules\Notify\Filament\Resources\NotifyThemeResource;
use Modules\Notify\Filament\Resources\NotifyThemeResource\Pages\EditNotifyTheme;
use Modules\Notify\Filament\Resources\NotifyThemeResource\Pages\ListNotifyThemes;
use Modules\Notify\Filament\Resources\NotifyThemeResource\RelationManagers\LinkableRelationManager;
use Modules\Notify\Filament\Tables\Columns\ContactColumn;
use Modules\Notify\Tests\TestCase;

uses(TestCase::class);

class EditNotifyThemeTestProxy extends EditNotifyTheme
{
    public function exposedHeaderActions(): array
    {
        return // @var mixed getHeaderActions(;
    }
}

test('list notification templates page returns empty table columns array', function (): void {
    $page = new ListNotificationTemplates;

    expect($page->getTableColumns())->toBeArray()
        ->and($page->getTableColumns())->toBe([]);
});

test('notify theme resource field options are configured', function (): void {
    expect(NotifyThemeResource::fieldOptions('lang'))->toBe([
        'it' => 'Italiano',
        'en' => 'English',
    ])->and(NotifyThemeResource::fieldOptions('type'))->toBe([
        'email' => 'Email',
        'sms' => 'SMS',
        'push' => 'Push Notification',
    ])->and(NotifyThemeResource::fieldOptions('post_type'))->toBe([
        'page' => 'Page',
        'post' => 'Post',
        'product' => 'Product',
    ])->and(NotifyThemeResource::fieldOptions('unknown'))->toBe([]);
});

test('notify theme resource form schema exposes expected components', function (): void {
    $schema = NotifyThemeResource::getFormSchema();

    expect($schema)->toBeArray()
        ->and($schema)->toHaveKey('lang')
        ->and($schema['lang'])->toBeInstanceOf(Select::class)
        ->and($schema)->toHaveKey('post_id')
        ->and($schema['post_id'])->toBeInstanceOf(TextInput::class)
        ->and($schema)->toHaveKey('logo')
        ->and($schema['logo'])->toBeInstanceOf(SpatieMediaLibraryFileUpload::class)
        ->and($schema)->toHaveKey('body')
        ->and($schema['body'])->toBeInstanceOf(Textarea::class)
        ->and($schema)->toHaveKey('body_html')
        ->and($schema['body_html'])->toBeInstanceOf(RichEditor::class);
});

test('edit notify theme page exposes delete header action', function (): void {
    $page = new EditNotifyThemeTestProxy;
    $actions = $page->exposedHeaderActions();

    expect($actions)->toBeArray()
        ->and($actions)->toHaveKey('delete')
        ->and($actions['delete'])->toBeInstanceOf(DeleteAction::class);
});

test('list notify themes columns and filters are configured', function (): void {
    $columns = ListNotifyThemes::getNotifyThemeTableColumns();
    $page = new ListNotifyThemes;
    $filters = $page->getTableFilters();

    expect($columns)->toBeArray()
        ->and($columns)->toHaveKey('id')
        ->and($columns['id'])->toBeInstanceOf(TextColumn::class)
        ->and($columns)->toHaveKey('lang')
        ->and($columns)->toHaveKey('type')
        ->and($columns)->toHaveKey('post_type')
        ->and($filters)->toBeArray()
        ->and($filters)->toHaveKey('lang')
        ->and($filters['lang'])->toBeInstanceOf(SelectFilter::class)
        ->and($filters)->toHaveKey('post_type')
        ->and($filters['post_type'])->toBeInstanceOf(SelectFilter::class)
        ->and($filters)->toHaveKey('type')
        ->and($filters['type'])->toBeInstanceOf(SelectFilter::class);
});

test('linkable relation manager exposes text input form schema', function (): void {
    $manager = new LinkableRelationManager;
    $schema = $manager->getFormSchema();

    expect($schema)->toBeArray()
        ->and($schema[0])->toBeInstanceOf(TextInput::class);
});

test('contact column is a view column with expected name', function (): void {
    $column = ContactColumn::make('contact');

    expect($column)->toBeInstanceOf(ViewColumn::class)
        ->and($column->getName())->toBe('contact');
});
