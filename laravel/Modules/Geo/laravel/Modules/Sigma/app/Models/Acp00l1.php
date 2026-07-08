<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Acp00l1.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $acpkvo
 * @property string|null $acpali
 * @property string|null $acpmli
 * @property string|null $acpgio
 * @property string|null $acpcon
 * @property string|null $acpope
 * @property string|null $acptip
 * @property string|null $acpvoc
 * @property string|null $acpimp
 * @property string|null $acpeur
 * @property string|null $acpann
 *
 * @method static Builder|Acp00l1 newModelQuery()
 * @method static Builder|Acp00l1 newQuery()
 * @method static Builder|Acp00l1 query()
 * @method static Builder|Acp00l1 whereAcpali($value)
 * @method static Builder|Acp00l1 whereAcpann($value)
 * @method static Builder|Acp00l1 whereAcpcon($value)
 * @method static Builder|Acp00l1 whereAcpeur($value)
 * @method static Builder|Acp00l1 whereAcpgio($value)
 * @method static Builder|Acp00l1 whereAcpimp($value)
 * @method static Builder|Acp00l1 whereAcpkvo($value)
 * @method static Builder|Acp00l1 whereAcpmli($value)
 * @method static Builder|Acp00l1 whereAcpope($value)
 * @method static Builder|Acp00l1 whereAcptip($value)
 * @method static Builder|Acp00l1 whereAcpvoc($value)
 * @method static Builder|Acp00l1 whereEnte($value)
 * @method static Builder|Acp00l1 whereId($value)
 * @method static Builder|Acp00l1 whereMatr($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Acp00l1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Acp00l1 extends BaseModel
{
    protected $table = 'acp00l1';
}
