<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Models;

use function Safe\json_encode;
use PHPUnit\Framework\Assert;
use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Tests\TestCase;
use Modules\Notify\Database\Factories\MailTemplateFactory;
use function Pest\Laravel\get;

uses(\Modules\Notify\Tests\TestCase::class);

beforeEach(function (): void {
    /** @var \Modules\Notify\Tests\TestCase $this */
$this->disableExceptionHandling();
});

describe('Mail Template', function (): void {
    test('_can_create_mail_template', function (): void {
        /** @var \Modules\Notify\Tests\TestCase $this */
$template = MailTemplateFactory::new()->createOne([
            'mailable' => 'App\Mail\WelcomeMail',
            'name' => 'Welcome Email Template',
            'subject' => 'Benvenuto {{name}}!',
            'html_template' => '<h1>Benvenuto {{name}}!</h1><p>Grazie per esserti registrato.</p>',
            'text_template' => 'Benvenuto {{name}}! Grazie per esserti registrato.',
            'sms_template' => [
                'message' => 'Benvenuto {{name}}! Grazie per esserti registrato.',
                'variables' => ['name'],
            ],
            'params' => ['name', 'email'],
            'counter' => 0,
        ]);
        \assertNotifyTableHas('mail_templates', [
            'id' => $template->id,
            'mailable' => 'App\Mail\WelcomeMail',
            'name' => 'Welcome Email Template',
            'subject' => 'Benvenuto {{name}}!',
            'html_template' => '<h1>Benvenuto {{name}}!</h1><p>Grazie per esserti registrato.</p>',
            'text_template' => 'Benvenuto {{name}}! Grazie per esserti registrato.',
            'params' => json_encode(['name', 'email']),
            'counter' => 0,
        ]);

        Assert::assertInstanceOf(MailTemplate::class, $template);
    });

    test('_has_correct_fillable_fields', function (): void {
$template = new MailTemplate;

        $expectedFillable = [
            'mailable',
            'name',
            'slug',
            'subject',
            'html_template',
            'text_template',
            'sms_template',
            'params',
            'counter',
        ];

        Assert::assertEquals($expectedFillable, $template->getFillable());
    });

    test('_has_correct_casts', function (): void {
$template = new MailTemplate;

        $expectedCasts = [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];

        Assert::assertEquals($expectedCasts, $template->getCasts());
    });

    test('_has_translatable_fields', function (): void {
$template = new MailTemplate;

        $expectedTranslatable = [
            'subject',
            'html_template',
            'text_template',
            'sms_template',
        ];

        Assert::assertEquals($expectedTranslatable, $template->translatable);
    });

    test('_uses_notify_connection', function (): void {
$template = new MailTemplate;

        Assert::assertEquals('notify', $template->getConnectionName());
    });

    test('_generates_slug_from_name', function (): void {
$template = MailTemplateFactory::new()->createOne([
            'mailable' => 'App\Mail\TestMail',
            'name' => 'Test Email Template',
            'subject' => 'Test Subject',
            'html_template' => '<p>Test content</p>',
            'params' => ['test'],
            'counter' => 0,
        ]);

        Assert::assertEquals('test-email-template', $template->slug);
        \assertNotifyTableHas('mail_templates', [
            'id' => $template->id,
            'slug' => 'test-email-template',
        ]);
    });

    test('_can_store_json_params', function (): void {
$params = ['name', 'email', 'company', 'role'];

        $template = MailTemplateFactory::new()->createOne([
            'mailable' => 'App\Mail\ComplexMail',
            'name' => 'Complex Email Template',
            'subject' => 'Test Subject',
            'html_template' => '<p>Test content</p>',
            'params' => $params,
            'counter' => 0,
        ]);
        \assertNotifyTableHas('mail_templates', [
            'id' => $template->id,
            'params' => json_encode($params),
        ]);
        $params = \assertNotifyArray($template->params);
        Assert::assertCount(4, $params);
        Assert::assertContains('name', $params);
        Assert::assertContains('email', $params);
        Assert::assertContains('company', $params);
        Assert::assertContains('role', $params);
    });

    test('_can_store_json_sms_template', function (): void {
$smsTemplate = [
            'message' => 'Benvenuto {{name}}! La tua email è {{email}}',
            'variables' => ['name', 'email'],
            'max_length' => 160,
            'encoding' => 'GSM7',
        ];

        $template = MailTemplateFactory::new()->createOne([
            'mailable' => 'App\Mail\SmsMail',
            'name' => 'SMS Email Template',
            'subject' => 'Test Subject',
            'html_template' => '<p>Test content</p>',
            'sms_template' => $smsTemplate,
            'params' => ['test'],
            'counter' => 0,
        ]);
        \assertNotifyTableHas('mail_templates', [
            'id' => $template->id,
            'sms_template' => json_encode($smsTemplate),
        ]);
        $smsTemplateData = \assertNotifyArray($template->sms_template);
        Assert::assertEquals('Benvenuto {{name}}! La tua email è {{email}}', $smsTemplateData['message']);
        Assert::assertEquals(['name', 'email'], $smsTemplateData['variables']);
        Assert::assertEquals(160, $smsTemplateData['max_length']);
        Assert::assertEquals('GSM7', $smsTemplateData['encoding']);
    });

    test('_can_increment_counter', function (): void {
$template = MailTemplateFactory::new()->createOne([
            'mailable' => 'App\Mail\CounterMail',
            'name' => 'Counter Email Template',
            'subject' => 'Test Subject',
            'html_template' => '<p>Test content</p>',
            'params' => ['test'],
            'counter' => 0,
        ]);

        Assert::assertEquals(0, $template->counter);

        $template->increment('counter');
        Assert::assertEquals(1, \assertFreshModel($template, \Modules\Notify\Models\MailTemplate::class)->counter);

        $template->increment('counter', 5);
        Assert::assertEquals(6, \assertFreshModel($template, \Modules\Notify\Models\MailTemplate::class)->counter);
    });

    test('_can_update_template', function (): void {
$template = MailTemplateFactory::new()->createOne([
            'mailable' => 'App\Mail\UpdateMail',
            'name' => 'Original Name',
            'subject' => 'Original Subject',
            'html_template' => '<p>Original content</p>',
            'params' => ['original'],
            'counter' => 0,
        ]);

        $template->update([
            'name' => 'Updated Name',
            'subject' => 'Updated Subject',
            'html_template' => '<p>Updated content</p>',
            'params' => ['updated'],
        ]);
        \assertNotifyTableHas('mail_templates', [
            'id' => $template->id,
            'name' => 'Updated Name',
            'subject' => 'Updated Subject',
            'html_template' => '<p>Updated content</p>',
            'params' => json_encode(['updated']),
        ]);

        Assert::assertEquals('updated-name', \assertFreshModel($template, \Modules\Notify\Models\MailTemplate::class)->slug);
    });

    test('_can_find_by_mailable_and_slug', function (): void {
$template = MailTemplateFactory::new()->createOne([
            'mailable' => 'App\Mail\FindMail',
            'name' => 'Find Test Template',
            'subject' => 'Test Subject',
            'html_template' => '<p>Test content</p>',
            'params' => ['test'],
            'counter' => 0,
        ]);

        $foundTemplate = MailTemplate::where('mailable', 'App\Mail\FindMail')
            ->where('slug', 'find-test-template')
            ->first();

        Assert::assertNotNull($foundTemplate);
        Assert::assertEquals($template->id, $foundTemplate->id);
        Assert::assertEquals('App\Mail\FindMail', $foundTemplate->mailable);
        Assert::assertEquals('find-test-template', $foundTemplate->slug);
    });

    test('_can_find_by_name', function (): void {
$template = MailTemplateFactory::new()->createOne([
            'mailable' => 'App\Mail\NameMail',
            'name' => 'Name Search Template',
            'subject' => 'Test Subject',
            'html_template' => '<p>Test content</p>',
            'params' => ['test'],
            'counter' => 0,
        ]);

        $foundTemplate = MailTemplate::where('name', 'Name Search Template')->first();

        Assert::assertNotNull($foundTemplate);
        Assert::assertEquals($template->id, $foundTemplate->id);
        Assert::assertEquals('Name Search Template', $foundTemplate->name);
    });

    test('_can_find_by_subject_pattern', function (): void {
$template = MailTemplateFactory::new()->createOne([
            'mailable' => 'App\Mail\PatternMail',
            'name' => 'Pattern Template',
            'subject' => 'Welcome to our platform',
            'html_template' => '<p>Test content</p>',
            'params' => ['test'],
            'counter' => 0,
        ]);

        $foundTemplates = MailTemplate::where('subject', 'like', '%Welcome%')->get();

        Assert::assertCount(1, $foundTemplates);
        Assert::assertEquals('Welcome to our platform', \assertFirstModel($foundTemplates, \Modules\Notify\Models\MailTemplate::class)->subject);
    });

    test('_can_find_by_params', function (): void {
$template = MailTemplateFactory::new()->createOne([
            'mailable' => 'App\Mail\ParamsMail',
            'name' => 'Params Template',
            'subject' => 'Test Subject',
            'html_template' => '<p>Test content</p>',
            'params' => ['name', 'email', 'company'],
            'counter' => 0,
        ]);

        $foundTemplates = MailTemplate::whereJsonContains('params', 'name')->get();

        Assert::assertCount(1, $foundTemplates);
        Assert::assertEquals($template->id, \assertFirstModel($foundTemplates, \Modules\Notify\Models\MailTemplate::class)->id);
        Assert::assertContains('name', \assertNotifyArray(\assertFirstModel($foundTemplates, \Modules\Notify\Models\MailTemplate::class)->params));
    });

    test('_can_find_by_counter_range', function (): void {
MailTemplateFactory::new()->createOne([
            'mailable' => 'App\Mail\LowCounterMail',
            'name' => 'Low Counter Template',
            'subject' => 'Test Subject',
            'html_template' => '<p>Test content</p>',
            'params' => ['test'],
            'counter' => 5,
        ]);

        MailTemplateFactory::new()->createOne([
            'mailable' => 'App\Mail\HighCounterMail',
            'name' => 'High Counter Template',
            'subject' => 'Test Subject',
            'html_template' => '<p>Test content</p>',
            'params' => ['test'],
            'counter' => 50,
        ]);

        $lowCounterTemplates = MailTemplate::where('counter', '<=', 10)->get();
        $highCounterTemplates = MailTemplate::where('counter', '>=', 25)->get();

        Assert::assertCount(1, $lowCounterTemplates);
        Assert::assertCount(1, $highCounterTemplates);
        Assert::assertEquals(5, \assertFirstModel($lowCounterTemplates, \Modules\Notify\Models\MailTemplate::class)->counter);
        Assert::assertEquals(50, \assertFirstModel($highCounterTemplates, \Modules\Notify\Models\MailTemplate::class)->counter);
    });

    test('_can_handle_empty_params', function (): void {
$template = MailTemplateFactory::new()->createOne([
            'mailable' => 'App\Mail\EmptyParamsMail',
            'name' => 'Empty Params Template',
            'subject' => 'Test Subject',
            'html_template' => '<p>Test content</p>',
            'params' => [],
            'counter' => 0,
        ]);
        Assert::assertEmpty($template->params);
    });

    test('_can_handle_empty_sms_template', function (): void {
$template = MailTemplateFactory::new()->createOne([
            'mailable' => 'App\Mail\EmptySmsMail',
            'name' => 'Empty SMS Template',
            'subject' => 'Test Subject',
            'html_template' => '<p>Test content</p>',
            'sms_template' => [],
            'params' => ['test'],
            'counter' => 0,
        ]);
        Assert::assertEmpty($template->sms_template);
    });

    test('_can_store_complex_sms_template', function (): void {
$complexSmsTemplate = [
            'message' => 'Benvenuto {{name}}!',
            'variables' => ['name', 'email'],
            'max_length' => 160,
            'encoding' => 'GSM7',
            'fallback' => [
                'enabled' => true,
                'message' => 'Welcome {{name}}!',
                'language' => 'en',
            ],
            'delivery_options' => [
                'priority' => 'high',
                'retry_count' => 3,
                'timeout' => 30,
            ],
        ];

        $template = MailTemplateFactory::new()->createOne([
            'mailable' => 'App\Mail\ComplexSmsMail',
            'name' => 'Complex SMS Template',
            'subject' => 'Test Subject',
            'html_template' => '<p>Test content</p>',
            'sms_template' => $complexSmsTemplate,
            'params' => ['test'],
            'counter' => 0,
        ]);
        \assertNotifyTableHas('mail_templates', [
            'id' => $template->id,
            'sms_template' => json_encode($complexSmsTemplate),
        ]);

        $smsData = \assertNotifyArray($template->sms_template);
        Assert::assertEquals('Benvenuto {{name}}!', $smsData['message']);
        Assert::assertEquals(['name', 'email'], $smsData['variables']);
        Assert::assertEquals(160, $smsData['max_length']);
        Assert::assertTrue(\notifyArrayGet($smsData, 'fallback', 'enabled'));
        Assert::assertEquals('high', \notifyArrayGet($smsData, 'delivery_options', 'priority'));
    });

    test('_can_find_templates_by_multiple_criteria', function (): void {
MailTemplateFactory::new()->createOne([
            'mailable' => 'App\Mail\MultiCriteriaMail',
            'name' => 'Multi Criteria Template',
            'subject' => 'Welcome to our platform',
            'html_template' => '<p>Test content</p>',
            'params' => ['name', 'email'],
            'counter' => 10,
        ]);

        MailTemplateFactory::new()->createOne([
            'mailable' => 'App\Mail\AnotherMultiCriteriaMail',
            'name' => 'Another Multi Criteria Template',
            'subject' => 'Welcome to our platform',
            'html_template' => '<p>Test content</p>',
            'params' => ['name', 'email'],
            'counter' => 20,
        ]);

        $foundTemplates = MailTemplate::where('subject', 'like', '%Welcome%')
            ->whereJsonContains('params', 'name')
            ->where('counter', '>=', 15)
            ->get();

        Assert::assertCount(1, $foundTemplates);
        Assert::assertEquals('Another Multi Criteria Template', \assertFirstModel($foundTemplates, \Modules\Notify\Models\MailTemplate::class)->name);
        Assert::assertEquals(20, \assertFirstModel($foundTemplates, \Modules\Notify\Models\MailTemplate::class)->counter);
    });

    test('_can_handle_null_values', function (): void {
$template = MailTemplateFactory::new()->createOne([
            'mailable' => 'App\Mail\NullValuesMail',
            'name' => 'Null Values Template',
            'subject' => null,
            'html_template' => '<p>Test content</p>',
            'text_template' => null,
            'sms_template' => null,
            'params' => null,
            'counter' => 0,
        ]);

        Assert::assertNull($template->subject);
        Assert::assertNull($template->text_template);
        Assert::assertNull($template->sms_template);
        Assert::assertNull($template->params);
    });

    test('_can_generate_unique_slugs', function (): void {
MailTemplateFactory::new()->createOne([
            'mailable' => 'App\Mail\UniqueSlugMail1',
            'name' => 'Test Template',
            'subject' => 'Test Subject',
            'html_template' => '<p>Test content</p>',
            'params' => ['test'],
            'counter' => 0,
        ]);

        MailTemplateFactory::new()->createOne([
            'mailable' => 'App\Mail\UniqueSlugMail2',
            'name' => 'Test Template',
            'subject' => 'Test Subject',
            'html_template' => '<p>Test content</p>',
            'params' => ['test'],
            'counter' => 0,
        ]);

        $templates = MailTemplate::where('name', 'Test Template')->get();

        Assert::assertCount(2, $templates);
        Assert::assertEquals('test-template', \assertFirstModel($templates, \Modules\Notify\Models\MailTemplate::class)->slug);
        Assert::assertEquals('test-template-1', \assertFirstModel($templates->slice(1), \Modules\Notify\Models\MailTemplate::class)->slug);
    });
});
