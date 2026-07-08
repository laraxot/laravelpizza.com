<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Accina.
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
 * @method static Builder|Accina newModelQuery()
 * @method static Builder|Accina newQuery()
 * @method static Builder|Accina query()
 * @method static Builder|Accina whereAccaa($value)
 * @method static Builder|Accina whereAccann($value)
 * @method static Builder|Accina whereAccmm($value)
 * @method static Builder|Accina whereDatass($value)
 * @method static Builder|Accina whereEnte($value)
 * @method static Builder|Accina whereId($value)
 * @method static Builder|Accina whereImpeur($value)
 * @method static Builder|Accina whereImpina($value)
 * @method static Builder|Accina whereMatr($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\AccinaFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Accina extends BaseModel
{
    protected $table = 'accina';
}
