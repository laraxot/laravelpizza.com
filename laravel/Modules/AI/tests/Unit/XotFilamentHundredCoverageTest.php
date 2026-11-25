<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use Modules\Xot\Models\Cache;
use Modules\Xot\Tests\Fixtures\Stubs\XotFilamentRelationContract;
use Modules\Xot\Tests\Fixtures\Stubs\XotFilamentResourceContract;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class)->group('no-xot-db');

test('Xot resources preserve model and route contracts', function (): void {
    expect(XotFilamentResourceContract::getModel())->toBe(Cache::class)
        ->and(XotFilamentResourceContract::getRelations())->toBe([])
        ->and(XotFilamentResourceContract::getWidgets())->toBe([]);
});

test('relation managers expose their configured relationship', function (): void {
    expect(XotFilamentRelationContract::getRelationshipName())->toBe('sessions');
});
