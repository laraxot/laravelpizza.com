<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\ScheduleResource\Pages;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Support\Carbon;
use Illuminate\Support\HtmlString;
use Livewire\Attributes\Url;
use Modules\Job\Filament\Resources\ScheduleResource;
use Modules\Job\Models\ScheduleHistory;
use Modules\Xot\Filament\Resources\Pages\XotBaseResourcePage;
use Webmozart\Assert\Assert;

class ViewSchedule extends XotBaseResourcePage implements HasTable
{
    use InteractsWithForms;
    use InteractsWithTable {
        makeTable as makeBaseTable;
    }

    #[Url]
    public ?string $activeTab = null;

    protected static string $resource = ScheduleResource::class;

    protected string $view = 'filament-panels::resources.pages.list-records';

    public function getTitle(): string
    {
        return __('job::schedule.resource.history');
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getTableColumns(): array
    {
        $date_format = config('app.date_format');
        Assert::string($date_format, '['.__LINE__.']['.class_basename($this).']');

        return [
            Split::make([
                'command' => TextColumn::make('command'),
                'created_at' => TextColumn::make('created_at')->dateTime($date_format),
                'updated_at' => TextColumn::make('updated_at')->formatStateUsing(static function (
                    ?Carbon $state,
                    ScheduleHistory $record,
                ): string {
                    if ($record->created_at === null || $state === null) {
                        return '';
                    }

                    if ($state->equalTo($record->created_at)) {
                        return 'Processing...';
                    }

                    return (string) $state->diffInSeconds($record->created_at).' seconds';
                }),
                'output' => TextColumn::make('output')->formatStateUsing(
                    static fn (string $state): string => (count(explode('<br />', nl2br($state))) - 1).' rows of output',
                ),
            ]),
            Panel::make([
                'output' => TextColumn::make('output')
                    ->extraAttributes(['class' => '!max-w-max'], true)
                    ->formatStateUsing(static fn (string $state): HtmlString => new HtmlString(nl2br(
                        $state,
                    ))),
            ])->collapsible(),
            // ->collapsed(config('job::history_collapsed'))
        ];
    }
}
