<?php

declare(strict_types=1);

namespace Modules\Job\Actions\Command;

use Spatie\QueueableAction\QueueableAction;
use Symfony\Component\Console\Command\Command;

/**
 * @see docs/contracts/get-command-arguments-actions.md
 * @contract docs/contracts/get-command-arguments-actions.md
 */
class GetCommandArgumentsActions
{
    use QueueableAction;

    /**
     * @return array<int, array{name: string, default: mixed, required: bool}>
     */
    public function execute(Command $command): array
    {
        $arguments = [];
        foreach ($command->getDefinition()->getArguments() as $argument) {
            $arguments[] = [
                'name' => $argument->getName(),
                'default' => $argument->getDefault(),
                'required' => $argument->isRequired(),
            ];
        }

        return $arguments;
    }
}
