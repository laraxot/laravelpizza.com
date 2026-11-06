<?php

declare(strict_types=1);

namespace Modules\User\Database\Factories;

use Modules\User\Models\Extra;
use Modules\Xot\Database\Factories\BaseExtraFactory;

/**
 * La forma del dato sta in {@see BaseExtraFactory}, nel modulo che possiede il
 * concetto. Qui si dichiara **solo** il modello: e' quello che porta con se' la
 * connection di questo modulo.
 *
 * @extends BaseExtraFactory<Extra>
 */
class ExtraFactory extends BaseExtraFactory
{
    /** @var class-string<Extra> */
    protected $model = Extra::class;
}
