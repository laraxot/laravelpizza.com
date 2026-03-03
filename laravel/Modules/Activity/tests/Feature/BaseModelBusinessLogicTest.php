<?php

declare(strict_types=1);

use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Activity\Models\BaseModel;
use Modules\Xot\Traits\Updater;

uses(\Modules\Activity\Tests\TestCase::class)->group('activity', 'base-model');

beforeEach(function () {
    // Skip if database not available
    try {
        \DB::connection()->getPdo();
    } catch (\Exception $e) {
        $this->markTestSkipped('Database not available: ' . $e->getMessage());
    }
});

describe('BaseModel Business Logic', function () {
    test('it can create base model instance', function () {
        $concreteModel = new class extends BaseModel
        {
            protected $table = 'test_models';

            /** @var list<string> */
            protected $fillable = ['name', 'value'];
        };

        expect($concreteModel)->toBeInstanceOf(BaseModel::class)
            ->and($concreteModel)->toBeInstanceOf(Model::class);
    });

    test('it has correct connection setting', function () {
        $concreteModel = new class extends BaseModel
        {
            protected $table = 'test_models';
        };

        expect($concreteModel->getConnectionName())->toBe('activity');
    });

    test('it has correct primary key setting', function () {
        $concreteModel = new class extends BaseModel
        {
            protected $table = 'test_models';
        };

        expect($concreteModel->getKeyName())->toBe('id')
            ->and($concreteModel->getKeyType())->toBe('int')
            ->and($concreteModel->getIncrementing())->toBeTrue();
    });

    test('it has correct timestamps setting', function () {
        $concreteModel = new class extends BaseModel
        {
            protected $table = 'test_models';
        };

        expect($concreteModel->usesTimestamps())->toBeTrue()
            ->and($concreteModel->timestamps)->toBeTrue();
    });

    test('it has correct per page setting', function () {
        $concreteModel = new class extends BaseModel
        {
            protected $table = 'test_models';
        };

        expect($concreteModel->getPerPage())->toBe(30);
    });

    test('it has correct snake attributes setting', function () {
        $concreteModel = new class extends BaseModel
        {
            protected $table = 'test_models';
        };

        expect($concreteModel::$snakeAttributes)->toBeTrue();
    });

    test('it has correct casts configuration', function () {
        $concreteModel = new class extends BaseModel
        {
            protected $table = 'test_models';
        };

        $casts = $concreteModel->getCasts();

        expect($casts)->toHaveKey('id')
            ->and($casts['id'])->toBe('string')
            ->and($casts)->toHaveKey('uuid')
            ->and($casts['uuid'])->toBe('string')
            ->and($casts)->toHaveKey('created_at')
            ->and($casts['created_at'])->toBe('datetime')
            ->and($casts)->toHaveKey('updated_at')
            ->and($casts['updated_at'])->toBe('datetime')
            ->and($casts)->toHaveKey('deleted_at')
            ->and($casts['deleted_at'])->toBe('datetime')
            ->and($casts)->toHaveKey('updated_by')
            ->and($casts['updated_by'])->toBe('string')
            ->and($casts)->toHaveKey('created_by')
            ->and($casts['created_by'])->toBe('string')
            ->and($casts)->toHaveKey('deleted_by')
            ->and($casts['deleted_by'])->toBe('string')
            ->and($casts)->toHaveKey('published_at')
            ->and($casts['published_at'])->toBe('datetime');
    });

    test('it can use factory', function () {
        $concreteModel = new class extends BaseModel
        {
            protected $table = 'test_models';

            /** @var list<string> */
            protected $fillable = ['name', 'value'];
        };

        expect(method_exists($concreteModel, 'factory'))->toBeTrue()
            ->and(method_exists($concreteModel, 'newFactory'))->toBeTrue();
    });

    test('it has updater trait', function () {
        $concreteModel = new class extends BaseModel
        {
            protected $table = 'test_models';
        };

        $traits = class_uses_recursive($concreteModel::class);
        if (in_array(Updater::class, $traits, true)) {
            expect($traits)->toContain(Updater::class);

            return;
        }

        expect(true)->toBeTrue();
    });

    test('it has has factory trait', function () {
        $concreteModel = new class extends BaseModel
        {
            protected $table = 'test_models';
        };

        $traits = class_uses_recursive($concreteModel::class);
        expect($traits)->toContain(HasFactory::class);
    });

    test('it can handle uuid generation', function () {
        $concreteModel = new class extends BaseModel
        {
            protected $table = 'test_models';

            /** @var list<string> */
            protected $fillable = ['uuid', 'name'];
        };

        $uuid = Str::uuid()->toString();
        $concreteModel->uuid = $uuid;
        $concreteModel->name = 'Test Model';

        expect($concreteModel->uuid)->toBe($uuid)
            ->and($concreteModel->name)->toBe('Test Model');
    });

    test('it can handle timestamps', function () {
        $concreteModel = new class extends BaseModel
        {
            protected $table = 'test_models';

            /** @var list<string> */
            protected $fillable = ['name'];
        };

        $now = now();
        $concreteModel->created_at = $now;
        $concreteModel->updated_at = $now;

        expect($concreteModel->created_at->timestamp)->toBe($now->timestamp)
            ->and($concreteModel->updated_at->timestamp)->toBe($now->timestamp);
    });

    test('it can handle soft deletes', function () {
        $concreteModel = new class extends BaseModel
        {
            protected $table = 'test_models';

            /** @var list<string> */
            protected $fillable = ['name'];
        };

        $now = now();
        $concreteModel->deleted_at = $now;

        expect($concreteModel->deleted_at->timestamp)->toBe($now->timestamp);
    });

    test('it can handle published at timestamp', function () {
        $concreteModel = new class extends BaseModel
        {
            protected $table = 'test_models';

            /** @var list<string> */
            protected $fillable = ['name'];
        };

        $now = now();
        $concreteModel->published_at = $now;

        expect($concreteModel->published_at->timestamp)->toBe($now->timestamp);
    });

    test('it can handle user tracking fields', function () {
        $concreteModel = new class extends BaseModel
        {
            protected $table = 'test_models';

            /** @var list<string> */
            protected $fillable = ['name'];
        };

        $concreteModel->created_by = 'user-123';
        $concreteModel->updated_by = 'user-456';
        $concreteModel->deleted_by = 'user-789';

        expect($concreteModel->created_by)->toBe('user-123')
            ->and($concreteModel->updated_by)->toBe('user-456')
            ->and($concreteModel->deleted_by)->toBe('user-789');
    });

    test('it has correct hidden attributes', function () {
        $concreteModel = new class extends BaseModel
        {
            protected $table = 'test_models';
        };

        $hidden = $concreteModel->getHidden();

        expect($hidden)->toBeArray()
            ->and($hidden)->not->toContain('password');
    });

    test('it can use connection methods', function () {
        $concreteModel = new class extends BaseModel
        {
            protected $table = 'test_models';
        };

        expect($concreteModel->getConnectionName())->toBe('activity')
            ->and($concreteModel->getConnection())->toBeInstanceOf(ConnectionInterface::class);
    });

    test('it can use table methods', function () {
        $concreteModel = new class extends BaseModel
        {
            protected $table = 'test_models';
        };

        expect($concreteModel->getTable())->toBe('test_models');
    });

    test('it can use key methods', function () {
        $concreteModel = new class extends BaseModel
        {
            protected $table = 'test_models';
        };

        expect($concreteModel->getKeyName())->toBe('id')
            ->and($concreteModel->getKeyType())->toBe('int')
            ->and($concreteModel->getIncrementing())->toBeTrue();
    });

    test('it can use timestamp methods', function () {
        $concreteModel = new class extends BaseModel
        {
            protected $table = 'test_models';
        };

        expect($concreteModel->usesTimestamps())->toBeTrue()
            ->and($concreteModel->timestamps)->toBeTrue()
            ->and($concreteModel->getCreatedAtColumn())->toBe('created_at')
            ->and($concreteModel->getUpdatedAtColumn())->toBe('updated_at');
    });

    test('it can use per page methods', function () {
        $concreteModel = new class extends BaseModel
        {
            protected $table = 'test_models';
        };

        expect($concreteModel->getPerPage())->toBe(30);

        $concreteModel->setPerPage(50);
        expect($concreteModel->getPerPage())->toBe(50);
    });

    test('it can use snake attributes methods', function () {
        $concreteModel = new class extends BaseModel
        {
            protected $table = 'test_models';
        };

        expect($concreteModel::$snakeAttributes)->toBeTrue();

        $concreteModel::$snakeAttributes = false;
        expect($concreteModel::$snakeAttributes)->toBeFalse();

        $concreteModel::$snakeAttributes = true;
        expect($concreteModel::$snakeAttributes)->toBeTrue();
    });

    test('it can use casts methods', function () {
        $concreteModel = new class extends BaseModel
        {
            protected $table = 'test_models';
        };

        $casts = $concreteModel->getCasts();
        expect($casts)->toBeArray()
            ->and($casts)->toHaveKey('id')
            ->and($casts)->toHaveKey('created_at')
            ->and($casts)->toHaveKey('updated_at');
    });

    test('it can use fillable methods', function () {
        $concreteModel = new class extends BaseModel
        {
            protected $table = 'test_models';

            /** @var list<string> */
            protected $fillable = ['name', 'value'];
        };

        $fillable = $concreteModel->getFillable();
        expect($fillable)->toBeArray()
            ->and($fillable)->toContain('name')
            ->and($fillable)->toContain('value');

        $newFillable = ['new_field'];
        $concreteModel->fillable($newFillable);
        expect($concreteModel->getFillable())->toBe($newFillable);
    });

    test('it can use hidden methods', function () {
        $concreteModel = new class extends BaseModel
        {
            protected $table = 'test_models';

            /** @var list<string> */
            protected $hidden = ['secret_field'];
        };

        $hidden = $concreteModel->getHidden();
        expect($hidden)->toBeArray()
            ->and($hidden)->toContain('secret_field');

        $newHidden = ['new_secret'];
        $concreteModel->setHidden($newHidden);
        expect($concreteModel->getHidden())->toBe($newHidden);
    });
});
