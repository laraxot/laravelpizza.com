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
use Modules\Notify\Filament\Resources\NotificationTemplateResource\Pages\ListNotificationTemplates;
use Modules\Notify\Filament\Resources\NotifyThemeResource;
use Modules\Notify\Filament\Resources\NotifyThemeResource\RelationManagers\LinkableRelationManager;
use Modules\Notify\Filament\Resources\NotifyThemeResource\Schemas\NotifyThemeForm;
use Modules\Notify\Filament\Resources\NotifyThemeResource\Tables\NotifyThemesTable;
use Modules\Notify\Filament\Tables\Columns\ContactColumn;
use Modules\Notify\Tests\Fixtures\EditNotifyThemeTestProxy;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
function makeEditNotifyThemeTestProxy(): EditNotifyThemeTestProxy
{
    return new EditNotifyThemeTestProxy;
}

test('list notification templates page returns empty table columns array', function (): void {
    $reflection = new \ReflectionMethod(ListNotificationTemplates::class, 'getTableColumns');
    $columns = $reflection->invoke(new ListNotificationTemplates);
    Assert::assertSame([], $columns);
});

test('notify theme resource field options are configured', function (): void {
    Assert::assertArrayHasKey('it', NotifyThemeResource::fieldOptions('lang'));
    Assert::assertArrayHasKey('email', NotifyThemeResource::fieldOptions('type'));
    Assert::assertArrayHasKey('page', NotifyThemeResource::fieldOptions('post_type'));
});

test('notify theme resource form schema exposes expected components', function (): void {
    $schema = app(NotifyThemeForm::class)->getFormSchema();
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

test('list notify themes columns are configured', function (): void {
    $columns = app(NotifyThemesTable::class)->getTableColumns();
    Assert::assertArrayHasKey('id', $columns);
    Assert::assertInstanceOf(TextColumn::class, $columns['id']);
    Assert::assertArrayHasKey('lang', $columns);
    Assert::assertArrayHasKey('type', $columns);
    Assert::assertArrayHasKey('post_type', $columns);
});

test('linkable relation manager exposes text input form schema', function (): void {
    $manager = new LinkableRelationManager;
    $schema = $manager->getFormSchema();
    Assert::assertNotEmpty($schema);
    Assert::assertInstanceOf(TextInput::class, $schema[0]);
});

test('contact column is a view column with expected name', function (): void {
    $column = ContactColumn::make('contact');

    Assert::assertSame('contact', $column->getName());
});