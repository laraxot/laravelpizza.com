<?php

declare(strict_types=1);

namespace Modules\Xot\Actions;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

/**
 * Lingue che il sito supporta (`config/laravellocalization.php`), per scegliere la lingua primaria
 * tra quelle che esistono davvero.
<<<<<<< .merge_file_MKVPzz
 *
 * @see docs/contracts/list-supported-locales-action.md
 *
=======
 * @see docs/contracts/list-supported-locales-action.md
>>>>>>> .merge_file_i65AaI
 * @contract docs/contracts/list-supported-locales-action.md
 */
final class ListSupportedLocalesAction
{
    use QueueableAction;

    /**
     * @return array<string, string> codice => nome nativo
     */
    public function execute(): array
    {
        $options = [];
        foreach (LaravelLocalization::getSupportedLocales() as $code => $properties) {
            Assert::isArray($properties);
            $native = $properties['native'] ?? $code;
            Assert::string($native);

            $options[(string) $code] = $native;
        }

        return $options;
    }
}
