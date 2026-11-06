<?php

declare(strict_types=1);

namespace Modules\Lang\Actions;

use Modules\Lang\Datas\LangConfigData;
use Spatie\QueueableAction\QueueableAction;

/**
 * Lingua con cui si apre l'editor: quella salvata se e' fra le lingue scelte, altrimenti
 * `$fallback` (ogni chiamante aveva il suo: `app.locale` per le Resource, `it` per il selettore).
 */
class ResolveDefaultTranslatableLocaleAction
{
    use QueueableAction;

    public function execute(string $fallback): string
    {
        $saved = LangConfigData::make()->default_locale;

        if ($saved !== null && in_array($saved, app(ResolveTranslatableLocalesAction::class)->execute(), true)) {
            return $saved;
        }

        return $fallback;
    }
}
