<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Giu03l1.
 *
 * @property int $id
 * @property string|null $g3annu
 * @property int|null $enteap
 * @property int|null $stdata
 * @property int|null $g3matr
 * @property int|null $lecod1
 * @property int|null $lecod2
 * @property int|null $g3qtaa
 * @property string|null $g3qtav
 * @property string|null $g3orad
 * @property string|null $g3oraa
 * @property string|null $g3umis
 * @property int|null $g3qtar
 * @property string|null $g3flgs
 * @property string|null $g3flg1
 * @property string|null $g3com1
 * @property int|null $g3com2
 *
 * @method static Builder|Giu03l1 newModelQuery()
 * @method static Builder|Giu03l1 newQuery()
 * @method static Builder|Giu03l1 query()
 * @method static Builder|Giu03l1 whereEnteap($value)
 * @method static Builder|Giu03l1 whereG3annu($value)
 * @method static Builder|Giu03l1 whereG3com1($value)
 * @method static Builder|Giu03l1 whereG3com2($value)
 * @method static Builder|Giu03l1 whereG3flg1($value)
 * @method static Builder|Giu03l1 whereG3flgs($value)
 * @method static Builder|Giu03l1 whereG3matr($value)
 * @method static Builder|Giu03l1 whereG3oraa($value)
 * @method static Builder|Giu03l1 whereG3orad($value)
 * @method static Builder|Giu03l1 whereG3qtaa($value)
 * @method static Builder|Giu03l1 whereG3qtar($value)
 * @method static Builder|Giu03l1 whereG3qtav($value)
 * @method static Builder|Giu03l1 whereG3umis($value)
 * @method static Builder|Giu03l1 whereId($value)
 * @method static Builder|Giu03l1 whereLecod1($value)
 * @method static Builder|Giu03l1 whereLecod2($value)
 * @method static Builder|Giu03l1 whereStdata($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Giu03l1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Giu03l1 extends BaseModel
{
    protected $table = 'giu03l1';
}
