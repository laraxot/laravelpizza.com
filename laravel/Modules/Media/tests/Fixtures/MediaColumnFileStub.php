<?php

declare(strict_types=1);

namespace Modules\Media\Tests\Fixtures;

/**
 * Media finto: alla colonna serve solo `file_name`.
 */
class MediaColumnFileStub
{
    /**
     * Il nome della proprieta e imposto da Spatie: le closure della colonna
     * leggono `$media->file_name`. Non e camelCase e non puo esserlo.
     *
     * @SuppressWarnings("PHPMD.CamelCasePropertyName")
     */
    public string $file_name;

    public function __construct(string $fileName)
    {
        $this->file_name = $fileName;
    }
}
