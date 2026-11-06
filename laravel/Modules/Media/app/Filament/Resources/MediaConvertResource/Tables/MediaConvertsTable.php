<?php

declare(strict_types=1);

namespace Modules\Media\Filament\Resources\MediaConvertResource\Tables;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\BaseFilter;
use Filament\Tables\Filters\SelectFilter;
use Modules\Media\Actions\Video\ConvertVideoByMediaConvertAction;
use Modules\Media\Datas\ConvertData;
use Modules\Media\Models\MediaConvert;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;
use Spatie\QueueableAction\ActionJob;

use function app;
use function dispatch;

class MediaConvertsTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'id' => IDColumn::make('id')->searchable()->sortable(),
            'created_at' => TextColumn::make('created_at')->dateTime(),
            'updated_at' => TextColumn::make('updated_at')->dateTime(),
        ];
    }

    /**
     * @return array<string, BaseFilter>
     */
    public function getTableFilters(): array
    {
        return [
            'format' => SelectFilter::make('format')->options(
                static fn (): array => MediaConvert::query()->distinct()->pluck('format', 'format')->toArray(),
            ),
            'codec_video' => SelectFilter::make('codec_video')->options(
                static fn (): array => MediaConvert::query()->distinct()->pluck('codec_video', 'codec_video')->toArray(),
            ),
            'codec_audio' => SelectFilter::make('codec_audio')->options(
                static fn (): array => MediaConvert::query()->distinct()->pluck('codec_audio', 'codec_audio')->toArray(),
            ),
        ];
    }

    /**
     * @return array<string, Action|ActionGroup>
     */
    public function getTableActions(): array
    {
        return [
            'view' => ViewAction::make(),
            'edit' => EditAction::make(),
            'convert' => Action::make('convert')->action(function (MediaConvert $record): void {
                $record->update(['percentage' => 0]);
                $data = ConvertData::from([
                    'file' => $record->file,
                    'disk' => $record->disk,
                ]);
                // `QueueableAction::onQueue()` restituisce una classe anonima non tipizzata:
                // PHPStan la vede `mixed` e ogni chiamata su di essa e' un errore. Il job
                // che quel proxy costruisce e' pubblico, quindi lo si accoda direttamente.
                dispatch(new ActionJob(app(ConvertVideoByMediaConvertAction::class), [$data, $record]));
            }),
        ];
    }

    /**
     * @return array<string, BulkAction>
     */
    public function getTableBulkActions(): array
    {
        return [
            'delete' => DeleteBulkAction::make(),
        ];
    }
}
