<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Notify\Models\MailTemplate;
use Tests\TestCase;

class MailTemplateTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    /** @test */
    public function it_can_create_mail_template(): void
    {
        $template = MailTemplate::create([
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

        $this->assertDatabaseHas('mail_templates', [
            'id' => $template->id,
            'mailable' => 'App\Mail\WelcomeMail',
            'name' => 'Welcome Email Template',
            'subject' => 'Benvenuto {{name}}!',
            'html_template' => '<h1>Benvenuto {{name}}!</h1><p>Grazie per esserti registrato.</p>',
            'text_template' => 'Benvenuto {{name}}! Grazie per esserti registrato.',
            'params' => json_encode(['name', 'email']),
            'counter' => 0,
        ]);

        $this->assertInstanceOf(MailTemplate::class, $template);
    }

    /** @test */
    public function it_has_correct_fillable_fields(): void
    {
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

        $this->assertEquals($expectedFillable, $template->getFillable());
    }

    /** @test */
    public function it_has_correct_casts(): void
    {
        $template = new MailTemplate;

        $expectedCasts = [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];

        $this->assertEquals($expectedCasts, $template->casts());
    }

    /** @test */
    public function it_has_translatable_fields(): void
    {
        $template = new MailTemplate;

        $expectedTranslatable = [
            'subject',
            'html_template',
            'text_template',
            'sms_template',
        ];

        $this->assertEquals($expectedTranslatable, $template->translatable);
    }

    /** @test */
    public function it_uses_notify_connection(): void
    {
        $template = new MailTemplate;

        $this->assertEquals('notify', $template->getConnectionName());
    }

    /** @test */
    public function it_generates_slug_from_name(): void
    {
        $template = MailTemplate::create([
            'mailable' => 'App\Mail\TestMail',
            'name' => 'Test Email Template',
            'subject' => 'Test Subject',
            'html_template' => '<p>Test content</p>',
            'params' => ['test'],
            'counter' => 0,
        ]);

        $this->assertEquals('test-email-template', $template->slug);
        $this->assertDatabaseHas('mail_templates', [
            'id' => $template->id,
            'slug' => 'test-email-template',
        ]);
    }

    /** @test */
    public function it_can_store_json_params(): void
    {
        $params = ['name', 'email', 'company', 'role'];

        $template = MailTemplate::create([
            'mailable' => 'App\Mail\ComplexMail',
            'name' => 'Complex Email Template',
            'subject' => 'Test Subject',
            'html_template' => '<p>Test content</p>',
            'params' => $params,
            'counter' => 0,
        ]);

        $this->assertDatabaseHas('mail_templates', [
            'id' => $template->id,
            'params' => json_encode($params),
        ]);

        $this->assertIsArray($template->params);
        $this->assertCount(4, $template->params);
        $this->assertContains('name', $template->params);
        $this->assertContains('email', $template->params);
        $this->assertContains('company', $template->params);
        $this->assertContains('role', $template->params);
    }

    /** @test */
    public function it_can_store_json_sms_template(): void
    {
        $smsTemplate = [
            'message' => 'Benvenuto {{name}}! La tua email è {{email}}',
            'variables' => ['name', 'email'],
            'max_length' => 160,
            'encoding' => 'GSM7',
        ];

        $template = MailTemplate::create([
            'mailable' => 'App\Mail\SmsMail',
            'name' => 'SMS Email Template',
            'subject' => 'Test Subject',
            'html_template' => '<p>Test content</p>',
            'sms_template' => $smsTemplate,
            'params' => ['test'],
            'counter' => 0,
        ]);

        $this->assertDatabaseHas('mail_templates', [
            'id' => $template->id,
            'sms_template' => json_encode($smsTemplate),
        ]);

        $this->assertIsArray($template->sms_template);
        $this->assertEquals('Benvenuto {{name}}! La tua email è {{email}}', $template->sms_template['message']);
        $this->assertEquals(['name', 'email'], $template->sms_template['variables']);
        $this->assertEquals(160, $template->sms_template['max_length']);
        $this->assertEquals('GSM7', $template->sms_template['encoding']);
    }

    /** @test */
    public function it_can_increment_counter(): void
    {
        $template = MailTemplate::create([
            'mailable' => 'App\Mail\CounterMail',
            'name' => 'Counter Email Template',
            'subject' => 'Test Subject',
            'html_template' => '<p>Test content</p>',
            'params' => ['test'],
            'counter' => 0,
        ]);

        $this->assertEquals(0, $template->counter);

        $template->increment('counter');
        $this->assertEquals(1, $template->fresh()->counter);

        $template->increment('counter', 5);
        $this->assertEquals(6, $template->fresh()->counter);
    }

    /** @test */
    public function it_can_update_template(): void
    {
        $template = MailTemplate::create([
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

        $this->assertDatabaseHas('mail_templates', [
            'id' => $template->id,
            'name' => 'Updated Name',
            'subject' => 'Updated Subject',
            'html_template' => '<p>Updated content</p>',
            'params' => json_encode(['updated']),
        ]);

        $this->assertEquals('updated-name', $template->fresh()->slug);
    }

    /** @test */
    public function it_can_find_by_mailable_and_slug(): void
    {
        $template = MailTemplate::create([
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

        $this->assertNotNull($foundTemplate);
        $this->assertEquals($template->id, $foundTemplate->id);
        $this->assertEquals('App\Mail\FindMail', $foundTemplate->mailable);
        $this->assertEquals('find-test-template', $foundTemplate->slug);
    }

    /** @test */
    public function it_can_find_by_name(): void
    {
        $template = MailTemplate::create([
            'mailable' => 'App\Mail\NameMail',
            'name' => 'Name Search Template',
            'subject' => 'Test Subject',
            'html_template' => '<p>Test content</p>',
            'params' => ['test'],
            'counter' => 0,
        ]);

        $foundTemplate = MailTemplate::where('name', 'Name Search Template')->first();

        $this->assertNotNull($foundTemplate);
        $this->assertEquals($template->id, $foundTemplate->id);
        $this->assertEquals('Name Search Template', $foundTemplate->name);
    }

    /** @test */
    public function it_can_find_by_subject_pattern(): void
    {
        $template = MailTemplate::create([
            'mailable' => 'App\Mail\PatternMail',
            'name' => 'Pattern Template',
            'subject' => 'Welcome to our platform',
            'html_template' => '<p>Test content</p>',
            'params' => ['test'],
            'counter' => 0,
        ]);

        $foundTemplates = MailTemplate::where('subject', 'like', '%Welcome%')->get();

        $this->assertCount(1, $foundTemplates);
        $this->assertEquals('Welcome to our platform', $foundTemplates[0]->subject);
    }

    /** @test */
    public function it_can_find_by_params(): void
    {
        $template = MailTemplate::create([
            'mailable' => 'App\Mail\ParamsMail',
            'name' => 'Params Template',
            'subject' => 'Test Subject',
            'html_template' => '<p>Test content</p>',
            'params' => ['name', 'email', 'company'],
            'counter' => 0,
        ]);

        $foundTemplates = MailTemplate::whereJsonContains('params', 'name')->get();

        $this->assertCount(1, $foundTemplates);
        $this->assertEquals($template->id, $foundTemplates[0]->id);
        $this->assertContains('name', $foundTemplates[0]->params);
    }

    /** @test */
    public function it_can_find_by_counter_range(): void
    {
        MailTemplate::create([
            'mailable' => 'App\Mail\LowCounterMail',
            'name' => 'Low Counter Template',
            'subject' => 'Test Subject',
            'html_template' => '<p>Test content</p>',
            'params' => ['test'],
            'counter' => 5,
        ]);

        MailTemplate::create([
            'mailable' => 'App\Mail\HighCounterMail',
            'name' => 'High Counter Template',
            'subject' => 'Test Subject',
            'html_template' => '<p>Test content</p>',
            'params' => ['test'],
            'counter' => 50,
        ]);

        $lowCounterTemplates = MailTemplate::where('counter', '<=', 10)->get();
        $highCounterTemplates = MailTemplate::where('counter', '>=', 25)->get();

        $this->assertCount(1, $lowCounterTemplates);
        $this->assertCount(1, $highCounterTemplates);
        $this->assertEquals(5, $lowCounterTemplates[0]->counter);
        $this->assertEquals(50, $highCounterTemplates[0]->counter);
    }

    /** @test */
    public function it_can_handle_empty_params(): void
    {
        $template = MailTemplate::create([
            'mailable' => 'App\Mail\EmptyParamsMail',
            'name' => 'Empty Params Template',
            'subject' => 'Test Subject',
            'html_template' => '<p>Test content</p>',
            'params' => [],
            'counter' => 0,
        ]);

        $this->assertIsArray($template->params);
        $this->assertEmpty($template->params);
    }

    /** @test */
    public function it_can_handle_empty_sms_template(): void
    {
        $template = MailTemplate::create([
            'mailable' => 'App\Mail\EmptySmsMail',
            'name' => 'Empty SMS Template',
            'subject' => 'Test Subject',
            'html_template' => '<p>Test content</p>',
            'sms_template' => [],
            'params' => ['test'],
            'counter' => 0,
        ]);

        $this->assertIsArray($template->sms_template);
        $this->assertEmpty($template->sms_template);
    }

    /** @test */
    public function it_can_store_complex_sms_template(): void
    {
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

        $template = MailTemplate::create([
            'mailable' => 'App\Mail\ComplexSmsMail',
            'name' => 'Complex SMS Template',
            'subject' => 'Test Subject',
            'html_template' => '<p>Test content</p>',
            'sms_template' => $complexSmsTemplate,
            'params' => ['test'],
            'counter' => 0,
        ]);

        $this->assertDatabaseHas('mail_templates', [
            'id' => $template->id,
            'sms_template' => json_encode($complexSmsTemplate),
        ]);

        $this->assertEquals('Benvenuto {{name}}!', $template->sms_template['message']);
        $this->assertEquals(['name', 'email'], $template->sms_template['variables']);
        $this->assertEquals(160, $template->sms_template['max_length']);
        $this->assertTrue($template->sms_template['fallback']['enabled']);
        $this->assertEquals('high', $template->sms_template['delivery_options']['priority']);
    }

    /** @test */
    public function it_can_find_templates_by_multiple_criteria(): void
    {
        MailTemplate::create([
            'mailable' => 'App\Mail\MultiCriteriaMail',
            'name' => 'Multi Criteria Template',
            'subject' => 'Welcome to our platform',
            'html_template' => '<p>Test content</p>',
            'params' => ['name', 'email'],
            'counter' => 10,
        ]);

        MailTemplate::create([
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

        $this->assertCount(1, $foundTemplates);
        $this->assertEquals('Another Multi Criteria Template', $foundTemplates[0]->name);
        $this->assertEquals(20, $foundTemplates[0]->counter);
    }

    /** @test */
    public function it_can_handle_null_values(): void
    {
        $template = MailTemplate::create([
            'mailable' => 'App\Mail\NullValuesMail',
            'name' => 'Null Values Template',
            'subject' => null,
            'html_template' => '<p>Test content</p>',
            'text_template' => null,
            'sms_template' => null,
            'params' => null,
            'counter' => 0,
        ]);

        $this->assertNull($template->subject);
        $this->assertNull($template->text_template);
        $this->assertNull($template->sms_template);
        $this->assertNull($template->params);
    }

    /** @test */
    public function it_can_generate_unique_slugs(): void
    {
        MailTemplate::create([
            'mailable' => 'App\Mail\UniqueSlugMail1',
            'name' => 'Test Template',
            'subject' => 'Test Subject',
            'html_template' => '<p>Test content</p>',
            'params' => ['test'],
            'counter' => 0,
        ]);

        MailTemplate::create([
            'mailable' => 'App\Mail\UniqueSlugMail2',
            'name' => 'Test Template',
            'subject' => 'Test Subject',
            'html_template' => '<p>Test content</p>',
            'params' => ['test'],
            'counter' => 0,
        ]);

        $templates = MailTemplate::where('name', 'Test Template')->get();

        $this->assertCount(2, $templates);
        $this->assertEquals('test-template', $templates[0]->slug);
        $this->assertEquals('test-template-1', $templates[1]->slug);
    }
}
