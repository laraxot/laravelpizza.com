<?php

declare(strict_types=1);

namespace Modules\Job\Actions;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Spatie\QueueableAction\QueueableAction;
use Symfony\Component\Console\Command\Command;
use Webmozart\Assert\Assert;

/**
 * @see docs/contracts/get-task-commands-action.md
 *
 * @contract docs/contracts/get-task-commands-action.md
 */
class GetTaskCommandsAction
{
    use QueueableAction;

    /**
     * @return Collection<int, Command>
     */
    public function execute(): Collection
    {
        /** @var Collection<string, Command> $allCommands */
        $allCommands = collect(Artisan::all());

        $sorted = $allCommands->sortBy(static function (mixed $command): string {
            Assert::isInstanceOf($command, Command::class, __FILE__.':'.__LINE__.' - '.class_basename(self::class));
            $name = $command->getName();
            Assert::string($name, __FILE__.':'.__LINE__.' - '.class_basename(self::class));
            if (mb_strpos($name, ':') === false) {
                return ':'.$name;
            }

            return $name;
        });

        /** @var Collection<int, Command> $values */
        $values = $sorted->values();

        return $values;
    }
}
