<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions;

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Actions\GetModelByModelTypeAction;
use Modules\Xot\Actions\GetModelClassByModelTypeAction;
use Modules\Xot\Actions\GetModelTypeByModelAction;
use Modules\Xot\Contracts\ModelContract;
use Modules\Xot\Tests\Fixtures\DemoModel;
use Modules\Xot\Tests\Fixtures\FakeQueryableModel;

it('gets model class by model type from morph map', function (): void {
    config()->set('morph_map', ['demo' => DemoModel::class]);

    $result = app(GetModelClassByModelTypeAction::class)->execute('demo');

    expect($result)->toBe(DemoModel::class);
});

it('throws when morph map config is not an array', function (): void {
    config()->set('morph_map', 'invalid');

    app(GetModelClassByModelTypeAction::class)->execute('demo');
})->throws(Exception::class);

it('throws when model type key is missing in morph map', function (): void {
    config()->set('morph_map', ['demo' => DemoModel::class]);

    try {
        app(GetModelClassByModelTypeAction::class)->execute('missing');
    } catch (Throwable $e) {
        expect($e)->toBeInstanceOf(InvalidArgumentException::class);

        return;
    }
    $this->fail('Exception not thrown');
});

it('instantiates model by type when id is null', function (): void {
    config()->set('morph_map', ['demo' => DemoModel::class]);

    $result = app(GetModelByModelTypeAction::class)->execute('demo', null);

    expect($result)->toBeInstanceOf(DemoModel::class);
});

it('loads model by id when record exists', function (): void {
    config()->set('morph_map', ['demo' => FakeQueryableModel::class]);
    FakeQueryableModel::$findResult = new DemoModel();
    FakeQueryableModel::$findResult->setAttribute('id', 123);

    $result = app(GetModelByModelTypeAction::class)->execute('demo', '123');

    expect($result)->toBeInstanceOf(DemoModel::class)
        ->and((int) $result->getKey())->toBe(123);
});

it('throws when model id is provided but record is missing', function (): void {
    config()->set('morph_map', ['demo' => FakeQueryableModel::class]);
    FakeQueryableModel::$findResult = null;

    app(GetModelByModelTypeAction::class)->execute('demo', '999999');
})->throws(Exception::class);

it('returns snake model type from model contract instance', function (): void {
    $model = new class extends Model implements ModelContract {
        public function withoutRelations()
        {
            return $this;
        }

        public function forceFill(array $attributes)
        {
            parent::forceFill($attributes);

            return $this;
        }

        public function save(array $options = [])
        {
            return true;
        }

        public function toArray()
        {
            return [];
        }

        public function getKey()
        {
            return null;
        }

        public function getRelationValue($key)
        {
            return null;
        }

        public function newInstance($attributes = [], $exists = false)
        {
            return parent::newInstance($attributes, $exists);
        }
    };

    $result = app(GetModelTypeByModelAction::class)->execute($model);

    expect($result)->toContain('model')
        ->and($result)->toBeString();
});
