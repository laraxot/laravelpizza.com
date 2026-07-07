<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Datas;

use Illuminate\Support\Collection;
use Modules\Notify\Datas\FirebaseNotificationData;
use Modules\Notify\Datas\NetfunSmsData;
use Modules\Notify\Datas\NetfunSmsMessage;
use Modules\Notify\Datas\NetfunSmsRequestData;
use Modules\Notify\Datas\NetfunSmsResponseData;
use Modules\Notify\Datas\SendNotificationBulkResultData;
use Modules\Notify\Datas\SMS\SmsFactorData;
use Modules\Notify\Datas\SmsMessageData;
use Modules\Notify\Datas\TelegramData;
use Modules\Notify\Datas\WhatsAppData;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('netfun sms request and response data can be created from arrays', function () {
    $request = NetfunSmsRequestData::fromArray([
        'token' => 'abc-token',
        'messages' => [
            ['recipient' => '+391234', 'text' => 'hello'],
        ],
    ]);

    $response = NetfunSmsResponseData::fromArray([
        'status' => 'ok',
        'batchId' => 'batch-1',
        'messages' => [
            ['id' => 'm1', 'status' => 'queued'],
        ],
    ]);

    Assert::assertSame('abc-token', $request->token);
    Assert::assertCount(1, \assertNotifyArray($request->messages));
    Assert::assertSame('ok', $response->status);
    Assert::assertSame('batch-1', $response->batchId);
    Assert::assertCount(1, \assertNotifyArray($response->messages));
});

test('netfun sms message-style data objects keep values', function () {
    $data = new NetfunSmsData(
        recipient: '+39123',
        message: 'Body',
        sender: 'Sender',
        reference: 'ref-1',
        scheduledDate: '2026-03-06 10:00:00',
    );

    $message = new NetfunSmsMessage(
        recipient: '+39999',
        text: 'Text',
        sender: 'Sender2',
    );

    Assert::assertSame('+39123', $data->recipient);
    Assert::assertSame('Body', $data->message);
    Assert::assertSame('+39999', $message->recipient);
    Assert::assertSame('Text', $message->text);
});

test('sms driver data classes expose auth headers and defaults', function () {
    config()->set('sms.drivers.smsfactor', [
        'token' => 'tok',
    ]);

    $smsfactor = SmsFactorData::make();

    Assert::assertArrayHasKey('Authorization', $smsfactor->getAuthHeaders());
});

test('telegram, whatsapp and sms message datas keep payload', function () {
    $telegram = new TelegramData(chatId: '123', text: 'hello', parseMode: 'HTML');
    $whatsapp = new WhatsAppData(recipient: '+39111', body: 'body', type: 'text');
    $smsMessage = new SmsMessageData(recipient: '+39222', message: 'sms body', sender: 'ACME');

    Assert::assertSame('123', $telegram->chatId);
    Assert::assertSame('hello', $telegram->text);
    Assert::assertSame('+39111', $whatsapp->recipient);
    Assert::assertSame('body', $whatsapp->body);
    Assert::assertSame('+39222', $smsMessage->recipient);
    Assert::assertSame('sms body', $smsMessage->message);
});

test('send notification bulk result data keeps counters and errors collection', function () {
    $errors = collect([
        ['record' => 'r1', 'channel' => 'sms', 'error' => 'fail'],
    ]);

    $result = new SendNotificationBulkResultData(
        successCount: 3,
        errorCount: 1,
        errors: $errors,
        totalProcessed: 4,
    );

    Assert::assertInstanceOf(Collection::class, $result->errors);
    Assert::assertSame(3, $result->successCount);
    Assert::assertSame(4, $result->totalProcessed);
    Assert::assertSame(1, $result->errorCount);
});

test('firebase notification data fromType fills type and translations structure', function () {
    config()->set('xra.main_module', 'Notify');

    $data = FirebaseNotificationData::fromType('ticket_created');

    Assert::assertSame('ticket_created', $data->type);
    Assert::assertNotSame('', $data->title);
    Assert::assertNotSame('', $data->body);
    Assert::assertNotEmpty($data->data);
});
