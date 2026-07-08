<?php

declare(strict_types=1);

namespace Modules\Incentivi\Tests\Unit\Models;

use Modules\Incentivi\Tests\TestCase;
use Modules\Incentivi\Models\DefaultActivity;

uses(TestCase::class);

test('it can create a default activity', function () {
    $da = DefaultActivity::factory()->create([
        'nome' => 'Attività Predefinita',
    ]);

    expect($da->nome)->toBe('Attività Predefinita');
    
    $this->assertDatabaseHas('default_activities', [
        'id' => $da->id,
        'nome' => 'Attività Predefinita',
    ], 'incentivi');
});
