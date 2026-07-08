<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Actions;

use Illuminate\Support\Str;
use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;
use Modules\IndennitaResponsabilita\Models\Rating;
use Modules\Xot\Filament\Actions\XotBaseAction;

/**
 * Action per preparare i dati del form di compilazione indennità.
 *
 * Idrata i rating per l'anno corrente e calcola i totali iniziali.
 */
final class PrepareCompilaDataAction extends XotBaseAction
{
    /**
     * Esegue l'azione.
     *
     * @return array<string, mixed>
     */
    public function execute(IndennitaResponsabilita $record): array
    {
        $modelData = $record->attributesToArray();

        // Get ratings for the current year using schemaless attributes
        // @var \Illuminate\Database\Eloquent\Builder<Rating> $ratingsQuery
        /** @var \Illuminate\Database\Eloquent\Builder<Rating> $ratingsQuery */
        $ratingsQuery = Rating::withExtraAttributes(['anno' => $record->anno]);
        $ratingsForYear = $ratingsQuery->get();

        // Sync and get hydrated ratings
        $record->ratings()->syncWithoutDetaching($ratingsForYear->pluck('id'));
        /** @var \Illuminate\Database\Eloquent\Collection<int, Rating> $hydratedRatings */
        $hydratedRatings = $record->ratings()->wherePivotIn('rating_id', $ratingsForYear->pluck('id'))->get();

        /** @var array<int|string, array{title?: string, pivot: array{value: mixed}}> $ratingsKeyed */
        $ratingsKeyed = $hydratedRatings->keyBy('id')->toArray();

        // Calculate initial totals
        $totals = $this->calculateTotals($ratingsKeyed, (float) ($record->perc_p_time_year ?? 1.0));

        // Inject computed values back into ratings data
        foreach ($ratingsKeyed as &$rData) {
            $title = (string) ($rData['title'] ?? '');
            $studlyTitle = Str::studly($title);
            if (isset($totals[$studlyTitle])) {
                $rData['pivot']['value'] = $totals[$studlyTitle];
            }
        }
        unset($rData);

        $modelData['ratings'] = $ratingsKeyed;

        return $modelData;
    }

    /**
     * Calcola i totali basati sui rating correnti.
     *
     * @param  array<int|string, array{title?: string, pivot: array{value: mixed}}>  $ratings
     * @return array<string, float|int>
     */
    protected function calculateTotals(array $ratings, float $perc): array
    {
        $readonlyTitles = ['tot', 'importo mensile calcolato', 'importo mensile attribuito', 'importo annuale attribuito'];

        $tot = 0;
        foreach ($ratings as $rData) {
            $title = (string) ($rData['title'] ?? '');
            if (! in_array($title, $readonlyTitles, true)) {
                $value = $rData['pivot']['value'];
                $tot += is_numeric($value) ? (int) $value : 0;
            }
        }

        $importoMensileCalcolato = (float) $tot * 10.0;
        $importoMensileAttribuito = $importoMensileCalcolato * $perc;
        $importoAnnualeAttribuito = $importoMensileAttribuito * 12.0;

        return [
            'Tot' => $tot,
            'ImportoMensileCalcolato' => $importoMensileCalcolato,
            'ImportoMensileAttribuito' => $importoMensileAttribuito,
            'ImportoAnnualeAttribuito' => $importoAnnualeAttribuito,
        ];
    }
}
