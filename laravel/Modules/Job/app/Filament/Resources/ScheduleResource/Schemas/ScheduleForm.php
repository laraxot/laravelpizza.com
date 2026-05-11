<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\ScheduleResource\Schemas;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Modules\Job\Actions\Command\GetCommandsAction;
use Modules\Job\Datas\CommandData;
use Modules\Job\Rules\Corn;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;
use Spatie\LaravelData\DataCollection;
use Webmozart\Assert\Assert;

/**
 * ScheduleForm Schema.
 */
class ScheduleForm extends XotBaseResourceForm
{
    /** @var DataCollection<CommandData>|null */
    protected static ?DataCollection $commands = null;

    /**
     * Get the form schema.
     *
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        if (static::$commands === null) {
            static::$commands = app(GetCommandsAction::class)->execute();
        }

        $commands_opts = static::$commands->toCollection()->pluck('full_name', 'name')->toArray();

        return [
            'main_section' => Section::make([
                Select::make('command')
                    ->options(fn () => $commands_opts)
                    ->reactive()
                    ->searchable()
                    ->required()
                    ->afterStateUpdated(function (Set $set, ?string $state): void {
                        Assert::string($state);
                        if (static::$commands === null) {
                            static::$commands = app(GetCommandsAction::class)->execute();
                        }
                        Assert::isInstanceOf(
                            $command = static::$commands->where('name', $state)->first(),
                            CommandData::class,
                        );
                        $params = $command->arguments;
                        $options_with_value = $command->options['withValue'] ?? [];
                        Assert::isArray($options_with_value);
                        $set('params', $params);
                        $set('options_with_value', $options_with_value);
                    }),
                Repeater::make('params')
                    ->schema([
                        Hidden::make('name'),
                        TextInput::make('value')
                            ->label(function (Get $get): string {
                                $name = $get('name');
                                Assert::string($name);

                                return $name;
                            })
                            ->required(function (Get $get): bool {
                                $required = $get('required');

                                return (bool) $required;
                            }),
                    ])
                    ->addable(false)
                    ->deletable(false)
                    ->reorderable(false),
                Repeater::make('options_with_value')
                    ->schema([
                        Hidden::make('name'),
                        Hidden::make('type')->default('string'),
                        TextInput::make('value')
                            ->label(function (Get $get): string {
                                $name = $get('name');
                                Assert::string($name);

                                return $name;
                            })
                            ->required(function (Get $get): bool {
                                $required = $get('required');

                                return (bool) $required;
                            }),
                    ])
                    ->addable(false)
                    ->deletable(false)
                    ->reorderable(false),
                TextInput::make('expression')
                    ->placeholder('* * * * *')
                    ->rules([new Corn])
                    ->required(),
                TagsInput::make('environments')->placeholder(null),
                TextInput::make('log_filename'),
                TextInput::make('webhook_before'),
                TextInput::make('webhook_after'),
                TextInput::make('email_output'),
                Toggle::make('sendmail_success'),
                Toggle::make('sendmail_error'),
                Toggle::make('log_success')->default(true),
                Toggle::make('log_error')->default(true),
                Toggle::make('even_in_maintenance_mode'),
                Toggle::make('without_overlapping'),
                Toggle::make('on_one_server'),
                Toggle::make('run_in_background'),
            ])->inlineLabel(false),
        ];
    }
}
