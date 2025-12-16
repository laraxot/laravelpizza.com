<?php

declare(strict_types=1);

namespace Modules\Job\Actions\Command;

use Illuminate\Console\Application;
use Illuminate\Support\Collection;
use Modules\Job\Datas\CommandData;
use Spatie\LaravelData\DataCollection;
use Symfony\Component\Console\Command\Command;

class GetCommandsAction
{
    /**
     * Execute the action.
     *
     * @return DataCollection<CommandData>
     */
    public function execute(): DataCollection
    {
        $artisan = app(Application::class);

        /** @var array<string, Command> $commands */
        $commands = $artisan->all();

        /** @var Collection<int, CommandData> $commandDataCollection */
        $commandDataCollection = collect($commands)->map(function (Command $command): CommandData {
            $name = $command->getName() ?? '';
            $description = $command->getDescription();

            // Ensure signature is always a string
            $rawSignature = method_exists($command, 'getSignature') ? $command->getSignature() : $name;
            $signature = is_string($rawSignature) ? $rawSignature : (string) $name;

            /** @var Collection<int, array{name: string, description: string, required: bool}> $arguments */
            $arguments = collect($command->getDefinition()->getArguments())
                ->map(fn ($argument) => [
                    'name' => $argument->getName(),
                    'description' => $argument->getDescription(),
                    'required' => $argument->isRequired(),
                ])
                ->values();

            /** @var Collection<int, array{name: string, description: string, required: bool}> $options */
            $options = collect($command->getDefinition()->getOptions())
                ->map(fn ($option) => [
                    'name' => $option->getName(),
                    'description' => $option->getDescription(),
                    'required' => $option->isValueRequired(),
                ])
                ->values();

            return new CommandData(
                name: $name,
                description: $description,
                signature: $signature,
                full_name: $name.' - '.$description,
                arguments: $arguments->toArray(),
                options: [
                    'withValue' => $options->toArray(),
                ],
            );
        });

        return new DataCollection(CommandData::class, $commandDataCollection->values()->all());
    }
}
