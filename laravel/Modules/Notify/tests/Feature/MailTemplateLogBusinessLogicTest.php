<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Feature;

use Modules\Notify\Database\Factories\MailTemplateFactory;
use Modules\Notify\Database\Factories\MailTemplateLogFactory;
use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Models\MailTemplateLog;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\json_encode;

uses(\Modules\Notify\Tests\TestCase::class);

describe('Mail Template Log Business Logic', function () {
    it('can create mail template log with basic information', function () {
        $template = MailTemplateFactory::new()->createOne();

        $logData = [
            'template_id' => $template->id,
            'mailable_type' => 'App\Mail\AppointmentConfirmation',
            'mailable_id' => 123,
            'status' => 'sent',
            'status_message' => 'Email inviata con successo',
            'data' => [
                'recipient' => 'patient@example.com',
                'variables' => [
                    'patient_name' => 'Mario Rossi',
                ],
            ],
            'metadata' => [
                'campaign_id' => 'appointment_confirmation_001',
            ],
            'sent_at' => now(),
        ];

        $log = MailTemplateLog::query()->create($logData);

        \assertNotifyTableHas('mail_template_logs', [
            'id' => $log->id,
            'template_id' => $template->id,
            'status' => 'sent',
            'status_message' => 'Email inviata con successo',
        ]);

        Assert::assertSame('sent', $log->status);
        $data = \assertNotifyArray($log->data);
        $variables = \assertNotifyArray($data['variables'] ?? null);
        Assert::assertSame('patient@example.com', $data['recipient']);
        Assert::assertSame('Mario Rossi', $variables['patient_name']);
        Assert::assertSame('appointment_confirmation_001', \assertNotifyArray($log->metadata)['campaign_id']);
    });

    it('can manage mail template log template relationship', function () {
        $template = MailTemplateFactory::new()->createOne();
        $log = MailTemplateLogFactory::new()->createOne([
            'template_id' => $template->id,
        ]);

        Assert::assertInstanceOf(MailTemplate::class, $log->template);
        Assert::assertSame($template->id, $log->template->id);
    });

    it('can track email lifecycle events', function () {
        $template = MailTemplateFactory::new()->createOne();
        $log = MailTemplateLogFactory::new()->createOne([
            'template_id' => $template->id,
            'status' => 'pending',
        ]);

        $log->update([
            'status' => 'sent',
            'sent_at' => now(),
        ]);

        $log->update([
            'status' => 'delivered',
            'delivered_at' => now(),
        ]);

        $fresh = \assertFreshModel($log, MailTemplateLog::class);
        Assert::assertSame('delivered', $fresh->status);
        Assert::assertNotNull($fresh->sent_at);
        Assert::assertNotNull($fresh->delivered_at);
    });

    it('can handle email failure scenarios', function () {
        $template = MailTemplateFactory::new()->createOne();
        $log = MailTemplateLogFactory::new()->createOne([
            'template_id' => $template->id,
            'status' => 'pending',
        ]);

        $log->update([
            'status' => 'failed',
            'status_message' => 'SMTP timeout',
            'failed_at' => now(),
            'metadata' => ['error_code' => 'TIMEOUT'],
        ]);

        $fresh = \assertFreshModel($log, MailTemplateLog::class);
        Assert::assertSame('failed', $fresh->status);
        Assert::assertSame('SMTP timeout', $fresh->status_message);
        Assert::assertSame('TIMEOUT', \assertNotifyArray($fresh->metadata)['error_code']);
    });

    it('can persist structured data and metadata as json', function () {
        $template = MailTemplateFactory::new()->createOne();
        $payload = [
            'recipient' => 'user@example.com',
            'tags' => ['welcome', 'transactional'],
        ];
        $meta = ['provider' => 'sendgrid', 'attempt' => 1];

        $log = MailTemplateLogFactory::new()->createOne([
            'template_id' => $template->id,
            'data' => $payload,
            'metadata' => $meta,
        ]);

        \assertNotifyTableHas('mail_template_logs', [
            'id' => $log->id,
            'data' => json_encode($payload),
            'metadata' => json_encode($meta),
        ]);
    });
});
