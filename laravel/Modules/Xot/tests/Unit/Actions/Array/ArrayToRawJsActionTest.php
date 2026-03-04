<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Array;

use Filament\Support\RawJs;
use Modules\Xot\Actions\Array\ArrayToRawJsAction;
use Tests\TestCase;

uses(TestCase::class);

test('array to raw js action converts various types correctly', function () {
    $action = app(ArrayToRawJsAction::class);

    $data = [
        'string' => 'hello',
        'int' => 123,
        'float' => 12.3,
        'bool_true' => true,
        'bool_false' => false,
        'null_val' => null,
        'special-key' => 'value',
        'with\'quote' => 'o\'reilly',
        'raw' => RawJs::make('function() { return 1; }'),
        'nested' => [
            'key' => 'val',
        ],
    ];

    $result = $action->execute($data);
    $html = $result->toHtml();

    expect($html)->toContain('string: \'hello\'')
        ->and($html)->toContain('int: 123')
        ->and($html)->toContain('float: 12.3')
        ->and($html)->toContain('bool_true: true')
        ->and($html)->toContain('bool_false: false')
        ->and($html)->toContain('null_val: null')
        ->and($html)->toContain('\'special-key\': \'value\'')
        ->and($html)->toContain('\'with\\\'quote\': \'o\\\'reilly\'')
        ->and($html)->toContain('raw: function() { return 1; }')
        ->and($html)->toContain('nested: {key: \'val\'}');
});
