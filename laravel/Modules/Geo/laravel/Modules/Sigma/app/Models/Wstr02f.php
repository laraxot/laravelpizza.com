<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;
use stdClass;

// ---- xot ---
/**
 * Modules\Sigma\Models\Wstr02f.
 *
 * @property int $id
 * @property string $w2annu
 * @property int $enteap
 * @property mixed $stdata
 * @property int $ortobb
 * @property int $w2matr
 * @property string $w2orar
 * @property int $w2odat
 * @property string $w2turn
 * @property int $w2tdat
 * @property string $w2chiu
 * @property string $w2moda
 * @property string $w2modp
 * @property string $w2quad
 * @property int $w2sogl
 * @property int $w2sogd
 * @property int $w2vent
 * @property int $w2vesc
 * @property int $w2tent
 * @property int $w2tesc
 * @property int $w2pesg
 * @property int $w2mint
 * @property int $w2minp
 * @property int $w2stab
 * @property int $w2repa
 * @property string $w2pers
 * @property int $w2aper
 * @property int $w2anom
 * @property string $w2orae
 * @property string $w2orau
 * @property string $w2svil
 * @property string $w2teef
 * @property int $w2minf
 * @property string $w2aste
 * @property string $w2gipe
 * @property int $w2calc
 * @property string $w2corr
 * @property int $w2flg1
 * @property int $w2flg2
 * @property int $w2flg3
 * @property int $w2flg4
 * @property int $w2tora
 * @property int $w2ttur
 * @property string $w2tfes
 * @property int $w2ruol
 * @property int $w2prof
 * @property int $w2posi
 * @property int $w2rapp
 * @property int $w2cont
 * @property int $w2paui
 * @property int $w2pauf
 * @property int $w2paum
 * @property int $w2paus
 * @property int $w2ince
 * @property int $w2incc
 * @property string $w2com1
 * @property int $w2com2
 * @property int $w2com3
 * @property-read Anag|null $anag
 * @property-read bool $diritto_buonopasto
 * @property-read float $durata
 * @property-read float $durata_pomeriggio
 * @property-read Collection<int, stdClass> $pause
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Wmen00f> $wmen00f
 * @property-read int|null $wmen00f_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Wstr01lx> $wstr01lx
 * @property-read int|null $wstr01lx_count
 *
 * @method static Builder|Wstr02f newModelQuery()
 * @method static Builder|Wstr02f newQuery()
 * @method static Builder|Wstr02f query()
 * @method static Builder|Wstr02f whereEnteap($value)
 * @method static Builder|Wstr02f whereId($value)
 * @method static Builder|Wstr02f whereOrtobb($value)
 * @method static Builder|Wstr02f whereStdata($value)
 * @method static Builder|Wstr02f whereW2annu($value)
 * @method static Builder|Wstr02f whereW2anom($value)
 * @method static Builder|Wstr02f whereW2aper($value)
 * @method static Builder|Wstr02f whereW2aste($value)
 * @method static Builder|Wstr02f whereW2calc($value)
 * @method static Builder|Wstr02f whereW2chiu($value)
 * @method static Builder|Wstr02f whereW2com1($value)
 * @method static Builder|Wstr02f whereW2com2($value)
 * @method static Builder|Wstr02f whereW2com3($value)
 * @method static Builder|Wstr02f whereW2cont($value)
 * @method static Builder|Wstr02f whereW2corr($value)
 * @method static Builder|Wstr02f whereW2flg1($value)
 * @method static Builder|Wstr02f whereW2flg2($value)
 * @method static Builder|Wstr02f whereW2flg3($value)
 * @method static Builder|Wstr02f whereW2flg4($value)
 * @method static Builder|Wstr02f whereW2gipe($value)
 * @method static Builder|Wstr02f whereW2incc($value)
 * @method static Builder|Wstr02f whereW2ince($value)
 * @method static Builder|Wstr02f whereW2matr($value)
 * @method static Builder|Wstr02f whereW2minf($value)
 * @method static Builder|Wstr02f whereW2minp($value)
 * @method static Builder|Wstr02f whereW2mint($value)
 * @method static Builder|Wstr02f whereW2moda($value)
 * @method static Builder|Wstr02f whereW2modp($value)
 * @method static Builder|Wstr02f whereW2odat($value)
 * @method static Builder|Wstr02f whereW2orae($value)
 * @method static Builder|Wstr02f whereW2orar($value)
 * @method static Builder|Wstr02f whereW2orau($value)
 * @method static Builder|Wstr02f whereW2pauf($value)
 * @method static Builder|Wstr02f whereW2paui($value)
 * @method static Builder|Wstr02f whereW2paum($value)
 * @method static Builder|Wstr02f whereW2paus($value)
 * @method static Builder|Wstr02f whereW2pers($value)
 * @method static Builder|Wstr02f whereW2pesg($value)
 * @method static Builder|Wstr02f whereW2posi($value)
 * @method static Builder|Wstr02f whereW2prof($value)
 * @method static Builder|Wstr02f whereW2quad($value)
 * @method static Builder|Wstr02f whereW2rapp($value)
 * @method static Builder|Wstr02f whereW2repa($value)
 * @method static Builder|Wstr02f whereW2ruol($value)
 * @method static Builder|Wstr02f whereW2sogd($value)
 * @method static Builder|Wstr02f whereW2sogl($value)
 * @method static Builder|Wstr02f whereW2stab($value)
 * @method static Builder|Wstr02f whereW2svil($value)
 * @method static Builder|Wstr02f whereW2tdat($value)
 * @method static Builder|Wstr02f whereW2teef($value)
 * @method static Builder|Wstr02f whereW2tent($value)
 * @method static Builder|Wstr02f whereW2tesc($value)
 * @method static Builder|Wstr02f whereW2tfes($value)
 * @method static Builder|Wstr02f whereW2tora($value)
 * @method static Builder|Wstr02f whereW2ttur($value)
 * @method static Builder|Wstr02f whereW2turn($value)
 * @method static Builder|Wstr02f whereW2vent($value)
 * @method static Builder|Wstr02f whereW2vesc($value)
 *
 * @mixin \Eloquent
 */
class Wstr02f extends BaseModel
{
    protected $fillable = [
        'id',
        'w2annu',
        'enteap',
        'stdata',
        'ortobb',
        'w2matr',
        'w2orar',
        'w2odat',
        'w2turn',
        'w2tdat',
        'w2chiu',
        'w2moda',
        'w2modp',
        'w2quad',
        'w2sogl',
        'w2sogd',
        'w2vent',
        'w2vesc',
        'w2tent',
        'w2tesc',
        'w2pesg',
        'w2mint',
        'w2minp',
        'w2stab',
        'w2repa',
        'w2pers',
        'w2aper',
        'w2anom',
        'w2orae',
        'w2orau',
        'w2svil',
        'w2teef',
        'w2minf',
        'w2aste',
        'w2gipe',
        'w2calc',
        'w2corr',
        'w2flg1',
        'w2flg2',
        'w2flg3',
        'w2flg4',
        'w2tora',
        'w2ttur',
        'w2tfes',
        'w2ruol',
        'w2prof',
        'w2posi',
        'w2rapp',
        'w2cont',
        'w2paui',
        'w2pauf',
        'w2paum',
        'w2paus',
        'w2ince',
        'w2incc',
        'w2com1',
        'w2com2',
        'w2com3',
    ];

    protected $connection = 'generale';

    // this will use the specified database connection
    protected $table = 'wstr02f';

    public $timestamps = false;

    public function matrField(): string
    {
        return 'w2matr';
    }

    public function enteField(): string
    {
        return 'enteap';
    }

    /**
     * @return array<string, mixed>
     */
    public function casts(): array
    {
        return [
            // 'stdata' => 'datetime'
        ];
    }

    // ----------relationship-----------
    /**
     * @return HasOne<Anag, $this>
     */
    public function anag(): HasOne
    {
        return $this->hasOneByEnteMatr(Anag::class);
    }

    /**
     * @return HasMany<Wstr01lx, $this>
     */
    public function wstr01lx(): HasMany
    {
        return $this->hasMany(Wstr01lx::class, 'wtmatr', $this->matrField())
            ->whereRaw('wtannu=""')
            ->where('enteap', $this->{$this->enteField()})
            // ->where('wtdata', $this->stdata->format('Ymd'));
            ->where('wtdata', $this->stdata);
    }

    /**
     * @return HasMany<Wmen00f, $this>
     */
    public function wmen00f(): HasMany
    {
        return $this->hasMany(Wmen00f::class, 'mnmatr', $this->matrField())
            ->whereRaw('mnannu=""')
            ->where('enteap', $this->{$this->enteField()})
            // ->where('mndata', $this->stdata->format('Ymd'));
            ->where('mndata', $this->stdata);
    }

    // ----------mutators---------------
    /**
     * Undocumented function.
     *
     *
     * @return Carbon|mixed
     */
    protected function getStdataAttribute(mixed $value): mixed
    {
        // if (! \is_object($value)) {
        if (is_string($value)) {
            return Date::parse($value);
        }

        return $value;
    }

    protected function getDurataAttribute(?int $value): float
    {
        $timbr = $this->wstr01lx;
        $sens1 = $timbr->where('wtsens', 1)->pluck('wtorat');
        $sens2 = $timbr->where('wtsens', 2)->pluck('wtorat');
        $durata = 0;
        $n = min($sens1->count(), $sens2->count());
        for ($i = 0; $i < $n; $i++) {
            $a = $sens1[$i] ?? null;
            $b = $sens2[$i] ?? null;
            if ($a instanceof Carbon && $b instanceof Carbon) {
                $durata += $b->diffInMinutes($a);
            }
        }

        return (float) $durata; // <b>Durata: </b>{{ floor($durata/60) }}:{{ ($durata%60) }}
    }

    /**
     * Build pauses between OUT(IN=2) and next IN events.
     *
     * @return Collection<int, stdClass>
     */
    protected function getPauseAttribute(mixed $value): Collection
    {
        $timbr = $this->wstr01lx->values();
        $n = $timbr->count();
        $pause = [];
        for ($i = 0; $i < ($n - 1); $i++) {
            /** @var Wstr01lx $curr */
            $curr = $timbr[$i];
            /** @var Wstr01lx $succ */
            $succ = $timbr[$i + 1];
            if (($curr->wtsens ?? null) === 2) {
                $ws = $curr->getAttribute('wtorat');
                $we = $succ->getAttribute('wtorat');
                if ($ws instanceof Carbon && $we instanceof Carbon) {
                    $tmp = new stdClass;
                    $tmp->time_start = $ws;
                    $tmp->time_end = $we;
                    $tmp->durata = $we->diffInMinutes($ws);
                    $pause[] = $tmp;
                }
            }
        }

        return collect($pause);
    }

    // end function

    protected function getDurataPomeriggioAttribute(?int $value): float
    {
        $pause = $this->pause;
        $pausa30 = $pause->where('durata', '>=', 30)->first();
        if ($pausa30 === null) {
            return 0;
        }
        $timbr = $this->wstr01lx;

        if (! method_exists($timbr, 'where')) {
            return 0.0;
        }

        // ensure pausa30 is an object with property time_end
        // property_exists() non può essere usato sui modelli Eloquent perché gli attributi sono magici
        // Usiamo isset() che rispetta i magic methods __isset() di Eloquent
        if (! \is_object($pausa30) || ! isset($pausa30->time_end)) {
            return 0.0;
        }
        /** @var Carbon|null $timeEnd */
        $timeEnd = $pausa30->time_end;
        if (! $timeEnd instanceof Carbon) {
            return 0.0;
        }

        $timbr = $timbr->where('wtorat', '>=', $timeEnd);
        $sens1 = $timbr->where('wtsens', 1)->pluck('wtorat');
        $sens2 = $timbr->where('wtsens', 2)->pluck('wtorat');
        $durata = 0;
        $n = min($sens1->count(), $sens2->count());
        for ($i = 0; $i < $n; $i++) {
            $a = $sens1[$i] ?? null;
            $b = $sens2[$i] ?? null;
            if ($a instanceof Carbon && $b instanceof Carbon) {
                $durata += $b->diffInMinutes($a);
            }
        }

        return (float) $durata;
    }

    protected function getDirittoBuonopastoAttribute(?bool $value): bool
    {
        $min = (7 * 60) + 15;
        $pomeriggio = 90;

        return $this->durata > $min && $this->durata_pomeriggio > $pomeriggio;
    }
}

// end class
