<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use Modules\Xot\Datas\RouteParamsData;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class)->group('no-xot-db');

test('route parameters preserve row query and nesting intent', function (): void {
    $row = (object) ['id' => 7];
    $params = RouteParamsData::from([
        'act' => 'show',
        'row' => $row,
        'query' => ['tab' => 'details'],
        'n' => 2,
        'in_admin' => true,
    ]);

    expect($params->act)->toBe('show')
        ->and($params->row)->toBe($row)
        ->and($params->query)->toBe(['tab' => 'details'])
        ->and($params->n)->toBe(2)
        ->and($params->in_admin)->toBeTrue();
});
