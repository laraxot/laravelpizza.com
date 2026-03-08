<?php

declare(strict_types=1);

use Filament\Forms\Components\TextInput;
use Modules\Notify\Filament\Forms\Components\ChannelCheckboxList;
use Modules\Notify\Filament\Forms\Components\ContactSection;
use Modules\Notify\Filament\Forms\Components\HtmlLayoutPathSelect;
use Modules\Notify\Filament\Forms\Components\MailTemplateSelect;
use Modules\Notify\Tests\TestCase;

uses(TestCase::class);

class ContactSectionTestProxy extends ContactSection
{
    public function exposedFormSchema(): array
    {
        return // @var mixed getFormSchema(;
    }
}

test('channel checkbox list and selects have expected default names', function () {
    $channels = ChannelCheckboxList::make();
    $mailTemplate = MailTemplateSelect::make();

    expect($channels->getName())->toBe('channels')
        ->and($mailTemplate->getName())->toBe('mail_template_slug');
});

test('html layout path select exposes expected default name via method signature', function () {
    $reflection = new ReflectionMethod(HtmlLayoutPathSelect::class, 'make');
    $params = $reflection->getParameters();

    expect($params)->toHaveCount(1)
        ->and($params[0]->getName())->toBe('name');
});

test('contact section returns text inputs schema from enum', function () {
    $proxy = new ContactSectionTestProxy();
    $schema = $proxy->exposedFormSchema();

    expect($schema)->toBeArray();

    foreach ($schema as $component) {
        expect($component)->toBeInstanceOf(TextInput::class);
    }
});
