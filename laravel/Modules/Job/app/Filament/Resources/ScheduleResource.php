<?php

/**
 * @see https://github.com/husam-tariq/filament-database-schedule/blob/main/src/Filament/resources/ScheduleResource.php
 */

declare(strict_types=1);

namespace Modules\Job\Filament\Resources;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Modules\Job\Actions\Command\GetCommandsAction;
use Modules\Job\Datas\CommandData;
use Modules\Job\Filament\Resources\ScheduleResource\Pages\CreateSchedule;
use Modules\Job\Filament\Resources\ScheduleResource\Pages\EditSchedule;
use Modules\Job\Filament\Resources\ScheduleResource\Pages\ListSchedules;
use Modules\Job\Filament\Resources\ScheduleResource\Pages\ViewSchedule;
use Modules\Job\Models\Schedule;
use Modules\Job\Rules\Corn;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;
use Spatie\LaravelData\DataCollection;
use Webmozart\Assert\Assert;

class ScheduleResource extends XotBaseResource
{
    protected static ?string $model = Schedule::class;

    protected static bool $shouldRegisterNavigation = true;

    /** @var DataCollection<CommandData> */
    protected static DataCollection $commands;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListSchedules::route('/'),
            'create' => CreateSchedule::route('/create'),
            'edit' => EditSchedule::route('/{record}/edit'),
            'view' => ViewSchedule::route('/{record}'),
        ];
    }

    #[Override]
    public static function getFormSchema(): array
    {
        static::$commands = app(GetCommandsAction::class)->execute();
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
                TextInput::make('log_filename')->helperText(static::trans('messages.help-log-filename')),
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

    #[Override]
    public static function getRelations(): array
    {
        return [

        ];
    }
}
