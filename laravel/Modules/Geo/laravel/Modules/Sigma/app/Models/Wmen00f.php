<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Date;
use stdClass;

/**
 * Modules\Sigma\Models\Wmen00f.
 *
 * @property int $id
 * @property int $enteap
 * @property string $mnannu
 * @property int $mnbadg
 * @property int $mnmatr
 * @property string $mncogn
 * @property string $mnnome
 * @property int $mncaus
 * @property int $mnp1
 * @property int $mnp2
 * @property int $mnp3
 * @property int $mnp4
 * @property mixed $mndata
 * @property mixed $mnorat
 * @property string $mnflg1
 * @property string $mnflg2
 * @property int $mnflg3
 * @property string $mnflg4
 * @property int $mntmen
 * @property string $mncom2
 * @property int $mncom3
 * @property string $ixterm
 * @property-read mixed $durata
 * @property-read float $durata_giornata
 * @property-read float $durata_pomeriggio
 * @property-read mixed $mensa_end
 * @property-read mixed $mensa_start
 * @property-read mixed $pause
 * @property-read bool $valida
 * @property-read Collection<int, Wstr01lx> $wstr01lx
 * @property-read int|null $wstr01lx_count
 * @property-read Collection<int, Wstr02f> $wstr02f
 * @property-read int|null $wstr02f_count
 *
 * @method static Builder|Wmen00f newModelQuery()
 * @method static Builder|Wmen00f newQuery()
 * @method static Builder|Wmen00f query()
 * @method static Builder|Wmen00f whereEnteap($value)
 * @method static Builder|Wmen00f whereId($value)
 * @method static Builder|Wmen00f whereIxterm($value)
 * @method static Builder|Wmen00f whereMnannu($value)
 * @method static Builder|Wmen00f whereMnbadg($value)
 * @method static Builder|Wmen00f whereMncaus($value)
 * @method static Builder|Wmen00f whereMncogn($value)
 * @method static Builder|Wmen00f whereMncom2($value)
 * @method static Builder|Wmen00f whereMncom3($value)
 * @method static Builder|Wmen00f whereMndata($value)
 * @method static Builder|Wmen00f whereMnflg1($value)
 * @method static Builder|Wmen00f whereMnflg2($value)
 * @method static Builder|Wmen00f whereMnflg3($value)
 * @method static Builder|Wmen00f whereMnflg4($value)
 * @method static Builder|Wmen00f whereMnmatr($value)
 * @method static Builder|Wmen00f whereMnnome($value)
 * @method static Builder|Wmen00f whereMnorat($value)
 * @method static Builder|Wmen00f whereMnp1($value)
 * @method static Builder|Wmen00f whereMnp2($value)
 * @method static Builder|Wmen00f whereMnp3($value)
 * @method static Builder|Wmen00f whereMnp4($value)
 * @method static Builder|Wmen00f whereMntmen($value)
 *
 * @mixin \Eloquent
 */
class Wmen00f extends BaseModel
{
    protected $fillable = [
        'id',
        'enteap',
        'mnannu',
        'mnbadg',
        'mnmatr',
        'mncogn',
        'mnnome',
        'mncaus',
        'mnp1',
        'mnp2',
        'mnp3',
        'mnp4',
        'mndata',
        'mnorat',
        'mnflg1',
        'mnflg2',
        'mnflg3',
        'mnflg4',
        'mntmen',
        'mncom2',
        'mncom3',
        'ixterm',
    ];

    protected $connection = 'generale';

    // this will use the specified database connection
    protected $table = 'wmen00f';

    public $timestamps = false;

    /**
     * @return array<string, mixed>
     */
    public function casts(): array
    {
        return [
            'mndata' => 'datetime',
        ];
    }

    // ----------relationship--------
    /**
     * @return HasMany<Wstr01lx, $this>
     */
    public function wstr01lx(): HasMany
    {
        return $this->hasMany(Wstr01lx::class, 'wtmatr', 'mnmatr')
            ->whereRaw('wtannu=""')
            ->where('enteap', $this->enteap)
            ->where('wtdata', $this->mndata->format('Ymd'));
    }

    /**
     * @return HasMany<Wstr02f, $this>
     */
    public function wstr02f(): HasMany
    {
        return $this->hasMany(Wstr02f::class, 'w2matr', 'mnmatr')
            ->whereRaw('w2annu=""')
            ->where('enteap', $this->enteap)
            ->where('stdata', $this->mndata->format('Ymd'));
    }

    // ----------mutators------------
    /**
     * Parse mndata attribute to Carbon instance.
     */
    protected function getMndataAttribute(mixed $value): Carbon
    {
        if ($value === null) {
            return now();
        }

        if (is_string($value)) {
            return Date::parse($value);
        }

        if ($value instanceof Carbon) {
            return $value;
        }

        return now();
    }

    /**
     * Build Carbon time from raw HHmm string combined with mndata date.
     */
    protected function getMnoratAttribute(mixed $value): Carbon
    {
        if ($value === null) {
            return now();
        }

        if (is_string($value)) {
            $raw = str_pad($value, 4, '0', STR_PAD_LEFT);
            $hh = substr($raw, 0, -2);
            $mm = substr($raw, -2);
            $date = $this->getAttribute('mndata');
            $dateStr = $date instanceof Carbon ? $date->format('Y-m-d') : (string) ($date ?? '');

            return Date::parse($dateStr.' '.$hh.':'.$mm);
        }

        if ($value instanceof Carbon) {
            return $value;
        }

        return now();
    }

    /**
     * Undocumented function.
     */
    protected function getMensaStartAttribute(mixed $value): mixed
    {
        $wstr01lx = $this->wstr01lx;
        $start = $wstr01lx->where('wtorat', '<', $this->mnorat)->sortByDesc('wtorat')->first();
        if (\is_object($start)) {
            // Trigger accessor on related model to get Carbon instance
            return $start->getAttribute('wtorat');
        }

        return $start;
    }

    /**
     * Undocumented function.
     */
    protected function getMensaEndAttribute(mixed $value): mixed
    {
        $wstr01lx = $this->wstr01lx;
        $start = $wstr01lx->where('wtorat', '>', $this->mnorat)->sortBy('wtorat')->first();
        if (\is_object($start)) {
            return $start->getAttribute('wtorat');
        }

        return $start;
    }

    /**
     * Undocumented function.
     */
    protected function getDurataAttribute(mixed $value): int
    {
        $start = $this->mensa_start;
        $end = $this->mensa_end;
        if ($start === null) {
            return 0;
        }

        if ($end === null) {
            return 0;
        }

        if ($start instanceof Carbon && $end instanceof Carbon) {
            return (int) $end->diffInMinutes($start);
        }

        return 0;
    }

    /**
     * Undocumented function.
     *
     *
     * @return mixed
     */
    /**
     * @return \Illuminate\Support\Collection<int, stdClass>
     */
    protected function getPauseAttribute(mixed $value): \Illuminate\Support\Collection
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
                $tmp = new stdClass;
                $ws = $curr->getAttribute('wtorat');
                $we = $succ->getAttribute('wtorat');
                if ($ws instanceof Carbon && $we instanceof Carbon) {
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

    protected function getDurataGiornataAttribute(?float $value): float
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

        return (float) $durata;
    }

    protected function getDurataPomeriggioAttribute(?float $value): float
    {
        $pause = $this->pause;
        $pausa30 = $pause->where('durata', '>=', 25)->first();
        if ($pausa30 === null) {
            return 0.0;
        }

        $wstr01lx = $this->wstr01lx;
        if (! method_exists($wstr01lx, 'where')) {
            return 0.0;
        }

        // property_exists() non può essere usato sui modelli Eloquent perché gli attributi sono magici
        // Usiamo isset() che rispetta i magic methods __isset() di Eloquent
        if (! is_object($pausa30) || ! isset($pausa30->time_end)) {
            return 0.0;
        }

        $timbr = $wstr01lx->where('wtorat', '>=', $pausa30->time_end);
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

    protected function getValidaAttribute(?bool $value): bool
    {
        $durata_giornata = (7 * 60) + 10;
        $durata_pomeriggio = 90;
        $motivo = '';
        if ($this->durata < 25) {
            $motivo .= ', pausa mensa < 25 ';
        }

        if ($this->durata_giornata < $durata_giornata) {
            $motivo .= ', durata giornata < '.floor($durata_giornata / 60).':'.($durata_giornata % 60);
        }

        if ($this->durata_pomeriggio < $durata_pomeriggio) {
            $motivo .= ', durata pomeriggio < '.floor($durata_pomeriggio / 60).':'.($durata_pomeriggio % 60);
        }

        // 259    Access to an undefined property Modules\Sigma\Models\Wmen00f::$motivo.
        // $this->motivo = $motivo;
        return $motivo === '';
    }

    // */
}

// end class
