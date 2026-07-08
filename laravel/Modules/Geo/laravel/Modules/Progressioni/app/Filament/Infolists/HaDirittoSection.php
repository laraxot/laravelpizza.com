<?php

declare(strict_types=1);

/*
 * @see https://coderflex.com/blog/create-advanced-filters-with-filament
 */

namespace Modules\Progressioni\Filament\Infolists;

use Filament\Actions\Action;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Modules\Progressioni\Actions\RefreshHaDirittoAction;
use Modules\Progressioni\Models\CriteriEsclusione;
use Modules\Progressioni\Models\Progressioni;

use function Safe\date;

class HaDirittoSection extends Section
{
    /**
     * Undocumented function.
     */
    public static function getDefaultName(): ?string
    {
        return 'ha_diritto';
    }

    protected function setUp(): void
    {
        parent::setUp();
        $year = intval(date('Y')) - 1; // devo prenderlo dal record
        $criteri_esclusione = CriteriEsclusione::where('anno', $year)
            ->where('value', '!=', 0)
            ->where('value', '!=', null)
            ->where('field_name', '!=', null)
            ->get();

        $form = [];

        foreach ($criteri_esclusione as $criterio) {
            if ($criterio->field_name !== null) {
                $form[] = TextEntry::make($criterio->field_name);
            }
        }
        $form[] = TextEntry::make('gg_cateco_posfun');
        $form[] = TextEntry::make('gg_asz_cateco_posfun');
        $form[] = TextEntry::make('gg_cateco_posfun_in_sede');
        $form[] = TextEntry::make('gg_cateco_posfun_fuori_sede');
        $form[] = TextEntry::make('gg_asz_cateco_posfun_in_sede');
        $form[] = TextEntry::make('gg_asz_cateco_posfun_fuori_sede');

        $this->schema([
            Grid::make(4)->schema([
                TextEntry::make('ha_diritto')
                    ->prefixAction(
                        Action::make('ricalcolaDiritto')
                            ->icon('heroicon-o-arrow-path')
                            ->requiresConfirmation()
                            ->action(function (Progressioni $record): void {
                                app(RefreshHaDirittoAction::class)->execute($record);
                            })
                    ),
                TextEntry::make('motivo'),
                ...$form,
            ]),
        ]);
    }
}
