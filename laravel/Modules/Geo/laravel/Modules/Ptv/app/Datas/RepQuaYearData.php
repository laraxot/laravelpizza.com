<?php

declare(strict_types=1);

namespace Modules\Ptv\Datas;

use Livewire\Wireable;
use Modules\Ptv\Casts\DateStringToIntCast;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Webmozart\Assert\Assert;

/**
 * Data Transfer Object per rappresentare i dati di Rep e Qua per un anno.
 *
 * I campi `dal` e `al` possono arrivare dal database come stringhe di date
 * (formato YYYY-MM-DD) e vengono automaticamente convertiti in interi
 * (formato YYYYMMDD) tramite il cast DateStringToIntCast.
 */
class RepQuaYearData extends Data implements Wireable
{
    use WireableData;

    public int $ente; // => 90

    public int $matr; // => 21569

    public int $stabi; // => 613

    public int $repar; // => 20

    public ?int $rep2kd; // => 20160101

    public ?int $rep2ka; // => 0

    public ?int $propro; // => 716

    public ?int $posfun; // => 6

    public ?int $qua2kd; // => 20210101

    public ?int $qua2ka; // => 20230331

    /**
     * Data di inizio nel formato YYYYMMDD.
     * Può arrivare come stringa data (YYYY-MM-DD) dal database e viene convertita automaticamente.
     */
    #[WithCast(DateStringToIntCast::class)]
    public ?int $dal; // => 20230101

    /**
     * Data di fine nel formato YYYYMMDD.
     * Può arrivare come stringa data (YYYY-MM-DD) dal database e viene convertita automaticamente.
     */
    #[WithCast(DateStringToIntCast::class)]
    public ?int $al; // => 20230331

    /**
     * ---.
     *
     * @param  array<int, mixed>  $data
     * @return DataCollection<int|string, static>
     */
    public static function collection(array $data): DataCollection
    {
        try {
            Assert::isInstanceOf($res = self::collect($data, DataCollection::class), DataCollection::class);

            return $res;
        } catch (\Exception|\TypeError $e) {
            dddx(['err' => $e->getMessage(), 'data' => $data]);
            // return new DataCollection([]);
            throw new \Exception('Error in RepQuaYearData::collection: '.$e->getMessage().'<pre>'.print_r($data, true).'</pre>');
        }
    }
}
