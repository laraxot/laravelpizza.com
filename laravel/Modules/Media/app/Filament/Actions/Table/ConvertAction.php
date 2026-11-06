<?php

declare(strict_types=1);
/**
 * @see https://coderflex.com/blog/create-advanced-filters-with-filament
 */

namespace Modules\Media\Filament\Actions\Table;

// Header actions must be an instance of Filament\Actions\Action, or Filament\Actions\ActionGroup.
// use Filament\Actions\Action;
use Filament\Actions\Action;
use Filament\Forms\Components\Radio;

class ConvertAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->translateLabel()
            ->tooltip('convert')
            ->openUrlInNewTab()
            ->icon('media-convert')
            ->schema([
                Radio::make('format')
                    ->options([
                        'webm01' => 'webm01',
                        'webm02' => 'webm02',
                    ])
                    ->inline()
                    ->inlineLabel(false),
            ])
            // Segnaposto senza caller (solo MediaHighestMissCoverageTest ne legge il nome): la conversione vera
            // e' ConvertVideoByMediaConvertAction, accodata da MediaConvertsTable. Prima qui c'era dddx(...),
            // che al submit scaricava il form e uccideva la richiesta.
            ->action(static fn (): never => throw new \LogicException('Media ConvertAction not implemented: use MediaConvertsTable'));

        // ->requiresConfirmation()
    }
}
