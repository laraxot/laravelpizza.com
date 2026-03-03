<?php

declare(strict_types=1);

use Modules\Xot\Actions\Model\DestroyAction;
use Modules\Xot\Tests\TestCase;
use Modules\Xot\Models\BaseModel;
use Illuminate\Support\Facades\Session;

uses(TestCase::class);

beforeEach(function (): void {
    $this->action = app(DestroyAction::class);
});

it('deletes model and returns it', function (): void {
    // Create a mock model that tracks delete calls
    $mockModel = new class extends BaseModel {
        public bool $deleted = false;
        
        public function delete(): bool
        {
            $this->deleted = true;
            return true;
        }
    };

    $result = $this->action->execute($mockModel, [], []);

    expect($result)->toBe($mockModel)
        ->and($mockModel->deleted)->toBeTrue();
});

it('flashes status message on successful delete', function (): void {
    $mockModel = new class extends BaseModel {
        public function delete(): bool
        {
            return true;
        }
    };

    $this->action->execute($mockModel, [], []);

    expect(Session::get('status'))->toBe('eliminato');
});

it('flashes failure message when delete returns false', function (): void {
    $mockModel = new class extends BaseModel {
        public function delete(): bool
        {
            return false;
        }
    };

    $this->action->execute($mockModel, [], []);

    expect(Session::get('status'))->toBe('NON eliminato');
});
