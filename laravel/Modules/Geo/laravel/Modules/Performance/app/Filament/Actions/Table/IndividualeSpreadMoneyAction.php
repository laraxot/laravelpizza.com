<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Actions\Table;

use Filament\Actions\Action;
use Modules\Performance\Filament\Resources\PerformanceFondoResource;

/**
 * --.
 */
class IndividualeSpreadMoneyAction extends Action
{
    /**
     * ---.
     */
    public static function getDefaultName(): ?string
    {
        return 'individuale_spread_money';
    }

    /**
     * ---.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->label('individuale')
            ->tooltip(__('ptv::scheda.actions.'.$this->getDefaultName()))
            ->icon('heroicon-o-currency-euro')
            ->url(fn ($record) => PerformanceFondoResource::getUrl('individuale-money', ['record' => $record]));
    }
}
