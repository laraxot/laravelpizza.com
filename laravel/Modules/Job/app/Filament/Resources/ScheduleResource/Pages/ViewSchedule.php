<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\ScheduleResource\Pages;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Resources\Concerns\HasTabs;
use Filament\Resources\Pages\Concerns\HasRelationManagers;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Support\HtmlString;
use Livewire\Attributes\Url;
use Modules\Job\Filament\Resources\ScheduleResource;
use Webmozart\Assert\Assert;

class ViewSchedule extends Page implements HasTable
{
    use HasRelationManagers;
    use HasTabs;
    use InteractsWithForms;
    use InteractsWithRecord;
    use InteractsWithTable {
        makeTable as makeBaseTable;
    }
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

    /*
     * Undocumented function
     *
     * @param string $record
     * @return void
     *
     * public function mount($record): void
     * {
     * static::authorizeResourceAccess();
     *
     * $this->record = $this->resolveRecord($record);
     *
     * abort_unless(static::getResource()::canView($this->getRecord()), 403);
     * }
     *
     * protected function getRelationManagers(): array
     * {
     * return [];
     * }
     *
     *
     * protected function getTableQuery(): Builder
     * {
     * return ScheduleHistory::where('schedule_id', $this->record->id)->latest();
     * }
     */

    protected function getTableColumns(): array
    {
        $date_format = config('app.date_format');
        Assert::string($date_format, '['.__LINE__.']['.class_basename($this).']');

        return [
            Split::make([
                TextColumn::make('command'),
                TextColumn::make('created_at')->dateTime($date_format),
                TextColumn::make('updated_at')->formatStateUsing(static function (
                    $state,
                    $record,
                ): string {
                    if (is_object($record) && method_exists($record, 'getAttribute')) {
                        $createdAt = $record->getAttribute('created_at');
                        if ($state === $createdAt) {
                            return 'Processing...';
                        }

                        if (is_object($state) && method_exists($state, 'diffInSeconds') && is_object($createdAt) && method_exists($createdAt, 'getTimestamp')) {
                            $diffSeconds = $state->diffInSeconds($createdAt);
                            $diffStr = is_numeric($diffSeconds) ? ((string) $diffSeconds) : '0';

                            return sprintf('%s seconds', $diffStr);
                        }
                    }

                    return '0 seconds';
                }),
                TextColumn::make('output')->formatStateUsing(
                    static fn (string $state): string => (
                        (count(explode('<br />', nl2br($state))) - 1).' rows of output'
                    ),
                ),
            ]),
            Panel::make([
                TextColumn::make('output')
                    ->extraAttributes(['class' => '!max-w-max'], true)
                    ->formatStateUsing(static fn (string $state): HtmlString => new HtmlString(nl2br(
                        $state,
                    ))),
            ])->collapsible(),
            // ->collapsed(config('job::history_collapsed'))
        ];
    }
}
