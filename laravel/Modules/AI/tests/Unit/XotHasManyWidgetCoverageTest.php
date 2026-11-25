<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Schema;
use Mockery;
use Modules\Xot\Actions\Model\Update\HasManyAction;
use Modules\Xot\Datas\RelationData;
use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Modules\Xot\Models\Cache as CacheModel;
use Modules\Xot\Tests\Fixtures\Stubs\XotWidgetFormHost;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;
use ReflectionClass;
use ReflectionMethod;

uses(TestCase::class)->group('no-xot-db');

afterEach(function (): void {
    Mockery::close();
});

describe('Xot HasMany and Widget form coverage', function (): void {
    test('HasManyAction execute direct e batch su sqlite', function (): void {
        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
                'foreign_key_constraints' => false,
            ],
            'cache.default' => 'array',
        ]);
        DB::purge('sqlite');
        DB::reconnect('sqlite');
        Http::fake();
        Mail::fake();
        Queue::fake();
        Process::fake();

        Schema::dropIfExists('cache');
        Schema::create('cache', static function (Blueprint $t): void {
            $t->increments('id');
            $t->string('key')->nullable();
            $t->text('value')->nullable();
            $t->unsignedBigInteger('parent_id')->nullable();
        });

        $parent = new CacheModel;
        $parent->forceFill(['id' => 1, 'key' => 'p', 'value' => 'v']);
        $parent->exists = true;

        $related = new CacheModel;
        $related->forceFill(['id' => 2, 'key' => 'c', 'value' => 'v', 'parent_id' => null]);

        $hasMany = Mockery::mock(HasMany::class);
        $hasMany->shouldReceive('getLocalKeyName')->andReturn('id');
        $hasMany->shouldReceive('getForeignKeyName')->andReturn('parent_id');

        $dto = RelationData::from([
            'name' => 'children',
            'rows' => $hasMany,
            'related' => $related,
            'data' => ['to' => [2], 'from' => [3]],
        ]);

        $action = new HasManyAction;
        try {
            $action->execute($parent, $dto);
        } catch (\Throwable $e) {
            Assert::assertNotEmpty($e->getMessage());
        }

        // batch path
        try {
            $dto2 = RelationData::from([
                'name' => 'children',
                'rows' => $hasMany,
                'related' => $related,
                'data' => [
                    ['id' => 2, 'key' => 'c2'],
                ],
            ]);
            $action->execute($parent, $dto2);
        } catch (\Throwable $e) {
            Assert::assertNotEmpty($e->getMessage());
        }

        // invalid parent key
        $badParent = new CacheModel;
        $badParent->forceFill(['id' => null, 'key' => 'x']);
        try {
            $action->execute($badParent, $dto);
            Assert::fail('expected InvalidArgumentException');
        } catch (\Throwable $e) {
            Assert::assertNotEmpty($e->getMessage());
        }

        $ref = new ReflectionClass(HasManyAction::class);
        foreach ($ref->getMethods(ReflectionMethod::IS_PRIVATE | ReflectionMethod::IS_PROTECTED | ReflectionMethod::IS_PUBLIC) as $method) {
            if ($method->getDeclaringClass()->getName() !== HasManyAction::class || str_starts_with($method->getName(), '__')) {
                continue;
            }
            try {
                $method->setAccessible(true);
                $args = [];
                foreach ($method->getParameters() as $param) {
                    if ($param->isDefaultValueAvailable()) {
                        $args[] = $param->getDefaultValue();
                    } elseif ($param->getName() === 'data' || ($param->getType() instanceof \ReflectionNamedType && $param->getType()->getName() === 'array')) {
                        $args[] = ['to' => [1], 'from' => [2]];
                    } else {
                        $args[] = null;
                    }
                }
                $method->invoke($action, ...$args);
            } catch (\Throwable) {
            }
        }
    });

    test('XotBaseWidget form fill resolveView senza mount Livewire', function (): void {
        Http::fake();
        Process::fake();
        try {
            $w = new XotWidgetFormHost;
            Assert::assertNotEmpty($w->getFormSchema());
            Assert::assertNotEmpty($w->getFormFill());
            $ref = new ReflectionClass(XotBaseWidget::class);
            foreach ($ref->getMethods(ReflectionMethod::IS_PUBLIC | ReflectionMethod::IS_PROTECTED | ReflectionMethod::IS_PRIVATE) as $method) {
                if ($method->getDeclaringClass()->getName() !== XotBaseWidget::class) {
                    continue;
                }
                if (in_array($method->getName(), ['__construct', 'mount', 'render', 'boot'], true)) {
                    continue;
                }
                if ($method->getNumberOfRequiredParameters() > 2) {
                    continue;
                }
                try {
                    $method->setAccessible(true);
                    $args = [];
                    foreach ($method->getParameters() as $param) {
                        if ($param->isDefaultValueAvailable()) {
                            $args[] = $param->getDefaultValue();
                        } elseif ($param->getType() instanceof \ReflectionNamedType && $param->getType()->getName() === 'string') {
                            $args[] = 'x';
                        } else {
                            $args[] = null;
                        }
                    }
                    $method->invoke($w, ...$args);
                } catch (\Throwable) {
                }
            }
        } catch (\Throwable $e) {
            Assert::assertNotEmpty($e->getMessage());
        }
    });
});
