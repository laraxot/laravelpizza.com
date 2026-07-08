<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Cap00l1.
 *
 * @property int $id
 * @property string|null $capcap
 * @property string|null $capdes
 * @property string|null $cappro
 * @property string|null $capseq
 * @property string|null $capast
 *
 * @method static Builder|Cap00l1 newModelQuery()
 * @method static Builder|Cap00l1 newQuery()
 * @method static Builder|Cap00l1 query()
 * @method static Builder|Cap00l1 whereCapast($value)
 * @method static Builder|Cap00l1 whereCapcap($value)
 * @method static Builder|Cap00l1 whereCapdes($value)
 * @method static Builder|Cap00l1 whereCappro($value)
 * @method static Builder|Cap00l1 whereCapseq($value)
 * @method static Builder|Cap00l1 whereId($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Cap00l1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Cap00l1 extends BaseModel
{
    protected $table = 'cap00l1';
}
