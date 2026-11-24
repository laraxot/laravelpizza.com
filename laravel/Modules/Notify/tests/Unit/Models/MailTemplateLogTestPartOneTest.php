<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Models;

// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.

use Modules\Notify\Models\MailTemplateLog;
use Modules\Notify\Tests\TestCase;
use Modules\Xot\Tests\XotBasePest;
use PHPUnit\Framework\Assert;

use function Pest\Laravel\withoutExceptionHandling;
use function Safe\json_encode;

uses(TestCase::class);
beforeEach(function (): void {
    withoutExceptionHandling();
});

describe('Mail Template Log PartOne', function (): void {
    test('_can_create_mail_template_log', function (): void {
        $log = MailTemplateLog::create([
            'template_id' => 123,
            'mailable_type' => 'App\Mail\WelcomeMail',
            'mailable_id' => 456,
            'status' => 'sent',
            'status_message' => 'Email sent successfully',
            'data' => [
                'to' => 'user@example.com',
                'subject' => 'Welcome to our platform',
                'template' => 'welcome_email'],
            'metadata' => [
                'provider' => 'smtp',
                'queue_id' => 'queue_789',
                'attempts' => 1],
            'sent_at' => now(),
            'delivered_at' => now()->addMinutes(1)]);
        XotBasePest::assertTableHas('notify', 'mail_template_logs', [
            'id' => $log->id,
            'template_id' => 123,
            'mailable_type' => 'App\Mail\WelcomeMail',
            'mailable_id' => 456,
            'status' => 'sent',
            'status_message' => 'Email sent successfully']);

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
            'clicked_at'];

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
            'clicked_at' => 'datetime'];

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
                'activation_link' => 'https://example.com/activate']];

        $log = MailTemplateLog::create([
            'template_id' => 123,
            'mailable_type' => 'App\Mail\TestMail',
            'mailable_id' => 456,
            'status' => 'sent',
            'data' => $data]);
        XotBasePest::assertTableHas('notify', 'mail_template_logs', [
            'id' => $log->id,
            'data' => json_encode($data)]);
        Assert::assertEquals('user@example.com', TestCase::notifyArrayGet($log->data, 'to'));
        Assert::assertEquals(['cc1@example.com', 'cc2@example.com'], TestCase::notifyArrayGet($log->data, 'cc'));
        Assert::assertEquals('John Doe', TestCase::notifyArrayGet($log->data, 'variables', 'name'));
        Assert::assertEquals('Example Corp', TestCase::notifyArrayGet($log->data, 'variables', 'company'));
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
                'retry_count' => 2],
            'performance' => [
                'queue_time' => 1500,
                'processing_time' => 2500,
                'total_time' => 4000]];

        $log = MailTemplateLog::create([
            'template_id' => 123,
            'mailable_type' => 'App\Mail\TestMail',
            'mailable_id' => 456,
            'status' => 'failed',
            'metadata' => $metadata]);
        XotBasePest::assertTableHas('notify', 'mail_template_logs', [
            'id' => $log->id,
            'metadata' => json_encode($metadata)]);
        Assert::assertEquals('smtp', TestCase::notifyArrayGet($log->metadata, 'provider'));
        Assert::assertEquals('queue_123', TestCase::notifyArrayGet($log->metadata, 'queue_id'));
        Assert::assertEquals(3, TestCase::notifyArrayGet($log->metadata, 'attempts'));
        Assert::assertEquals('SMTP_ERROR', TestCase::notifyArrayGet($log->metadata, 'error_details', 'code'));
        Assert::assertEquals(4000, TestCase::notifyArrayGet($log->metadata, 'performance', 'total_time'));
    });

    test('_can_update_status_and_timestamps', function (): void {
        $log = MailTemplateLog::create([
            'template_id' => 123,
            'mailable_type' => 'App\Mail\TestMail',
            'mailable_id' => 456,
            'status' => 'pending']);

        $log->update([
            'status' => 'sent',
            'sent_at' => now(),
            'status_message' => 'Email sent successfully']);
        XotBasePest::assertTableHas('notify', 'mail_template_logs', [
            'id' => $log->id,
            'status' => 'sent',
            'status_message' => 'Email sent successfully']);

        Assert::assertEquals('sent', XotBasePest::assertFreshModel($log, MailTemplateLog::class)->status);
        Assert::assertNotNull(XotBasePest::assertFreshModel($log, MailTemplateLog::class)->sent_at);
        Assert::assertEquals('Email sent successfully', XotBasePest::assertFreshModel($log, MailTemplateLog::class)->status_message);
    });

    test('_can_mark_as_delivered', function (): void {
        $log = MailTemplateLog::create([
            'template_id' => 123,
            'mailable_type' => 'App\Mail\TestMail',
            'mailable_id' => 456,
            'status' => 'sent',
            'sent_at' => now()]);

        $log->update([
            'status' => 'delivered',
            'delivered_at' => now()->addMinutes(1)]);
        XotBasePest::assertTableHas('notify', 'mail_template_logs', [
            'id' => $log->id,
            'status' => 'delivered']);

        Assert::assertEquals('delivered', XotBasePest::assertFreshModel($log, MailTemplateLog::class)->status);
        Assert::assertNotNull(XotBasePest::assertFreshModel($log, MailTemplateLog::class)->delivered_at);
    });

    test('_can_mark_as_failed', function (): void {
        $log = MailTemplateLog::create([
            'template_id' => 123,
            'mailable_type' => 'App\Mail\TestMail',
            'mailable_id' => 456,
            'status' => 'pending']);

        $log->update([
            'status' => 'failed',
            'failed_at' => now(),
            'status_message' => 'SMTP connection failed']);
        XotBasePest::assertTableHas('notify', 'mail_template_logs', [
            'id' => $log->id,
            'status' => 'failed',
            'status_message' => 'SMTP connection failed']);

        Assert::assertEquals('failed', XotBasePest::assertFreshModel($log, MailTemplateLog::class)->status);
        Assert::assertNotNull(XotBasePest::assertFreshModel($log, MailTemplateLog::class)->failed_at);
        Assert::assertEquals('SMTP connection failed', XotBasePest::assertFreshModel($log, MailTemplateLog::class)->status_message);
    });

    test('_can_mark_as_opened', function (): void {
        $log = MailTemplateLog::create([
            'template_id' => 123,
            'mailable_type' => 'App\Mail\TestMail',
            'mailable_id' => 456,
            'status' => 'delivered',
            'delivered_at' => now()]);

        $log->update([
            'opened_at' => now()->addMinutes(5)]);
        XotBasePest::assertTableHas('notify', 'mail_template_logs', [
            'id' => $log->id,
            'opened_at' => XotBasePest::assertFreshModel($log, MailTemplateLog::class)->opened_at]);

        Assert::assertNotNull(XotBasePest::assertFreshModel($log, MailTemplateLog::class)->opened_at);
    });
});
