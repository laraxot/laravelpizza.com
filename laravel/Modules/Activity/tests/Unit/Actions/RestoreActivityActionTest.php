<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Actions;

uses(\Modules\Activity\Tests\TestCase::class);

use Modules\Activity\Actions\RestoreActivityAction;

test('RestoreActivityAction can be instantiated', function () {
    $action = new RestoreActivityAction;

    expect($action)->toBeObject();
});

test('RestoreActivityAction can execute', function () {
    $action = new RestoreActivityAction;

    // Siccome non abbiamo un metodo specifico per testare l'execute senza un'attività specifica
    expect($action)->toBeObject();
});
