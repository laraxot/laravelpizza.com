<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Actions\Cast\SafeEloquentCastAction;
use Modules\Xot\States\Transitions\XotBaseTransition;

/**
 * @return array{0: SafeEloquentCastAction, 1: Model}
 */
function safeEloquentCastFixture(): array
{
    $action = app(SafeEloquentCastAction::class);
    $model = new class extends Model {
        protected $table = 'safe_eloquent_cast_test';

        protected $fillable = ['name', 'age', 'score', 'active', 'meta', 'empty', 'nickname'];

        protected function casts(): array
        {
            return ['meta' => 'array'];
        }
    };
    $model->setAttribute('name', 'Mario');
    $model->setAttribute('age', 42);
    $model->setAttribute('score', 12.5);
    $model->setAttribute('active', true);
    $model->setAttribute('meta', ['k' => 'v']);
    $model->setAttribute('empty', '');

    return [$action, $model];
}

/**
 * @return array{0: Model, 1: XotBaseTransition}
 */
function xotBaseTransitionFixture(): array
{
    $record = new class extends Model {
        protected $table = 'xot_transition_test';
    };

    $transition = new class($record) extends XotBaseTransition {
        public static string $name = 'test_transition';
    };

    return [$record, $transition];
}
