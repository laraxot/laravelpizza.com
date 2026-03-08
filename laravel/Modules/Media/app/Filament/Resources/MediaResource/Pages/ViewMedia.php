<?php

declare(strict_types=1);

namespace Modules\Media\Filament\Resources\MediaResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Modules\Media\Datas\ConvertData;
use Modules\Media\Filament\Infolists\VideoEntry;
use Modules\Media\Filament\Resources\MediaConvertResource;
use Modules\Media\Filament\Resources\MediaResource;
use Modules\Media\Filament\Resources\MediaResource\Widgets\ConvertWidget;
use Modules\Media\Models\Media;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
use Override;

class ViewMedia extends XotBaseViewRecord
{
    protected static string $resource = MediaResource::class;

    /**
     * Restituisce lo schema dell'infolist per la visualizzazione dei dettagli del record.
     *
     * @return array<string, Component>
     */
    #[Override]
    protected function getInfolistSchema(): array
    {
        return [
            'media_grid' => Grid::make(2)
                ->schema([
                    'media_preview' => Section::make()->schema([
                        'image' => ImageEntry::make('url')
                            ->defaultImageUrl(fn (Media $record) => $record->getUrl())
                            ->size(500)
                            ->visible(fn (Media $record): bool => $record->type === 'image'),
                        'video' => VideoEntry::make('url')
                            ->defaultImageUrl(fn (Media $record) => $record->getUrl())
                            ->size(500)
                            ->visible(fn (Media $record): bool => $record->type === 'video'),
                    ]),
                    'media_details' => Section::make()->schema([
                        'actions' => Actions::make([
                            Action::make('convert')
                                ->tooltip('convert')
                                ->icon('heroicon-o-scale')
                                ->schema(MediaConvertResource::getFormSchema())
                                ->action(function (Media $record, array $data): void {
                                    /** @var array<string, mixed> $actionData */
                                    $actionData = $data;
                                    $actionData['disk'] = (string) $record->disk;
                                    $actionData['file'] = (string) $record->path.'/'.(string) $record->file_name;
                                    $convert_data = ConvertData::from($actionData);

                                    /** @var array<string, mixed> $convertArray */
                                    $convertArray = $convert_data->toArray();
                                    $record->mediaConverts()->create($convertArray);
                                }),
                        ]),
                        'name' => TextEntry::make('name'),
                        'collection_name' => TextEntry::make('collection_name'),
                        'mime_type' => TextEntry::make('mime_type'),
                        'human_readable_size' => TextEntry::make('human_readable_size'),
                        'created_at' => TextEntry::make('created_at'),
                    ]),
                ]),
            'conversions' => RepeatableEntry::make('entry_conversions')
                ->schema([
                    'name' => TextEntry::make('name'),
                    'src_text' => TextEntry::make('src'),
                    'src_image' => ImageEntry::make('src'),
                ])
                ->columns(4),
        ];
    }

    /**
     * @return array<string, DeleteAction>
     */
    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ConvertWidget::make(['record' => // @var mixed record]
        ];
    }
}
