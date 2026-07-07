# Analisi Dettagliata del Modulo Notify - Parte 5: Testing

## 5. Testing

### 5.1 Unit Tests

#### 5.1.1 TemplateTest
```php
namespace Modules\Notify\Tests\Unit;

use Tests\TestCase;
use Modules\Notify\Models\Template;
use Modules\Notify\Services\TemplateService;
use Modules\Notify\Exceptions\TemplateException;

class TemplateTest extends TestCase
{
    protected $templateService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->templateService = app(TemplateService::class);
    }

    /** @test */
    public function it_can_create_a_template()
    {
        $data = [
            'name' => 'Test Template',
            'subject' => 'Test Subject',
            'content' => '<mjml>Test Content</mjml>',
            'layout' => 'default'
        ];

        $template = $this->templateService->create($data);

        $this->assertInstanceOf(Template::class, $template);
        $this->assertEquals($data['name'], $template->name);
        $this->assertEquals($data['subject'], $template->subject);
        $this->assertEquals($data['content'], $template->content);
        $this->assertEquals($data['layout'], $template->layout);
        $this->assertTrue($template->is_active);
        $this->assertEquals(1, $template->version);
    }

    /** @test */
    public function it_can_update_a_template()
    {
        $template = Template::factory()->create();

        $data = [
            'name' => 'Updated Template',
            'subject' => 'Updated Subject',
            'content' => '<mjml>Updated Content</mjml>'
        ];

        $updated = $this->templateService->update($template, $data);

        $this->assertEquals($data['name'], $updated->name);
        $this->assertEquals($data['subject'], $updated->subject);
        $this->assertEquals($data['content'], $updated->content);
        $this->assertEquals(2, $updated->version);
    }

    /** @test */
    public function it_can_delete_a_template()
    {
        $template = Template::factory()->create();

        $this->templateService->delete($template);

        $this->assertSoftDeleted($template);
    }

    /** @test */
    public function it_can_create_a_version()
    {
        $template = Template::factory()->create();

        $data = [
            'content' => '<mjml>New Version</mjml>',
            'status' => 'draft'
        ];

        $version = $this->templateService->createVersion($template, $data);

        $this->assertEquals($template->id, $version->template_id);
        $this->assertEquals(2, $version->version);
        $this->assertEquals($data['content'], $version->content);
        $this->assertEquals($data['status'], $version->status);
    }

    /** @test */
    public function it_can_rollback_to_a_version()
    {
        $template = Template::factory()->create();
        $version = $template->versions()->create([
            'version' => 2,
            'content' => '<mjml>Version 2</mjml>',
            'status' => 'published'
        ]);

        $rolledBack = $this->templateService->rollbackVersion($template, 1);

        $this->assertEquals(1, $rolledBack->version);
        $this->assertEquals($template->versions()->where('version', 1)->first()->content, $rolledBack->content);
    }

    /** @test */
    public function it_can_create_a_translation()
    {
        $template = Template::factory()->create();

        $data = [
            'locale' => 'en',
            'content' => '<mjml>English Content</mjml>',
            'subject' => 'English Subject'
        ];

        $translation = $this->templateService->createTranslation($template, $data);

        $this->assertEquals($template->id, $translation->template_id);
        $this->assertEquals($data['locale'], $translation->locale);
        $this->assertEquals($data['content'], $translation->content);
        $this->assertEquals($data['subject'], $translation->subject);
    }

    /** @test */
    public function it_can_update_a_translation()
    {
        $template = Template::factory()->create();
        $translation = $template->translations()->create([
            'locale' => 'en',
            'content' => '<mjml>English Content</mjml>',
            'subject' => 'English Subject'
        ]);

        $data = [
            'content' => '<mjml>Updated English Content</mjml>',
            'subject' => 'Updated English Subject'
        ];

        $updated = $this->templateService->updateTranslation($translation, $data);

        $this->assertEquals($data['content'], $updated->content);
        $this->assertEquals($data['subject'], $updated->subject);
    }

    /** @test */
    public function it_can_delete_a_translation()
    {
        $template = Template::factory()->create();
        $translation = $template->translations()->create([
            'locale' => 'en',
            'content' => '<mjml>English Content</mjml>',
            'subject' => 'English Subject'
        ]);

        $this->templateService->deleteTranslation($translation);

        $this->assertDatabaseMissing('template_translations', [
            'id' => $translation->id
        ]);
    }

    /** @test */
    public function it_can_preview_a_template()
    {
        $template = Template::factory()->create([
            'content' => '<mjml>Test Content</mjml>'
        ]);

        $preview = $this->templateService->preview($template);

        $this->assertIsString($preview);
        $this->assertStringContainsString('Test Content', $preview);
    }

    /** @test */
    public function it_can_test_a_template()
    {
        $template = Template::factory()->create([
            'content' => '<mjml>Test Content</mjml>'
        ]);

        $result = $this->templateService->test($template, 'test@example.com');

        $this->assertTrue($result);
    }

    /** @test */
    public function it_throws_exception_for_invalid_template()
    {
        $this->expectException(TemplateException::class);

        $template = Template::factory()->create([
            'content' => 'Invalid Content'
        ]);

        $this->templateService->preview($template);
    }
}
```

#### 5.1.2 MjmlServiceTest
```php
namespace Modules\Notify\Tests\Unit;

use Tests\TestCase;
use Modules\Notify\Services\MjmlService;
use Modules\Notify\Exceptions\TemplateException;

class MjmlServiceTest extends TestCase
{
    protected $mjmlService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mjmlService = app(MjmlService::class);
    }

    /** @test */
    public function it_can_compile_mjml()
    {
        $mjml = '<mjml>
            <mj-body>
                <mj-section>
                    <mj-column>
                        <mj-text>Hello World</mj-text>
                    </mj-column>
                </mj-section>
            </mj-body>
        </mjml>';

        $html = $this->mjmlService->compile($mjml);

        $this->assertIsString($html);
        $this->assertStringContainsString('Hello World', $html);
    }

    /** @test */
    public function it_can_validate_mjml()
    {
        $validMjml = '<mjml>
            <mj-body>
                <mj-section>
                    <mj-column>
                        <mj-text>Hello World</mj-text>
                    </mj-column>
                </mj-section>
            </mj-body>
        </mjml>';

        $invalidMjml = '<mjml>
            <mj-body>
                <mj-invalid>Hello World</mj-invalid>
            </mj-body>
        </mjml>';

        $this->assertTrue($this->mjmlService->validate($validMjml));
        $this->assertFalse($this->mjmlService->validate($invalidMjml));
    }

    /** @test */
    public function it_can_extract_styles()
    {
        $mjml = '<mjml>
            <mj-head>
                <mj-style>body { color: red; }</mj-style>
            </mj-head>
            <mj-body style="background: blue;">
                <mj-section>
                    <mj-column>
                        <mj-text style="font-size: 20px;">Hello World</mj-text>
                    </mj-column>
                </mj-section>
            </mj-body>
        </mjml>';

        $styles = $this->mjmlService->extractStyles($mjml);

        $this->assertIsArray($styles);
        $this->assertContains('body { color: red; }', $styles);
        $this->assertContains('background: blue', $styles);
        $this->assertContains('font-size: 20px', $styles);
    }

    /** @test */
    public function it_can_extract_components()
    {
        $mjml = '<mjml>
            <mj-head>
                <mj-style>body { color: red; }</mj-style>
            </mj-head>
            <mj-body>
                <mj-section>
                    <mj-column>
                        <mj-text>Hello World</mj-text>
                        <mj-image src="test.jpg" />
                    </mj-column>
                </mj-section>
            </mj-body>
        </mjml>';

        $components = $this->mjmlService->extractComponents($mjml);

        $this->assertIsArray($components);
        $this->assertContains('head', $components);
        $this->assertContains('body', $components);
        $this->assertContains('section', $components);
        $this->assertContains('column', $components);
        $this->assertContains('text', $components);
        $this->assertContains('image', $components);
    }

    /** @test */
    public function it_throws_exception_for_invalid_mjml()
    {
        $this->expectException(TemplateException::class);

        $invalidMjml = '<mjml>
            <mj-body>
                <mj-invalid>Hello World</mj-invalid>
            </mj-body>
        </mjml>';

        $this->mjmlService->compile($invalidMjml);
    }
}
```

#### 5.1.3 MailgunServiceTest
```php
namespace Modules\Notify\Tests\Unit;

use Tests\TestCase;
use Modules\Notify\Services\MailgunService;
use Modules\Notify\Exceptions\TemplateException;

class MailgunServiceTest extends TestCase
{
    protected $mailgunService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mailgunService = app(MailgunService::class);
    }

    /** @test */
    public function it_can_send_an_email()
    {
        $data = [
            'to' => 'test@example.com',
            'subject' => 'Test Subject',
            'html' => '<p>Test Content</p>',
            'from_name' => 'Test Sender',
            'from_email' => 'sender@example.com'
        ];

        $result = $this->mailgunService->send($data);

        $this->assertTrue($result);
    }

    /** @test */
    public function it_can_handle_webhook_events()
    {
        $data = [
            'event' => 'delivered',
            'message-id' => 'test-message-id'
        ];

        $this->mailgunService->handleWebhook($data);

        $this->assertDatabaseHas('template_analytics', [
            'event' => 'delivered',
            'metadata->message_id' => 'test-message-id'
        ]);
    }

    /** @test */
    public function it_throws_exception_for_invalid_email()
    {
        $this->expectException(TemplateException::class);

        $data = [
            'to' => 'invalid-email',
            'subject' => 'Test Subject',
            'html' => '<p>Test Content</p>'
        ];

        $this->mailgunService->send($data);
    }

    /** @test */
    public function it_can_format_from_field()
    {
        $data = [
            'from_name' => 'Test Sender',
            'from_email' => 'sender@example.com'
        ];

        $from = $this->mailgunService->formatFrom($data);

        $this->assertEquals('Test Sender <sender@example.com>', $from);
    }

    /** @test */
    public function it_can_format_attachments()
    {
        $attachments = [
            [
                'path' => 'path/to/file1.pdf',
                'name' => 'file1.pdf'
            ],
            [
                'path' => 'path/to/file2.pdf',
                'name' => 'file2.pdf'
            ]
        ];

        $formatted = $this->mailgunService->formatAttachments($attachments);

        $this->assertIsArray($formatted);
        $this->assertCount(2, $formatted);
        $this->assertEquals('path/to/file1.pdf', $formatted[0]['filePath']);
        $this->assertEquals('file1.pdf', $formatted[0]['filename']);
    }
}
```

### 5.2 Feature Tests

#### 5.2.1 TemplateControllerTest
```php
namespace Modules\Notify\Tests\Feature;

use Tests\TestCase;
use Modules\Notify\Models\Template;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TemplateControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_templates()
    {
        $templates = Template::factory()->count(3)->create();

        $response = $this->getJson('/api/notify/templates');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'subject',
                        'content',
                        'layout',
                        'is_active',
                        'version',
                        'created_at',
                        'updated_at'
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_can_show_a_template()
    {
        $template = Template::factory()->create();

        $response = $this->getJson("/api/notify/templates/{$template->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $template->id,
                    'name' => $template->name,
                    'subject' => $template->subject,
                    'content' => $template->content,
                    'layout' => $template->layout,
                    'is_active' => $template->is_active,
                    'version' => $template->version
                ]
            ]);
    }

    /** @test */
    public function it_can_create_a_template()
    {
        $data = [
            'name' => 'Test Template',
            'subject' => 'Test Subject',
            'content' => '<mjml>Test Content</mjml>',
            'layout' => 'default'
        ];

        $response = $this->postJson('/api/notify/templates', $data);

        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'name' => $data['name'],
                    'subject' => $data['subject'],
                    'content' => $data['content'],
                    'layout' => $data['layout']
                ]
            ]);

        $this->assertDatabaseHas('templates', [
            'name' => $data['name'],
            'subject' => $data['subject'],
            'content' => $data['content'],
            'layout' => $data['layout']
        ]);
    }

    /** @test */
    public function it_can_update_a_template()
    {
        $template = Template::factory()->create();

        $data = [
            'name' => 'Updated Template',
            'subject' => 'Updated Subject',
            'content' => '<mjml>Updated Content</mjml>'
        ];

        $response = $this->putJson("/api/notify/templates/{$template->id}", $data);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => $data['name'],
                    'subject' => $data['subject'],
                    'content' => $data['content']
                ]
            ]);

        $this->assertDatabaseHas('templates', [
            'id' => $template->id,
            'name' => $data['name'],
            'subject' => $data['subject'],
            'content' => $data['content']
        ]);
    }

    /** @test */
    public function it_can_delete_a_template()
    {
        $template = Template::factory()->create();

        $response = $this->deleteJson("/api/notify/templates/{$template->id}");

        $response->assertStatus(204);

        $this->assertSoftDeleted($template);
    }

    /** @test */
    public function it_can_preview_a_template()
    {
        $template = Template::factory()->create([
            'content' => '<mjml>Test Content</mjml>'
        ]);

        $response = $this->getJson("/api/notify/templates/{$template->id}/preview");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'html'
                ]
            ]);
    }

    /** @test */
    public function it_can_test_a_template()
    {
        $template = Template::factory()->create([
            'content' => '<mjml>Test Content</mjml>'
        ]);

        $data = [
            'email' => 'test@example.com',
            'variables' => [
                'name' => 'Test User'
            ]
        ];

        $response = $this->postJson("/api/notify/templates/{$template->id}/test", $data);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Email sent successfully'
            ]);
    }

    /** @test */
    public function it_validates_required_fields()
    {
        $response = $this->postJson('/api/notify/templates', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'name',
                'subject',
                'content'
            ]);
    }

    /** @test */
    public function it_validates_email_format()
    {
        $template = Template::factory()->create();

        $data = [
            'email' => 'invalid-email'
        ];

        $response = $this->postJson("/api/notify/templates/{$template->id}/test", $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'email'
            ]);
    }
}
```

#### 5.2.2 WebhookControllerTest
```php
namespace Modules\Notify\Tests\Feature;

use Tests\TestCase;
use Modules\Notify\Models\Template;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebhookControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_handle_delivered_event()
    {
        $template = Template::factory()->create();

        $data = [
            'event' => 'delivered',
            'message-id' => 'test-message-id',
            'recipient' => 'test@example.com',
            'domain' => 'example.com',
            'timestamp' => time()
        ];

        $response = $this->postJson('/api/notify/webhooks/mailgun', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('template_analytics', [
            'template_id' => $template->id,
            'event' => 'delivered',
            'metadata->message_id' => 'test-message-id'
        ]);
    }

    /** @test */
    public function it_can_handle_opened_event()
    {
        $template = Template::factory()->create();

        $data = [
            'event' => 'opened',
            'message-id' => 'test-message-id',
            'recipient' => 'test@example.com',
            'domain' => 'example.com',
            'timestamp' => time()
        ];

        $response = $this->postJson('/api/notify/webhooks/mailgun', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('template_analytics', [
            'template_id' => $template->id,
            'event' => 'opened',
            'metadata->message_id' => 'test-message-id'
        ]);
    }

    /** @test */
    public function it_can_handle_clicked_event()
    {
        $template = Template::factory()->create();

        $data = [
            'event' => 'clicked',
            'message-id' => 'test-message-id',
            'recipient' => 'test@example.com',
            'domain' => 'example.com',
            'timestamp' => time(),
            'url' => 'https://example.com'
        ];

        $response = $this->postJson('/api/notify/webhooks/mailgun', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('template_analytics', [
            'template_id' => $template->id,
            'event' => 'clicked',
            'metadata->message_id' => 'test-message-id',
            'metadata->url' => 'https://example.com'
        ]);
    }

    /** @test */
    public function it_can_handle_bounced_event()
    {
        $template = Template::factory()->create();

        $data = [
            'event' => 'bounced',
            'message-id' => 'test-message-id',
            'recipient' => 'test@example.com',
            'domain' => 'example.com',
            'timestamp' => time(),
            'code' => '550',
            'error' => 'User unknown'
        ];

        $response = $this->postJson('/api/notify/webhooks/mailgun', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('template_analytics', [
            'template_id' => $template->id,
            'event' => 'bounced',
            'metadata->message_id' => 'test-message-id',
            'metadata->code' => '550',
            'metadata->error' => 'User unknown'
        ]);
    }

    /** @test */
    public function it_can_handle_complained_event()
    {
        $template = Template::factory()->create();

        $data = [
            'event' => 'complained',
            'message-id' => 'test-message-id',
            'recipient' => 'test@example.com',
            'domain' => 'example.com',
            'timestamp' => time()
        ];

        $response = $this->postJson('/api/notify/webhooks/mailgun', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('template_analytics', [
            'template_id' => $template->id,
            'event' => 'complained',
            'metadata->message_id' => 'test-message-id'
        ]);
    }

    /** @test */
    public function it_can_handle_unsubscribed_event()
    {
        $template = Template::factory()->create();

        $data = [
            'event' => 'unsubscribed',
            'message-id' => 'test-message-id',
            'recipient' => 'test@example.com',
            'domain' => 'example.com',
            'timestamp' => time()
        ];

        $response = $this->postJson('/api/notify/webhooks/mailgun', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('template_analytics', [
            'template_id' => $template->id,
            'event' => 'unsubscribed',
            'metadata->message_id' => 'test-message-id'
        ]);
    }

    /** @test */
    public function it_validates_webhook_signature()
    {
        $data = [
            'event' => 'delivered',
            'message-id' => 'test-message-id'
        ];

        $response = $this->postJson('/api/notify/webhooks/mailgun', $data);

        $response->assertStatus(401);
    }
}
``` 
