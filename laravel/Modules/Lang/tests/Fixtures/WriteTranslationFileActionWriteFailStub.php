<?php

declare(strict_types=1);

namespace Modules\Lang\Tests\Fixtures;

use Modules\Lang\Actions\WriteTranslationFileAction;

final class WriteTranslationFileActionWriteFailStub extends WriteTranslationFileAction
{
    protected function writeLangTempContents(string $tempFile, string $phpContent): false
    {
        return false;
    }
}
