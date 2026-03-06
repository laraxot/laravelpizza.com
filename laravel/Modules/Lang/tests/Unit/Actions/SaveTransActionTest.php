<?php

declare(strict_types=1);

namespace Modules\Lang\Tests\Unit\Actions;

use Modules\Lang\Actions\SaveTransAction;
use Modules\Lang\Tests\TestCase;
use Modules\Xot\Actions\Arr\SaveArrayAction;

uses(TestCase::class);

describe('SaveTransAction', function (): void {
    test('it has execute method', function (): void {
        $action = new SaveTransAction(
            app(SaveArrayAction::class),
        );

        expect(method_exists($action, 'execute'))->toBeTrue();
    });

    test('action is invokable via app', function (): void {
        expect(app(SaveTransAction::class))->toBeInstanceOf(SaveTransAction::class);
    });
});
