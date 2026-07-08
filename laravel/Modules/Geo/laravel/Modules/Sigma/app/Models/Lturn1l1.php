<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Lturn1l1.
 *
 * @property int $id
 * @property string|null $t1annu
 * @property int|null $enteap
 * @property string|null $t1codi
 * @property int|null $t1dal
 * @property int|null $t1al
 * @property int|null $t1stor
 * @property string|null $t1desc
 * @property int|null $t1modu
 * @property string|null $t1fest
 * @property string|null $t1manu
 * @property int|null $t1orar
 * @property int|null $t1turn
 * @property int|null $t1sogl
 * @property int|null $t1sogd
 * @property string|null $t1chiu
 * @property string|null $t1moda
 * @property string|null $t1modp
 * @property string|null $t1quad
 * @property string|null $t1pers
 * @property string|null $t1svil
 * @property string|null $t1teef
 * @property string|null $t1aste
 * @property string|null $t1gipe
 * @property string|null $t1corr
 * @property string|null $t1rife
 * @property string|null $t1rico
 * @property string|null $t1cofe
 * @property string|null $t1ripp
 * @property string|null $t1com1
 * @property string|null $t1com2
 * @property string|null $t1com3
 * @property int|null $t1com4
 * @property int|null $t1com5
 * @property int|null $t1com6
 * @property int|null $t1com7
 * @property string|null $tjob
 * @property string|null $utente
 * @property int|null $fldate
 * @property int|null $fltime
 * @property string|null $fltipo
 *
 * @method static Builder|Lturn1l1 newModelQuery()
 * @method static Builder|Lturn1l1 newQuery()
 * @method static Builder|Lturn1l1 query()
 * @method static Builder|Lturn1l1 whereEnteap($value)
 * @method static Builder|Lturn1l1 whereFldate($value)
 * @method static Builder|Lturn1l1 whereFltime($value)
 * @method static Builder|Lturn1l1 whereFltipo($value)
 * @method static Builder|Lturn1l1 whereId($value)
 * @method static Builder|Lturn1l1 whereT1al($value)
 * @method static Builder|Lturn1l1 whereT1annu($value)
 * @method static Builder|Lturn1l1 whereT1aste($value)
 * @method static Builder|Lturn1l1 whereT1chiu($value)
 * @method static Builder|Lturn1l1 whereT1codi($value)
 * @method static Builder|Lturn1l1 whereT1cofe($value)
 * @method static Builder|Lturn1l1 whereT1com1($value)
 * @method static Builder|Lturn1l1 whereT1com2($value)
 * @method static Builder|Lturn1l1 whereT1com3($value)
 * @method static Builder|Lturn1l1 whereT1com4($value)
 * @method static Builder|Lturn1l1 whereT1com5($value)
 * @method static Builder|Lturn1l1 whereT1com6($value)
 * @method static Builder|Lturn1l1 whereT1com7($value)
 * @method static Builder|Lturn1l1 whereT1corr($value)
 * @method static Builder|Lturn1l1 whereT1dal($value)
 * @method static Builder|Lturn1l1 whereT1desc($value)
 * @method static Builder|Lturn1l1 whereT1fest($value)
 * @method static Builder|Lturn1l1 whereT1gipe($value)
 * @method static Builder|Lturn1l1 whereT1manu($value)
 * @method static Builder|Lturn1l1 whereT1moda($value)
 * @method static Builder|Lturn1l1 whereT1modp($value)
 * @method static Builder|Lturn1l1 whereT1modu($value)
 * @method static Builder|Lturn1l1 whereT1orar($value)
 * @method static Builder|Lturn1l1 whereT1pers($value)
 * @method static Builder|Lturn1l1 whereT1quad($value)
 * @method static Builder|Lturn1l1 whereT1rico($value)
 * @method static Builder|Lturn1l1 whereT1rife($value)
 * @method static Builder|Lturn1l1 whereT1ripp($value)
 * @method static Builder|Lturn1l1 whereT1sogd($value)
 * @method static Builder|Lturn1l1 whereT1sogl($value)
 * @method static Builder|Lturn1l1 whereT1stor($value)
 * @method static Builder|Lturn1l1 whereT1svil($value)
 * @method static Builder|Lturn1l1 whereT1teef($value)
 * @method static Builder|Lturn1l1 whereT1turn($value)
 * @method static Builder|Lturn1l1 whereTjob($value)
 * @method static Builder|Lturn1l1 whereUtente($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Lturn1l1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Lturn1l1 extends BaseModel
{
    protected $table = 'lturn1l1';
}
