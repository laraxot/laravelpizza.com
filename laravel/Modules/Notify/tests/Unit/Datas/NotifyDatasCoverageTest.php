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
use Modules\Notify\Datas\SmsMessageData;
use Modules\Notify\Datas\TelegramData;
use Modules\Notify\Datas\WhatsAppData;
use Modules\Notify\Datas\SMS\AgiletelecomData;
use Modules\Notify\Datas\SMS\GammuData;
use Modules\Notify\Datas\SMS\NexmoData;
use Modules\Notify\Datas\SMS\PlivoData;
use Modules\Notify\Datas\SMS\SmsFactorData;
use Modules\Notify\Tests\TestCase;

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

    expect($request->token)->toBe('abc-token')
        ->and($request->messages)->toHaveCount(1)
        ->and($response->status)->toBe('ok')
        ->and($response->batchId)->toBe('batch-1')
        ->and($response->messages)->toHaveCount(1);
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

    expect($data->recipient)->toBe('+39123')
        ->and($data->message)->toBe('Body')
        ->and($message->recipient)->toBe('+39999')
        ->and($message->text)->toBe('Text');
});

test('sms driver data classes expose auth headers and defaults', function () {
    config()->set('sms.drivers.agiletelecom', [
        'username' => 'u',
        'password' => 'p',
        'auth_type' => 'basic',
    ]);
    config()->set('sms.drivers.gammu', [
        'path' => '/usr/local/bin/gammu',
        'config' => '/tmp/gammurc',
        'timeout' => 45,
    ]);
    config()->set('sms.drivers.nexmo', [
        'key' => 'k',
        'secret' => 's',
    ]);
    config()->set('sms.drivers.plivo', [
        'auth_id' => 'aid',
        'auth_token' => 'atok',
    ]);
    config()->set('sms.drivers.smsfactor', [
        'token' => 'tok',
    ]);

    $agile = AgiletelecomData::make();
    $gammu = GammuData::make();
    $nexmo = NexmoData::make();
    $plivo = PlivoData::make();
    $smsfactor = SmsFactorData::make();

    expect($agile->getAuthHeaders())->toHaveKey('Authorization')
        ->and($gammu->getPath())->toBe('/usr/local/bin/gammu')
        ->and($gammu->getConfig())->toBe('/tmp/gammurc')
        ->and($gammu->getTimeout())->toBe(45)
        ->and($nexmo->getBaseUrl())->toBeString()
        ->and($plivo->getBaseUrl())->toBeString()
        ->and($smsfactor->getBaseUrl())->toBeString();
});

test('telegram, whatsapp and sms message datas keep payload', function () {
    $telegram = new TelegramData(chatId: '123', text: 'hello', parseMode: 'HTML');
    $whatsapp = new WhatsAppData(recipient: '+39111', body: 'body', type: 'text');
    $smsMessage = new SmsMessageData(recipient: '+39222', message: 'sms body', sender: 'ACME');

    expect($telegram->chatId)->toBe('123')
        ->and($telegram->text)->toBe('hello')
        ->and($whatsapp->recipient)->toBe('+39111')
        ->and($whatsapp->body)->toBe('body')
        ->and($smsMessage->recipient)->toBe('+39222')
        ->and($smsMessage->message)->toBe('sms body');
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

    expect($result->successCount)->toBe(3)
        ->and($result->errorCount)->toBe(1)
        ->and($result->errors)->toBeInstanceOf(Collection::class)
        ->and($result->totalProcessed)->toBe(4);
});

test('firebase notification data fromType fills type and translations structure', function () {
    config()->set('xra.main_module', 'Notify');

    $data = FirebaseNotificationData::fromType('ticket_created');

    expect($data->type)->toBe('ticket_created')
        ->and($data->title)->toBeString()
        ->and($data->body)->toBeString()
        ->and($data->data)->toBeArray();
});
