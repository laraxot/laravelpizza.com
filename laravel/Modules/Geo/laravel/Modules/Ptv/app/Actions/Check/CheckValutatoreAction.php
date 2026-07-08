<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\Check;

use Illuminate\Database\Eloquent\Model;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

/**
 * Action per verificare quali righe Organizzativa non hanno valutatore_id valorizzato.
 */
class CheckValutatoreAction
{
    use QueueableAction;

    /**
     * Esegue il check e restituisce le righe senza valutatore_id.
     *
     * @param  class-string<Model>  $class
     * @param  string  $year  Anno di riferimento
     * @param  string  $type  Tipo di scheda (es. 'dip')
     * @return array<int, array{id: int, ha_diritto: int|null, matr: int|null, cognome: string|null, nome: string|null, stabi: int|null, repar: int|null, valutatore_id: int|null}>
     */
    public function execute(string $class, string $year, string $type): array
    {
        $rows = $class::query()
            ->where([
                'anno' => $year,
                'type' => $type,
            ])
            ->whereNull('valutatore_id')
            ->get(['id', 'matr', 'cognome', 'nome', 'stabi', 'repar', 'ha_diritto', 'valutatore_id']);

        $result = [];
        foreach ($rows as $row) {
            Assert::isInstanceOf($row, Model::class);
            $result[] = [
                'id' => (int) $row->getAttribute('id'),
                'ha_diritto' => is_numeric($row->getAttribute('ha_diritto')) ? (int) $row->getAttribute('ha_diritto') : null,
                'matr' => is_numeric($row->getAttribute('matr')) ? (int) $row->getAttribute('matr') : null,
                'cognome' => is_string($row->getAttribute('cognome')) ? $row->getAttribute('cognome') : null,
                'nome' => is_string($row->getAttribute('nome')) ? $row->getAttribute('nome') : null,
                'stabi' => is_numeric($row->getAttribute('stabi')) ? (int) $row->getAttribute('stabi') : null,
                'repar' => is_numeric($row->getAttribute('repar')) ? (int) $row->getAttribute('repar') : null,
                'valutatore_id' => is_numeric($row->getAttribute('valutatore_id')) ? (int) $row->getAttribute('valutatore_id') : null,
            ];
        }
        echo '<h1>CheckValutatoreAction</h1><pre>';
        print_r($result);
        echo '</pre>';

        return $result;
    }
}
