<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Accinal2.
 *
 * @property int $id
 * @property int $ente
 * @property int $matr
 * @property int $datass
 * @property int $impina
 * @property string $impeur
 * @property string $accann
 * @property int $accaa
 * @property int $accmm
 *
 * @method static Builder|Accinal2 newModelQuery()
 * @method static Builder|Accinal2 newQuery()
 * @method static Builder|Accinal2 query()
 * @method static Builder|Accinal2 whereAccaa($value)
 * @method static Builder|Accinal2 whereAccann($value)
 * @method static Builder|Accinal2 whereAccmm($value)
 * @method static Builder|Accinal2 whereDatass($value)
 * @method static Builder|Accinal2 whereEnte($value)
 * @method static Builder|Accinal2 whereId($value)
 * @method static Builder|Accinal2 whereImpeur($value)
 * @method static Builder|Accinal2 whereImpina($value)
 * @method static Builder|Accinal2 whereMatr($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Accinal2Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Accinal2 extends BaseModel
{
    protected $table = 'accinal2';
}
