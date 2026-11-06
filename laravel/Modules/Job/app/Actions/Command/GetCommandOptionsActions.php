<?php

declare(strict_types=1);

namespace Modules\Job\Actions\Command;

use Spatie\QueueableAction\QueueableAction;
use Symfony\Component\Console\Command\Command;

class GetCommandOptionsActions
{
    use QueueableAction;

    /**
     * @return array{withValue: array<int, object>, withoutValue: array<int, string>}
     */
    public function execute(Command $command): array
    {
        $options = [
            'withValue' => [],
            'withoutValue' => [
                'verbose',
                'quiet',
                'ansi',
                'no-ansi',
            ],
        ];
        foreach ($command->getDefinition()->getOptions() as $option) {
            if (! $option->acceptValue()) {
                $options['withoutValue'][] = $option->getName();

                continue;
            }

            $options['withValue'][] = (object) [
                'name' => $option->getName(),
                'default' => $option->getDefault(),
                'required' => $option->isValueRequired(),
            ];
        }

        return $options;
    }
}
