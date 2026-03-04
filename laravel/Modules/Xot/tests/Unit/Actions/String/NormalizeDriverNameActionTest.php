<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\String;

use Modules\Xot\Actions\String\NormalizeDriverNameAction;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

it('normalizes driver names correctly', function (): void {
    $action = app(NormalizeDriverNameAction::class);

    expect($action->execute('360-Dialog'))->toBe('360dialog');
    expect($action->execute('My_Driver'))->toBe('mydriver');
    expect($action->execute('Spaces In Name'))->toBe('spacesinname');
    expect($action->execute('UPPERcase'))->toBe('uppercase');
});
