<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Filament\Resources;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Modules\Notify\Filament\Resources\ContactResource\Schemas\ContactForm;
use Modules\Notify\Filament\Resources\ContactResource\Tables\ContactsTable;
use Modules\Notify\Filament\Resources\MailTemplateResource\Schemas\MailTemplateForm;
use Modules\Notify\Filament\Resources\MailTemplateResource\Tables\MailTemplatesTable;
use Modules\Notify\Filament\Resources\NotificationLogResource;
use Modules\Notify\Filament\Resources\NotificationLogResource\Schemas\NotificationLogForm;
use Modules\Notify\Filament\Resources\NotificationLogResource\Schemas\NotificationLogInfolist;
use Modules\Notify\Filament\Resources\NotificationLogResource\Tables\NotificationLogsTable;
use Modules\Notify\Filament\Resources\NotificationResource\Schemas\NotificationForm;
use Modules\Notify\Filament\Resources\NotificationResource\Schemas\NotificationInfolist;
use Modules\Notify\Filament\Resources\NotificationResource\Tables\NotificationsTable;
use Modules\Notify\Filament\Resources\NotificationTemplateResource;
use Modules\Notify\Filament\Resources\NotificationTemplateResource\Pages\PreviewNotificationTemplate;
use Modules\Notify\Filament\Resources\NotificationTemplateResource\Schemas\NotificationTemplateForm;
use Modules\Notify\Tests\Fixtures\EditContactTestProxy;
use Modules\Notify\Tests\Fixtures\PreviewMailTemplateTestProxy;
use Modules\Notify\Tests\TestCase;
use Modules\Xot\Tests\XotBasePest;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
function makeEditContactTestProxy(): EditContactTestProxy
{
    return new EditContactTestProxy;
}

function makePreviewMailTemplateTestProxy(): PreviewMailTemplateTestProxy
{
    return new PreviewMailTemplateTestProxy;
}

function makePreviewNotificationTemplateTestProxy(): PreviewNotificationTemplate
{
    return new class extends PreviewNotificationTemplate {};
}

test('contact resource form schema exposes expected fields', function (): void {
    $schema = TestCase::assertNotifyArray(app(ContactForm::class)->getFormSchema());

    Assert::assertArrayHasKey('name', $schema);
    Assert::assertArrayHasKey('email', $schema);
    Assert::assertArrayHasKey('phone', $schema);
});

test('edit contact page exposes delete header action', function (): void {
    $page = makeEditContactTestProxy();
    $actions = XotBasePest::assertArray($page->exposedHeaderActions());

    Assert::assertArrayHasKey('delete', $actions);
    Assert::assertInstanceOf(DeleteAction::class, $actions['delete']);
});

test('list contacts page exposes expected table columns', function (): void {
    $columns = XotBasePest::assertArray(ContactsTable::contactTableColumns());

    Assert::assertArrayHasKey('id', $columns);
    Assert::assertInstanceOf(TextColumn::class, $columns['id']);
    Assert::assertArrayHasKey('is_read', $columns);
    Assert::assertInstanceOf(IconColumn::class, $columns['is_read']);
});

test('list mail templates page exposes expected table columns', function (): void {
    $columns = XotBasePest::assertArray(MailTemplatesTable::mailTemplateTableColumns());

    Assert::assertArrayHasKey('slug', $columns);
    Assert::assertInstanceOf(TextColumn::class, $columns['slug']);
    Assert::assertArrayHasKey('subject', $columns);
    Assert::assertInstanceOf(TextColumn::class, $columns['subject']);
    Assert::assertArrayHasKey('counter', $columns);
    Assert::assertInstanceOf(TextColumn::class, $columns['counter']);
});

test('preview mail template page title and header actions are configured', function (): void {
    $page = makePreviewMailTemplateTestProxy();
    $actions = $page->exposedHeaderActions();

    $actions = array_values(XotBasePest::assertArray($actions));
    Assert::assertCount(1, $actions);
    Assert::assertInstanceOf(Action::class, $actions[0]);
});

test('list notifications page exposes expected columns and filters', function (): void {
    $columns = XotBasePest::assertArray(app(NotificationsTable::class)->getTableColumns());
    $filters = XotBasePest::assertArray(app(NotificationsTable::class)->getTableFilters());

    Assert::assertArrayHasKey('id', $columns);
    Assert::assertInstanceOf(TextColumn::class, $columns['id']);
    Assert::assertArrayHasKey('type', $columns);
    Assert::assertInstanceOf(TextColumn::class, $columns['type']);
    Assert::assertArrayHasKey('read', $filters);
    Assert::assertInstanceOf(Filter::class, $filters['read']);
    Assert::assertArrayHasKey('unread', $filters);
    Assert::assertInstanceOf(Filter::class, $filters['unread']);
    Assert::assertArrayHasKey('type', $filters);
    Assert::assertInstanceOf(SelectFilter::class, $filters['type']);
});

test('notification resource infolist schema exposes expected text entries', function (): void {
    $schema = app(NotificationInfolist::class)->getInfolistSchema();

    Assert::assertArrayHasKey('id', $schema);
    Assert::assertArrayHasKey('type', $schema);
    Assert::assertArrayHasKey('read_at', $schema);
    Assert::assertGreaterThanOrEqual(1, count($schema));
});

test('mail template resource form schema exposes expected components', function (): void {
    // Nessuna fixture da creare: HtmlLayoutPathSelect legge
    // XotData::make()->getMailHtmlLayoutPath(), cioe' Themes/<pub_theme>/resources/mail-layouts,
    // e in questo progetto pub_theme e' 'Zero', che i suoi layout ce li ha gia'.
    $schema = XotBasePest::assertArray(app(MailTemplateForm::class)->getFormSchema());

    Assert::assertArrayHasKey('mailable_slug_group', $schema);
    Assert::assertInstanceOf(Group::class, $schema['mailable_slug_group']);
    Assert::assertArrayHasKey('subject', $schema);
    Assert::assertInstanceOf(TextInput::class, $schema['subject']);
    Assert::assertArrayHasKey('html_layout_path', $schema);
    Assert::assertArrayHasKey('html_template', $schema);
    Assert::assertInstanceOf(RichEditor::class, $schema['html_template']);
    Assert::assertArrayHasKey('params_display', $schema);
    Assert::assertArrayHasKey('text_template', $schema);
    Assert::assertInstanceOf(Textarea::class, $schema['text_template']);
});

test('notification resource form schema exposes expected components', function (): void {
    $schema = TestCase::assertNotifyArray(app(NotificationForm::class)->getFormSchema());

    Assert::assertArrayHasKey('type', $schema);
    Assert::assertInstanceOf(TextInput::class, $schema['type']);
    Assert::assertArrayHasKey('data', $schema);
    Assert::assertInstanceOf(Textarea::class, $schema['data']);
    Assert::assertArrayHasKey('read_at', $schema);
    Assert::assertInstanceOf(DateTimePicker::class, $schema['read_at']);
});

test('notification template resource form schema and pages are configured', function (): void {
    $schema = TestCase::assertNotifyArray(app(NotificationTemplateForm::class)->getFormSchema());
    $pages = TestCase::assertNotifyArray(NotificationTemplateResource::getPages());

    Assert::assertArrayHasKey('name', $schema);
    Assert::assertInstanceOf(TextInput::class, $schema['name']);
    Assert::assertArrayHasKey('type', $schema);
    Assert::assertInstanceOf(Select::class, $schema['type']);
    Assert::assertArrayHasKey('attachments', $schema);
    Assert::assertInstanceOf(SpatieMediaLibraryFileUpload::class, $schema['attachments']);
    Assert::assertArrayHasKey('preview', $pages);
});

test('preview notification template page exposes title and subheading', function (): void {
    $page = makePreviewNotificationTemplateTestProxy();

    Assert::assertNotSame('', $page->getTitle());
    Assert::assertNotSame('', $page->getSubheading());
});

test('notification log resource pages resolve index create edit and view', function (): void {
    $pages = TestCase::assertNotifyArray(NotificationLogResource::getPages());

    Assert::assertArrayHasKey('index', $pages);
    Assert::assertArrayHasKey('create', $pages);
    Assert::assertArrayHasKey('edit', $pages);
    // 'view' e' registrata solo se ViewNotificationLog esiste (XotBaseResource::getPages()).
    Assert::assertArrayHasKey('view', $pages);
});

test('notification log form schema exposes channel and status as enum backed selects', function (): void {
    $schema = TestCase::assertNotifyArray(app(NotificationLogForm::class)->getFormSchema());

    Assert::assertArrayHasKey('channel', $schema);
    Assert::assertInstanceOf(Select::class, $schema['channel']);
    Assert::assertArrayHasKey('status', $schema);
    Assert::assertInstanceOf(Select::class, $schema['status']);
    Assert::assertArrayHasKey('status_message', $schema);
    Assert::assertInstanceOf(Textarea::class, $schema['status_message']);
});

test('notification log infolist schema exposes expected entries', function (): void {
    $schema = app(NotificationLogInfolist::class)->getInfolistSchema();

    Assert::assertArrayHasKey('channel', $schema);
    Assert::assertArrayHasKey('status', $schema);
    Assert::assertArrayHasKey('notifiable_type', $schema);
    Assert::assertArrayHasKey('sent_at', $schema);
    Assert::assertGreaterThanOrEqual(1, count($schema));
});

test('notification log table columns match the notification_logs schema', function (): void {
    $columns = TestCase::assertNotifyArray(app(NotificationLogsTable::class)->getTableColumns());

    Assert::assertArrayHasKey('channel', $columns);
    Assert::assertInstanceOf(TextColumn::class, $columns['channel']);
    Assert::assertArrayHasKey('status', $columns);
    Assert::assertArrayHasKey('notifiable_type', $columns);
    Assert::assertArrayHasKey('sent_at', $columns);
});