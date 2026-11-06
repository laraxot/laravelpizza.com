<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use Modules\Xot\Datas\MetatagData;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class)->group('no-xot-db');

test('metatag defaults provide stable document metadata', function (): void {
    $metatag = MetatagData::from([]);

    expect($metatag->charset)->toBe('UTF-8')
        ->and($metatag->generator)->toBe('xot')
        ->and($metatag->favicon)->toBe('/favicon.ico')
        ->and($metatag->colors)->toBe([]);
});
