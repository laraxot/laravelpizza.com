<?php

/**
 * @see https://coderflex.com/blog/create-advanced-filters-with-filament
 */

declare(strict_types=1);

namespace Modules\Ptv\Filament\Actions\Header;

use Filament\Actions\Action;
// Header actions must be an instance of Filament\Actions\Action, or Filament\Actions\ActionGroup.
// use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Modules\Sigma\Models\Rep00f;

class ImportStabiDirigenteAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->translateLabel()
            ->label('Carica/Aggiorna Stabi Dirigenti')
            ->icon('heroicon-o-arrow-up-tray')
            ->action(
                static function (array $data, $livewire): void {
                    // dd([get_class_methods($livewire), $livewire->getModel()]);
                    if (! is_object($livewire) || ! method_exists($livewire, 'getModel')) {
                        throw new \Exception('Livewire object does not have getModel method');
                    }
                    $model = $livewire->getModel();
                    if (! is_string($model) || ! class_exists($model)) {
                        throw new \Exception('Invalid model class');
                    }
                    /** @var class-string<Model> $modelClass */
                    $modelClass = $model;
                    $anno = 2025;
                    $rows = Rep00f::select('repst1')->where('repre1', '!=', 0)->distinct()->ofEnteYear(90, $anno)->get();

                    foreach ($rows as $row) {
                        $where = ['stabi' => $row->repst1, 'repar' => 0];

                        $data = [
                            'nome_stabi' => $row->stabi_txt,
                            'stabi' => $row->repst1,
                            'repar' => 0,
                            'anno' => $anno,
                            'valutatore_id' => null,
                            // 'nome_diri' => $row->nome_diri,
                        ];

                        $modelClass::firstOrCreate($where, $data);
                    }

                    Notification::make()->success()->title('Upload executed successfully.');
                }
            );
    }
}
