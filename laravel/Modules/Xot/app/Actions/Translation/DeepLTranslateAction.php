<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Translation;

/**
 * @see docs/contracts/deep-l-translate-action.md
 * @contract docs/contracts/deep-l-translate-action.md
 */
class DeepLTranslateAction extends BaseTranslateAction
{
    public function execute(string $text, string $from, string $to): string
    {
        return '';
    }
}
