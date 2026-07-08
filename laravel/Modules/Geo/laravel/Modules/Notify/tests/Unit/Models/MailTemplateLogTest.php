<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Models;

use function Safe\json_encode;
use PHPUnit\Framework\Assert;
use Modules\Notify\Models\MailTemplateLog;
use Modules\Notify\Tests\TestCase;
use function Pest\Laravel\get;

uses(\Modules\Notify\Tests\TestCase::class);

beforeEach(function (): void {
    /** @var \Modules\Notify\Tests\TestCase $this */
$this->disableExceptionHandling();
});

describe('Mail Template Log', function (): void {
    test('_can_create_mail_template_log', function (): void {
        /** @var \Modules\Notify\Tests\TestCase $this */
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
        \assertNotifyTableHas('mail_template_logs', [
            'id' => $log->id,
            'template_id' => 123,
            'mailable_type' => 'App\Mail\WelcomeMail',
            'mailable_id' => 456,
            'status' => 'sent',
            'status_message' => 'Email sent successfully',
        ]);

        Assert::assertInstanceOf(MailTemplateLog::class, $log);
    });

    test('_has_correct_fillable_fields', function (): void {
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

        Assert::assertEquals($expectedFillable, $log->getFillable());
    });

    test('_has_correct_casts', function (): void {
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

        Assert::assertEquals($expectedCasts, $log->getCasts());
    });

    test('_can_store_json_data', function (): void {
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
        \assertNotifyTableHas('mail_template_logs', [
            'id' => $log->id,
            'data' => json_encode($data),
        ]);
        Assert::assertEquals('user@example.com', $log->data['to']);
        Assert::assertEquals(['cc1@example.com', 'cc2@example.com'], $log->data['cc']);
        Assert::assertEquals('John Doe', \notifyArrayGet($log->data, 'variables', 'name'));
        Assert::assertEquals('Example Corp', \notifyArrayGet($log->data, 'variables', 'company'));
    });

    test('_can_store_json_metadata', function (): void {
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
        \assertNotifyTableHas('mail_template_logs', [
            'id' => $log->id,
            'metadata' => json_encode($metadata),
        ]);
        Assert::assertEquals('smtp', $log->metadata['provider']);
        Assert::assertEquals('queue_123', $log->metadata['queue_id']);
        Assert::assertEquals(3, $log->metadata['attempts']);
        Assert::assertEquals('SMTP_ERROR', \notifyArrayGet($log->metadata, 'error_details', 'code'));
        Assert::assertEquals(4000, \notifyArrayGet($log->metadata, 'performance', 'total_time'));
    });

    test('_can_update_status_and_timestamps', function (): void {
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
        \assertNotifyTableHas('mail_template_logs', [
            'id' => $log->id,
            'status' => 'sent',
            'status_message' => 'Email sent successfully',
        ]);

        Assert::assertEquals('sent', \assertFreshModel($log, \Modules\Notify\Models\MailTemplateLog::class)->status);
        Assert::assertNotNull(\assertFreshModel($log, \Modules\Notify\Models\MailTemplateLog::class)->sent_at);
        Assert::assertEquals('Email sent successfully', \assertFreshModel($log, \Modules\Notify\Models\MailTemplateLog::class)->status_message);
    });

    test('_can_mark_as_delivered', function (): void {
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
        \assertNotifyTableHas('mail_template_logs', [
            'id' => $log->id,
            'status' => 'delivered',
        ]);

        Assert::assertEquals('delivered', \assertFreshModel($log, \Modules\Notify\Models\MailTemplateLog::class)->status);
        Assert::assertNotNull(\assertFreshModel($log, \Modules\Notify\Models\MailTemplateLog::class)->delivered_at);
    });

    test('_can_mark_as_failed', function (): void {
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
        \assertNotifyTableHas('mail_template_logs', [
            'id' => $log->id,
            'status' => 'failed',
            'status_message' => 'SMTP connection failed',
        ]);

        Assert::assertEquals('failed', \assertFreshModel($log, \Modules\Notify\Models\MailTemplateLog::class)->status);
        Assert::assertNotNull(\assertFreshModel($log, \Modules\Notify\Models\MailTemplateLog::class)->failed_at);
        Assert::assertEquals('SMTP connection failed', \assertFreshModel($log, \Modules\Notify\Models\MailTemplateLog::class)->status_message);
    });

    test('_can_mark_as_opened', function (): void {
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
        \assertNotifyTableHas('mail_template_logs', [
            'id' => $log->id,
            'opened_at' => \assertFreshModel($log, \Modules\Notify\Models\MailTemplateLog::class)->opened_at,
        ]);

        Assert::assertNotNull(\assertFreshModel($log, \Modules\Notify\Models\MailTemplateLog::class)->opened_at);
    });

    test('_can_mark_as_clicked', function (): void {
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
        \assertNotifyTableHas('mail_template_logs', [
            'id' => $log->id,
            'clicked_at' => \assertFreshModel($log, \Modules\Notify\Models\MailTemplateLog::class)->clicked_at,
        ]);

        Assert::assertNotNull(\assertFreshModel($log, \Modules\Notify\Models\MailTemplateLog::class)->clicked_at);
    });

    test('_can_find_by_template_id', function (): void {
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

        Assert::assertCount(2, $template123Logs);
        Assert::assertCount(1, $template456Logs);
        Assert::assertEquals(123, \assertFirstModel($template123Logs, \Modules\Notify\Models\MailTemplateLog::class)->template_id);
        Assert::assertEquals(123, \assertFirstModel($template123Logs->slice(1), \Modules\Notify\Models\MailTemplateLog::class)->template_id);
        Assert::assertEquals(456, \assertFirstModel($template456Logs, \Modules\Notify\Models\MailTemplateLog::class)->template_id);
    });

    test('_can_find_by_status', function (): void {
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

        Assert::assertCount(1, $sentLogs);
        Assert::assertCount(1, $failedLogs);
        Assert::assertCount(1, $deliveredLogs);
        Assert::assertEquals('sent', \assertFirstModel($sentLogs, \Modules\Notify\Models\MailTemplateLog::class)->status);
        Assert::assertEquals('failed', \assertFirstModel($failedLogs, \Modules\Notify\Models\MailTemplateLog::class)->status);
        Assert::assertEquals('delivered', \assertFirstModel($deliveredLogs, \Modules\Notify\Models\MailTemplateLog::class)->status);
    });

    test('_can_find_by_mailable_type', function (): void {
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

        Assert::assertCount(2, $testMailLogs);
        Assert::assertCount(1, $welcomeMailLogs);
        Assert::assertEquals('App\Mail\TestMail', \assertFirstModel($testMailLogs, \Modules\Notify\Models\MailTemplateLog::class)->mailable_type);
        Assert::assertEquals('App\Mail\TestMail', \assertFirstModel($testMailLogs->slice(1), \Modules\Notify\Models\MailTemplateLog::class)->mailable_type);
        Assert::assertEquals('App\Mail\WelcomeMail', \assertFirstModel($welcomeMailLogs, \Modules\Notify\Models\MailTemplateLog::class)->mailable_type);
    });

    test('_can_find_by_date_range', function (): void {
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

        Assert::assertCount(1, $todayLogs);
        Assert::assertCount(2, $recentLogs); // yesterday and today
        Assert::assertEquals('App\Mail\WelcomeMail', \assertFirstModel($todayLogs, \Modules\Notify\Models\MailTemplateLog::class)->mailable_type);
    });

    test('_can_find_by_data_pattern', function (): void {
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

        Assert::assertCount(1, $welcomeSubjectLogs);
        Assert::assertCount(1, $welcomeTemplateLogs);
        Assert::assertEquals('Welcome to our platform', \assertFirstModel($welcomeSubjectLogs, \Modules\Notify\Models\MailTemplateLog::class)->data['subject']);
        Assert::assertEquals('welcome_template', \notifyArrayGet(\assertFirstModel($welcomeTemplateLogs, \Modules\Notify\Models\MailTemplateLog::class)->data, 'template'));
    });

    test('_can_find_by_metadata_pattern', function (): void {
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

        Assert::assertCount(1, $smtpLogs);
        Assert::assertCount(1, $sesLogs);
        Assert::assertEquals('smtp', \assertFirstModel($smtpLogs, \Modules\Notify\Models\MailTemplateLog::class)->metadata['provider']);
        Assert::assertEquals('ses', \assertFirstModel($sesLogs, \Modules\Notify\Models\MailTemplateLog::class)->metadata['provider']);
    });

    test('_can_find_by_multiple_criteria', function (): void {
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

        Assert::assertCount(1, $smtpWelcomeLogs);
        Assert::assertEquals('sent', \assertFirstModel($smtpWelcomeLogs, \Modules\Notify\Models\MailTemplateLog::class)->status);
        Assert::assertEquals('smtp', \assertFirstModel($smtpWelcomeLogs, \Modules\Notify\Models\MailTemplateLog::class)->metadata['provider']);
        Assert::assertEquals('Welcome email', \assertFirstModel($smtpWelcomeLogs, \Modules\Notify\Models\MailTemplateLog::class)->data['subject']);
    });

    test('_can_handle_null_values', function (): void {
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

        Assert::assertNull($log->template_id);
        Assert::assertNull($log->mailable_type);
        Assert::assertNull($log->mailable_id);
        Assert::assertNull($log->status);
        Assert::assertNull($log->status_message);
        Assert::assertNull($log->data);
        Assert::assertNull($log->metadata);
        Assert::assertNull($log->sent_at);
        Assert::assertNull($log->delivered_at);
        Assert::assertNull($log->failed_at);
        Assert::assertNull($log->opened_at);
        Assert::assertNull($log->clicked_at);
    });

    test('_can_handle_empty_arrays', function (): void {
$log = MailTemplateLog::create([
            'template_id' => 123,
            'mailable_type' => 'App\Mail\TestMail',
            'mailable_id' => 456,
            'status' => 'sent',
            'data' => [],
            'metadata' => [],
        ]);
        \assertNotifyTableHas('mail_template_logs', [
            'id' => $log->id,
            'data' => json_encode([]),
            'metadata' => json_encode([]),
        ]);
        Assert::assertEmpty($log->data);
        Assert::assertEmpty($log->metadata);
    });
});
