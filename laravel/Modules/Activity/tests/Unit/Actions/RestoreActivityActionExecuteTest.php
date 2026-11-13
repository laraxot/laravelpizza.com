<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Actions;

use Exception;
<<<<<<< .merge_file_Bh64Dp
use Illuminate\Database\Eloquent\Model;
use Modules\Activity\Actions\RestoreActivityAction;
use Webmozart\Assert\InvalidArgumentException as AssertInvalidArgumentException;

test('RestoreActivityAction aggiorna il record con le vecchie proprietà', function (): void {
    $model = new class() extends Model
    {
        protected $table = 'stub_models';

        /** @var array<string, mixed> */
        public array $updatedAttributes = [];

        /**
         * @param  array<string, mixed>  $attributes
         */
        public function update(array $attributes = [], array $options = []): bool
        {
            $this->updatedAttributes = $attributes;

            return true;
        }
    };

    (new RestoreActivityAction())->execute($model, ['name' => 'Ripristinato', 'status' => 'active']);
=======
use Modules\Activity\Actions\RestoreActivityAction;
use Modules\Activity\Tests\Fixtures\RestoreActivityEmptyModel;
use Modules\Activity\Tests\Fixtures\RestoreActivityFailingUpdateModel;
use Modules\Activity\Tests\Fixtures\RestoreActivityRecordingModel;
use Modules\Activity\Tests\TestCase;
use Webmozart\Assert\InvalidArgumentException as AssertInvalidArgumentException;

uses(TestCase::class);

test('RestoreActivityAction aggiorna il record con le vecchie proprietà', function (): void {
    $model = new RestoreActivityRecordingModel;

    (new RestoreActivityAction)->execute($model, ['name' => 'Ripristinato', 'status' => 'active']);
>>>>>>> .merge_file_yfl7KN

    expect($model->updatedAttributes)->toBe(['name' => 'Ripristinato', 'status' => 'active']);
});

test('RestoreActivityAction incapsula eccezioni di update', function (): void {
<<<<<<< .merge_file_Bh64Dp
    $model = new class() extends Model
    {
        protected $table = 'stub_models';

        /**
         * @param  array<string, mixed>  $attributes
         */
        public function update(array $attributes = [], array $options = []): bool
        {
            throw new Exception('db error');
        }
    };

    expect(function () use ($model): void {
        (new RestoreActivityAction())->execute($model, ['name' => 'x']);
=======
    $model = new RestoreActivityFailingUpdateModel;

    expect(function () use ($model): void {
        (new RestoreActivityAction)->execute($model, ['name' => 'x']);
>>>>>>> .merge_file_yfl7KN
    })->toThrow(Exception::class);
});

test('RestoreActivityAction rifiuta oldProperties vuote', function (): void {
<<<<<<< .merge_file_Bh64Dp
    $model = new class() extends Model
    {
        protected $table = 'stub_models';
    };

    expect(function () use ($model): void {
        (new RestoreActivityAction())->execute($model, []);
=======
    $model = new RestoreActivityEmptyModel;

    expect(function () use ($model): void {
        (new RestoreActivityAction)->execute($model, []);
>>>>>>> .merge_file_yfl7KN
    })->toThrow(AssertInvalidArgumentException::class);
});
