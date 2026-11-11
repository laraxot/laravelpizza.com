<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Models;

use Modules\Notify\Enums\NotificationTypeEnum;
use Modules\Notify\Models\NotificationTemplate;
use Modules\Notify\Tests\TestCase;

use function Safe\json_encode;

uses(TestCase::class);
class NotificationTemplateTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    /** @test */
    public function it_can_create_notification_template(): void
    {
        $template = NotificationTemplate::create([
            'name' => 'Welcome Email',
            'code' => 'welcome_email',
            'description' => 'Welcome email for new users',
            'subject' => 'Benvenuto {{name}}!',
            'body_html' => '<h1>Benvenuto {{name}}!</h1><p>Grazie per esserti registrato.</p>',
            'body_text' => 'Benvenuto {{name}}! Grazie per esserti registrato.',
            'channels' => ['mail', 'database'],
            'variables' => ['name', 'email'],
            'conditions' => ['user_type' => 'new'],
            'preview_data' => ['name' => 'Test User', 'email' => 'test@example.com'],
            'metadata' => ['priority' => 'high'],
            'category' => 'welcome',
            'is_active' => true,
            'version' => 1,
            'type' => NotificationTypeEnum::EMAIL,
        ]);

        $this->assertDatabaseHas('notification_templates', [
            'id' => $template->id,
            'name' => 'Welcome Email',
            'code' => 'welcome_email',
            'description' => 'Welcome email for new users',
            'subject' => 'Benvenuto {{name}}!',
            'category' => 'welcome',
            'is_active' => true,
            'version' => 1,
        ]);

        $this->assertInstanceOf(NotificationTemplate::class, $template);
    }

    /** @test */
    public function it_has_correct_fillable_fields(): void
    {
        $template = new NotificationTemplate;

        $expectedFillable = [
            'name',
            'code',
            'description',
            'subject',
            'body_html',
            'body_text',
            'channels',
            'variables',
            'conditions',
            'preview_data',
            'metadata',
            'category',
            'is_active',
            'version',
            'tenant_id',
            'grapesjs_data',
            'type',
        ];

        $this->assertEquals($expectedFillable, $template->getFillable());
    }

    /** @test */
    public function it_has_correct_casts(): void
    {
        $template = new NotificationTemplate;

        $expectedCasts = [
            'id' => 'string',
            'type' => NotificationTypeEnum::class,
            'preview_data' => 'array',
            'channels' => 'array',
            'variables' => 'array',
            'conditions' => 'array',
            'metadata' => 'array',
            'is_active' => 'boolean',
            'grapesjs_data' => 'array',
            // HasTranslations castra ad array le colonne in $translatable.
            'subject' => 'array',
            'body_html' => 'array',
            'body_text' => 'array',
        ];

        $this->assertEquals($expectedCasts, $template->getCasts());
    }

    /** @test */
    public function it_has_translatable_fields(): void
    {
        $template = new NotificationTemplate;

        $expectedTranslatable = [
            'subject',
            'body_text',
            'body_html',
        ];

        $this->assertEquals($expectedTranslatable, $template->translatable);
    }

    /** @test */
    public function it_can_store_json_channels(): void
    {
        $channels = ['mail', 'database', 'sms'];

        $template = NotificationTemplate::create([
            'name' => 'Multi Channel Template',
            'code' => 'multi_channel',
            'subject' => 'Test Subject',
            'channels' => $channels,
            'variables' => ['test'],
            'is_active' => true,
            'version' => 1,
            'type' => NotificationTypeEnum::EMAIL,
        ]);

        $this->assertDatabaseHas('notification_templates', [
            'id' => $template->id,
            'channels' => json_encode($channels),
        ]);

        $this->assertIsArray($template->channels);
        $this->assertCount(3, $template->channels);
        $this->assertContains('mail', $template->channels);
        $this->assertContains('database', $template->channels);
        $this->assertContains('sms', $template->channels);
    }

    /** @test */
    public function it_can_store_json_variables(): void
    {
        $variables = ['name', 'email', 'company', 'role'];

        $template = NotificationTemplate::create([
            'name' => 'Complex Template',
            'code' => 'complex_template',
            'subject' => 'Test Subject',
            'channels' => ['mail'],
            'variables' => $variables,
            'is_active' => true,
            'version' => 1,
            'type' => NotificationTypeEnum::EMAIL,
        ]);

        $this->assertDatabaseHas('notification_templates', [
            'id' => $template->id,
            'variables' => json_encode($variables),
        ]);

        $this->assertIsArray($template->variables);
        $this->assertCount(4, $template->variables);
        $this->assertContains('name', $template->variables);
        $this->assertContains('email', $template->variables);
        $this->assertContains('company', $template->variables);
        $this->assertContains('role', $template->variables);
    }

    /** @test */
    public function it_can_store_json_conditions(): void
    {
        $conditions = [
            'user_type' => 'premium',
            'subscription_status' => 'active',
            'country' => 'IT',
        ];

        $template = NotificationTemplate::create([
            'name' => 'Conditional Template',
            'code' => 'conditional_template',
            'subject' => 'Test Subject',
            'channels' => ['mail'],
            'variables' => ['test'],
            'conditions' => $conditions,
            'is_active' => true,
            'version' => 1,
            'type' => NotificationTypeEnum::EMAIL,
        ]);

        $this->assertDatabaseHas('notification_templates', [
            'id' => $template->id,
            'conditions' => json_encode($conditions),
        ]);

        $this->assertIsArray($template->conditions);
        $this->assertEquals('premium', $template->conditions['user_type']);
        $this->assertEquals('active', $template->conditions['subscription_status']);
        $this->assertEquals('IT', $template->conditions['country']);
    }

    /** @test */
    public function it_can_store_json_preview_data(): void
    {
        $previewData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'company' => 'Acme Corp',
            'role' => 'Manager',
        ];

        $template = NotificationTemplate::create([
            'name' => 'Preview Template',
            'code' => 'preview_template',
            'subject' => 'Test Subject',
            'channels' => ['mail'],
            'variables' => ['test'],
            'preview_data' => $previewData,
            'is_active' => true,
            'version' => 1,
            'type' => NotificationTypeEnum::EMAIL,
        ]);

        $this->assertDatabaseHas('notification_templates', [
            'id' => $template->id,
            'preview_data' => json_encode($previewData),
        ]);

        $this->assertIsArray($template->preview_data);
        $this->assertEquals('John Doe', $template->preview_data['name']);
        $this->assertEquals('john@example.com', $template->preview_data['email']);
        $this->assertEquals('Acme Corp', $template->preview_data['company']);
        $this->assertEquals('Manager', $template->preview_data['role']);
    }

    /** @test */
    public function it_can_store_json_metadata(): void
    {
        $metadata = [
            'priority' => 'high',
            'tags' => ['welcome', 'onboarding'],
            'author' => 'system',
            'last_modified' => now()->toISOString(),
        ];

        $template = NotificationTemplate::create([
            'name' => 'Metadata Template',
            'code' => 'metadata_template',
            'subject' => 'Test Subject',
            'channels' => ['mail'],
            'variables' => ['test'],
            'metadata' => $metadata,
            'is_active' => true,
            'version' => 1,
            'type' => NotificationTypeEnum::EMAIL,
        ]);

        $this->assertDatabaseHas('notification_templates', [
            'id' => $template->id,
            'metadata' => json_encode($metadata),
        ]);

        $this->assertIsArray($template->metadata);
        $this->assertEquals('high', $template->metadata['priority']);
        $this->assertEquals(['welcome', 'onboarding'], $template->metadata['tags']);
        $this->assertEquals('system', $template->metadata['author']);
    }

    /** @test */
    public function it_can_store_json_grapesjs_data(): void
    {
        $grapesjsData = [
            'html' => '<div>Custom HTML</div>',
            'css' => '.custom { color: red; }',
            'components' => ['header', 'content', 'footer'],
            'styles' => ['theme' => 'modern'],
        ];

        $template = NotificationTemplate::create([
            'name' => 'GrapesJS Template',
            'code' => 'grapesjs_template',
            'subject' => 'Test Subject',
            'channels' => ['mail'],
            'variables' => ['test'],
            'grapesjs_data' => $grapesjsData,
            'is_active' => true,
            'version' => 1,
            'type' => NotificationTypeEnum::EMAIL,
        ]);

        $this->assertDatabaseHas('notification_templates', [
            'id' => $template->id,
            'grapesjs_data' => json_encode($grapesjsData),
        ]);

        $this->assertIsArray($template->grapesjs_data);
        $this->assertEquals('<div>Custom HTML</div>', TestCase::notifyArrayGet($template->grapesjs_data, 'html'));
        $this->assertEquals('.custom { color: red; }', TestCase::notifyArrayGet($template->grapesjs_data, 'css'));
        $this->assertEquals(['header', 'content', 'footer'], $template->grapesjs_data['components']);
        $this->assertEquals(['theme' => 'modern'], $template->grapesjs_data['styles']);
    }

    /** @test */
    public function it_can_compile_template_with_data(): void
    {
        $template = NotificationTemplate::create([
            'name' => 'Compile Test Template',
            'code' => 'compile_test',
            'subject' => 'Benvenuto {{name}}!',
            'body_html' => '<h1>Benvenuto {{name}}!</h1><p>La tua email è {{email}}</p>',
            'body_text' => 'Benvenuto {{name}}! La tua email è {{email}}',
            'channels' => ['mail'],
            'variables' => ['name', 'email'],
            'is_active' => true,
            'version' => 1,
            'type' => NotificationTypeEnum::EMAIL,
        ]);

        $data = [
            'name' => 'Mario Rossi',
            'email' => 'mario@example.com',
        ];

        $result = $template->compile($data);

        $this->assertEquals('Benvenuto Mario Rossi!', $result['subject']);
        $this->assertEquals(
            '<h1>Benvenuto Mario Rossi!</h1><p>La tua email è mario@example.com</p>',
            $result['body_html']);
        $this->assertEquals('Benvenuto Mario Rossi! La tua email è mario@example.com', $result['body_text']);
    }

    /** @test */
    public function it_can_check_conditions(): void
    {
        $template = NotificationTemplate::create([
            'name' => 'Conditional Test Template',
            'code' => 'conditional_test',
            'subject' => 'Test Subject',
            'channels' => ['mail'],
            'variables' => ['test'],
            'conditions' => [
                'user_type' => 'premium',
                'country' => 'IT',
            ],
            'is_active' => true,
            'version' => 1,
            'type' => NotificationTypeEnum::EMAIL,
        ]);

        // Dati che soddisfano le condizioni
        $validData = [
            'user_type' => 'premium',
            'country' => 'IT',
            'name' => 'Test User',
        ];

        $this->assertTrue($template->shouldSend($validData));

        // Dati che NON soddisfano le condizioni
        $invalidData = [
            'user_type' => 'basic',
            'country' => 'IT',
            'name' => 'Test User',
        ];

        $this->assertFalse($template->shouldSend($invalidData));

        // Template senza condizioni
        $templateNoConditions = NotificationTemplate::create([
            'name' => 'No Conditions Template',
            'code' => 'no_conditions',
            'subject' => 'Test Subject',
            'channels' => ['mail'],
            'variables' => ['test'],
            'is_active' => true,
            'version' => 1,
            'type' => NotificationTypeEnum::EMAIL,
        ]);

        $this->assertTrue($templateNoConditions->shouldSend($validData));
    }

    /** @test */
    public function it_can_preview_template(): void
    {
        $template = NotificationTemplate::create([
            'name' => 'Preview Test Template',
            'code' => 'preview_test',
            'subject' => 'Benvenuto {{name}}!',
            'body_html' => '<h1>Benvenuto {{name}}!</h1><p>Email: {{email}}</p>',
            'body_text' => 'Benvenuto {{name}}! Email: {{email}}',
            'channels' => ['mail'],
            'variables' => ['name', 'email'],
            'preview_data' => [
                'name' => 'Preview User',
                'email' => 'preview@example.com',
            ],
            'is_active' => true,
            'version' => 1,
            'type' => NotificationTypeEnum::EMAIL,
        ]);

        $result = $template->preview();

        $this->assertEquals('Benvenuto Preview User!', $result['subject']);
        $this->assertEquals('<h1>Benvenuto Preview User!</h1><p>Email: preview@example.com</p>', $result['body_html']);
        $this->assertEquals('Benvenuto Preview User! Email: preview@example.com', $result['body_text']);

        // Preview con dati aggiuntivi
        $additionalData = ['company' => 'Acme Corp'];
        $resultWithAdditional = $template->preview($additionalData);

        $this->assertEquals('Benvenuto Preview User!', $resultWithAdditional['subject']);
        $this->assertEquals(
            '<h1>Benvenuto Preview User!</h1><p>Email: preview@example.com</p>',
            $resultWithAdditional['body_html']);
    }

    /** @test */
    public function it_can_use_active_scope(): void
    {
        NotificationTemplate::create([
            'name' => 'Active Template',
            'code' => 'active_template',
            'subject' => 'Active Subject',
            'channels' => ['mail'],
            'variables' => ['test'],
            'is_active' => true,
            'version' => 1,
            'type' => NotificationTypeEnum::EMAIL,
        ]);

        NotificationTemplate::create([
            'name' => 'Inactive Template',
            'code' => 'inactive_template',
            'subject' => 'Inactive Subject',
            'channels' => ['mail'],
            'variables' => ['test'],
            'is_active' => false,
            'version' => 1,
            'type' => NotificationTypeEnum::EMAIL,
        ]);

        $activeTemplates = NotificationTemplate::active()->get();
        $allTemplates = NotificationTemplate::all();

        $this->assertCount(1, $activeTemplates);
        $this->assertCount(2, $allTemplates);
        $this->assertEquals('Active Template', $activeTemplates->firstOrFail()->name);
        $this->assertTrue($activeTemplates->firstOrFail()->is_active);
    }

    /** @test */
    public function it_can_use_for_channel_scope(): void
    {
        NotificationTemplate::create([
            'name' => 'Mail Template',
            'code' => 'mail_template',
            'subject' => 'Mail Subject',
            'channels' => ['mail'],
            'variables' => ['test'],
            'is_active' => true,
            'version' => 1,
            'type' => NotificationTypeEnum::EMAIL,
        ]);

        NotificationTemplate::create([
            'name' => 'SMS Template',
            'code' => 'sms_template',
            'subject' => 'SMS Subject',
            'channels' => ['sms'],
            'variables' => ['test'],
            'is_active' => true,
            'version' => 1,
            'type' => NotificationTypeEnum::SMS,
        ]);

        NotificationTemplate::create([
            'name' => 'Multi Channel Template',
            'code' => 'multi_channel_template',
            'subject' => 'Multi Subject',
            'channels' => ['mail', 'sms'],
            'variables' => ['test'],
            'is_active' => true,
            'version' => 1,
            'type' => NotificationTypeEnum::EMAIL,
        ]);

        $mailTemplates = NotificationTemplate::forChannel('mail')->get();
        $smsTemplates = NotificationTemplate::forChannel('sms')->get();

        $this->assertCount(2, $mailTemplates); // mail_template + multi_channel_template
        $this->assertCount(2, $smsTemplates); // sms_template + multi_channel_template
    }

    /** @test */
    public function it_can_use_for_category_scope(): void
    {
        NotificationTemplate::create([
            'name' => 'Welcome Template',
            'code' => 'welcome_template',
            'subject' => 'Welcome Subject',
            'channels' => ['mail'],
            'variables' => ['test'],
            'category' => 'welcome',
            'is_active' => true,
            'version' => 1,
            'type' => NotificationTypeEnum::EMAIL,
        ]);

        NotificationTemplate::create([
            'name' => 'Reminder Template',
            'code' => 'reminder_template',
            'subject' => 'Reminder Subject',
            'channels' => ['mail'],
            'variables' => ['test'],
            'category' => 'reminder',
            'is_active' => true,
            'version' => 1,
            'type' => NotificationTypeEnum::EMAIL,
        ]);

        NotificationTemplate::create([
            'name' => 'Another Welcome Template',
            'code' => 'another_welcome_template',
            'subject' => 'Another Welcome Subject',
            'channels' => ['mail'],
            'variables' => ['test'],
            'category' => 'welcome',
            'is_active' => true,
            'version' => 1,
            'type' => NotificationTypeEnum::EMAIL,
        ]);

        $welcomeTemplates = NotificationTemplate::forCategory('welcome')->get();
        $reminderTemplates = NotificationTemplate::forCategory('reminder')->get();

        $this->assertCount(2, $welcomeTemplates);
        $this->assertCount(1, $reminderTemplates);
        $this->assertEquals('welcome', $welcomeTemplates->firstOrFail()->category);
        $this->assertEquals('welcome', $welcomeTemplates->skip(1)->firstOrFail()->category);
        $this->assertEquals('reminder', $reminderTemplates->firstOrFail()->category);
    }

    /** @test */
    public function it_can_get_channels_label(): void
    {
        $template = NotificationTemplate::create([
            'name' => 'Channels Label Template',
            'code' => 'channels_label_template',
            'subject' => 'Test Subject',
            'channels' => ['mail', 'database', 'sms'],
            'variables' => ['test'],
            'is_active' => true,
            'version' => 1,
            'type' => NotificationTypeEnum::EMAIL,
        ]);

        $channelsLabel = $template->channels_label;

        $this->assertIsString($channelsLabel);
        $this->assertNotEmpty($channelsLabel);
    }

    /** @test */
    public function it_can_get_and_set_grapesjs_data(): void
    {
        $template = NotificationTemplate::create([
            'name' => 'GrapesJS Test Template',
            'code' => 'grapesjs_test',
            'subject' => 'Test Subject',
            'channels' => ['mail'],
            'variables' => ['test'],
            'is_active' => true,
            'version' => 1,
            'type' => NotificationTypeEnum::EMAIL,
        ]);

        $initialData = $template->getGrapesJSData();
        $this->assertIsArray($initialData);
        $this->assertEmpty($initialData);

        $newData = [
            'html' => '<div>New HTML</div>',
            'css' => '.new { color: blue; }',
        ];

        $template->setGrapesJSData($newData);

        $this->assertEquals($newData, $template->getGrapesJSData());
        $this->assertEquals('<div>New HTML</div>', TestCase::notifyArrayGet($template->grapesjs_data, 'html'));
        $this->assertEquals('.new { color: blue; }', TestCase::notifyArrayGet($template->grapesjs_data, 'css'));
    }

    /** @test */
    public function it_can_get_preview_methods(): void
    {
        $template = NotificationTemplate::create([
            'name' => 'Preview Methods Template',
            'code' => 'preview_methods',
            'subject' => 'Test Subject',
            'body_html' => 'Test HTML',
            'body_text' => 'Test Text',
            'channels' => ['mail'],
            'variables' => ['test'],
            'is_active' => true,
            'version' => 1,
            'type' => NotificationTypeEnum::EMAIL,
        ]);

        $this->assertEquals('Test Subject', $template->getPreviewSubject());
        $this->assertEquals('Test HTML', $template->getPreviewBodyHtml());
        $this->assertEquals('Test Text', $template->getPreviewBodyText());
    }

    /** @test */
    public function it_can_update_template(): void
    {
        $template = NotificationTemplate::create([
            'name' => 'Update Test Template',
            'code' => 'update_test',
            'subject' => 'Original Subject',
            'channels' => ['mail'],
            'variables' => ['test'],
            'is_active' => true,
            'version' => 1,
            'type' => NotificationTypeEnum::EMAIL,
        ]);

        $template->update([
            'name' => 'Updated Template Name',
            'subject' => 'Updated Subject',
            'is_active' => false,
            'version' => 2,
        ]);

        $this->assertDatabaseHas('notification_templates', [
            'id' => $template->id,
            'name' => 'Updated Template Name',
            'subject' => 'Updated Subject',
            'is_active' => false,
            'version' => 2,
        ]);
    }

    /** @test */
    public function it_can_handle_empty_arrays(): void
    {
        $template = NotificationTemplate::create([
            'name' => 'Empty Arrays Template',
            'code' => 'empty_arrays',
            'subject' => 'Test Subject',
            'channels' => [],
            'variables' => [],
            'conditions' => [],
            'preview_data' => [],
            'metadata' => [],
            'grapesjs_data' => [],
            'is_active' => true,
            'version' => 1,
            'type' => NotificationTypeEnum::EMAIL,
        ]);

        $this->assertIsArray($template->channels);
        $this->assertIsArray($template->variables);
        $this->assertIsArray($template->conditions);
        $this->assertIsArray($template->preview_data);
        $this->assertIsArray($template->metadata);
        $this->assertIsArray($template->grapesjs_data);

        $this->assertEmpty($template->channels);
        $this->assertEmpty($template->variables);
        $this->assertEmpty($template->conditions);
        $this->assertEmpty($template->preview_data);
        $this->assertEmpty($template->metadata);
        $this->assertEmpty($template->grapesjs_data);
    }
}
