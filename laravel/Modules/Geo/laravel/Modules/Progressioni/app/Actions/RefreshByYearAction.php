<?php

declare(strict_types=1);

namespace Modules\Progressioni\Actions;

use Carbon\Carbon;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;
use Modules\Progressioni\Models\Progressioni;
use Spatie\QueueableAction\QueueableAction;

/**
 * @phpstan-type ProgressioniClass class-string<Progressioni>
 */
class RefreshByYearAction
{
    use QueueableAction;

    /**
     * @param  ProgressioniClass  $modelClass
     * @param  non-empty-string  $fieldname
     */
    public function execute(string $modelClass, string $fieldname, int|string $year): void
    {
        if (! is_subclass_of($modelClass, Progressioni::class)) {
            throw new InvalidArgumentException(sprintf(
                'Expected a Progressioni model class, %s given.',
                $modelClass
            ));
        }

        /** @var Builder<Progressioni> $query */
        $query = $modelClass::query();

        /** @var Collection<int, Progressioni> $rows */
        $rows = $query
            ->where($fieldname, $year)
            ->where(function (Builder $query): void {
                $query->whereDate('refreshed_at', '<', Carbon::now()->subDay())
                    ->orWhereNull('refreshed_at');
            })
            ->inRandomOrder()
            ->get();

        /** @var Collection<int, Progressioni> $rowsToProcess */
        $rowsToProcess = $rows; // ->take(5);

        foreach ($rowsToProcess as $row) {
            app(RefreshHaDirittoAction::class)
                ->onQueue()
                ->execute($row);

            $row->update([
                'refreshed_at' => now(),
            ]);
        }

        /** @var array<int, int|string> $refreshedIds */
        $refreshedIds = $rowsToProcess->modelKeys();

        Notification::make()
            ->title('refreshed ['.implode(', ', $refreshedIds).']!')
            ->success()
            ->send();
    }
}
