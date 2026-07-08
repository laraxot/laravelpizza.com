<?php

declare(strict_types=1);

use Carbon\Carbon;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Progressioni\Actions\RefreshByYearAction;
use Modules\Progressioni\Actions\RefreshHaDirittoAction;
use Modules\Progressioni\Models\Progressioni;

beforeEach(function () {
    $this->action = new RefreshByYearAction;
    $this->year = 2025;

    // Mock Progressioni model collection
    $this->mockProgressioniCollection = new Collection([
        $this->createMockProgressioni(1, '2023-01-01'),
        $this->createMockProgressioni(2, null),  // Never refreshed
        $this->createMockProgressioni(3, Carbon::now()->subDays(2)->toDateTimeString()),  // Refreshed more than 1 day ago
    ]);
});

// Helper to create mock progressioni models
function createMockProgressioni(int $id, ?string $refreshedAt): Model
{
    return new class($id, $refreshedAt) extends Model
    {
        protected $attributes = [];

        /**
         * @return void
         */
        public function __construct()
        {
            $this->attributes['id'] = $id;
            $this->attributes['refreshed_at'] = $refreshedAt;
        }

        public function getAttribute($key): mixed
        {
            return $this->attributes[$key] ?? null;
        }

        public function getKey(): mixed
        {
            return $this->attributes['id'];
        }

        public function update(array $attributes = []): bool
        {
            $this->attributes = array_merge($this->attributes, $attributes);

            return true;
        }

        public function getAttributes(): array
        {
            return $this->attributes;
        }
    };
}

describe('RefreshByYearAction Basic Functionality', function () {
    it('can be instantiated', function () {
        expect($this->action)->toBeInstanceOf(RefreshByYearAction::class);
    });

    it('uses QueueableAction trait', function () {
        $traits = class_uses($this->action);

        expect($traits)->toContain('Spatie\QueueableAction\QueueableAction');
    });
});

describe('RefreshByYearAction Execute Method', function () {
    it('fetches progressioni records for given year and field', function () {
        // Mock the Progressioni model
        $modelClass = Mockery::mock('overload:'.Progressioni::class);

        $query = Mockery::mock();
        $query->shouldReceive('where')
            ->with('anno', $this->year)
            ->andReturnSelf();

        $query->shouldReceive('where')
            ->with(Mockery::on(is_callable(...)))
            ->andReturnSelf();

        $query->shouldReceive('inRandomOrder')
            ->andReturnSelf();

        $query->shouldReceive('get')
            ->andReturn(new Collection([]));

        $modelClass->shouldReceive('where')
            ->with('anno', $this->year)
            ->andReturn($query);

        // Mock the RefreshHaDirittoAction
        $refreshHaDirittoAction = Mockery::mock(RefreshHaDirittoAction::class);
        $refreshHaDirittoAction->shouldReceive('onQueue->execute')->never();
        app()->instance(RefreshHaDirittoAction::class, $refreshHaDirittoAction);

        // Mock Notification facade
        Notification::fake();

        // Execute the action
        $this->action->execute(Progressioni::class, 'anno', $this->year);

        // Verify notification was sent
        Notification::assertSentTimes(Notification::class, 1);
    });

    it('processes eligible records and updates refreshed_at', function () {
        // Mock the Progressioni model
        $modelClass = Mockery::mock('overload:'.Progressioni::class);

        $query = Mockery::mock();
        $query->shouldReceive('where')
            ->with('anno', $this->year)
            ->andReturnSelf();

        $query->shouldReceive('where')
            ->with(Mockery::on(is_callable(...)))
            ->andReturnSelf();

        $query->shouldReceive('inRandomOrder')
            ->andReturnSelf();

        $query->shouldReceive('get')
            ->andReturn($this->mockProgressioniCollection);

        $modelClass->shouldReceive('where')
            ->with('anno', $this->year)
            ->andReturn($query);

        // Mock the RefreshHaDirittoAction
        $refreshHaDirittoAction = Mockery::mock(RefreshHaDirittoAction::class);
        $refreshHaDirittoAction->shouldReceive('onQueue->execute')
            ->times(3); // All 3 records should be processed

        app()->instance(RefreshHaDirittoAction::class, $refreshHaDirittoAction);

        // Mock Notification facade
        Notification::fake();

        // Execute the action
        $this->action->execute(Progressioni::class, 'anno', $this->year);

        // Verify each record was updated with refreshed_at
        foreach ($this->mockProgressioniCollection as $record) {
            expect($record->getAttribute('refreshed_at'))->not()->toBeNull();
        }

        // Verify notification was sent with correct IDs
        Notification::assertSent(fn (Notification $notification) => $notification->getTitle() === 'refreshed [1, 2, 3]!');
    });

    it('handles empty query result gracefully', function () {
        // Mock the Progressioni model
        $modelClass = Mockery::mock('overload:'.Progressioni::class);

        $query = Mockery::mock();
        $query->shouldReceive('where')->andReturnSelf();
        $query->shouldReceive('inRandomOrder')->andReturnSelf();
        $query->shouldReceive('get')->andReturn(new Collection([]));

        $modelClass->shouldReceive('where')->andReturn($query);

        // Mock the RefreshHaDirittoAction
        $refreshHaDirittoAction = Mockery::mock(RefreshHaDirittoAction::class);
        $refreshHaDirittoAction->shouldReceive('onQueue->execute')->never();
        app()->instance(RefreshHaDirittoAction::class, $refreshHaDirittoAction);

        // Mock Notification facade
        Notification::fake();

        // Execute the action
        $this->action->execute(Progressioni::class, 'anno', $this->year);

        // Verify notification was sent with empty array
        Notification::assertSent(fn (Notification $notification) => $notification->getTitle() === 'refreshed []!');
    });
});

describe('RefreshByYearAction Error Handling', function () {
    it('handles database query exceptions gracefully', function () {
        // Mock the Progressioni model to throw exception
        $modelClass = Mockery::mock('overload:'.Progressioni::class);
        $modelClass->shouldReceive('where')
            ->andThrow(new Exception('Database error'));

        // Execute the action and expect exception
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Database error');

        $this->action->execute(Progressioni::class, 'anno', $this->year);
    });

    it('handles empty year parameter gracefully', function () {
        $this->expectException(TypeError::class);

        $this->action->execute(Progressioni::class, 'anno', '');
    });
});
