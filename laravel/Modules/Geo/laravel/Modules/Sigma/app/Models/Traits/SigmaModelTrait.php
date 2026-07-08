<?php

declare(strict_types=1);

namespace Modules\Sigma\Models\Traits;

use Modules\Sigma\Models\Traits\Extras\FunctionExtra;
use Modules\Sigma\Models\Traits\Extras\MassExtra;
use Modules\Sigma\Models\Traits\Mutators\CommonMutator;
use Modules\Sigma\Models\Traits\Relationships\CommonRelationship;

// --- traits ---
/**
 * Modules\Sigma\Models\Traits\SigmaModelTrait.
 *
 * CommonScope è su {@see BaseDateRangeModel}, non qui (evita collisione trait).
 *
 * @property float $percparttime
 * @property int $giorni_parttimevert
 * @property int $giorni_presenza
 */
trait SigmaModelTrait
{
    use CommonMutator;
    use CommonRelationship;

    // --- relationship ---------
    use FunctionExtra;

    // use RelationshipEnteMatrTrait; //da chiamare all'occorrenza
    use MassExtra;
}
