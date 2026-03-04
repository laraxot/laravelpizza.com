<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Debug;

use Modules\Xot\Actions\Debug\MeasureAction;
use Modules\Xot\Tests\TestCase;
use Filament\Notifications\Notification;

uses(TestCase::class);

it('measures performance and sends notification', function (): void {
    Notification::fake();
    
    $action = app(MeasureAction::class);
    $result = $action->execute(function () {
        return 'done';
    }, 'Test Measurement');
    
    expect($result)->toBe('done');
    
    Notification::assertSent();
});
