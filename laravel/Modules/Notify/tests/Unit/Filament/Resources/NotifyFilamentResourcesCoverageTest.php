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
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\View;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Modules\Notify\Filament\Resources\ContactResource;
use Modules\Notify\Filament\Resources\ContactResource\Pages\EditContact;
use Modules\Notify\Filament\Resources\ContactResource\Pages\ListContacts;
use Modules\Notify\Filament\Resources\MailTemplateResource;
use Modules\Notify\Filament\Resources\MailTemplateResource\Pages\ListMailTemplates;
use Modules\Notify\Filament\Resources\MailTemplateResource\Pages\PreviewMailTemplate;
use Modules\Notify\Filament\Resources\NotificationResource;
use Modules\Notify\Filament\Resources\NotificationResource\Pages\ListNotifications;
use Modules\Notify\Filament\Resources\NotificationResource\Pages\ViewNotification;
use Modules\Notify\Filament\Resources\NotificationTemplateResource;
use Modules\Notify\Filament\Resources\NotificationTemplateResource\Pages\PreviewNotificationTemplate;
use Modules\Notify\Tests\TestCase;

uses(TestCase::class);

function makeEditContactTestProxy(): EditContact
{
    return new class extends EditContact
    {
        public function exposedHeaderActions(): array
        {
            return $this->getHeaderActions();
        }
    };
}

function makePreviewMailTemplateTestProxy(): PreviewMailTemplate
{
    return new class extends PreviewMailTemplate
    {
        public function exposedHeaderActions(): array
        {
            return $this->getHeaderActions();
        }
    };
}

function makeViewNotificationTestProxy(): ViewNotification
{
    return new class extends ViewNotification
    {
        public function exposedInfolistSchema(): array
        {
            return $this->getInfolistSchema();
        }
    };
}

function makePreviewNotificationTemplateTestProxy(): PreviewNotificationTemplate
{
    return new class extends PreviewNotificationTemplate {};
}

test('contact resource form schema exposes expected fields', function (): void {
    $schema = ContactResource::getFormSchema();

    expect($schema)->toBeArray()
        ->and($schema)->toHaveKey('name')
        ->and($schema)->toHaveKey('email')
        ->and($schema)->toHaveKey('phone');
});

test('edit contact page exposes delete header action', function (): void {
    $page = makeEditContactTestProxy();
    $actions = $page->exposedHeaderActions();

    expect($actions)->toBeArray()
        ->and($actions)->toHaveKey('delete')
        ->and($actions['delete'])->toBeInstanceOf(DeleteAction::class);
});

test('list contacts page exposes expected table columns and filters', function (): void {
    $page = new ListContacts;

    $columns = $page->getTableColumns();
    $filters = $page->getTableFilters();

    expect($columns)->toBeArray()
        ->and($columns)->toHaveKey('id')
        ->and($columns['id'])->toBeInstanceOf(TextColumn::class)
        ->and($columns)->toHaveKey('is_read')
        ->and($columns['is_read'])->toBeInstanceOf(IconColumn::class)
        ->and($filters)->toBeArray()
        ->and($filters)->toHaveKey('active')
        ->and($filters['active'])->toBeInstanceOf(Filter::class)
        ->and($filters)->toHaveKey('inactive')
        ->and($filters['inactive'])->toBeInstanceOf(Filter::class);
});

test('list mail templates page exposes expected table columns', function (): void {
    $page = new ListMailTemplates;
    $columns = $page->getTableColumns();

    expect($columns)->toBeArray()
        ->and($columns)->toHaveKey('slug')
        ->and($columns['slug'])->toBeInstanceOf(TextColumn::class)
        ->and($columns)->toHaveKey('subject')
        ->and($columns['subject'])->toBeInstanceOf(TextColumn::class)
        ->and($columns)->toHaveKey('counter')
        ->and($columns['counter'])->toBeInstanceOf(TextColumn::class);
});

test('preview mail template page title and header actions are configured', function (): void {
    $page = makePreviewMailTemplateTestProxy();
    $actions = $page->exposedHeaderActions();

    expect($page->getTitle())->toBeString()
        ->and($actions)->toBeArray()
        ->and($actions)->toHaveCount(1)
        ->and($actions[0])->toBeInstanceOf(Action::class);
});

test('list notifications page exposes expected columns and filters', function (): void {
    $page = new ListNotifications;

    $columns = $page->getTableColumns();
    $filters = $page->getTableFilters();

    expect($columns)->toBeArray()
        ->and($columns)->toHaveKey('id')
        ->and($columns['id'])->toBeInstanceOf(TextColumn::class)
        ->and($columns)->toHaveKey('type')
        ->and($columns['type'])->toBeInstanceOf(TextColumn::class)
        ->and($filters)->toBeArray()
        ->and($filters)->toHaveKey('read')
        ->and($filters['read'])->toBeInstanceOf(Filter::class)
        ->and($filters)->toHaveKey('unread')
        ->and($filters['unread'])->toBeInstanceOf(Filter::class)
        ->and($filters)->toHaveKey('type')
        ->and($filters['type'])->toBeInstanceOf(SelectFilter::class);
});

test('view notification page infolist schema contains section with text entries', function (): void {
    $page = makeViewNotificationTestProxy();
    $schema = $page->exposedInfolistSchema();

    expect($schema)->toBeArray()
        ->and($schema[0])->toBeInstanceOf(Section::class);

    $reflection = new \ReflectionClass($schema[0]);
    $prop = $reflection->getProperty('childComponents');
    $prop->setAccessible(true);
    $components = $prop->getValue($schema[0]);
    expect($components)->toBeArray()
        ->and($components)->not->toBeEmpty();
});

test('mail template resource form schema exposes expected components', function (): void {
    $mailLayoutsPath = base_path('Themes/Meetup/resources/mail-layouts');
    if (! is_dir($mailLayoutsPath)) {
        mkdir($mailLayoutsPath, 0777, true);
    }
    $fixture = $mailLayoutsPath.'/test-layout.html';
    if (! file_exists($fixture)) {
        file_put_contents($fixture, '<html><body>layout</body></html>');
    }

    $schema = MailTemplateResource::getFormSchema();

    expect($schema)->toBeArray()
        ->and($schema)->toHaveKey('mailable_slug_group')
        ->and($schema['mailable_slug_group'])->toBeInstanceOf(\Filament\Schemas\Components\Group::class)
        ->and($schema)->toHaveKey('subject')
        ->and($schema['subject'])->toBeInstanceOf(TextInput::class)
        ->and($schema)->toHaveKey('html_layout_path')
        ->and($schema)->toHaveKey('html_template')
        ->and($schema['html_template'])->toBeInstanceOf(RichEditor::class)
        ->and($schema)->toHaveKey('params_display')
        ->and($schema['params_display'])->toBeInstanceOf(View::class)
        ->and($schema)->toHaveKey('text_template')
        ->and($schema['text_template'])->toBeInstanceOf(Textarea::class);
});

test('notification resource form schema exposes expected components', function (): void {
    $schema = NotificationResource::getFormSchema();

    expect($schema)->toBeArray()
        ->and($schema)->toHaveKey('type')
        ->and($schema['type'])->toBeInstanceOf(TextInput::class)
        ->and($schema)->toHaveKey('data')
        ->and($schema['data'])->toBeInstanceOf(Textarea::class)
        ->and($schema)->toHaveKey('read_at')
        ->and($schema['read_at'])->toBeInstanceOf(DateTimePicker::class);
});

test('notification template resource form schema and pages are configured', function (): void {
    $schema = NotificationTemplateResource::getFormSchema();
    $pages = NotificationTemplateResource::getPages();

    expect($schema)->toBeArray()
        ->and($schema)->toHaveKey('name')
        ->and($schema['name'])->toBeInstanceOf(TextInput::class)
        ->and($schema)->toHaveKey('type')
        ->and($schema['type'])->toBeInstanceOf(Select::class)
        ->and($schema)->toHaveKey('attachments')
        ->and($schema['attachments'])->toBeInstanceOf(SpatieMediaLibraryFileUpload::class)
        ->and($pages)->toBeArray()
        ->and($pages)->toHaveKey('preview');
});

test('preview notification template page exposes title and subheading', function (): void {
    $page = makePreviewNotificationTemplateTestProxy();

    expect($page->getTitle())->toBeString()
        ->and($page->getSubheading())->toBeString();
});
