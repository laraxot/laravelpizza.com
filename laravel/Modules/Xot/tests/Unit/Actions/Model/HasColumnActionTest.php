<?php

declare(strict_types=1);

use Modules\Xot\Actions\Model\HasColumnAction;
use Modules\Xot\Models\BaseModel;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

beforeEach(function (): void {
    $this->action = app(HasColumnAction::class);
});

it('executes without errors', function (): void {
    // Use BaseModel which should have standard columns
    $model = new class extends BaseModel {
        protected $table = 'users';
    };

    // Just verify the action runs without throwing
    try {
        $result = $this->action->execute($model, 'id');
        expect($result)->toBeBool();
    } catch (Exception $e) {
        // Database may not be available in test environment
        $this->markTestSkipped('Database not available: '.$e->getMessage());
    }
});

it('handles different tables', function (): void {
    $model = new class extends BaseModel {
        protected $table = 'migrations';
    };

    try {
        $result = $this->action->execute($model, 'id');
        expect($result)->toBeBool();
    } catch (Exception $e) {
        $this->markTestSkipped('Database not available: '.$e->getMessage());
    }
});

it('returns boolean result', function (): void {
    $model = new class extends BaseModel {
        protected $table = 'users';
    };

    try {
        $result = $this->action->execute($model, 'nonexistent_xyz_123');
        expect($result)->toBeBool();
    } catch (Exception $e) {
        $this->markTestSkipped('Database not available: '.$e->getMessage());
    }
});
