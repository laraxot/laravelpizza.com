<?php

/**
 * @see https://coderflex.com/blog/create-advanced-filters-with-filament
 */

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\SchedaResource\Actions\Header;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
// Header actions must be an instance of Filament\Actions\Action, or Filament\Actions\ActionGroup.
// use Filament\Tables\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Modules\Progressioni\Actions\RefreshByYearAction;
use Modules\Progressioni\Models\Scheda;
use Modules\Progressioni\Models\StabiDirigente;
use Modules\Progressioni\Services\CriteriPrecedenzaService;
use Modules\Xot\Actions\Export\PdfByViewAction;

class MakePdfAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'MakePdfAction';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('')
            ->tooltip('PDF')
            // ->icon('fas-file-pdf')
            ->icon('heroicon-o-document-text')
            ->action(function (ListRecords $livewire): mixed {
                /** @var array<string, mixed> $tableFilters */
                $tableFilters = $livewire->tableFilters ?? [];

                $livewireClass = get_class($livewire);
                $filename = class_basename($livewireClass).'-'.collect((array) $tableFilters)->flatten()->implode('-').'.pdf';
                $module = Str::of($livewireClass)->between('Modules\\', '\Filament\\')->lower()->toString();
                $transKey = $module.'::'.Str::of(class_basename($livewireClass))
                    ->kebab()
                    ->replace('list-', '')
                    ->singular()
                    ->append('.fields')
                    ->toString();

                $view = $module.'::admin.'.Str::of(class_basename($livewireClass))
                    ->kebab()
                    ->replace('list-', '')
                    ->singular()
                    ->append('.pdf')
                    ->toString();
                /** @var array<string, mixed> $annoValutatoreFilter */
                $annoValutatoreFilter = Arr::get($tableFilters, 'anno/valutatore', []);
                /** @var int|string|null $anno */
                $anno = Arr::get($annoValutatoreFilter, 'anno');

                /** @var array<int, object{name: string, label: string, type: string}> $precedenza */
                $precedenza = CriteriPrecedenzaService::getFieldsYear($anno);

                $filteredQuery = $livewire->getFilteredTableQuery();
                if ($filteredQuery === null) {
                    return null;
                }
                /** @var Builder<Scheda> $queryBuilder */
                $queryBuilder = $filteredQuery
                    ->where('ha_diritto', 1)
                    // ->orderByDesc('totale')
                    ->orderByDesc('punt_progressione_finale');
                /*
                // ->orderByDesc('totale_pond')
                ->orderByDesc('excellences_count_last_3_years') // 2023
                ->orderByDesc('perf_ind_media')

                ->orderByDesc('gg_cateco_posfun_no_asz')
                // ->orderByDesc('excellences_count_last_3_years') // 2024
                ->orderByDesc('gg_in_sede')
                ->orderByDesc('eta')
                ->get();
                */
                foreach ($precedenza as $field) {
                    /** @var object{name: string, label: string, type: string} $field */
                    $fieldName = $field->name ?? null;
                    if ($fieldName !== null && is_string($fieldName)) {
                        $queryBuilder = $queryBuilder->orderByDesc($fieldName);
                    }
                }
                /** @var Collection<int, Scheda> $rows */
                $rows = $queryBuilder->get();

                /** @var class-string<Scheda> $modelClass */
                $modelClass = $livewire->getModel();

                /** @var Collection<int, Scheda> $fixRows */
                $fixRows = $rows->where('perf_ind_media', '<', 1);
                foreach ($fixRows as $frow) {
                    /** @var Scheda|null $row */
                    $row = $modelClass::firstWhere('id', $frow->id);
                    if ($row !== null) {
                        $row->perf_ind_media = $row->perfIndMedia();
                        $row->save();
                    }
                }

                /** @var Collection<int, Scheda> $fixRows2 */
                $fixRows2 = $rows->where('excellences_count_last_3_years', '<', 1);
                foreach ($fixRows2 as $frow) {
                    /** @var Scheda|null $row */
                    $row = $modelClass::firstWhere('id', $frow->id);
                    if ($row !== null) {
                        $row->excellences_count_last_3_years = $row->excellencesCountLast3Years();
                        $row->save();
                    }
                }

                /** @var int|string|null $valutatoreId */
                $valutatoreId = Arr::get($annoValutatoreFilter, 'valutatore_id');

                /** @var StabiDirigente|null $valutatore */
                $valutatore = StabiDirigente::where('valutatore_id', $valutatoreId)
                    ->whereRaw('id=valutatore_id')
                    ->where('anno', $anno)
                    ->first();
                /*
                dddx([
                    'transkey'=>$transKey,
                    'view'=>$view,
                    'livewire'=>get_class($livewire),
                ]);
                */
                $view_params = [
                    'transKey' => $transKey,
                    'rows' => $rows->groupBy('categoria_ecoval'),
                    'firma' => $valutatore !== null ? ($valutatore->nome_diri ?? '') : '',
                ];
                // dddx($view);//progressioni::admin.schede.pdf
                // PHPStan: $view is constructed from strings, so it's safe to cast
                /** @phpstan-ignore-next-line */
                $out = view($view, $view_params);

                return app(PdfByViewAction::class)->execute($out, $filename);

                /*
                $resource = $livewire->getResource();

                dddx([
                    'rows' => $rows,
                    'resource' => $resource,
                    'livewire' => $livewire,
                ]);
                */

                /*
                $modelClass = $livewire->getResource()::getModel();
                $year = Arr::get($livewire->tableFilters, 'anno.value'); // 2023

                $fieldname = 'anno';
                app(RefreshByYearAction::class)->execute($modelClass, $fieldname, $year);
                */
                /*
                Notification::make()
                    ->title('Successfully')
                    ->success()
                    ->send();
                */
            });
    }
}
