<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Notify\Models\MailTemplateLog;
use Tests\TestCase;

class MailTemplateLogTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    /** @test */
    public function it_can_create_mail_template_log(): void
    {
        $log = MailTemplateLog::create([
            'template_id' => 123,
            'mailable_type' => 'App\Mail\WelcomeMail',
            'mailable_id' => 456,
            'status' => 'sent',
            'status_message' => 'Email sent successfully',
            'data' => [
                'to' => 'user@example.com',
                'subject' => 'Welcome to our platform',
                'template' => 'welcome_email',
            ],
            'metadata' => [
                'provider' => 'smtp',
                'queue_id' => 'queue_789',
                'attempts' => 1,
            ],
            'sent_at' => now(),
            'delivered_at' => now()->addMinutes(1),
        ]);

        $this->assertDatabaseHas('mail_template_logs', [
            'id' => $log->id,
            'template_id' => 123,
            'mailable_type' => 'App\Mail\WelcomeMail',
            'mailable_id' => 456,
            'status' => 'sent',
            'status_message' => 'Email sent successfully',
        ]);

        $this->assertInstanceOf(MailTemplateLog::class, $log);
    }

    /** @test */
    public function it_has_correct_fillable_fields(): void
    {
        $log = new MailTemplateLog;

        $expectedFillable = [
            'template_id',
            'mailable_type',
            'mailable_id',
            'status',
            'status_message',
            'data',
            'metadata',
            'sent_at',
            'delivered_at',
            'failed_at',
            'opened_at',
            'clicked_at',
        ];

        $this->assertEquals($expectedFillable, $log->getFillable());
    }

    /** @test */
    public function it_has_correct_casts(): void
    {
        $log = new MailTemplateLog;

        $expectedCasts = [
            'id' => 'string',
            'uuid' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
            'updated_by' => 'string',
            'created_by' => 'string',
            'deleted_by' => 'string',
            'data' => 'array',
            'metadata' => 'array',
            'sent_at' => 'datetime',
            'delivered_at' => 'datetime',
            'failed_at' => 'datetime',
            'opened_at' => 'datetime',
            'clicked_at' => 'datetime',
        ];

        $this->assertEquals($expectedCasts, $log->casts());
    }

    /** @test */
    public function it_can_store_json_data(): void
    {
        $data = [
            'to' => 'user@example.com',
            'cc' => ['cc1@example.com', 'cc2@example.com'],
            'bcc' => ['bcc@example.com'],
            'subject' => 'Test Email Subject',
            'body' => 'Test email body content',
            'template' => 'test_template',
            'variables' => [
                'name' => 'John Doe',
                'company' => 'Example Corp',
                'activation_link' => 'https://example.com/activate',
            ],
        ];

        $log = MailTemplateLog::create([
            'template_id' => 123,
            'mailable_type' => 'App\Mail\TestMail',
            'mailable_id' => 456,
            'status' => 'sent',
            'data' => $data,
        ]);

        $this->assertDatabaseHas('mail_template_logs', [
            'id' => $log->id,
            'data' => json_encode($data),
        ]);

        $this->assertIsArray($log->data);
        $this->assertEquals('user@example.com', $log->data['to']);
        $this->assertEquals(['cc1@example.com', 'cc2@example.com'], $log->data['cc']);
        $this->assertEquals('John Doe', $log->data['variables']['name']);
        $this->assertEquals('Example Corp', $log->data['variables']['company']);
    }

    /** @test */
    public function it_can_store_json_metadata(): void
    {
        $metadata = [
            'provider' => 'smtp',
            'queue_id' => 'queue_123',
            'attempts' => 3,
            'max_attempts' => 5,
            'retry_after' => 300,
            'error_details' => [
                'code' => 'SMTP_ERROR',
                'message' => 'Connection timeout',
                'retry_count' => 2,
            ],
            'performance' => [
                'queue_time' => 1500,
                'processing_time' => 2500,
                'total_time' => 4000,
            ],
        ];

        $log = MailTemplateLog::create([
            'template_id' => 123,
            'mailable_type' => 'App\Mail\TestMail',
            'mailable_id' => 456,
            'status' => 'failed',
            'metadata' => $metadata,
        ]);

        $this->assertDatabaseHas('mail_template_logs', [
            'id' => $log->id,
            'metadata' => json_encode($metadata),
        ]);

        $this->assertIsArray($log->metadata);
        $this->assertEquals('smtp', $log->metadata['provider']);
        $this->assertEquals('queue_123', $log->metadata['queue_id']);
        $this->assertEquals(3, $log->metadata['attempts']);
        $this->assertEquals('SMTP_ERROR', $log->metadata['error_details']['code']);
        $this->assertEquals(4000, $log->metadata['performance']['total_time']);
    }

    /** @test */
    public function it_can_update_status_and_timestamps(): void
    {
        $log = MailTemplateLog::create([
            'template_id' => 123,
            'mailable_type' => 'App\Mail\TestMail',
            'mailable_id' => 456,
            'status' => 'pending',
        ]);

        $log->update([
            'status' => 'sent',
            'sent_at' => now(),
            'status_message' => 'Email sent successfully',
        ]);

        $this->assertDatabaseHas('mail_template_logs', [
            'id' => $log->id,
            'status' => 'sent',
            'status_message' => 'Email sent successfully',
        ]);

        $this->assertEquals('sent', $log->fresh()->status);
        $this->assertNotNull($log->fresh()->sent_at);
        $this->assertEquals('Email sent successfully', $log->fresh()->status_message);
    }

    /** @test */
    public function it_can_mark_as_delivered(): void
    {
        $log = MailTemplateLog::create([
            'template_id' => 123,
            'mailable_type' => 'App\Mail\TestMail',
            'mailable_id' => 456,
            'status' => 'sent',
            'sent_at' => now(),
        ]);

        $log->update([
            'status' => 'delivered',
            'delivered_at' => now()->addMinutes(1),
        ]);

        $this->assertDatabaseHas('mail_template_logs', [
            'id' => $log->id,
            'status' => 'delivered',
        ]);

        $this->assertEquals('delivered', $log->fresh()->status);
        $this->assertNotNull($log->fresh()->delivered_at);
    }

    /** @test */
    public function it_can_mark_as_failed(): void
    {
        $log = MailTemplateLog::create([
            'template_id' => 123,
            'mailable_type' => 'App\Mail\TestMail',
            'mailable_id' => 456,
            'status' => 'pending',
        ]);

        $log->update([
            'status' => 'failed',
            'failed_at' => now(),
            'status_message' => 'SMTP connection failed',
        ]);

        $this->assertDatabaseHas('mail_template_logs', [
            'id' => $log->id,
            'status' => 'failed',
            'status_message' => 'SMTP connection failed',
        ]);

        $this->assertEquals('failed', $log->fresh()->status);
        $this->assertNotNull($log->fresh()->failed_at);
        $this->assertEquals('SMTP connection failed', $log->fresh()->status_message);
    }

    /** @test */
    public function it_can_mark_as_opened(): void
    {
        $log = MailTemplateLog::create([
            'template_id' => 123,
            'mailable_type' => 'App\Mail\TestMail',
            'mailable_id' => 456,
            'status' => 'delivered',
            'delivered_at' => now(),
        ]);

        $log->update([
            'opened_at' => now()->addMinutes(5),
        ]);

        $this->assertDatabaseHas('mail_template_logs', [
            'id' => $log->id,
            'opened_at' => $log->fresh()->opened_at,
        ]);

        $this->assertNotNull($log->fresh()->opened_at);
    }

    /** @test */
    public function it_can_mark_as_clicked(): void
    {
        $log = MailTemplateLog::create([
            'template_id' => 123,
            'mailable_type' => 'App\Mail\TestMail',
            'mailable_id' => 456,
            'status' => 'delivered',
            'delivered_at' => now(),
            'opened_at' => now()->addMinutes(5),
        ]);

        $log->update([
            'clicked_at' => now()->addMinutes(10),
        ]);

        $this->assertDatabaseHas('mail_template_logs', [
            'id' => $log->id,
            'clicked_at' => $log->fresh()->clicked_at,
        ]);

        $this->assertNotNull($log->fresh()->clicked_at);
    }

    /** @test */
    public function it_can_find_by_template_id(): void
    {
        MailTemplateLog::create([
            'template_id' => 123,
            'mailable_type' => 'App\Mail\TestMail',
            'mailable_id' => 456,
            'status' => 'sent',
        ]);

        MailTemplateLog::create([
            'template_id' => 123,
            'mailable_type' => 'App\Mail\WelcomeMail',
            'mailable_id' => 789,
            'status' => 'sent',
        ]);

        MailTemplateLog::create([
            'template_id' => 456,
            'mailable_type' => 'App\Mail\TestMail',
            'mailable_id' => 101,
            'status' => 'sent',
        ]);

        $template123Logs = MailTemplateLog::where('template_id', 123)->get();
        $template456Logs = MailTemplateLog::where('template_id', 456)->get();

        $this->assertCount(2, $template123Logs);
        $this->assertCount(1, $template456Logs);
        $this->assertEquals(123, $template123Logs[0]->template_id);
        $this->assertEquals(123, $template123Logs[1]->template_id);
        $this->assertEquals(456, $template456Logs[0]->template_id);
    }

    /** @test */
    public function it_can_find_by_status(): void
    {
        MailTemplateLog::create([
            'template_id' => 123,
            'mailable_type' => 'App\Mail\TestMail',
            'mailable_id' => 456,
            'status' => 'sent',
        ]);

        MailTemplateLog::create([
            'template_id' => 124,
            'mailable_type' => 'App\Mail\WelcomeMail',
            'mailable_id' => 789,
            'status' => 'failed',
        ]);

        MailTemplateLog::create([
            'template_id' => 125,
            'mailable_type' => 'App\Mail\NewsletterMail',
            'mailable_id' => 101,
            'status' => 'delivered',
        ]);

        $sentLogs = MailTemplateLog::where('status', 'sent')->get();
        $failedLogs = MailTemplateLog::where('status', 'failed')->get();
        $deliveredLogs = MailTemplateLog::where('status', 'delivered')->get();

        $this->assertCount(1, $sentLogs);
        $this->assertCount(1, $failedLogs);
        $this->assertCount(1, $deliveredLogs);
        $this->assertEquals('sent', $sentLogs[0]->status);
        $this->assertEquals('failed', $failedLogs[0]->status);
        $this->assertEquals('delivered', $deliveredLogs[0]->status);
    }

    /** @test */
    public function it_can_find_by_mailable_type(): void
    {
        MailTemplateLog::create([
            'template_id' => 123,
            'mailable_type' => 'App\Mail\TestMail',
            'mailable_id' => 456,
            'status' => 'sent',
        ]);

        MailTemplateLog::create([
            'template_id' => 124,
            'mailable_type' => 'App\Mail\WelcomeMail',
            'mailable_id' => 789,
            'status' => 'sent',
        ]);

        MailTemplateLog::create([
            'template_id' => 125,
            'mailable_type' => 'App\Mail\TestMail',
            'mailable_id' => 101,
            'status' => 'sent',
        ]);

        $testMailLogs = MailTemplateLog::where('mailable_type', 'App\Mail\TestMail')->get();
        $welcomeMailLogs = MailTemplateLog::where('mailable_type', 'App\Mail\WelcomeMail')->get();

        $this->assertCount(2, $testMailLogs);
        $this->assertCount(1, $welcomeMailLogs);
        $this->assertEquals('App\Mail\TestMail', $testMailLogs[0]->mailable_type);
        $this->assertEquals('App\Mail\TestMail', $testMailLogs[1]->mailable_type);
        $this->assertEquals('App\Mail\WelcomeMail', $welcomeMailLogs[0]->mailable_type);
    }

    /** @test */
    public function it_can_find_by_date_range(): void
    {
        $yesterday = now()->subDay();
        $today = now();
        $tomorrow = now()->addDay();

        MailTemplateLog::create([
            'template_id' => 123,
            'mailable_type' => 'App\Mail\TestMail',
            'mailable_id' => 456,
            'status' => 'sent',
            'sent_at' => $yesterday,
        ]);

        MailTemplateLog::create([
            'template_id' => 124,
            'mailable_type' => 'App\Mail\WelcomeMail',
            'mailable_id' => 789,
            'status' => 'sent',
            'sent_at' => $today,
        ]);

        MailTemplateLog::create([
            'template_id' => 125,
            'mailable_type' => 'App\Mail\NewsletterMail',
            'mailable_id' => 101,
            'status' => 'sent',
            'sent_at' => $tomorrow,
        ]);

        $todayLogs = MailTemplateLog::whereDate('sent_at', $today->toDateString())->get();
        $recentLogs = MailTemplateLog::where('sent_at', '>=', $yesterday)->get();

        $this->assertCount(1, $todayLogs);
        $this->assertCount(2, $recentLogs); // yesterday and today
        $this->assertEquals('App\Mail\WelcomeMail', $todayLogs[0]->mailable_type);
    }

    /** @test */
    public function it_can_find_by_data_pattern(): void
    {
        MailTemplateLog::create([
            'template_id' => 123,
            'mailable_type' => 'App\Mail\TestMail',
            'mailable_id' => 456,
            'status' => 'sent',
            'data' => [
                'to' => 'user@example.com',
                'subject' => 'Welcome to our platform',
                'template' => 'welcome_template',
            ],
        ]);

        MailTemplateLog::create([
            'template_id' => 124,
            'mailable_type' => 'App\Mail\WelcomeMail',
            'mailable_id' => 789,
            'status' => 'sent',
            'data' => [
                'to' => 'admin@example.com',
                'subject' => 'System notification',
                'template' => 'system_template',
            ],
        ]);

        $welcomeSubjectLogs = MailTemplateLog::whereJsonPath('data.subject', 'like', '%Welcome%')->get();
        $welcomeTemplateLogs = MailTemplateLog::whereJsonPath('data.template', 'like', '%welcome%')->get();

        $this->assertCount(1, $welcomeSubjectLogs);
        $this->assertCount(1, $welcomeTemplateLogs);
        $this->assertEquals('Welcome to our platform', $welcomeSubjectLogs[0]->data['subject']);
        $this->assertEquals('welcome_template', $welcomeTemplateLogs[0]->data['template']);
    }

    /** @test */
    public function it_can_find_by_metadata_pattern(): void
    {
        MailTemplateLog::create([
            'template_id' => 123,
            'mailable_type' => 'App\Mail\TestMail',
            'mailable_id' => 456,
            'status' => 'sent',
            'metadata' => [
                'provider' => 'smtp',
                'queue_id' => 'queue_123',
                'attempts' => 1,
            ],
        ]);

        MailTemplateLog::create([
            'template_id' => 124,
            'mailable_type' => 'App\Mail\WelcomeMail',
            'mailable_id' => 789,
            'status' => 'sent',
            'metadata' => [
                'provider' => 'ses',
                'queue_id' => 'queue_456',
                'attempts' => 1,
            ],
        ]);

        $smtpLogs = MailTemplateLog::whereJsonPath('metadata.provider', 'smtp')->get();
        $sesLogs = MailTemplateLog::whereJsonPath('metadata.provider', 'ses')->get();

        $this->assertCount(1, $smtpLogs);
        $this->assertCount(1, $sesLogs);
        $this->assertEquals('smtp', $smtpLogs[0]->metadata['provider']);
        $this->assertEquals('ses', $sesLogs[0]->metadata['provider']);
    }

    /** @test */
    public function it_can_find_by_multiple_criteria(): void
    {
        MailTemplateLog::create([
            'template_id' => 123,
            'mailable_type' => 'App\Mail\TestMail',
            'mailable_id' => 456,
            'status' => 'sent',
            'data' => [
                'to' => 'user@example.com',
                'subject' => 'Welcome email',
            ],
            'metadata' => [
                'provider' => 'smtp',
                'attempts' => 1,
            ],
        ]);

        MailTemplateLog::create([
            'template_id' => 124,
            'mailable_type' => 'App\Mail\WelcomeMail',
            'mailable_id' => 789,
            'status' => 'failed',
            'data' => [
                'to' => 'admin@example.com',
                'subject' => 'System notification',
            ],
            'metadata' => [
                'provider' => 'smtp',
                'attempts' => 3,
            ],
        ]);

        $smtpWelcomeLogs = MailTemplateLog::where('status', 'sent')
            ->whereJsonPath('metadata.provider', 'smtp')
            ->whereJsonPath('data.subject', 'like', '%Welcome%')
            ->get();

        $this->assertCount(1, $smtpWelcomeLogs);
        $this->assertEquals('sent', $smtpWelcomeLogs[0]->status);
        $this->assertEquals('smtp', $smtpWelcomeLogs[0]->metadata['provider']);
        $this->assertEquals('Welcome email', $smtpWelcomeLogs[0]->data['subject']);
    }

    /** @test */
    public function it_can_handle_null_values(): void
    {
        $log = MailTemplateLog::create([
            'template_id' => null,
            'mailable_type' => null,
            'mailable_id' => null,
            'status' => null,
            'status_message' => null,
            'data' => null,
            'metadata' => null,
            'sent_at' => null,
            'delivered_at' => null,
            'failed_at' => null,
            'opened_at' => null,
            'clicked_at' => null,
        ]);

        $this->assertNull($log->template_id);
        $this->assertNull($log->mailable_type);
        $this->assertNull($log->mailable_id);
        $this->assertNull($log->status);
        $this->assertNull($log->status_message);
        $this->assertNull($log->data);
        $this->assertNull($log->metadata);
        $this->assertNull($log->sent_at);
        $this->assertNull($log->delivered_at);
        $this->assertNull($log->failed_at);
        $this->assertNull($log->opened_at);
        $this->assertNull($log->clicked_at);
    }

    /** @test */
    public function it_can_handle_empty_arrays(): void
    {
        $log = MailTemplateLog::create([
            'template_id' => 123,
            'mailable_type' => 'App\Mail\TestMail',
            'mailable_id' => 456,
            'status' => 'sent',
            'data' => [],
            'metadata' => [],
        ]);

        $this->assertDatabaseHas('mail_template_logs', [
            'id' => $log->id,
            'data' => json_encode([]),
            'metadata' => json_encode([]),
        ]);

        $this->assertIsArray($log->data);
        $this->assertIsArray($log->metadata);
        $this->assertEmpty($log->data);
        $this->assertEmpty($log->metadata);
    }
}
