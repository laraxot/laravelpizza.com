<?php

declare(strict_types=1);

namespace Modules\Rating\Tests\Fixtures\Models;

use Modules\Rating\Models\Rating as ModuleRating;

/**
 * `Rating` del "modulo" delle fixture: e' la classe che `Rating::getClassName()` risolve
 * quando il chiamante e' {@see RatingsHost} (`<namespace prima di \Models\>\Models\Rating`),
 * come `Modules\Ptv\Models\Rating` per una scheda Ptv. Stessa tabella e connection del
 * Rating di modulo: non aggiunge comportamento.
 *
 * @see Modules/Rating/docs/testing-and-coverage.md
 */
class Rating extends ModuleRating {}
