<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Translation;

/**
 * @see docs/contracts/my-memory-translate-action.md
 *
 * @contract docs/contracts/my-memory-translate-action.md
 */
class MyMemoryTranslateAction extends BaseTranslateAction
{
    public function execute(string $text, string $from, string $to): string
    {
        return '';
    }
}
