<?php

declare(strict_types=1);

/*
 * @see https://coderflex.com/blog/create-advanced-filters-with-filament
 */

namespace Modules\Progressioni\Filament\Infolists;

use Filament\Infolists\Components;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Modules\Progressioni\Models\CriteriPrecedenza;

class CriteriPrecedenzaSection extends Section
{
    public static int $year = 0;

    // public function mount(int $year): void
    // {
    //    $this->year=$year;
    // }

    public static function setYear(int $year): static
    {
        static::$year = $year;

        return new static;
    }

    /**
     * Undocumented function.
     */
    public static function getDefaultName(): ?string
    {
        return 'criteri_valutazione';
    }

    protected function setUp(): void
    {
        parent::setUp();
        $year = static::$year;
        // $year = intval(date('Y')) -  1; // devo prenderlo dal record o sessione
        $criteri = CriteriPrecedenza::where('anno', $year)
            // ->where('value', '!=', 0)
            // ->where('value', '!=', null)
            // ->where('field_name', '!=', null)
            ->orderBy('posizione')
            ->get();

        $form = [];

        foreach ($criteri as $criterio) {
            if ($criterio->name !== null) {
                $form[] = TextEntry::make($criterio->name);
            }
        }
        // for($i=0;$i<4;$i++){
        //    $form[] = Components\TextEntry::make('perf_ind_'.($year-$i));
        // }
        /*
        $form[] = Components\TextEntry::make('gg_cateco_posfun');
        $form[] = Components\TextEntry::make('gg_asz_cateco_posfun');
        $form[] = Components\TextEntry::make('gg_cateco_posfun_in_sede');
        $form[] = Components\TextEntry::make('gg_cateco_posfun_fuori_sede');
        $form[] = Components\TextEntry::make('gg_asz_cateco_posfun_in_sede');
        $form[] = Components\TextEntry::make('gg_asz_cateco_posfun_fuori_sede');
        */
        $this->schema([
            Section::make('Criteri Precedenza')->schema([
                Grid::make(4)

                    ->schema([

                        ...$form,
                    ]),
            ]),
        ]);
    }
}
