<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit\Stubs;

use Filament\Schemas\Components\Component;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Modules\Xot\Contracts\StateContract;

/**
 * Stato che solleva eccezione su transitionableStates — copre fallback getStatesFor.
 */
final class UiCoverageThrowingState implements StateContract
{
    /** @param array<array-key, mixed>|Model|string|null $record */
    /**
     * @param  Model|array<string, mixed>|string|null  $record
     */
    public function __construct(
        public Model|array|string|null $record = null,
    ) {}

    public function label(): string
    {
        return 'Throwing';
    }

    public function color(): string
    {
        return 'danger';
    }

    public function bgColor(): string
    {
        return 'gray';
    }

    public function icon(): string
    {
        return 'heroicon-o-x';
    }

    public function modalHeading(): string
    {
        return 'h';
    }

    public function modalDescription(): string
    {
        return 'd';
    }

    /**
     * @return array<string, Component>
     */
    public function modalFormSchema(): array
    {
        return [];
    }

    /**
     * @return array<string, mixed>
     */
    public function modalFillFormByRecord(Model $record): array
    {
        return [];
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function modalActionByRecord(Model $record, array $data): void {}

    /**
     * @return list<string>
     */
    public function transitionableStates(): array
    {
        throw new \RuntimeException('transitionableStates unavailable');
    }

    public function canTransitionTo(string $stateClass): bool
    {
        return false;
    }

    public function transitionTo(string $state, ?string $message = null): void {}

    /**
     * @return Collection<string, string>
     */
    public static function getStateMapping(): Collection
    {
        return collect(['throwing' => self::class]);
    }
}
