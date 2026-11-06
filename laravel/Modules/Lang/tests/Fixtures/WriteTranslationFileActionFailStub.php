<?php

declare(strict_types=1);

namespace Modules\Lang\Tests\Fixtures;

use Modules\Lang\Actions\WriteTranslationFileAction;

final class WriteTranslationFileActionFailStub extends WriteTranslationFileAction
{
    protected function putTranslationFile(string $filePath, string $phpContent): false
    {
        return false;
    }
}
