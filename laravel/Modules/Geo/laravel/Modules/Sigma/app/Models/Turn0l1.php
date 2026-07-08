<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Turn0l1.
 *
 * @property int $id
 * @property int|null $ente
 * @property int|null $cont
 * @property int|null $turrap
 * @property int|null $turora
 * @property int|null $turdal
 * @property int|null $tural
 * @property int|null $oralun
 * @property int|null $oramar
 * @property int|null $oramer
 * @property int|null $oragio
 * @property int|null $oraven
 * @property int|null $orasab
 * @property int|null $oradom
 * @property string|null $turann
 *
 * @method static Builder|Turn0l1 newModelQuery()
 * @method static Builder|Turn0l1 newQuery()
 * @method static Builder|Turn0l1 query()
 * @method static Builder|Turn0l1 whereCont($value)
 * @method static Builder|Turn0l1 whereEnte($value)
 * @method static Builder|Turn0l1 whereId($value)
 * @method static Builder|Turn0l1 whereOradom($value)
 * @method static Builder|Turn0l1 whereOragio($value)
 * @method static Builder|Turn0l1 whereOralun($value)
 * @method static Builder|Turn0l1 whereOramar($value)
 * @method static Builder|Turn0l1 whereOramer($value)
 * @method static Builder|Turn0l1 whereOrasab($value)
 * @method static Builder|Turn0l1 whereOraven($value)
 * @method static Builder|Turn0l1 whereTural($value)
 * @method static Builder|Turn0l1 whereTurann($value)
 * @method static Builder|Turn0l1 whereTurdal($value)
 * @method static Builder|Turn0l1 whereTurora($value)
 * @method static Builder|Turn0l1 whereTurrap($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Turn0l1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Turn0l1 extends BaseModel
{
    protected $table = 'turn0l1';
}
