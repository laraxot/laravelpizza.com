<?php

declare(strict_types=1);

use Modules\Notify\Actions\SMS\NormalizePhoneNumberAction;
use Modules\Notify\Datas\RecordNotificationData;
use Modules\Notify\Tests\TestCase;
use Modules\User\Models\User;

uses(TestCase::class);

test('record notification data returns mail route', function (): void {
    $user = new User;
    $user->setAttribute('email', 'recipient@example.test');

    $data = RecordNotificationData::from([
        'record' => $user,
        'channel' => 'mail',
    ]);

    expect($data->getChannel())->toBe('mail')
        ->and($data->getRoute())->toBe('recipient@example.test');
});

test('record notification data returns normalized sms route', function (): void {
    app()->instance(NormalizePhoneNumberAction::class, new class
    {
        public function execute(string $phone): string
        {
            return '+39'.$phone;
        }
    });

    $user = new User;
    $user->setAttribute('phone', '3331234567');

    $data = RecordNotificationData::from([
        'record' => $user,
        'channel' => 'sms',
    ]);

    expect($data->getRoute())->toBe('+393331234567');
});

test('record notification data throws for unsupported channel', function (): void {
    $user = new User;
    $user->setAttribute('email', 'recipient@example.test');

    $data = RecordNotificationData::from([
        'record' => $user,
        'channel' => 'telegram',
    ]);

    $data->getRoute();
})->throws(Exception::class);
