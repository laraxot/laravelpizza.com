<?php

declare(strict_types=1);

namespace Modules\Rating\Models;

use Modules\Rating\Models\Traits\HasRatingsTrait;

/**
 * Anchor per analisi statica: `HasRatingsTrait` va `@use` sugli host cross-modulo
 * (es. `Ptv\Models\BaseScheda`). Nel perimetro Rating non esiste un modello host reale;
 * questa base astratta documenta il contratto senza mappare una tabella
 * (resta `abstract`: `final` su HasRatingsTrait fa esplodere return.type/static).
 *
 * @see Modules/Rating/docs/wiki/concepts/phpstan-compliance.md
 */
abstract class AbstractRatingsHost extends BaseModel
{
    /** @use HasRatingsTrait<static> */
    use HasRatingsTrait;
}
