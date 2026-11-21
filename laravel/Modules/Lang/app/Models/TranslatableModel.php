<?php

declare(strict_types=1);

namespace Modules\Lang\Models;

use Modules\Lang\Models\Traits\HasStrictTranslations;

/**
 * Base for models with strict Spatie translations (string|array|int|null).
 */
abstract class TranslatableModel extends BaseModel
{
    use HasStrictTranslations;
}
