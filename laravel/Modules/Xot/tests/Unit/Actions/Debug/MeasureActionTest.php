<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Debug;

use Modules\Xot\Actions\Debug\MeasureAction;

it('measures performance', function (): void {
    $action = app(MeasureAction::class);
    $result = $action->execute(function () {
        return 'done';
    }, 'Test Measurement');

    expect($result)->toBe('done');
});
