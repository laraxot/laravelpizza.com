<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Limm0l1.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $limmti
 * @property string|null $limmco
 * @property string|null $limman
 * @property string|null $limmme
 * @property string|null $limmte
 * @property string|null $limmgo
 * @property string|null $limmum
 * @property string|null $limm01
 * @property string|null $limm02
 * @property string|null $liannu
 * @property string|null $lmm001
 * @property string|null $lmm002
 * @property string|null $lmm003
 * @property string|null $lmm004
 * @property string|null $lmm005
 *
 * @method static Builder|Limm0l1 newModelQuery()
 * @method static Builder|Limm0l1 newQuery()
 * @method static Builder|Limm0l1 query()
 * @method static Builder|Limm0l1 whereEnte($value)
 * @method static Builder|Limm0l1 whereId($value)
 * @method static Builder|Limm0l1 whereLiannu($value)
 * @method static Builder|Limm0l1 whereLimm01($value)
 * @method static Builder|Limm0l1 whereLimm02($value)
 * @method static Builder|Limm0l1 whereLimman($value)
 * @method static Builder|Limm0l1 whereLimmco($value)
 * @method static Builder|Limm0l1 whereLimmgo($value)
 * @method static Builder|Limm0l1 whereLimmme($value)
 * @method static Builder|Limm0l1 whereLimmte($value)
 * @method static Builder|Limm0l1 whereLimmti($value)
 * @method static Builder|Limm0l1 whereLimmum($value)
 * @method static Builder|Limm0l1 whereLmm001($value)
 * @method static Builder|Limm0l1 whereLmm002($value)
 * @method static Builder|Limm0l1 whereLmm003($value)
 * @method static Builder|Limm0l1 whereLmm004($value)
 * @method static Builder|Limm0l1 whereLmm005($value)
 * @method static Builder|Limm0l1 whereMatr($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Limm0l1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Limm0l1 extends BaseModel
{
    protected $table = 'limm0l1';
}
