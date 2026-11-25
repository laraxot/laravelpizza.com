<?php

declare(strict_types=1);

namespace Modules\Rating\Tests\Fixtures\Models;

use Modules\Rating\Tests\Fixtures\RatingsHostStub;

/**
 * Host di test in un namespace `...\Models\`, come ogni host reale (`Ptv\Models\Scheda`).
 *
 * `XotBaseModel::getClassName()` cerca nel `debug_backtrace()` il primo oggetto la cui
 * classe contiene `Models\` e lancia `RuntimeException` se non lo trova: e' voluto
 * (story 5.90, fallimento rumoroso invece del database sbagliato). {@see RatingsHostStub}
 * vive in `Tests\Fixtures` e quindi non puo' chiamare `myRatings()`, `ratingObjectives()`
 * e `syncRatingsWhere()`; questo host si'. Risolve {@see Rating} delle fixture.
 *
 * @see Modules/Rating/docs/testing-and-coverage.md
 */
class RatingsHost extends RatingsHostStub {}
