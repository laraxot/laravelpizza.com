<?php

declare(strict_types=1);

namespace Modules\Job\Actions;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Spatie\QueueableAction\QueueableAction;
use Symfony\Component\Console\Command\Command;
use Webmozart\Assert\Assert;

class GetTaskCommandsAction
{
    use QueueableAction;

    /**
     * @return Collection<int, Command>
     */
    public function execute(): Collection
    {
        $allCommands = collect(Artisan::all());

        /** @var Collection<int, Command> $sorted */
        $sorted = $allCommands->sortBy(static function (Command $command) {
            $name = $command->getName();
            Assert::string($name, __FILE__.':'.__LINE__.' - '.class_basename(self::class));
            if (mb_strpos($name, ':') === false) {
                return ':'.$name;
            }

            return $name;
        });

        return $sorted->values();
    }
}
