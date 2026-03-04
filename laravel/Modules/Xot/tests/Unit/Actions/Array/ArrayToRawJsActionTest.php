<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Array;

use Filament\Support\RawJs;
use Modules\Xot\Actions\Array\ArrayToRawJsAction;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

it('converts array to raw js string correctly', function (): void {
    $action = app(ArrayToRawJsAction::class);

    $data = [
        'simpleKey' => 'value',
        'complex-key' => "it's simple",
        'number' => 123,
        'boolean' => true,
        'nullValue' => null,
        'nested' => [
            'inner' => 'val',
        ],
        'raw' => RawJs::make('function() { return 1; }'),
    ];

    $result = $action->execute($data);
    $html = $result->toHtml();

    expect($html)->toContain('simpleKey: \'value\'');
    expect($html)->toContain('\'complex-key\': \'it\\\'s simple\'');
    expect($html)->toContain('number: 123');
    expect($html)->toContain('boolean: true');
    expect($html)->toContain('nullValue: null');
    expect($html)->toContain('nested: {inner: \'val\'}');
    expect($html)->toContain('raw: function() { return 1; }');
});
