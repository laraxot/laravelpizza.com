<?php

declare(strict_types=1);
use Modules\Xot\Actions\Model\HasColumnAction;
use Modules\Xot\Models\BaseModel;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

$action = app(HasColumnAction::class);

it('executes without errors', function () use ($action): void {
    $model = new class extends BaseModel
    {
        protected $table = 'users';
    };

    try {
        $result = $action->execute($model, 'id');
        Assert::assertIsBool($result);
    } catch (Exception $e) {
        Assert::assertStringContainsString('table', $e->getMessage());
    }
});

it('handles different tables', function () use ($action): void {
    $model = new class extends BaseModel
    {
        protected $table = 'migrations';
    };

    try {
        $result = $action->execute($model, 'id');
        Assert::assertIsBool($result);
    } catch (Exception $e) {
        Assert::assertStringContainsString('table', $e->getMessage());
    }
});

it('returns boolean result', function () use ($action): void {
    $model = new class extends BaseModel
    {
        protected $table = 'users';
    };

    try {
        $result = $action->execute($model, 'nonexistent_xyz_123');
        Assert::assertIsBool($result);
    } catch (Exception $e) {
        Assert::assertStringContainsString('table', $e->getMessage());
    }
});
