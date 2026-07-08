<?php

declare(strict_types=1);

namespace Modules\Incentivi\Tests\Unit\Models;

use Modules\Incentivi\Tests\TestCase;
use Modules\Incentivi\Models\StabiDirigente;

uses(TestCase::class);

test('it can create a stabi dirigente record', function () {
    $stabi = StabiDirigente::factory()->create([
        'nome_diri' => 'Mario Rossi',
    ]);

    expect($stabi->nome_diri)->toBe('Mario Rossi');
    
    $this->assertDatabaseHas('stabi_dirigente', [
        'id' => $stabi->id,
        'nome_diri' => 'Mario Rossi',
    ], 'incentivi');
});
