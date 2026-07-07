<?php

declare(strict_types=1);

uses(Modules\Xot\Tests\TestCase::class);
use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Actions\Cast\SafeIntCastAction;
use Modules\Xot\Actions\GetModelByModelTypeAction;
use Modules\Xot\Actions\GetModelClassByModelTypeAction;
use Modules\Xot\Actions\GetModelTypeByModelAction;
use Modules\Xot\Contracts\ModelContract;
use Modules\Xot\Tests\Fixtures\DemoModel;
use Modules\Xot\Tests\Fixtures\FakeQueryableModel;
use PHPUnit\Framework\Assert;

it('gets model class by model type from morph map', function (): void {
    config()->set('morph_map', ['demo' => DemoModel::class]);

    $result = app(GetModelClassByModelTypeAction::class)->execute('demo');

    Assert::assertSame(DemoModel::class, $result);
});

it('throws when morph map config is not an array', function (): void {
    config()->set('morph_map', 'invalid');

    try {
        app(GetModelClassByModelTypeAction::class)->execute('demo');
        Assert::fail('Expected exception not thrown');
    } catch (Exception $e) {
        Assert::assertInstanceOf(Exception::class, $e);
    }
});

it('throws when model type key is missing in morph map', function (): void {
    config()->set('morph_map', ['demo' => DemoModel::class]);

    try {
        app(GetModelClassByModelTypeAction::class)->execute('missing');
    } catch (Throwable $e) {
        Assert::assertInstanceOf(InvalidArgumentException::class, $e);

        return;
    }
    Assert::fail('Exception not thrown');
});

it('instantiates model by type when id is null', function (): void {
    config()->set('morph_map', ['demo' => DemoModel::class]);

    $result = app(GetModelByModelTypeAction::class)->execute('demo', null);

    Assert::assertInstanceOf(DemoModel::class, $result);
});

it('loads model by id when record exists', function (): void {
    config()->set('morph_map', ['demo' => FakeQueryableModel::class]);
    FakeQueryableModel::$findResult = new DemoModel();
    FakeQueryableModel::$findResult->setAttribute('id', 123);

    $result = app(GetModelByModelTypeAction::class)->execute('demo', '123');

    Assert::assertInstanceOf(DemoModel::class, $result);
    Assert::assertSame(123, SafeIntCastAction::cast($result->getKey()));
});

it('throws when model id is provided but record is missing', function (): void {
    config()->set('morph_map', ['demo' => FakeQueryableModel::class]);
    FakeQueryableModel::$findResult = null;

    try {
        app(GetModelByModelTypeAction::class)->execute('demo', '999999');
        Assert::fail('Expected exception not thrown');
    } catch (Exception $e) {
        Assert::assertInstanceOf(Exception::class, $e);
    }
});

it('returns snake model type from model contract instance', function (): void {
    $model = new class extends Model implements ModelContract {
    };

    $result = app(GetModelTypeByModelAction::class)->execute($model);

    Assert::assertStringContainsString('model', $result);
    Assert::assertIsString($result);
});
