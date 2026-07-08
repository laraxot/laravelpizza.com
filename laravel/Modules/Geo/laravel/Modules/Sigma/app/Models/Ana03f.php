<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Ana03f.
 *
 * @property int $id
 * @property int $ente
 * @property int $matr
 * @property string $telnum
 * @property string $celnum
 * @property string $cel2nu
 * @property string $faxnum
 * @property string $emaind
 * @property string $emaper
 * @property string $benefi
 * @property string $invced
 * @property string $cpaese
 * @property int $chedig
 * @property string $statoe
 * @property string $anacup
 * @property string $anacig
 * @property string $anaest
 * @property int $ana031
 * @property int $ana032
 * @property int $ana033
 * @property int $ana034
 * @property int $ana035
 * @property int $ana036
 * @property string $ana037
 * @property string $ana038
 * @property string $ana039
 *
 * @method static Builder|Ana03f newModelQuery()
 * @method static Builder|Ana03f newQuery()
 * @method static Builder|Ana03f query()
 * @method static Builder|Ana03f whereAna031($value)
 * @method static Builder|Ana03f whereAna032($value)
 * @method static Builder|Ana03f whereAna033($value)
 * @method static Builder|Ana03f whereAna034($value)
 * @method static Builder|Ana03f whereAna035($value)
 * @method static Builder|Ana03f whereAna036($value)
 * @method static Builder|Ana03f whereAna037($value)
 * @method static Builder|Ana03f whereAna038($value)
 * @method static Builder|Ana03f whereAna039($value)
 * @method static Builder|Ana03f whereAnacig($value)
 * @method static Builder|Ana03f whereAnacup($value)
 * @method static Builder|Ana03f whereAnaest($value)
 * @method static Builder|Ana03f whereBenefi($value)
 * @method static Builder|Ana03f whereCel2nu($value)
 * @method static Builder|Ana03f whereCelnum($value)
 * @method static Builder|Ana03f whereChedig($value)
 * @method static Builder|Ana03f whereCpaese($value)
 * @method static Builder|Ana03f whereEmaind($value)
 * @method static Builder|Ana03f whereEmaper($value)
 * @method static Builder|Ana03f whereEnte($value)
 * @method static Builder|Ana03f whereFaxnum($value)
 * @method static Builder|Ana03f whereId($value)
 * @method static Builder|Ana03f whereInvced($value)
 * @method static Builder|Ana03f whereMatr($value)
 * @method static Builder|Ana03f whereStatoe($value)
 * @method static Builder|Ana03f whereTelnum($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Ana03fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Ana03f extends BaseModel
{
    protected $table = 'ana03f';
}
