<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\String;

use Modules\Xot\Actions\String\SanitizeAction;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

it('sanitizes strings correctly', function (): void {
    $action = app(SanitizeAction::class);
    
    $input = " <script>alert('xss')</script> <b>Hello</b> &amp; Welcome! ";
    $expected = "alert('xss') Hello & Welcome!";
    
    expect($action->execute($input))->toBe($expected);
});
