<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Filament\Resources;

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
use Modules\Notify\Filament\Resources\NotifyThemeResource\Pages\ListNotifyThemes;
use Modules\Notify\Tests\Fixtures\EditNotifyThemeTestProxy;
use Modules\Notify\Filament\Resources\NotifyThemeResource\RelationManagers\LinkableRelationManager;
use Modules\Notify\Filament\Tables\Columns\ContactColumn;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(\Modules\Notify\Tests\TestCase::class);

function makeEditNotifyThemeTestProxy(): EditNotifyThemeTestProxy
{
    return new EditNotifyThemeTestProxy();
}

test('list notification templates page returns empty table columns array', function (): void {
    $page = new ListNotificationTemplates;
    $columns = $page->getTableColumns();
    Assert::assertSame([], $columns);
});

test('notify theme resource field options are configured', function (): void {
    Assert::assertArrayHasKey('it', NotifyThemeResource::fieldOptions('lang'));
    Assert::assertArrayHasKey('email', NotifyThemeResource::fieldOptions('type'));
    Assert::assertArrayHasKey('page', NotifyThemeResource::fieldOptions('post_type'));
});

test('notify theme resource form schema exposes expected components', function (): void {
    $schema = NotifyThemeResource::getFormSchema();
    Assert::assertArrayHasKey('post_id', $schema);
    Assert::assertInstanceOf(TextInput::class, $schema['post_id']);
    Assert::assertArrayHasKey('logo', $schema);
    Assert::assertInstanceOf(SpatieMediaLibraryFileUpload::class, $schema['logo']);
    Assert::assertArrayHasKey('body', $schema);
    Assert::assertInstanceOf(Textarea::class, $schema['body']);
    Assert::assertArrayHasKey('body_html', $schema);
    Assert::assertInstanceOf(RichEditor::class, $schema['body_html']);
    Assert::assertArrayHasKey('lang', $schema);
    Assert::assertInstanceOf(Select::class, $schema['lang']);
});

test('edit notify theme page exposes delete header action', function (): void {
    $page = makeEditNotifyThemeTestProxy();
    $actions = $page->exposedHeaderActions();

    Assert::assertArrayHasKey('delete', $actions);
    Assert::assertInstanceOf(DeleteAction::class, $actions['delete']);
});

test('list notify themes columns and filters are configured', function (): void {
    $columns = ListNotifyThemes::getNotifyThemeTableColumns();
    $page = new ListNotifyThemes;
    $filters = $page->getTableFilters();
    Assert::assertArrayHasKey('id', $columns);
    Assert::assertInstanceOf(TextColumn::class, $columns['id']);
    Assert::assertArrayHasKey('lang', $columns);
    Assert::assertArrayHasKey('type', $columns);
    Assert::assertArrayHasKey('post_type', $columns);
    Assert::assertArrayHasKey('lang', $filters);
    Assert::assertInstanceOf(SelectFilter::class, $filters['lang']);
    Assert::assertArrayHasKey('post_type', $filters);
    Assert::assertInstanceOf(SelectFilter::class, $filters['post_type']);
    Assert::assertArrayHasKey('type', $filters);
    Assert::assertInstanceOf(SelectFilter::class, $filters['type']);
});

test('linkable relation manager exposes text input form schema', function (): void {
    $manager = new LinkableRelationManager;
    $schema = $manager->getFormSchema();
    Assert::assertNotEmpty($schema);
    Assert::assertInstanceOf(TextInput::class, $schema[0]);
});

test('contact column is a view column with expected name', function (): void {
    $column = ContactColumn::make('contact');

    Assert::assertInstanceOf(ViewColumn::class, $column);
    Assert::assertSame('contact', $column->getName());
});
