<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Turn01lx.
 *
 * @property int $id
 * @property string $t1annu
 * @property int $enteap
 * @property string $t1codi
 * @property int $t1dal
 * @property int $t1al
 * @property int $t1stor
 * @property string $t1desc
 * @property int $t1modu
 * @property string $t1fest
 * @property string $t1manu
 * @property int $t1orar
 * @property int $t1turn
 * @property int $t1sogl
 * @property int $t1sogd
 * @property string $t1chiu
 * @property string $t1moda
 * @property string $t1modp
 * @property string $t1quad
 * @property string $t1pers
 * @property string $t1svil
 * @property string $t1teef
 * @property string $t1aste
 * @property string $t1gipe
 * @property string $t1corr
 * @property string $t1rife
 * @property string $t1rico
 * @property string $t1cofe
 * @property string $t1ripp
 * @property string $t1com1
 * @property string $t1com2
 * @property string $t1com3
 * @property int $t1com4
 * @property int $t1com5
 * @property int $t1com6
 * @property int $t1com7
 *
 * @method static Builder|Turn01lx newModelQuery()
 * @method static Builder|Turn01lx newQuery()
 * @method static Builder|Turn01lx query()
 * @method static Builder|Turn01lx whereEnteap($value)
 * @method static Builder|Turn01lx whereId($value)
 * @method static Builder|Turn01lx whereT1al($value)
 * @method static Builder|Turn01lx whereT1annu($value)
 * @method static Builder|Turn01lx whereT1aste($value)
 * @method static Builder|Turn01lx whereT1chiu($value)
 * @method static Builder|Turn01lx whereT1codi($value)
 * @method static Builder|Turn01lx whereT1cofe($value)
 * @method static Builder|Turn01lx whereT1com1($value)
 * @method static Builder|Turn01lx whereT1com2($value)
 * @method static Builder|Turn01lx whereT1com3($value)
 * @method static Builder|Turn01lx whereT1com4($value)
 * @method static Builder|Turn01lx whereT1com5($value)
 * @method static Builder|Turn01lx whereT1com6($value)
 * @method static Builder|Turn01lx whereT1com7($value)
 * @method static Builder|Turn01lx whereT1corr($value)
 * @method static Builder|Turn01lx whereT1dal($value)
 * @method static Builder|Turn01lx whereT1desc($value)
 * @method static Builder|Turn01lx whereT1fest($value)
 * @method static Builder|Turn01lx whereT1gipe($value)
 * @method static Builder|Turn01lx whereT1manu($value)
 * @method static Builder|Turn01lx whereT1moda($value)
 * @method static Builder|Turn01lx whereT1modp($value)
 * @method static Builder|Turn01lx whereT1modu($value)
 * @method static Builder|Turn01lx whereT1orar($value)
 * @method static Builder|Turn01lx whereT1pers($value)
 * @method static Builder|Turn01lx whereT1quad($value)
 * @method static Builder|Turn01lx whereT1rico($value)
 * @method static Builder|Turn01lx whereT1rife($value)
 * @method static Builder|Turn01lx whereT1ripp($value)
 * @method static Builder|Turn01lx whereT1sogd($value)
 * @method static Builder|Turn01lx whereT1sogl($value)
 * @method static Builder|Turn01lx whereT1stor($value)
 * @method static Builder|Turn01lx whereT1svil($value)
 * @method static Builder|Turn01lx whereT1teef($value)
 * @method static Builder|Turn01lx whereT1turn($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Turn01lxFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Turn01lx extends BaseModel
{
    protected $table = 'turn01lx';
}
