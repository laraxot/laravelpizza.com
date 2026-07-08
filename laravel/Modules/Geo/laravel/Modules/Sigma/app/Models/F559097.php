<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\F559097.
 *
 * @property int $id
 * @property string|null $mat
 * @property string|null $cognome
 * @property string|null $nome
 * @property string|null $contratto
 * @property string|null $voce
 * @property string|null $field
 * @property string|null $importo
 * @property string|null $anno_liquidazione
 * @property string|null $mese_liq
 * @property string|null $anno_riferimento
 * @property string|null $mese_riferimento
 * @property string|null $field1
 * @property string|null $field11
 * @property string|null $field111
 * @property string|null $field1111
 * @property string|null $field11111
 * @property string|null $field111111
 * @property string|null $stabilimento
 * @property string|null $field1111111
 * @property string|null $reparto
 * @property string|null $field11111111
 *
 * @method static Builder|F559097 newModelQuery()
 * @method static Builder|F559097 newQuery()
 * @method static Builder|F559097 query()
 * @method static Builder|F559097 whereAnnoLiquidazione($value)
 * @method static Builder|F559097 whereAnnoRiferimento($value)
 * @method static Builder|F559097 whereCognome($value)
 * @method static Builder|F559097 whereContratto($value)
 * @method static Builder|F559097 whereField($value)
 * @method static Builder|F559097 whereField1($value)
 * @method static Builder|F559097 whereField11($value)
 * @method static Builder|F559097 whereField111($value)
 * @method static Builder|F559097 whereField1111($value)
 * @method static Builder|F559097 whereField11111($value)
 * @method static Builder|F559097 whereField111111($value)
 * @method static Builder|F559097 whereField1111111($value)
 * @method static Builder|F559097 whereField11111111($value)
 * @method static Builder|F559097 whereId($value)
 * @method static Builder|F559097 whereImporto($value)
 * @method static Builder|F559097 whereMat($value)
 * @method static Builder|F559097 whereMeseLiq($value)
 * @method static Builder|F559097 whereMeseRiferimento($value)
 * @method static Builder|F559097 whereNome($value)
 * @method static Builder|F559097 whereReparto($value)
 * @method static Builder|F559097 whereStabilimento($value)
 * @method static Builder|F559097 whereVoce($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\F559097Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class F559097 extends BaseModel
{
    protected $table = 'f559097';
}
