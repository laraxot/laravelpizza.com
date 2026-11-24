<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Translation;

/**
 * @see docs/contracts/google-translate-action.md
 *
 * @contract docs/contracts/google-translate-action.md
 */
class GoogleTranslateAction extends BaseTranslateAction
{
    public function execute(string $text, string $from, string $to): string
    {
        return '';
    }
}
