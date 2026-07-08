<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Datelab.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $payann
 * @property string|null $paymon
 * @property string|null $eladal
 * @property string|null $elaal
 * @property string|null $testo
 *
 * @method static Builder|Datelab newModelQuery()
 * @method static Builder|Datelab newQuery()
 * @method static Builder|Datelab query()
 * @method static Builder|Datelab whereElaal($value)
 * @method static Builder|Datelab whereEladal($value)
 * @method static Builder|Datelab whereEnte($value)
 * @method static Builder|Datelab whereId($value)
 * @method static Builder|Datelab wherePayann($value)
 * @method static Builder|Datelab wherePaymon($value)
 * @method static Builder|Datelab whereTesto($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\DatelabFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Datelab extends BaseModel
{
    protected $table = 'datelab';
}
