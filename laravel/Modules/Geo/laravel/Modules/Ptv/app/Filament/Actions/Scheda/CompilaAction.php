<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Actions\Scheda;

use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class CompilaAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'compila';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->icon('heroicon-m-pencil-square')
            ->iconButton()
            ->tooltip(__('ptv::scheda.actions.compila.label'))
            ->url(function (ListRecords $livewire, $record): string {
                $resource = $livewire->getResource();
                $url = $resource::getUrl('compila', ['record' => $record]);

                return is_string($url) ? $url : '';
            });
    }
}
