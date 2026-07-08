<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Filters;

use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Modules\Ptv\Actions\GetValutatoriOptions;

class AnnoValutatoreFilter extends Filter
{
    public static function getDefaultName(): ?string
    {
        return 'anno_valutatore';
    }

    protected function setUp(): void
    {
        parent::setUp();
        // $trace = debug_backtrace();
        // $caller = $trace[4]['class'] ?? '';
        // $module_name = Str::of($caller)->between('Modules\\', '\Filament\\')->toString();

        $current_year = intval(date('Y'));
        $year_range = range($current_year - 2, $current_year);
        /** @var array<string, string> $years */
        $years = array_combine(array_map('strval', $year_range), array_map('strval', $year_range));
        $this->schema([
            Select::make('anno')
                ->options($years)
                ->reactive(),

            Select::make('valutatore_id')
                ->label('valutatore')
                ->options(static function (Get $get, Set $set, mixed $livewire): array {
                    if (! is_object($livewire)) {
                        return [];
                    }

                    $module_name = Str::of(get_class($livewire))->between('Modules\\', '\Filament\\')->toString();
                    $anno = $get('anno');
                    $annoValue = is_string($anno) || is_int($anno) ? $anno : null;

                    return app(GetValutatoriOptions::class)->execute($module_name, $annoValue);
                })
                // ->live(onBlur: true)
                ->reactive()
                ->afterStateUpdated(function (?string $state, ?string $old, $livewire): void {
                    /*
                    //$livewire
                    dddx([
                        $livewire->getTableFilters(),
                        //$livewire->getTableFilters()->getState(),
                        $livewire,
                        'state' => $state,
                    ]);
                    */
                    if (is_object($livewire) && method_exists($livewire, 'dispatch')) {
                        $livewire->dispatch('valutatoreIdUpdated', ['valutatore_id' => $state]);
                    }
                }),

            // TernaryFilter::make('is_admin'),
            /*
            Select::make('ha_diritto')
                ->label('diritto ?')
                ->options([null => 'Tutti', '0' => 'no', '1' => 'si']),
                */
        ])
            ->query(static function (Builder $query, array $data) {
                if ($data['anno'] == null) {
                    return $query->where('id', 0);
                }

                if ($data['valutatore_id'] == null) {
                    /** @var object|null $profile */
                    $profile = function_exists('profile') ? \profile() : null;
                    if ($profile !== null && method_exists($profile, 'isSuperAdmin') && $profile->isSuperAdmin()) {
                        unset($data['valutatore_id']);
                    }
                }

                if (isset($data['valutatore_id']) && $data['valutatore_id'] == null) {
                    return $query->where('id', 0);
                }

                // *
                if (isset($data['ha_diritto']) && $data['ha_diritto'] == null) {
                    unset($data['ha_diritto']);
                }

                // */
                /*
            if(in_array(array_keys($data),['ha_diritto'])){
                dddx($data);
            }
                */
                // $data = array_filter($data);

                // app(Populate::class)->execute($data);
                // app(FixValutatoreIdByAnno::class)->execute('IndennitaCondizioniLavoro', 'CondizioniLavoro', $data['anno']);

                $query = $query->where($data);

                return $query;
            })
            ->columns(3);
    }
}
