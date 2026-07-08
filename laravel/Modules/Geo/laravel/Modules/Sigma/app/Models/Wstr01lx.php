<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;

// ----------traits ---
/**
 * Modules\Sigma\Models\Wstr01lx.
 *
 * @property int $id
 * @property int $enteap
 * @property string $wtannu
 * @property int $wtsens
 * @property int $wtindi
 * @property int $wtbadg
 * @property int $wtdata
 * @property int $wtteor
 * @property int $wtorat
 * @property int $wxorat
 * @property int $wyorat
 * @property string $t1codi
 * @property string $orcodi
 * @property int $wtmatr
 * @property int $wtcaus
 * @property string $wtflg1
 * @property string $wtflg2
 * @property int $wtcomp
 * @property string $wtcom1
 * @property int $wtcom2
 * @property string $ixterm
 * @property-read Anag|null $anag
 *
 * @method static Builder|Wstr01lx newModelQuery()
 * @method static Builder|Wstr01lx newQuery()
 * @method static Builder|Wstr01lx query()
 * @method static Builder|Wstr01lx whereEnteap($value)
 * @method static Builder|Wstr01lx whereId($value)
 * @method static Builder|Wstr01lx whereIxterm($value)
 * @method static Builder|Wstr01lx whereOrcodi($value)
 * @method static Builder|Wstr01lx whereT1codi($value)
 * @method static Builder|Wstr01lx whereWtannu($value)
 * @method static Builder|Wstr01lx whereWtbadg($value)
 * @method static Builder|Wstr01lx whereWtcaus($value)
 * @method static Builder|Wstr01lx whereWtcom1($value)
 * @method static Builder|Wstr01lx whereWtcom2($value)
 * @method static Builder|Wstr01lx whereWtcomp($value)
 * @method static Builder|Wstr01lx whereWtdata($value)
 * @method static Builder|Wstr01lx whereWtflg1($value)
 * @method static Builder|Wstr01lx whereWtflg2($value)
 * @method static Builder|Wstr01lx whereWtindi($value)
 * @method static Builder|Wstr01lx whereWtmatr($value)
 * @method static Builder|Wstr01lx whereWtorat($value)
 * @method static Builder|Wstr01lx whereWtsens($value)
 * @method static Builder|Wstr01lx whereWtteor($value)
 * @method static Builder|Wstr01lx whereWxorat($value)
 * @method static Builder|Wstr01lx whereWyorat($value)
 *
 * @mixin \Eloquent
 */
class Wstr01lx extends BaseModel
{
    protected $fillable = [
        'id',
        'enteap',
        'wtannu',
        'wtsens',
        'wtindi',
        'wtbadg',
        'wtdata',
        'wtteor',
        'wtorat',
        'wxorat',
        'wyorat',
        't1codi',
        'orcodi',
        'wtmatr',
        'wtcaus',
        'wtflg1',
        'wtflg2',
        'wtcomp',
        'wtcom1',
        'wtcom2',
        'ixterm',
    ];

    protected $connection = 'generale'; // this will use the specified database connection

    // protected $table = 'wstr01lx';
    protected $table = 'wstr01f'; // da webservice non ci danno questa tabella

    // protected static $single_date=true;
    public $timestamps = false;

    public function matrField(): string
    {
        return 'wtmatr';
    }

    public function enteField(): string
    {
        return 'enteap';
    }

    // ------------------------------------
    /**
     * @return HasOne<Anag, $this>
     */
    public function anag(): HasOne
    {
        return $this->hasOneByEnteMatr(Anag::class);
    }

    // ----------mutators----------
    /**
     * Cast raw wtdata (Ymd) to Carbon instance.
     */
    protected function getWtdataAttribute(int|string|Carbon $value): Carbon
    {
        if ($value instanceof Carbon) {
            return $value;
        }
        $str = (string) $value;
        // Expecting Ymd format (e.g., 20240131)
        if (\strlen($str) === 8 && ctype_digit($str)) {
            $created = Date::createFromFormat('Ymd', $str);
            if ($created instanceof Carbon) {
                /** @var Carbon $created */
                return $created->startOfDay();
            }
        }

        return Date::parse($str);
    }

    /**
     * Cast raw wtorat (HHmm) combined with wtdata date to Carbon instance.
     */
    protected function getWtoratAttribute(int|string|Carbon $value): Carbon
    {
        if ($value instanceof Carbon) {
            return $value;
        }
        $raw = (string) $value;
        // Ensure at least 4 digits (HHmm)
        $raw = str_pad($raw, 4, '0', STR_PAD_LEFT);
        $hh = substr($raw, 0, -2);
        $mm = substr($raw, -2);
        $time = sprintf('%s:%s', $hh, $mm);
        $date = $this->getAttribute('wtdata');
        $dateStr = $date instanceof Carbon ? $date->format('Y-m-d') : (string) $date;

        return Date::parse($dateStr.' '.$time);
    }

    /*
     * public static function filter($params){
     * $rows=new self;
     * $form=$rows->getConnection()->getSchemaBuilder();
     * $tbl=$rows->getTable();
     * $fields=collect($form->getColumnListing($tbl));
     * $lang=trans('sigma::'.$tbl);
     * $lang=array_flip($lang);
     * //echo '<pre>';print_r($lang);echo '</pre>';
     * $parz=collect(array_keys($params));
     * $parz=$parz->map(function($item,$key) use ($lang){
     * if(isset($lang[$item])){
     * return $lang[$item];
     * }
     * return $item;
     * });
     * $intersect=$fields->intersect($parz);
     *
     * foreach($intersect->all() as $el){
     * $key=trans('sigma::'.$tbl.'.'.$el);
     * $value=$params[$key];
     * //echo '<br/>'.$el.'   '.$key.'   '.$value;
     * $rows=$rows->where($el,$value);
     * }
     * if(isset($lang['ann'])){
     * $rows=$rows->whereRaw($lang['ann'].'=""');
     * }
     *
     * //echo '<pre>';print_r($params);echo '</pre>';
     * if(isset($params['date_between'])){
     * extract($params['date_between']);
     * $from_time=strtotime($from);
     * $to_time=strtotime($to);
     * $rows=$rows->whereRaw(
     * 'wtdata between '.date('Ymd',$from_time).' and '.date('Ymd',$to_time)
     * );
     * }
     * //echo '<pre>'.$rows->toSql().'</pre>';
     * return $rows;
     * }//end filter
     */
    // *
    /**
     * Calcola la durata totale in minuti a partire dalle timbrature.
     *
     * @param  array{timbr: Collection<int, self>}  $params
     */
    public function durata(array $params): float
    {
        if (! isset($params['timbr']) || ! $params['timbr'] instanceof Collection) {
            throw new Exception('Parameter "timbr" must be a Collection');
        }

        /** @var Collection<int, self> $timbr */
        $timbr = $params['timbr'];

        $sens1 = $timbr->where('wtsens', 1)->pluck('wtorat');
        $sens2 = $timbr->where('wtsens', 2)->pluck('wtorat');
        $durata = 0;
        if ($sens1->count() !== $sens2->count()) {
            return $durata;
        }

        $n = $sens1->count();
        for ($i = 0; $i < $n; $i++) {
            // if(isset($sens2[$i]) && isset($sens1[$i]) ){
            $start = $sens1[$i] ?? null;
            $end = $sens2[$i] ?? null;
            if ($start instanceof Carbon && $end instanceof Carbon) {
                $durata += $end->diffInMinutes($start);
            }
        }

        return $durata;
    }

    // */
    // ------------------------------------
}

// end class
