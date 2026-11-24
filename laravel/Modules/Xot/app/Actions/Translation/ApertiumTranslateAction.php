<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Translation;

/**
 * @see docs/contracts/apertium-translate-action.md
<<<<<<< .merge_file_mHA60K
 *
=======
>>>>>>> .merge_file_Q5uX3Z
 * @contract docs/contracts/apertium-translate-action.md
 */
class ApertiumTranslateAction extends BaseTranslateAction
{
    public function execute(string $text, string $from, string $to): string
    {
        return '';
    }
}
