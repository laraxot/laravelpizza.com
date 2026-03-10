<?php

declare(strict_types=1);

<<<<<<< HEAD
namespace Modules\Notify\Tests\Unit\Actions;

=======
>>>>>>> 8e583cd (.)
use Illuminate\Support\Facades\Log;
use Modules\Notify\Actions\SendAppointmentNotificationAction;
use Modules\Notify\Tests\TestCase;

uses(TestCase::class);

test('send appointment notification returns false and logs info when models are missing', function () {
    Log::shouldReceive('info')->once();

    $result = app(SendAppointmentNotificationAction::class)->execute(
        appointment: (object) ['patient_id' => 1],
        type: 'reminder',
    );

    expect($result)->toBeFalse();
});
