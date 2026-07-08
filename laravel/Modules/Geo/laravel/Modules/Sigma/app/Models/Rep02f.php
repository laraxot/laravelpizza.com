<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Rep02f.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $re2dal
 * @property string|null $re2al
 * @property string|null $cdcseq
 * @property string|null $cdccod
 * @property string|null $cdcper
 * @property string|null $re2not
 * @property string|null $re2001
 * @property string|null $re2002
 * @property string|null $re2003
 *
 * @method static Builder|Rep02f newModelQuery()
 * @method static Builder|Rep02f newQuery()
 * @method static Builder|Rep02f query()
 * @method static Builder|Rep02f whereCdccod($value)
 * @method static Builder|Rep02f whereCdcper($value)
 * @method static Builder|Rep02f whereCdcseq($value)
 * @method static Builder|Rep02f whereEnte($value)
 * @method static Builder|Rep02f whereId($value)
 * @method static Builder|Rep02f whereMatr($value)
 * @method static Builder|Rep02f whereRe2001($value)
 * @method static Builder|Rep02f whereRe2002($value)
 * @method static Builder|Rep02f whereRe2003($value)
 * @method static Builder|Rep02f whereRe2al($value)
 * @method static Builder|Rep02f whereRe2dal($value)
 * @method static Builder|Rep02f whereRe2not($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Rep02fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Rep02f extends BaseModel
{
    protected $table = 'rep02f';
}
