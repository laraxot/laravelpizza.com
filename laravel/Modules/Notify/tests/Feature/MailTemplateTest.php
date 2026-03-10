<?php

declare(strict_types=1);

<<<<<<< HEAD
namespace Modules\Notify\Tests\Feature;

=======
>>>>>>> 8e583cd (.)
uses(\Modules\Notify\Tests\TestCase::class);

use Modules\Notify\Models\MailTemplate;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

describe('MailTemplate Model Tests', function () {
    it('can create a mail template', function () {
        $template = MailTemplate::create([
            'name' => 'Test Template',
            'mailable' => 'App\Mail\TestMail',
            'slug' => 'test-template',
            'subject' => ['en' => 'Test Subject'],
            'html_template' => ['en' => '<h1>Test HTML</h1>'],
            'text_template' => ['en' => 'Test Text'],
        ]);

        expect($template)
            ->toBeInstanceOf(MailTemplate::class)
            ->and($template->name)
            ->toBe('Test Template');

        assertDatabaseHas('mail_templates', [
            'id' => $template->id,
            'name' => 'Test Template',
            'slug' => $template->slug,
        ]);
    });

    it('can update a mail template', function () {
        $template = MailTemplate::create([
            'name' => 'Test Template 2',
            'mailable' => 'App\Mail\TestMail2',
            'slug' => 'test-template-2',
            'subject' => ['en' => 'Test Subject 2'],
            'html_template' => ['en' => '<h1>Test HTML 2</h1>'],
        ]);

        $template->update(['name' => 'Updated Template']);

        expect($template->fresh()->name)->toBe('Updated Template');
    });

    it('can delete a mail template', function () {
        $template = MailTemplate::create([
            'name' => 'Delete Me',
            'mailable' => 'App\Mail\DeleteMail',
            'slug' => 'delete-me',
            'subject' => ['en' => 'Delete Subject'],
            'html_template' => ['en' => '<h1>Delete HTML</h1>'],
        ]);

        $templateId = $template->id;
        $template->delete();

        assertDatabaseMissing('mail_templates', [
            'id' => $templateId,
        ]);
    });
});
