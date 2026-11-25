<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use Modules\Xot\Datas\ComponentFileData;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class)->group('no-xot-db');

test('component file data keeps discovery provenance', function (): void {
    $component = ComponentFileData::from([
        'name' => 'Alert',
        'class' => 'Modules\\Xot\\View\\Components\\Alert',
        'module' => 'Xot',
        'path' => '/tmp/Alert.php',
        'ns' => 'xot',
    ]);

    expect($component->name)->toBe('Alert')
        ->and($component->module)->toBe('Xot')
        ->and($component->path)->toBe('/tmp/Alert.php')
        ->and($component->ns)->toBe('xot');
});
