<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Lturn2l1.
 *
 * @property int $id
 * @property string|null $t2annu
 * @property int|null $enteap
 * @property string|null $t2codi
 * @property int|null $t2stor
 * @property int|null $t2sequ
 * @property string|null $t2ripp
 * @property string|null $t2com1
 * @property string|null $t2com2
 * @property string|null $tjob
 * @property string|null $utente
 * @property int|null $fldate
 * @property int|null $fltime
 * @property string|null $fltipo
 *
 * @method static Builder|Lturn2l1 newModelQuery()
 * @method static Builder|Lturn2l1 newQuery()
 * @method static Builder|Lturn2l1 query()
 * @method static Builder|Lturn2l1 whereEnteap($value)
 * @method static Builder|Lturn2l1 whereFldate($value)
 * @method static Builder|Lturn2l1 whereFltime($value)
 * @method static Builder|Lturn2l1 whereFltipo($value)
 * @method static Builder|Lturn2l1 whereId($value)
 * @method static Builder|Lturn2l1 whereT2annu($value)
 * @method static Builder|Lturn2l1 whereT2codi($value)
 * @method static Builder|Lturn2l1 whereT2com1($value)
 * @method static Builder|Lturn2l1 whereT2com2($value)
 * @method static Builder|Lturn2l1 whereT2ripp($value)
 * @method static Builder|Lturn2l1 whereT2sequ($value)
 * @method static Builder|Lturn2l1 whereT2stor($value)
 * @method static Builder|Lturn2l1 whereTjob($value)
 * @method static Builder|Lturn2l1 whereUtente($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Lturn2l1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Lturn2l1 extends BaseModel
{
    protected $table = 'lturn2l1';
}
