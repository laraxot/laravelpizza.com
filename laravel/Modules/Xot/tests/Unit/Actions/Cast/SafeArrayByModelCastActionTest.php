<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Actions\Cast\SafeArrayByModelCastAction;
use Tests\TestCase;

uses(TestCase::class);

it('returns attributesToArray when model is healthy', function (): void {
    $model = new class extends Model {
        protected $guarded = [];
    };
    $model->forceFill(['name' => 'Mario']);

    $action = app(SafeArrayByModelCastAction::class);

    expect($action->execute($model))->toHaveKey('name', 'Mario');
});

it('falls back to safeExecute when attributesToArray fails', function (): void {
    $model = new class extends Model {
        public function attributesToArray(): array
        {
            throw new Exception('boom');
        }

        public function getAttributes(): array
        {
            return ['ok' => '1', 'bad' => '2'];
        }

        public function getAttribute($key): mixed
        {
            if ('bad' === $key) {
                throw new Error('cannot read');
            }

            return 'value';
        }
    };

    $action = app(SafeArrayByModelCastAction::class);

    expect($action->execute($model))->toBe(['ok' => 'value']);
});
