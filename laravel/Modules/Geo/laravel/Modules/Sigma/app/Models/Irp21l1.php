<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Irp21l1.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $irpdal
 * @property string|null $irpal
 * @property string|null $irpcog
 * @property string|null $irpnom
 * @property string|null $irpnas
 * @property string|null $irpseq
 * @property string|null $irpcdf
 * @property string|null $irpper
 * @property string|null $irpinv
 * @property string|null $irptip
 * @property string|null $iann21
 *
 * @method static Builder|Irp21l1 newModelQuery()
 * @method static Builder|Irp21l1 newQuery()
 * @method static Builder|Irp21l1 query()
 * @method static Builder|Irp21l1 whereEnte($value)
 * @method static Builder|Irp21l1 whereIann21($value)
 * @method static Builder|Irp21l1 whereId($value)
 * @method static Builder|Irp21l1 whereIrpal($value)
 * @method static Builder|Irp21l1 whereIrpcdf($value)
 * @method static Builder|Irp21l1 whereIrpcog($value)
 * @method static Builder|Irp21l1 whereIrpdal($value)
 * @method static Builder|Irp21l1 whereIrpinv($value)
 * @method static Builder|Irp21l1 whereIrpnas($value)
 * @method static Builder|Irp21l1 whereIrpnom($value)
 * @method static Builder|Irp21l1 whereIrpper($value)
 * @method static Builder|Irp21l1 whereIrpseq($value)
 * @method static Builder|Irp21l1 whereIrptip($value)
 * @method static Builder|Irp21l1 whereMatr($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Irp21l1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Irp21l1 extends BaseModel
{
    protected $table = 'irp21l1';
}
