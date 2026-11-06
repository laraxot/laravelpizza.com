<?php

declare(strict_types=1);

namespace Modules\Job\Actions;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Spatie\QueueableAction\QueueableAction;
use Symfony\Component\Console\Command\Command;

class GetTaskCommandsAction
{
    use QueueableAction;

    /**
     * @return Collection<int, Command>
     */
    public function execute(): Collection
    {
        $allCommands = collect(Artisan::all())
            ->filter(static fn (mixed $command): bool => $command instanceof Command)
            ->values();

        $sorted = $allCommands->sortBy(static function (mixed $command): string {
            if (! $command instanceof Command) {
                return '';
            }

            $name = $command->getName();
            if ($name === null) {
                return '';
            }

            if (mb_strpos($name, ':') === false) {
                return ':'.$name;
            }

            return $name;
        });

        return $sorted->values();
    }
}
