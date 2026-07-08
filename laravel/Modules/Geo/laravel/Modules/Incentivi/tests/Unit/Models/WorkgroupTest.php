<?php

declare(strict_types=1);

namespace Modules\Incentivi\Tests\Unit\Models;

use Modules\Incentivi\Tests\TestCase;
use Modules\Incentivi\Models\Workgroup;

uses(TestCase::class);

test('it can create a workgroup', function () {
    $workgroup = Workgroup::factory()->create([
        'denominazione' => 'Team Alpha',
    ]);

    expect($workgroup->denominazione)->toBe('Team Alpha');
    
    $this->assertDatabaseHas('workgroups', [
        'id' => $workgroup->id,
        'denominazione' => 'Team Alpha',
    ], 'incentivi');
});
