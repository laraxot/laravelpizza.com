<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Feature;

use Modules\Notify\Database\Factories\MailTemplateFactory;
use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;




uses(\Modules\Notify\Tests\TestCase::class);

describe('MailTemplate Model Tests', function () {
    it('can create a mail template', function () {
        $template = MailTemplateFactory::new()->createOne([
            'name' => 'Test Template',
            'mailable' => 'App\Mail\TestMail',
            'slug' => 'test-template',
            'subject' => ['en' => 'Test Subject'],
            'html_template' => ['en' => '<h1>Test HTML</h1>'],
            'text_template' => ['en' => 'Test Text'],
        ]);

        Assert::assertInstanceOf(MailTemplate::class, $template);

        Assert::assertSame('Test Template', $template->name);

        \assertNotifyTableHas('mail_templates', [
            'id' => $template->id,
            'name' => 'Test Template',
            'slug' => $template->slug,
        ]);
    });

    it('can update a mail template', function () {
        $template = MailTemplateFactory::new()->createOne([
            'name' => 'Test Template 2',
            'mailable' => 'App\Mail\TestMail2',
            'slug' => 'test-template-2',
            'subject' => ['en' => 'Test Subject 2'],
            'html_template' => ['en' => '<h1>Test HTML 2</h1>'],
        ]);

        $template->update(['name' => 'Updated Template']);

        Assert::assertSame('Updated Template', \assertFreshModel($template, MailTemplate::class)->name);
    });

    it('can delete a mail template', function () {
        $template = MailTemplateFactory::new()->createOne([
            'name' => 'Delete Me',
            'mailable' => 'App\Mail\DeleteMail',
            'slug' => 'delete-me',
            'subject' => ['en' => 'Delete Subject'],
            'html_template' => ['en' => '<h1>Delete HTML</h1>'],
        ]);

        $templateId = $template->id;
        $template->delete();

        \assertNotifyTableMissing('mail_templates', [
            'id' => $templateId,
        ]);
    });
});
