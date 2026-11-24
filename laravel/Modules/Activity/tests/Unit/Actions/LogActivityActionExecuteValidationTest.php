<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Actions;

use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use Modules\Activity\Actions\LogActivityAction;
use Modules\Activity\Models\Activity;
use Modules\Activity\Tests\TestCase;

uses(TestCase::class);

test('LogActivityAction execute rifiuta user non User', function (): void {
    $nonUser = new class extends Model
    {
        protected $table = 'stub_users';
    };

    $action = new LogActivityAction(
        type: 'test_event',
        user: $nonUser,
    );

    expect(fn (): Activity => $action->execute())
        ->toThrow(InvalidArgumentException::class, 'User must implement UserContract');
<<<<<<< .merge_file_yX7EGP
<<<<<<< .merge_file_K1WKck
<<<<<<< .merge_file_vP5GcM
<<<<<<< .merge_file_QEWvtx
});
=======
})->group('ACTIVITY-LOG-INV-2');
>>>>>>> .merge_file_DCr9yX
=======
})->group('ACTIVITY-LOG-INV-2');
>>>>>>> .merge_file_6j6X8c
=======
})->group('ACTIVITY-LOG-INV-2');
>>>>>>> .merge_file_VIPzcT
=======
})->group('ACTIVITY-LOG-INV-2');
>>>>>>> .merge_file_n4AiDW

test('LogActivityAction execute accetta user null senza persistenza', function (): void {
    $action = new LogActivityAction(type: 'anonymous_event');

    expect($action->user)->toBeNull();
    expect($action->type)->toBe('anonymous_event');
});
