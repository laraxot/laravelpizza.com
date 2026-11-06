<?php

declare(strict_types=1);

namespace Modules\Job\Actions\Command;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Collection;
use Modules\Job\Datas\CommandData;
use Spatie\LaravelData\DataCollection;
use Spatie\QueueableAction\QueueableAction;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class GetCommandsAction
{
    use QueueableAction;

    /**
     * Execute the action.
     *
     * @return DataCollection<int, CommandData>
     */
    public function execute(): DataCollection
    {
        $kernel = app(Kernel::class);

        /** @var array<string, Command> $commands */
        $commands = $kernel->all();

        /** @var Collection<int, CommandData> $commandsData */
        $commandsData = collect($commands)->map(
            static function (Command $command): CommandData {
                $name = (string) $command->getName();
                $description = (string) $command->getDescription();
                $signature = $name;

                /** @var Collection<int, array{name: string, description: string, required: bool}> $arguments */
                $arguments = collect($command->getDefinition()->getArguments())
                    ->map(
                        static fn (InputArgument $argument): array => [
                            'name' => (string) $argument->getName(),
                            'description' => (string) $argument->getDescription(),
                            'required' => (bool) $argument->isRequired(),
                        ],
                    )
                    ->values();

                /** @var Collection<int, array{name: string, description: string, required: bool}> $options */
                $options = collect($command->getDefinition()->getOptions())
                    ->map(
                        static fn (InputOption $option): array => [
                            'name' => (string) $option->getName(),
                            'description' => (string) $option->getDescription(),
                            'required' => (bool) $option->isValueRequired(),
                        ],
                    )
                    ->values();

                /** @var array<int, array<string, mixed>> $argumentsArray */
                $argumentsArray = $arguments->values()->all();

                return new CommandData(
                    name: $name,
                    description: $description,
                    signature: $signature,
                    full_name: $name.' - '.$description,
                    arguments: $argumentsArray,
                    options: [
                        'withValue' => $options->toArray(),
                    ],
                );
            },
        );

        return new DataCollection(CommandData::class, $commandsData->values()->all());
    }
}
