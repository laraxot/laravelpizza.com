<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\File;

use Modules\Xot\Actions\File\SvgExistsAction;
use Modules\Xot\Tests\TestCase;
use BladeUI\Icons\Factory as IconFactory;
use Illuminate\Support\Facades\App;

uses(TestCase::class);

it('verifies svg existence', function (): void {
    // Factory is final, we check with a real instance if possible or just test logic flow
    $action = app(SvgExistsAction::class);

    // Empty name
    expect($action->execute(''))->toBeFalse();

    // We can't easily ensure a real icon exists without registering one, 
    // but the try/catch block will return false if it's missing.
    expect($action->execute('non-existent-icon-123456'))->toBeFalse();
});
