<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Debug;

use Modules\Xot\Actions\Debug\MeasureAction;
use Tests\TestCase;
use Filament\Notifications\Notification;

uses(TestCase::class);

test('measure action executes closure and sends notification', function () {
    Notification::fake();
    
    $action = app(MeasureAction::class);
    $result = $action->execute(function() {
        return 'done';
    }, 'Test Label');
    
    expect($result)->toBe('done');
    
    Notification::assertSent();
});
