<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Session;
use Modules\Xot\Actions\Model\DestroyAction;
use Modules\Xot\Models\BaseModel;


beforeEach(function (): void {
    $action = app(DestroyAction::class);
});

it('deletes model and returns it', function (): void {
    // Create a mock model that tracks delete calls
    $mockModel = new class extends BaseModel {
        public bool $deleted = false;

        public function delete(): bool
        {
            $deleted = true;

            return true;
        }
    };

    $result = $action->execute($mockModel, [], []);

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

    $action->execute($mockModel, [], []);

    expect(Session::get('status'))->toBe('eliminato');
});

it('flashes failure message when delete returns false', function (): void {
    $mockModel = new class extends BaseModel {
        public function delete(): bool
        {
            return false;
        }
    };

    $action->execute($mockModel, [], []);

    expect(Session::get('status'))->toBe('NON eliminato');
});
