<?php

declare(strict_types=1);

namespace Modules\Lang\Phpstan;

use Modules\Lang\Models\BaseModel;
use Modules\Lang\Models\Traits\HasStrictTranslations;

/**
 * PHPStan probes — tests/ excluded from scan.
 */
abstract class LangPhpstanProbeModel extends BaseModel
{
    protected $table = 'lang_phpstan_trait_probes';
}

/**
 * @property array<int, string> $translatable
 */
final class HasStrictTranslationsPhpstanProbe extends LangPhpstanProbeModel
{
    use HasStrictTranslations;

    /** @var array<int, string> */
    public array $translatable = ['title'];
}
