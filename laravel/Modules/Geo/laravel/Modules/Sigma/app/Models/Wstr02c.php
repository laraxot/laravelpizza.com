<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Wstr02c.
 *
 * @property int $id
 * @property int $enteap
 * @property int $stdata
 * @property int $w2matr
 * @property string $w2orar
 * @property string $w2turn
 * @property int $w2pesg
 * @property int $w2mint
 * @property int $w2minp
 * @property string $w2orae
 * @property string $w2orau
 * @property int $w2minf
 * @property int $w2calc
 * @property int $w2flg2
 * @property string $c2orac
 * @property string $c2orin
 * @property string $c2prev
 * @property int $rimecp
 * @property int $rimecm
 * @property int $rimdip
 * @property int $rimdim
 * @property int $rimdis
 * @property int $rimlav
 * @property int $rimdif
 *
 * @method static Builder|Wstr02c newModelQuery()
 * @method static Builder|Wstr02c newQuery()
 * @method static Builder|Wstr02c query()
 * @method static Builder|Wstr02c whereC2orac($value)
 * @method static Builder|Wstr02c whereC2orin($value)
 * @method static Builder|Wstr02c whereC2prev($value)
 * @method static Builder|Wstr02c whereEnteap($value)
 * @method static Builder|Wstr02c whereId($value)
 * @method static Builder|Wstr02c whereRimdif($value)
 * @method static Builder|Wstr02c whereRimdim($value)
 * @method static Builder|Wstr02c whereRimdip($value)
 * @method static Builder|Wstr02c whereRimdis($value)
 * @method static Builder|Wstr02c whereRimecm($value)
 * @method static Builder|Wstr02c whereRimecp($value)
 * @method static Builder|Wstr02c whereRimlav($value)
 * @method static Builder|Wstr02c whereStdata($value)
 * @method static Builder|Wstr02c whereW2calc($value)
 * @method static Builder|Wstr02c whereW2flg2($value)
 * @method static Builder|Wstr02c whereW2matr($value)
 * @method static Builder|Wstr02c whereW2minf($value)
 * @method static Builder|Wstr02c whereW2minp($value)
 * @method static Builder|Wstr02c whereW2mint($value)
 * @method static Builder|Wstr02c whereW2orae($value)
 * @method static Builder|Wstr02c whereW2orar($value)
 * @method static Builder|Wstr02c whereW2orau($value)
 * @method static Builder|Wstr02c whereW2pesg($value)
 * @method static Builder|Wstr02c whereW2turn($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Wstr02cFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Wstr02c extends BaseModel
{
    protected $table = 'wstr02c';
}
