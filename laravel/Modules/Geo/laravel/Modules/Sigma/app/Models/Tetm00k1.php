<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Tetm00k1.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $temrec
 * @property string|null $temdal
 * @property string|null $temal
 * @property string|null $temdur
 * @property string|null $t18dal
 * @property string|null $t18al
 * @property string|null $t18dur
 * @property string|null $temann
 * @property string|null $tem2kd
 * @property string|null $tem2ka
 * @property string|null $t182kd
 * @property string|null $t182ka
 * @property string|null $asz001
 * @property string|null $asz002
 * @property string|null $asz003
 * @property string|null $asz004
 * @property string|null $asz005
 *
 * @method static Builder|Tetm00k1 newModelQuery()
 * @method static Builder|Tetm00k1 newQuery()
 * @method static Builder|Tetm00k1 query()
 * @method static Builder|Tetm00k1 whereAsz001($value)
 * @method static Builder|Tetm00k1 whereAsz002($value)
 * @method static Builder|Tetm00k1 whereAsz003($value)
 * @method static Builder|Tetm00k1 whereAsz004($value)
 * @method static Builder|Tetm00k1 whereAsz005($value)
 * @method static Builder|Tetm00k1 whereEnte($value)
 * @method static Builder|Tetm00k1 whereId($value)
 * @method static Builder|Tetm00k1 whereMatr($value)
 * @method static Builder|Tetm00k1 whereT182ka($value)
 * @method static Builder|Tetm00k1 whereT182kd($value)
 * @method static Builder|Tetm00k1 whereT18al($value)
 * @method static Builder|Tetm00k1 whereT18dal($value)
 * @method static Builder|Tetm00k1 whereT18dur($value)
 * @method static Builder|Tetm00k1 whereTem2ka($value)
 * @method static Builder|Tetm00k1 whereTem2kd($value)
 * @method static Builder|Tetm00k1 whereTemal($value)
 * @method static Builder|Tetm00k1 whereTemann($value)
 * @method static Builder|Tetm00k1 whereTemdal($value)
 * @method static Builder|Tetm00k1 whereTemdur($value)
 * @method static Builder|Tetm00k1 whereTemrec($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Tetm00k1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Tetm00k1 extends BaseModel
{
    protected $table = 'tetm00k1';
}
