<?php

declare(strict_types=1);

namespace Modules\Rating\Tests\Fixtures\Models;

use Modules\Rating\Models\RatingMorph as ModuleRatingMorph;

/**
 * Pivot `rating_morph` del "modulo" delle fixture: `RelationX::guessMorphPivot()` cerca
 * `<namespace del related>\RatingMorph` accanto a {@see Rating}, come ogni modulo reale che
 * ha un proprio `Models\Rating` ha anche `Models\RatingMorph`. Nessun comportamento in piu'.
 *
 * @see Modules/Rating/docs/testing-and-coverage.md
 */
class RatingMorph extends ModuleRatingMorph {}
