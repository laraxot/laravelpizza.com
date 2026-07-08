<?php

declare(strict_types=1);

namespace Modules\Media\Exceptions;

use Exception;

class CouldNotAddUpload extends Exception
{
    public static function uuidAlreadyExists(): self
    {
        return new self('The given uuid is being used for an existing media item.');
    }
}
