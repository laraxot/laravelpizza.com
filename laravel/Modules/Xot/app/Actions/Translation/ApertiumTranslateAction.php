<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Translation;

/**
 * @see docs/contracts/apertium-translate-action.md
 * @contract docs/contracts/apertium-translate-action.md
 */
class ApertiumTranslateAction extends BaseTranslateAction
{
    public function execute(string $text, string $from, string $to): string
    {
        return '';
    }
}
