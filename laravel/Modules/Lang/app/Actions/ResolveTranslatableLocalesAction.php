<?php

declare(strict_types=1);

namespace Modules\Lang\Actions;

use Modules\Lang\Datas\LangConfigData;
use Spatie\QueueableAction\QueueableAction;

/**
 * Lingue in cui l'editor delle traduzioni lavora. Una lista vuota (file del tenant rovinato a mano)
 * non arriva mai all'editor: torna il default della Data.
 */
class ResolveTranslatableLocalesAction
{
    use QueueableAction;

    /**
     * @return list<string>
     */
    public function execute(): array
    {
        $locales = array_values(array_filter(
            LangConfigData::make()->supported_locales,
            static fn (mixed $locale): bool => is_string($locale) && $locale !== '',
        ));

        return $locales === [] ? LangConfigData::from([])->supported_locales : $locales;
    }
}
